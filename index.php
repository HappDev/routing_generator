<?php
session_start();

$supportedLangs = ['en', 'ru', 'zh'];

$defaultLang = 'en';

// Устанавливаем язык, если не установлен
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = $defaultLang;
}

// Проверяем, пришёл ли GET-параметр lang и входит ли он в список поддерживаемых
if (isset($_GET['lang']) && in_array($_GET['lang'], $supportedLangs)) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Текущий язык
$lang = $_SESSION['lang'];

// Подключаем файл с переводами
$translationsFile = __DIR__ . "/lang.$lang.php";
if (!file_exists($translationsFile)) {
    // Если файла с переводами нет, подставим английский
    $translationsFile = __DIR__ . "/lang.$defaultLang.php";
}
$t = include $translationsFile;

// Если пришёл POST — обрабатываем форму
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    processForm($t);
    exit;
}

// Если GET — отображаем форму
renderForm($t);

/**
 * Обработка формы и вывод результата
 */
function processForm(array $t)
{
    // Собираем данные из формы
    $data = [];

    $data['Name']             = $_POST['Name']            ?? '';
    $data['GlobalProxy']      = $_POST['GlobalProxy']      ?? 'false';

    // Новые поля DNS
    $data['RemoteDNSType']    = $_POST['RemoteDNSType']    ?? 'DoH';
    $data['RemoteDNSDomain']  = $_POST['RemoteDNSDomain']  ?? '';
    $data['RemoteDNSIP']      = $_POST['RemoteDNSIP']      ?? '';

    $data['DomesticDNSType']  = $_POST['DomesticDNSType']  ?? 'DoH';
    $data['DomesticDNSDomain']= $_POST['DomesticDNSDomain']?? '';
    $data['DomesticDNSIP']    = $_POST['DomesticDNSIP']    ?? '';

    $data['Geoipurl']         = $_POST['Geoipurl']         ?? '';
    $data['Geositeurl']       = $_POST['Geositeurl']       ?? '';
    $data['LastUpdated']     = $_POST['LastUpdated']     ?? '';

    // Разбираем поле DnsHosts как JSON
    $data['DnsHosts'] = parseJsonField($_POST['DnsHosts'] ?? '');

    // Поля с массивами
    $arrayFields = ['DirectSites', 'DirectIp', 'ProxySites', 'ProxyIp', 'BlockSites', 'BlockIp'];
    foreach ($arrayFields as $field) {
        $input         = $_POST[$field] ?? '';
        $lines         = explode("\n", trim($input));
        $lines         = array_map('trim', $lines);
        $lines         = array_filter($lines); // убрать пустые строки
        $data[$field]  = array_values($lines);
    }

    $data['DomainStrategy'] = $_POST['DomainStrategy'] ?? 'IPIfNonMatch';

    $data['FakeDNS']   = $_POST['FakeDNS']  ?? 'false';

    // Генерация JSON и Base64
    $jsonString    = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $base64Encoded = base64_encode($jsonString);
    $prefixedBase64= 'happ://routing/add/' . $base64Encoded;

    // Теперь выводим результат (HTML)
    renderResult($t, $jsonString, $prefixedBase64);
}

