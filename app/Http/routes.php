<?php

Route::get('', 'HomeController@index')->name('home');

/**
 * Guest routes
 */

Route::group(['middleware' => ['guest']], function () {
    Route::get('auth/sign-up', 'Auth\AuthController@getRegister')->name('auth.register');
    Route::post('auth/sign-up', 'Auth\AuthController@postRegister');

    Route::get('auth/sign-in', 'Auth\AuthController@getLogin')->name('auth.login');
    Route::post('auth/sign-in', 'Auth\AuthController@postLogin');

    Route::get('password/email', 'Auth\PasswordController@getEmail')->name('auth.password.email');
    Route::post('password/email', 'Auth\PasswordController@postEmail');
    
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset')->name('auth.password.reset');
    Route::post('password/reset/{token}', 'Auth\PasswordController@postReset');
});

/**
 * Authenticated routes
 */

Route::group(['middleware' => ['auth']], function () {
    Route::get('auth/sign-out', 'Auth\AuthController@logout')->name('auth.logout');

    Route::get('account/settings/profile', 'Account\AccountController@getProfile')->name('account.settings.profile');
    Route::post('account/settings/profile', 'Account\AccountController@postProfile');

    Route::get('@{username}', 'User\UserController@profile')->name('user.profile');

    Route::get('section/{slug}', 'Forum\SectionController@show')->name('forum.section.show');

    Route::get('topic/{slug}/{id}', 'Forum\TopicController@show')->name('forum.topic.show');

    Route::get('topic/create/{section_id?}', 'Forum\TopicController@create')->name('forum.topic.create');
    Route::post('topic/create/{section_id?}', 'Forum\TopicController@store');

    Route::post('topic/{topic}/post', 'Forum\PostController@store')->name('forum.topic.post');
});

Route::group(['prefix' => 'moderation', 'middleware' => ['role:owner|admin']], function () {
    Route::get('section/create', 'Forum\SectionController@create')->name('moderation.section.create');
    Route::post('section/create', 'Forum\SectionController@store');

    Route::get('post/{id}/destroy', 'Forum\PostController@destroy')->name('moderation.post.destroy');
    Route::get('topic/{id}/destroy', 'Forum\TopicController@destroy')->name('moderation.topic.destroy');
    Route::get('section/{id}/destroy', 'Forum\SectionController@destroy')->name('moderation.section.destroy');
});
