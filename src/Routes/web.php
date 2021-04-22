<?php

Route::prefix('oauth/sso')->namespace('Novay\\SSO\\Http\\Controllers')->middleware('web')->group(function() 
{
	Route::get('authorize', 'OAuthController@login')->name('sso.authorize');
	Route::get('callback', 'OAuthController@callback');
	
	Route::get('logout', 'OAuthController@logout')->name('sso.logout');

	Route::get('import/{type?}', 'ImportController@import')->name('sso.import');
});