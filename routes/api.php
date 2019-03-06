<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

// 'middleware' => 'auth:api'
Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.',
    'middleware' => 'auth:api'
], function () {
    Route::resource('tickets', 'TicketService', [
        'except' => [
            'create',
            'edit'
        ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('tickets', 'TicketService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.',
    'middleware' => 'auth:api'
], function () {
    Route::resource('species', 'SpecieDetailService', [
        'except' => [
            'create',
            'edit'
        ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('species', 'SpecieDetailService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('species/search/{value}', 'SpecieDetailService@search', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('species/advanced/begindate/{begindate}/enddate/{enddate}', 'SpecieDetailService@advanced', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('species/read/{id}', 'SpecieDetailService@byid', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('species/newest/{limit}', 'SpecieDetailService@newest', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.',
    'middleware' => 'auth:api'
], function () {
    Route::resource('articles/species', 'ArticleSpecieService', [
        'except' => [
            'create',
            'edit'
        ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('articles/species', 'ArticleSpecieService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('articles/{id}/all_species', 'ArticleSpecieService@species', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.',
    'middleware' => 'auth:api'
], function () {
    Route::resource('articles', 'ArticleService', [
        'except' => [
            'create',
            'edit'
        ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('articles', 'ArticleService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('articles/newest/{limit}', 'ArticleService@newest', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('articles/search/{value}', 'ArticleService@search', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('articles/read/{id}', 'ArticleService@byid', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('articles/advanced/begindate/{begindate}/enddate/{enddate}', 'ArticleService@advanced', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.',
    'middleware' => 'auth:api'
], function () {
    Route::resource('projects', 'ProjectService', [
        'except' => [
            'create',
            'edit'
        ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('projects', 'ProjectService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.',
    'middleware' => 'auth:api'
], function () {
    Route::resource('members', 'MemberService', [
        'except' => [
            'create',
            'edit'
        ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('members', 'MemberService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.',
    'middleware' => 'auth:api'
], function () {
    Route::resource('merchandise', 'MerchandiseService', [
        'except' => [
            'create',
            'edit'
        ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('merchandise', 'MerchandiseService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('merchandise/newest/{limit}', 'MerchandiseService@newest', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('splink/{taxon}/{offset}/{limit}', 'SplinkService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('britannica/{taxon}/{limit}', 'BritannicaService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('col/{taxon}/{limit}', 'CatalogOfLifeService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.',
    'middleware' => 'auth:api'
], function () {
    Route::resource('taxonomy/group', 'TaxonomyGroupService');
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('taxonomy/group', 'TaxonomyGroupService@index', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('rank/search/kingdom/{value}', 'TaxonomyGroupService@bykingdom', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('rank/search/phylum/{value}', 'TaxonomyGroupService@byphylum', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('rank/search/class/{value}', 'TaxonomyGroupService@byclass', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('rank/search/order/{value}', 'TaxonomyGroupService@byorder', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('rank/search/family/{value}', 'TaxonomyGroupService@byfamily', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('rank/search/genus/{value}', 'TaxonomyGroupService@bygenus', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});

Route::group([
    'prefix' => '/v1',
    'namespace' => 'Api\V1',
    'as' => 'api.'
], function () {
    Route::get('rank/search/specie/{value}', 'TaxonomyGroupService@byspecie', [
        'except' => [ 'create', 'edit', 'update', 'store', 'delete' ]
    ]);
});