function renderForm(array $t)
{
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo htmlspecialchars($t['page_title']); ?></title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .language-switcher {
                position: absolute;
                right: 20px;
                top: 20px;
            }
        </style>
    </head>
    <body class="bg-light">
    <div class="container mt-5">
        <!-- Ссылки для переключения языка -->
        <div class="language-switcher">
            <?php
            global $supportedLangs; // используем глобальный массив
            foreach ($supportedLangs as $code) {
                echo '<a href="?lang=' . htmlspecialchars($code) . '" class="me-2">' . strtoupper($code) . '</a>';
            }
            ?>
        </div>

        <h1 class="mb-4"><?php echo htmlspecialchars($t['page_title']); ?></h1>

        <form method="post">
            <?php
            // Перебираем поля формы из массива переводов
            foreach ($t['form'] as $key => $field) {

                // Массив полей (textarea)
                if ($key === 'array_fields') {
                    foreach ($field as $arrayKey => $arrayField) {
                        renderTextareaField($arrayKey, $arrayField);
                    }
                    continue;
                }

                // Кнопка "Отправить"
                if ($key === 'submit') {
                    // Не рендерим сейчас, потом ниже сделаем
                    continue;
                }

                // Если у поля есть options — значит это select
                if (isset($field['options'])) {
                    renderSelectField($key, $field);
                }
                // Если это DnsHosts (textarea)
                elseif ($key === 'DnsHosts') {
                    renderTextareaField($key, $field);
                }
                // Иначе обычное текстовое поле
                else {
                    renderInputField($key, $field);
                }
            }
            ?>

            <button type="submit" class="btn btn-primary">
                <?php echo htmlspecialchars($t['form']['submit']); ?>
            </button>
        </form>
    </div>

    <!-- Скрипт для динамического скрытия полей *DNSDomain при выборе DoU -->
    <script>
    function toggleDNSDomainFields(selectId, domainFieldId) {
        const select = document.getElementById(selectId);
        const domainField = document.getElementById(domainFieldId).closest('.mb-3');

        if (select.value === 'DoU') {
            domainField.style.display = 'none';
        } else {
            domainField.style.display = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const remoteSelectId = 'RemoteDNSType';
        const remoteDomainId = 'RemoteDNSDomain';
        const domesticSelectId = 'DomesticDNSType';
        const domesticDomainId = 'DomesticDNSDomain';

        // Первичная проверка при загрузке
        toggleDNSDomainFields(remoteSelectId, remoteDomainId);
        toggleDNSDomainFields(domesticSelectId, domesticDomainId);

        // При изменении
        document.getElementById(remoteSelectId).addEventListener('change', function() {
            toggleDNSDomainFields(remoteSelectId, remoteDomainId);
        });
        document.getElementById(domesticSelectId).addEventListener('change', function() {
            toggleDNSDomainFields(domesticSelectId, domesticDomainId);
        });
    });
    </script>
    </body>
    </html>
    <?php
}


function renderResult(array $t, string $jsonString, string $prefixedBase64)
{
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo htmlspecialchars($t['generated_json']); ?></title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <style>
            .copy-button, .deeplink-button, .qr-button {
                position: absolute;
                top: 10px;
            }
            .copy-button {
                right: 210px;
            }
            .deeplink-button {
                right: 110px;
            }
            .qr-button {
                right: 10px;
            }
            .pre-container {
                position: relative;
            }
            .language-switcher {
                position: absolute;
                right: 20px;
                top: 20px;
            }
        </style>
    </head>
    <body class="bg-light">
        <div class="container mt-5">
            <!-- Ссылки для переключения языка (как и в форме) -->
            <div class="language-switcher">
                <?php
                global $supportedLangs;
                foreach ($supportedLangs as $code) {
                    echo '<a href="?lang=' . htmlspecialchars($code) . '" class="me-2">' . strtoupper($code) . '</a>';
                }
                ?>
            </div>
            <h1 class="mb-4"><?php echo htmlspecialchars($t['generated_json']); ?></h1>

            <h3><?php echo htmlspecialchars($t['formatted_json']); ?></h3>
            <pre class="bg-white p-3 border rounded"><?php echo $jsonString; ?></pre>

            <h3><?php echo htmlspecialchars($t['base64_json']); ?></h3>
            <div class="pre-container">
                <pre id="base64Output" class="bg-white p-3 border rounded"><?php echo $prefixedBase64; ?></pre>
                <button class="btn btn-secondary copy-button" onclick="copyToClipboard()">
                    <?php echo htmlspecialchars($t['copy_to_clipboard']); ?>
                </button>
                <button class="btn btn-warning deeplink-button" onclick="openDeeplink()">
                    <?php echo htmlspecialchars($t['deeplink']); ?>
                </button>
                <button class="btn btn-success qr-button" onclick="showQRCode()">
                    <?php echo htmlspecialchars($t['qr_code']); ?>
                </button>
            </div>

            <!-- Модальное окно для QR-кода -->
            <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="qrModalLabel"><?php echo htmlspecialchars($t['qr_code']); ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center d-flex justify-content-center">
                    <div id="qrcode"></div>
                  </div>
                </div>
              </div>
            </div>

            <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="btn btn-primary mt-3">
                <?php echo htmlspecialchars($t['back']); ?>
            </a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function copyToClipboard() {
                const base64Text = document.getElementById('base64Output').innerText;
                navigator.clipboard.writeText(base64Text).then(function() {
                    alert('<?php echo addslashes($t['copy_success']); ?>');
                }, function(err) {
                    alert('<?php echo addslashes($t['copy_error']); ?> ' + err);
                });
            }

            function showQRCode() {
                const base64Text = document.getElementById('base64Output').innerText;
                var qrCodeContainer = document.getElementById('qrcode');
                qrCodeContainer.innerHTML = '';
                new QRCode(qrCodeContainer, {
                    text: base64Text,
                    width: 256,
                    height: 256,
                });
                var qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
                qrModal.show();
            }

            function openDeeplink() {
                const base64Text = document.getElementById('base64Output').innerText;
                window.open(base64Text, '_blank');
            }
        </script>
    </body>
    </html>
    <?php
}

