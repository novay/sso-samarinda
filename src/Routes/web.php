<?php

Route::prefix('oauth/sso')->namespace('Novay\\SSO\\Http\\Controllers')->group(function() 
{
	Route::get('authorize', 'OAuthController@login')->name('sso.authorize');
	Route::get('callback', 'OAuthController@callback');
	
	Route::get('logout', 'OAuthController@logout')->name('sso.logout');
});