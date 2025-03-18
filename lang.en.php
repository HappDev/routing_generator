<?php

return [
    'page_title'      => 'JSON Generator',
    'generated_json'  => 'Generated JSON',
    'formatted_json'  => 'Formatted JSON:',
    'base64_json'     => 'Base64 Encoded JSON:',
    'copy_to_clipboard' => 'Copy to Clipboard',
    'back'            => 'Back',
    'copy_success'    => 'Copied to clipboard',
    'copy_error'      => 'Error copying to clipboard:',
    'deeplink'        => 'Deeplink',
    'qr_code'         => 'QR-Code',

    // Форма
    'form' => [
        'Name' => [
            'label'       => 'Name',
            'placeholder' => 'China',
            'description' => 'Enter the configuration name.'
        ],
        'GlobalProxy' => [
            'label'       => 'GlobalProxy',
            'options'     => [
                'true'  => 'true',
                'false' => 'false'
            ],
            'description' => "Select 'true' to proxy all traffic except rules, or 'false' to direct all traffic except rules."
        ],


        'RemoteDNSType' => [
            'label'       => 'Remote DNS Type',
            'description' => 'Choose DoH (DNS over HTTPS) or DoU (DNS over UDP)',
            'options'     => [
                'DoH' => 'DoH',
                'DoU' => 'DoU'
            ]
        ],
        'RemoteDNSDomain' => [
            'label'       => 'Remote DNS Domain',
            'placeholder' => 'e.g. https://dns.google/dns-query',
            'description' => 'URL for DoH'
        ],
        'RemoteDNSIP' => [
            'label'       => 'Remote DNS IP',
            'placeholder' => 'e.g. 8.8.8.8',
            'description' => 'Server IP for DoH or DoU'
        ],

        'DomesticDNSType' => [
            'label'       => 'Domestic DNS Type',
            'description' => 'Choose DoH (DNS over HTTPS) or DoU (DNS over UDP)',
            'options'     => [
                'DoH' => 'DoH',
                'DoU' => 'DoU'
            ]
        ],
        'DomesticDNSDomain' => [
            'label'       => 'Domestic DNS Domain',
            'placeholder' => 'e.g. https://common.dot.dns.yandex.net/dns-query',
            'description' => 'URL for DoH'
        ],
        'DomesticDNSIP' => [
            'label'       => 'Domestic DNS IP',
            'placeholder' => 'e.g. 77.88.8.8',
            'description' => 'Server IP for DoH or DoU'
        ],

        'Geoipurl' => [
            'label'       => 'Geoipurl',
            'placeholder' => 'https://github.com/v2fly/geoip/releases/latest/download/geoip.dat',
            'description' => 'Link to the geoip.dat file. Leave this field empty if you want to use the default file.'
        ],
        'Geositeurl' => [
            'label'       => 'Geositeurl',
            'placeholder' => 'https://github.com/v2fly/domain-list-community/releases/latest/download/dlc.dat',
            'description' => 'Link to the geosite.dat file. Leave this field empty if you want to use the default file.'
        ],

        // Новое поле LastUpdated
        'LastUpdated' => [
            'label'       => 'LastUpdated',
            'placeholder' => 'e.g. 1693826255',
            'description' => 'Enter the Unix timestamp of the last update to the geoip and geosite files. Leave empty if not available.'
        ],

        'DnsHosts' => [
            'label'       => 'DnsHosts',
            'placeholder' => '{
    "example.com": "1.2.3.4",
    "test.org": "8.8.8.8"
}',
            'description' => 'JSON object with DNS hosts to override domain names.'
        ],
        'array_fields' => [
            'DirectSites' => [
                'label'       => 'DirectSites',
                'placeholder' => "geosite:ru\ngeosite:geolocation-ru",
                'description' => 'Sites that will use direct connection.'
            ],
            'DirectIp' => [
                'label'       => 'DirectIp',
                'placeholder' => 'geoip:cn',
                'description' => 'IP addresses for direct connection.'
            ],
            'ProxySites' => [
                'label'       => 'ProxySites',
                'placeholder' => 'geosite:com',
                'description' => 'Sites that will be proxied.'
            ],
            'ProxyIp' => [
                'label'       => 'ProxyIp',
                'placeholder' => 'geoip:amazon',
                'description' => 'IP addresses to be proxied.'
            ],
            'BlockSites' => [
                'label'       => 'BlockSites',
                'placeholder' => 'geosite:ads',
                'description' => 'Sites that will be blocked.'
            ],
            'BlockIp' => [
                'label'       => 'BlockIp',
                'placeholder' => 'geoip:ads',
                'description' => 'IP addresses that will be blocked.'
            ],
        ],
        'DomainStrategy' => [
            'label'   => 'DomainStrategy',
            'options' => [
                'IPIfNonMatch'  => 'IPIfNonMatch',
                'IPOnDemand'    => 'IPOnDemand',
                'AsIs'          => 'AsIs'
            ],
            'description' => 'Select the domain processing strategy.'
        ],
        'FakeDNS' => [
            'label'       => 'FakeDNS',
            'options'     => [
                'false' => 'false',
                'true'  => 'true',
            ],
            'description' => "Recommended to activate when using DoU"
        ],
        'submit' => 'Generate'
    ]
];