/**
 * Парсит JSON-поле (DnsHosts и т.п.), возвращая либо объект, либо пустой объект
 */
function parseJsonField(string $input)
{
    if (empty($input)) {
        return new stdClass();
    }
    $decoded = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Можно вывести ошибку, но для примера вернём пустой объект
        return new stdClass();
    }
    return $decoded;
}

/**
 * Рендер обычного текстового поля <input type="text">
 */
function renderInputField(string $key, array $field)
{
    ?>
    <div class="mb-3">
        <label for="<?php echo $key; ?>" class="form-label">
            <?php echo htmlspecialchars($field['label']); ?>
        </label>
        <input type="text" class="form-control" name="<?php echo $key; ?>" id="<?php echo $key; ?>"
               placeholder="<?php echo htmlspecialchars($field['placeholder']); ?>">
        <div class="form-text">
            <?php echo htmlspecialchars($field['description']); ?>
        </div>
    </div>
    <?php
}

/**
 * Рендер <select>
 */
function renderSelectField(string $key, array $field)
{
    ?>
    <div class="mb-3">
        <label for="<?php echo $key; ?>" class="form-label">
            <?php echo htmlspecialchars($field['label']); ?>
        </label>
        <select class="form-select" name="<?php echo $key; ?>" id="<?php echo $key; ?>">
            <?php
            foreach ($field['options'] as $value => $optionLabel) {
                echo '<option value="' . htmlspecialchars($value) . '">'
                     . htmlspecialchars($optionLabel) . '</option>';
            }
            ?>
        </select>
        <div class="form-text">
            <?php echo htmlspecialchars($field['description']); ?>
        </div>
    </div>
    <?php
}

/**
 * Рендер <textarea>
 */
function renderTextareaField(string $key, array $field)
{
    ?>
    <div class="mb-3">
        <label for="<?php echo $key; ?>" class="form-label">
            <?php echo htmlspecialchars($field['label']); ?>
        </label>
        <textarea class="form-control" name="<?php echo $key; ?>" id="<?php echo $key; ?>"
                  rows="3" placeholder="<?php echo htmlspecialchars($field['placeholder']); ?>"></textarea>
        <div class="form-text">
            <?php echo htmlspecialchars($field['description']); ?>
        </div>
    </div>
    <?php
}

