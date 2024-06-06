<?php
// config for Ariaieboy/LaravelSafeBrowsing
return [
    'google'=>[
        'api_domain'=>'https://safebrowsing.googleapis.com/',
        'api_key' => 'AIzaSyBY-m3TWuCyf9YbF8QcZmqdYEVCF46xcd0',
        'timeout'=>30,
        'threatTypes' => [
            'THREAT_TYPE_UNSPECIFIED',
            'MALWARE',
            'SOCIAL_ENGINEERING',
            'UNWANTED_SOFTWARE',
            'POTENTIALLY_HARMFUL_APPLICATION',
        ],

        'threatPlatforms' => [
            'ANY_PLATFORM'
        ],
        'clientId' => 'ariaieboy-safebrowsing',
        'clientVersion' => '1.5.2',
    ]
];
