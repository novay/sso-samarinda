# Integrasi SSO-Samarinda menggunakan Laravel

[![Latest Stable Version](https://poser.pugx.org/novay/sso-client/v/stable)](https://packagist.org/packages/novay/sso-client)
[![Total Downloads](https://poser.pugx.org/novay/sso-client/downloads)](https://packagist.org/packages/novay/sso-client)
[![Latest Unstable Version](https://poser.pugx.org/novay/sso-client/v/unstable)](https://packagist.org/packages/novay/sso-client)
[![License](https://poser.pugx.org/novay/sso-client/license)](https://packagist.org/packages/novay/sso-client)

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

Package ini berbasis pada [Simple PHP SSO skeleton](https://github.com/zefy/php-simple-sso) dan dibuat khusus agar dapat berjalan dan digunakan di framework Laravel.

### Requirements
* Laravel 5.5+
* PHP 7.1+

### How it works?
Client visits Broker and unique token is generated. When new token is generated we need to attach Client session to his session in Broker so he will be redirected to Server and back to Broker at this moment new session in Server will be created and associated with Client session in Broker's page. When Client visits other Broker same steps will be done except that when Client will be redirected to Server he already use his old session and same session id which associated with Broker#1.

# Installation

#### 1. Install Package

Install package ini menggunakan composer.
```shell
$ composer require novay/sso-client
```
Package ini otomatis akan mendaftarkan service provider kedalam aplikasi Anda.

#### 2. Publish Vendor

Salin file config `sso.php` ke dalam folder `config/` pada projek Anda dengan menjalankan:
```shell
$ php artisan vendor:publish --provider="Novay\SSO\Providers\SSOServiceProvider"
``` 
Berikut adalah isi konten default dari file konfigurasi yang disalin:
```php
//config/sso.php

return [
    'name' => 'Single Sign On - Broker (Client)', 
    'version' => '1.0.0', 

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
];
```

#### 3. Edit Environment

Buat 3 opsi baru dalam file `.env` Anda:
```shell
SSO_SERVER_URL=https://sso.samarindakota.go.id
SSO_BROKER_NAME=
SSO_BROKER_SECRET=
```
`SSO_SERVER_URL` berisi URI dari SSO Samarinda. `SSO_BROKER_NAME` dan `SSO_BROKER_SECRET` harus diisi sesuai dengan data aplikasi yang didaftarkan di https://sso.samarindakota.go.id.

#### 4. Register Middleware

Edit file `app/Http/Kernel.php` dan tambahkan `\Novay\SSO\Http\Middleware\SSOAutoLogin::class` ke gurp `web` middleware. Contohnya seperti ini:
```php
protected $middlewareGroups = [
	'web' => [
		...
	    \Novay\SSO\Http\Middleware\SSOAutoLogin::class,
	],

	'api' => [
		...
	],
];
```

Apabila 

#### 5. Usage

a) Login

```html
<a href="{{ route('sso.authorize') }}">Login</a>
```

b) Logout

```html
<a href="{{ route('sso.logout') }}">Logout</a>
```

Untuk penggunaan secara manual, Anda bisa menyisipkan potongan script berikut kedalam fungsi login dan logout pada class controller Anda.
```php
protected function attemptLogin(Request $request)
{
    $broker = new \Novay\SSO\Services\Broker;
    
    $credentials = $this->credentials($request);
    return $broker->login($credentials[$this->username()], $credentials['password']);
}

public function logout(Request $request)
{
    $broker = new \Novay\SSO\Services\Broker;
    
    $broker->logout();
    
    $this->guard()->logout();
    
    $request->session()->invalidate();
    
    return redirect('/');
}
```

Demikian. Untuk halaman Broker lain Anda harus mengulang semuanya dari awal hanya dengan mengubah nama dan secret Broker Anda di file konfigurasi.

Contoh tambahan pada file `.env`:
```shell
SSO_SERVER_URL=https://samarindakota.go.id
SSO_BROKER_NAME=Situsku
SSO_BROKER_SECRET=XXXXX
```