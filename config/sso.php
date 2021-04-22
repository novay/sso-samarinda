<?php

return [
    'name' => 'Single Sign On - Broker (Client)', 
    'version' => '1.0.5', 

    /*
    |--------------------------------------------------------------------------
    | Redirect to ???
    |--------------------------------------------------------------------------
    | Arahkan kemana Anda akan tuju setelah login berhasil
    |
    */
    'redirect_to' => '/home', 

    /*
    |--------------------------------------------------------------------------
    | Konfigurasi auth.php
    |--------------------------------------------------------------------------
    | Pilih guard auth default yang dipakai
    |
    */
    'guard' => 'web', 

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Umum untuk Broker
    |--------------------------------------------------------------------------
    | Beberapa parameter yang dibutuhkan untuk broker. Bisa ditemukan di
    | https://sso.samarindakota.go.id
    |
    */
    'server_url' => env('SSO_SERVER_URL', null),
    'broker_name' => env('SSO_BROKER_NAME', null),
    'broker_secret' => env('SSO_BROKER_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | Custom for UserList
    |--------------------------------------------------------------------------
    | Tentukan Model User yang dipakai
    |
    */
    'model' => '\App\Models\User'
];