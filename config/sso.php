<?php

return [
    'name' => 'Single Sign On - Broker (Client)', 
    'version' => '1.0.0', 

    /*
     |--------------------------------------------------------------------------
     | Settings necessary for the SSO broker.
     |--------------------------------------------------------------------------
     |
     | These settings should be changed if this page is working as SSO broker.
     |
     */
    'server_url' => env('SSO_SERVER_URL', null),
    'broker_name' => env('SSO_BROKER_NAME', null),
    'broker_secret' => env('SSO_BROKER_SECRET', null),
];