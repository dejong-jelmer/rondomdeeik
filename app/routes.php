<?php 



return [

/**
 *  example of route:
 *  'the/url' => [
 *      'name' => 'routeName', // as used in Controller $this->route() method
 *      'uses' => 'ControllerName@Method', 
 *      'allow' => ['GET', 'POST'], //set the allowed HTTP Request Methods
 *      'acces' => ['guest', 'auth'], //set who has acces guest or authenticated user
 *  ];
 */

    '' => [
        'name' => 'home',
        'uses' => 'HomeController@index',
        'allow' => ['GET'],
        'acces' => ['guest', 'auth']
    ],

    'auth/login' => [
        'name' => 'auth/login',
        'uses' => 'AuthController@userLogin',
        'allow' => ['POST'],
        'acces' => ['guest']

    ],

    'auth/logout' => [
        'name' => 'auth/logout',
        'uses' => 'AuthController@userLogout',
        'allow' => ['GET'],
        'acces' => ['auth']

    ],

    'admin/login' => [
        'name' => 'admin/login',
        'uses' => 'AdminController@getAdminLogin',
        'allow' => ['GET'],
        'acces' => ['guest']

    ],

    'admin/edit' => [
        'name' => 'admin/edit',
        'uses' => 'AdminController@getAdminEdit',
        'allow' => ['GET'],

    ], 

   
    'page/create' => [
        'name' => 'page/create',
        'uses' => 'PageController@createPage',
        'allow' => ['POST'],
        'acces' => ['auth']

    ],

 
    'article/create' => [
        'name' => 'article/create',
        'uses' => 'ArticleController@editArticle',
        'allow' => ['POST'],
        'acces' => ['auth']

    ],

    'image/delete' => [
        'name' => 'image/delete',
        'uses' => 'ImageController@deleteImage',
        'allow' => ['POST'],
        'acces' => ['auth']

    ],

    'admin/account' => [
        'name' => 'admin/account',
        'uses' => 'AdminController@adminAccount',
        'allow' => ['GET'],

    ],

    'auth/register' => [
        'name' => 'auth/register',
        'uses' => 'AuthController@registerUser',
        'allow' => ['POST'],
        'acces' => ['auth']

    ],

    'auth/editpassword' => [
        'name' => 'auth/editpassword',
        'uses' => 'AuthController@editPassword',
        'allow' => ['POST'],
        'acces' => ['auth']

    ],








];

