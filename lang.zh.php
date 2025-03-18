<?php
return [
    'page_title'      => 'JSON生成器',
    'generated_json'  => '生成的JSON',
    'formatted_json'  => '格式化的JSON:',
    'base64_json'     => 'Base64编码的JSON:',
    'copy_to_clipboard' => '复制到剪贴板',
    'back'            => '返回',
    'copy_success'    => '已复制到剪贴板',
    'copy_error'      => '复制到剪贴板时出错:',
    'deeplink'        => '深层链接',
    'qr_code'         => '二维码',

    // 表单
    'form' => [
        'Name' => [
            'label'       => '名称',
            'placeholder' => '中国',
            'description' => '请输入配置名称。'
        ],
        'GlobalProxy' => [
            'label'       => '全局代理',
            'options'     => [
                'true'  => '是',
                'false' => '否'
            ],
            'description' => "选择'是'以代理除规则外的所有流量，或选择'否'以直接连接除规则外的所有流量。"
        ],
        'RemoteDNSType' => [
            'label'       => '远程DNS类型',
            'description' => '选择DoH（DNS通过HTTPS）或DoU（DNS通过UDP）',
            'options'     => [
                'DoH' => 'DoH',
                'DoU' => 'DoU'
            ]
        ],
        'RemoteDNSDomain' => [
            'label'       => '远程DNS域名',
            'placeholder' => '例如 ttps://dns.google/dns-query',
            'description' => 'DoH的域名'
        ],
        'RemoteDNSIP' => [
            'label'       => '远程DNS IP',
            'placeholder' => '例如 8.8.8.8',
            'description' => 'DoH或DoU的服务器IP'
        ],

        'DomesticDNSType' => [
            'label'       => '国内DNS类型',
            'description' => '选择DoH（DNS通过HTTPS）或DoU（DNS通过UDP）',
            'options'     => [
                'DoH' => 'DoH',
                'DoU' => 'DoU'
            ]
        ],
        'DomesticDNSDomain' => [
            'label'       => '国内DNS域名',
            'placeholder' => '例如 https://common.dot.dns.yandex.net/dns-query',
            'description' => 'DoH的域名'
        ],
        'DomesticDNSIP' => [
            'label'       => '国内DNS IP',
            'placeholder' => '例如 77.88.8.8',
            'description' => 'DoH或DoU的服务器IP'
        ],

        'Geoipurl' => [
            'label'       => 'Geoipurl',
            'placeholder' => 'https://github.com/v2fly/geoip/releases/latest/download/geoip.dat',
            'description' => 'geoip.dat文件的链接。如果您希望使用默认文件，请留空此字段。'
        ],
        'Geositeurl' => [
            'label'       => 'Geositeurl',
            'placeholder' => 'https://github.com/v2fly/domain-list-community/releases/latest/download/dlc.dat',
            'description' => 'geosite.dat文件的链接。如果您希望使用默认文件，请留空此字段。'
        ],

        // 新字段 LastUpdated
        'LastUpdated' => [
            'label'       => '最后更新时间',
            'placeholder' => '例如 1693826255',
            'description' => '输入最后一次更新geoip和geosite文件的Unix时间戳。如果没有可用的时间戳，请留空。'
        ],

        'DnsHosts' => [
            'label'       => 'DnsHosts',
            'placeholder' => '{
    "example.com": "1.2.3.4",
    "test.org": "8.8.8.8"
}',
            'description' => '用于覆盖域名的DNS主机的JSON对象。'
        ],
        'array_fields' => [
            'DirectSites' => [
                'label'       => '直连站点',
                'placeholder' => "geosite:ru\ngeosite:geolocation-ru",
                'description' => '将使用直连的站点。'
            ],
            'DirectIp' => [
                'label'       => '直连IP',
                'placeholder' => 'geoip:cn',
                'description' => '用于直连的IP地址。'
            ],
            'ProxySites' => [
                'label'       => '代理站点',
                'placeholder' => 'geosite:com',
                'description' => '将被代理的站点。'
            ],
            'ProxyIp' => [
                'label'       => '代理IP',
                'placeholder' => 'geoip:amazon',
                'description' => '将被代理的IP地址。'
            ],
            'BlockSites' => [
                'label'       => '屏蔽站点',
                'placeholder' => 'geosite:ads',
                'description' => '将被屏蔽的站点。'
            ],
            'BlockIp' => [
                'label'       => '屏蔽IP',
                'placeholder' => 'geoip:ads',
                'description' => '将被屏蔽的IP地址。'
            ],
        ],
        'DomainStrategy' => [
            'label'   => '域名策略',
            'options' => [
                'IPIfNonMatch'  => 'IP如果不匹配',
                'IPOnDemand'    => '按需IP',
                'AsIs'          => '原样处理'
            ],
            'description' => '选择域名处理策略。'
        ],
        'FakeDNS' => [
            'label'       => '虚假DNS',
            'options'     => [
                'false' => '否',
                'true'  => '是',
            ],
            'description' => "使用DoU时推荐启用"
        ],
        'submit' => '生成'
    ]
];
