<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'key' => "",
    "exempted_route" => [

    ],
    "services" => [
        [
            "SERVICE_NAME" => "ACCOUNTS_SERVICE",
            "SERVICE_CODE" => "GTPSERVE_001"
        ]
    ],
    "service_remote_json" => env('SERVICE_REMOTE_JSON', ''),
    "service_auth_header" => env('SERVICE_AUTH_HEADER', 'SERVICE_AUTH_KEY'),
    "enc_request" => env('ENC_REQUEST', false),
    "enc_response" => env('ENC_RESPONSE', false),
];