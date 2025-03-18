<?php
return [
    'page_title'      => 'Генератор JSON',
    'generated_json'  => 'Сгенерированный JSON',
    'formatted_json'  => 'Отформатированный JSON:',
    'base64_json'     => 'JSON в формате Base64:',
    'copy_to_clipboard' => 'Копировать в буфер обмена',
    'back'            => 'Назад',
    'copy_success'    => 'Скопировано в буфер обмена',
    'copy_error'      => 'Ошибка при копировании в буфер обмена:',
    'deeplink'        => 'Глубокая ссылка',
    'qr_code'         => 'QR-код',

    'form' => [
        'Name' => [
            'label'       => 'Имя',
            'placeholder' => 'Китай',
            'description' => 'Введите имя конфигурации.'
        ],
        'GlobalProxy' => [
            'label'       => 'GlobalProxy',
            'options'     => [
                'true'  => 'true',
                'false' => 'false'
            ],
            'description' => "Выберите 'true', чтобы проксировать весь трафик, за исключением правил, или 'false', чтобы направить весь трафик, за исключением правил, напрямую."
        ],
        'RemoteDNSType' => [
            'label'       => 'Тип удаленного DNS',
            'description' => 'Выберите DoH (DNS через HTTPS) или DoU (DNS через UDP)',
            'options'     => [
                'DoH' => 'DoH',
                'DoU' => 'DoU'
            ]
        ],
        'RemoteDNSDomain' => [
            'label'       => 'Удаленный DNS домен',
            'placeholder' => 'например https://dns.google/dns-query',
            'description' => 'URL для DoH'
        ],
        'RemoteDNSIP' => [
            'label'       => 'Удаленный DNS IP',
            'placeholder' => 'например 8.8.8.8',
            'description' => 'IP-адрес сервера для DoH или DoU'
        ],

        'DomesticDNSType' => [
            'label'       => 'Тип внутреннего DNS',
            'description' => 'Выберите DoH (DNS через HTTPS) или DoU (DNS через UDP)',
            'options'     => [
                'DoH' => 'DoH',
                'DoU' => 'DoU'
            ]
        ],
        'DomesticDNSDomain' => [
            'label'       => 'Внутренний DNS домен',
            'placeholder' => 'например https://common.dot.dns.yandex.net/dns-query',
            'description' => 'URL для DoH'
        ],
        'DomesticDNSIP' => [
            'label'       => 'Внутренний DNS IP',
            'placeholder' => 'например 77.88.8.8',
            'description' => 'IP-адрес сервера для DoH или DoU'
        ],

        'Geoipurl' => [
            'label'       => 'Geoipurl',
            'placeholder' => 'https://github.com/v2fly/geoip/releases/latest/download/geoip.dat',
            'description' => 'Ссылка на файл geoip.dat. Оставьте это поле пустым, если хотите использовать файл по умолчанию.'
        ],
        'Geositeurl' => [
            'label'       => 'Geositeurl',
            'placeholder' => 'https://github.com/v2fly/domain-list-community/releases/latest/download/dlc.dat',
            'description' => 'Ссылка на файл geosite.dat. Оставьте это поле пустым, если хотите использовать файл по умолчанию.'
        ],

        // Новое поле LastUpdated
        'LastUpdated' => [
            'label'       => 'LastUpdated',
            'placeholder' => 'например 1693826255',
            'description' => 'Введите Unix-метку времени последнего обновления файлов geoip и geosite. Оставьте пустым, если информация недоступна.'
        ],

        'DnsHosts' => [
            'label'       => 'DnsHosts',
            'placeholder' => '{
    "example.com": "1.2.3.4",
    "test.org": "8.8.8.8"
}',
            'description' => 'JSON-объект с DNS-хостами для переопределения доменных имен.'
        ],
        'array_fields' => [
            'DirectSites' => [
                'label'       => 'DirectSites',
                'placeholder' => "geosite:ru\ngeosite:geolocation-ru",
                'description' => 'Сайты, которые будут использовать прямое подключение.'
            ],
            'DirectIp' => [
                'label'       => 'DirectIp',
                'placeholder' => 'geoip:cn',
                'description' => 'IP-адреса для прямого подключения.'
            ],
            'ProxySites' => [
                'label'       => 'ProxySites',
                'placeholder' => 'geosite:com',
                'description' => 'Сайты, которые будут проксироваться.'
            ],
            'ProxyIp' => [
                'label'       => 'ProxyIp',
                'placeholder' => 'geoip:amazon',
                'description' => 'IP-адреса, которые будут проксироваться.'
            ],
            'BlockSites' => [
                'label'       => 'BlockSites',
                'placeholder' => 'geosite:ads',
                'description' => 'Сайты, которые будут заблокированы.'
            ],
            'BlockIp' => [
                'label'       => 'BlockIp',
                'placeholder' => 'geoip:ads',
                'description' => 'IP-адреса, которые будут заблокированы.'
            ],
        ],
        'DomainStrategy' => [
            'label'   => 'Стратегия обработки доменов',
            'options' => [
                'IPIfNonMatch'  => 'IP, если не совпадает',
                'IPOnDemand'    => 'IP по запросу',
                'AsIs'          => 'Как есть'
            ],
            'description' => 'Выберите стратегию обработки доменов.'
        ],
        'FakeDNS' => [
            'label'       => 'FakeDNS',
            'options'     => [
                'false' => 'false',
                'true'  => 'true',
            ],
            'description' => "Рекомендуется включить при использовании DoU"
        ],
        'submit' => 'Генерировать'
    ]
];
