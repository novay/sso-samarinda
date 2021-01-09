# Simple PHP SSO integration for Laravel

[![Latest Stable Version](https://poser.pugx.org/novay/sso-client/v/stable)](https://packagist.org/packages/novay/sso-client)
[![Total Downloads](https://poser.pugx.org/novay/sso-client/downloads)](https://packagist.org/packages/novay/sso-client)
[![Latest Unstable Version](https://poser.pugx.org/novay/sso-client/v/unstable)](https://packagist.org/packages/novay/sso-client)
[![License](https://poser.pugx.org/novay/sso-client/license)](https://packagist.org/packages/novay/sso-client)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/novay/sso-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/novay/sso-client/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/novay/sso-client/badges/build.png?b=master)](https://scrutinizer-ci.com/g/novay/sso-client/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/novay/sso-client/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

This package based on [Simple PHP SSO skeleton](https://github.com/zefy/php-simple-sso) package and made suitable for Laravel framework.

### Requirements
* Laravel 5.5+
* PHP 7.1+

### How it works?
Client visits Broker and unique token is generated. When new token is generated we need to attach Client session to his session in Broker so he will be redirected to Server and back to Broker at this moment new session in Server will be created and associated with Client session in Broker's page. When Client visits other Broker same steps will be done except that when Client will be redirected to Server he already use his old session and same session id which associated with Broker#1.

# Installation

Install package ini menggunakan composer.
```shell
$ composer require novay/sso-client
```

Salin file config ke dalam folder `config/` pada projek Laravel Anda.
```shell
$ php artisan vendor:publish --provider="Novay\SSO\SSOServiceProvider"
``` 

Buat 3 opsi baru di dalam file `.env` Anda:
```shell
SSO_SERVER_URL=https://sso.samarindakota.go.id
SSO_BROKER_NAME=
SSO_BROKER_SECRET=
```
`SSO_SERVER_URL` berisi URI dari SSO Samarinda. `SSO_BROKER_NAME` dan `SSO_BROKER_SECRET` harus diisi sesuai dengan data aplikasi yang didaftarkan di https://sso.samarindakota.go.id.

Edit file `app/Http/Kernel.php` dan tambahkan `\Novay\SSO\Middleware\SSOAutoLogin::class` ke gurp `web` middleware. Contohnya seperti ini:
```php
protected $middlewareGroups = [
	'web' => [
		...
	    \Novay\SSO\Middleware\SSOAutoLogin::class,
	],

	'api' => [
		...
	],
];
```

Last but not least, you need to edit `app/Http/Controllers/Auth/LoginController.php`. You should add two functions into `LoginController` class which will authenticate your client through SSO server but not your Broker page.
```php
protected function attemptLogin(Request $request)
{
    $broker = new \Novay\SSO\Broker;
    
    $credentials = $this->credentials($request);
    return $broker->login($credentials[$this->username()], $credentials['password']);
}

public function logout(Request $request)
{
    $broker = new \Novay\SSO\Broker;
    
    $broker->logout();
    
    $this->guard()->logout();
    
    $request->session()->invalidate();
    
    return redirect('/');
}
```

That's all. For other Broker pages you should repeat everything from the beginning just changing your Broker name and secret in configuration file.

Example `.env` options:
```shell
SSO_SERVER_URL=https://server.test
SSO_BROKER_NAME=site1
SSO_BROKER_SECRET=892asjdajsdksja74jh38kljk2929023
```