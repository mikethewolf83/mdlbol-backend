<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('', function () {
    return redirect('api/v1');
});

$router->get('api/v1', function () use ($router) {
    $packageJson = json_decode(file_get_contents(base_path() . '/composer.json'), true);
    $packageObject = (object) $packageJson;
    return response()->json([
        "data" => [
            "name"        => $packageObject->name,
            "description" => $packageObject->description,
            "version"     => $packageObject->version,
            "license"     => $packageObject->license,
            "api_routes"  => $router->getRoutes()
        ]
    ]);
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    /**
     * Auth login method
     */
    $router->post('auth/login', ['uses' => 'AuthController@login']);

    /**
     * AUTHENTICATED ROUTES
     */
    $router->group(['middleware' => 'auth'], function ($router) {

        /**
         * Auth logout, refresh, userInfo and admin methods
         */
        $router->post('auth/logout',  ['uses' => 'AuthController@logout']);
        $router->post('auth/refresh', ['uses' => 'AuthController@refresh']);
        $router->get('auth/me',       ['uses' => 'AuthController@me']);
        // Only Admins can create profiles and get professors list
        $router->group(['middleware' => 'can:admin'], function ($router) {
            $router->get('auth/profile/list',    ['uses' => 'AuthController@profiles']);
            $router->post('auth/profile/new',    ['uses' => 'AuthController@newProfile']);
            $router->post('auth/profile/delete', ['uses' => 'AuthController@deleteProfile']);
            $router->get('auth/professors',      ['uses' => 'AuthController@professors']);
        });

        /**
         * Primaria
         */
        // 1EP
        $router->group(['middleware' => 'can:1ep'], function ($router) {
            $router->get('prim/1ep',                         ['uses' => 'EP\OneEPController@index']);
            $router->get('prim/1ep/group',                   ['uses' => 'EP\OneEPController@group']);
            $router->get('prim/1ep/students',                ['uses' => 'EP\OneEPController@students']);
            $router->post('prim/1ep/feedback/moodle/update', ['uses' => 'EP\OneEPController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('prim/1ep/feedback/cidead/new',    ['uses' => 'EP\OneEPController@newCidead']);
                $router->post('prim/1ep/feedback/cidead/update', ['uses' => 'EP\OneEPController@updateCidead']);
                $router->post('prim/1ep/feedback/cidead/delete', ['uses' => 'EP\OneEPController@deleteCidead']);
            });
        });
        // 2EP
        $router->group(['middleware' => 'can:2ep'], function ($router) {
            $router->get('prim/2ep',                         ['uses' => 'EP\TwoEPController@index']);
            $router->get('prim/2ep/group',                   ['uses' => 'EP\TwoEPController@group']);
            $router->get('prim/2ep/students',                ['uses' => 'EP\TwoEPController@students']);
            $router->post('prim/2ep/feedback/moodle/update', ['uses' => 'EP\TwoEPController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('prim/2ep/feedback/cidead/new',    ['uses' => 'EP\TwoEPController@newCidead']);
                $router->post('prim/2ep/feedback/cidead/update', ['uses' => 'EP\TwoEPController@updateCidead']);
                $router->post('prim/2ep/feedback/cidead/delete', ['uses' => 'EP\TwoEPController@deleteCidead']);
            });
        });
        // 3EP
        $router->group(['middleware' => 'can:3ep'], function ($router) {
            $router->get('prim/3ep',                         ['uses' => 'EP\TwoEPController@index']);
            $router->get('prim/3ep/group',                   ['uses' => 'EP\ThreeEPController@group']);
            $router->get('prim/3ep/students',                ['uses' => 'EP\ThreeEPController@students']);
            $router->post('prim/3ep/feedback/moodle/update', ['uses' => 'EP\ThreeEPController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('prim/3ep/feedback/cidead/new',    ['uses' => 'EP\ThreeEPController@newCidead']);
                $router->post('prim/3ep/feedback/cidead/update', ['uses' => 'EP\ThreeEPController@updateCidead']);
                $router->post('prim/3ep/feedback/cidead/delete', ['uses' => 'EP\ThreeEPController@deleteCidead']);
            });
        });
        // 4EP
        $router->group(['middleware' => 'can:4ep'], function ($router) {
            $router->get('prim/4ep',                         ['uses' => 'EP\FourEPController@index']);
            $router->get('prim/4ep/group',                   ['uses' => 'EP\FourEPController@group']);
            $router->get('prim/4ep/students',                ['uses' => 'EP\FourEPController@students']);
            $router->post('prim/4ep/feedback/moodle/update', ['uses' => 'EP\FourEPController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('prim/4ep/feedback/cidead/new',    ['uses' => 'EP\FourEPController@newCidead']);
                $router->post('prim/4ep/feedback/cidead/update', ['uses' => 'EP\FourEPController@updateCidead']);
                $router->post('prim/4ep/feedback/cidead/delete', ['uses' => 'EP\FourEPController@deleteCidead']);
            });
        });
        // 5EP
        $router->group(['middleware' => 'can:5ep'], function ($router) {
            $router->get('prim/5ep',                         ['uses' => 'EP\FiveEPController@index']);
            $router->get('prim/5ep/group',                   ['uses' => 'EP\FiveEPController@group']);
            $router->get('prim/5ep/students',                ['uses' => 'EP\FiveEPController@students']);
            $router->post('prim/5ep/feedback/moodle/update', ['uses' => 'EP\FiveEPController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('prim/5ep/feedback/cidead/new',    ['uses' => 'EP\FiveEPController@newCidead']);
                $router->post('prim/5ep/feedback/cidead/update', ['uses' => 'EP\FiveEPController@updateCidead']);
                $router->post('prim/5ep/feedback/cidead/delete', ['uses' => 'EP\FiveEPController@deleteCidead']);
            });
        });
        // 6EP
        $router->group(['middleware' => 'can:6ep'], function ($router) {
            $router->get('prim/6ep',                         ['uses' => 'EP\SixEPController@index']);
            $router->get('prim/6ep/group',                   ['uses' => 'EP\SixEPController@group']);
            $router->get('prim/6ep/students',                ['uses' => 'EP\SixEPController@students']);
            $router->post('prim/6ep/feedback/moodle/update', ['uses' => 'EP\SixEPController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('prim/6ep/feedback/cidead/new',    ['uses' => 'EP\SixEPController@newCidead']);
                $router->post('prim/6ep/feedback/cidead/update', ['uses' => 'EP\SixEPController@updateCidead']);
                $router->post('prim/6ep/feedback/cidead/delete', ['uses' => 'EP\SixEPController@deleteCidead']);
            });
        });

        /**
         * ESO
         */
        // 1ESO
        $router->group(['middleware' => 'can:1eso'], function ($router) {
            $router->get('eso/1eso',                         ['uses' => 'ESO\OneESOController@index']);
            $router->get('eso/1eso/group',                   ['uses' => 'ESO\OneESOController@group']);
            $router->get('eso/1eso/students',                ['uses' => 'ESO\OneESOController@students']);
            $router->post('eso/1eso/feedback/moodle/update', ['uses' => 'ESO\OneESOController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('eso/1eso/feedback/cidead/new',    ['uses' => 'ESO\OneESOController@newCidead']);
                $router->post('eso/1eso/feedback/cidead/update', ['uses' => 'ESO\OneESOController@updateCidead']);
                $router->post('eso/1eso/feedback/cidead/delete', ['uses' => 'ESO\OneESOController@deleteCidead']);
            });
        });
        // 2ESO
        $router->group(['middleware' => 'can:2eso'], function ($router) {
            $router->get('eso/2eso',                         ['uses' => 'ESO\TwoESOController@index']);
            $router->get('eso/2eso/group',                   ['uses' => 'ESO\TwoESOController@group']);
            $router->get('eso/2eso/students',                ['uses' => 'ESO\TwoESOController@students']);
            $router->post('eso/2eso/feedback/moodle/update', ['uses' => 'ESO\TwoESOController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('eso/2eso/feedback/cidead/new',    ['uses' => 'ESO\TwoESOController@newCidead']);
                $router->post('eso/2eso/feedback/cidead/update', ['uses' => 'ESO\TwoESOController@updateCidead']);
                $router->post('eso/2eso/feedback/cidead/delete', ['uses' => 'ESO\TwoESOController@deleteCidead']);
            });
        });
        // 3ESO
        $router->group(['middleware' => 'can:3eso'], function ($router) {
            $router->get('eso/3eso',                         ['uses' => 'ESO\ThreeESOController@index']);
            $router->get('eso/3eso/group',                   ['uses' => 'ESO\ThreeESOController@group']);
            $router->get('eso/3eso/students',                ['uses' => 'ESO\ThreeESOController@students']);
            $router->post('eso/3eso/feedback/moodle/update', ['uses' => 'ESO\ThreeESOController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('eso/3eso/feedback/cidead/new',    ['uses' => 'ESO\ThreeESOController@newCidead']);
                $router->post('eso/3eso/feedback/cidead/update', ['uses' => 'ESO\ThreeESOController@updateCidead']);
                $router->post('eso/3eso/feedback/cidead/delete', ['uses' => 'ESO\ThreeESOController@deleteCidead']);
            });
        });
        // 4ESO
        $router->group(['middleware' => 'can:4eso'], function ($router) {
            $router->get('eso/4eso',                         ['uses' => 'ESO\FourESOController@index']);
            $router->get('eso/4eso/group',                   ['uses' => 'ESO\FourESOController@group']);
            $router->get('eso/4eso/students',                ['uses' => 'ESO\FourESOController@students']);
            $router->post('eso/4eso/feedback/moodle/update', ['uses' => 'ESO\FourESOController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('eso/4eso/feedback/cidead/new',    ['uses' => 'ESO\FourESOController@newCidead']);
                $router->post('eso/4eso/feedback/cidead/update', ['uses' => 'ESO\FourESOController@updateCidead']);
                $router->post('eso/4eso/feedback/cidead/delete', ['uses' => 'ESO\FourESOController@deleteCidead']);
            });
        });

        /**
         * BACH
         */
        // 1BACH
        $router->group(['middleware' => 'can:1bach'], function ($router) {
            $router->get('bach/1bach',                         ['uses' => 'BACH\OneBACHController@index']);
            $router->get('bach/1bach/group',                   ['uses' => 'BACH\OneBACHController@group']);
            $router->get('bach/1bach/students',                ['uses' => 'BACH\OneBACHController@students']);
            $router->post('bach/1bach/feedback/moodle/update', ['uses' => 'BACH\OneBACHController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('bach/1bach/feedback/cidead/new',    ['uses' => 'BACH\OneBACHController@newCidead']);
                $router->post('bach/1bach/feedback/cidead/update', ['uses' => 'BACH\OneBACHController@updateCidead']);
                $router->post('bach/1bach/feedback/cidead/delete', ['uses' => 'BACH\OneBACHController@deleteCidead']);
            });
        });
        // 2BACH
        $router->group(['middleware' => 'can:2bach'], function ($router) {
            $router->get('bach/2bach',                         ['uses' => 'BACH\TwoBACHController@index']);
            $router->get('bach/2bach/group',                   ['uses' => 'BACH\TwoBACHController@group']);
            $router->get('bach/2bach/students',                ['uses' => 'BACH\TwoBACHController@students']);
            $router->post('bach/2bach/feedback/moodle/update', ['uses' => 'BACH\TwoBACHController@updateMoodle']);
            // Only Supervisors, Managers and Admins can create, update and delete CIDEAD feedbacks
            $router->group(['middleware' => 'can:cidead'], function ($router) {
                $router->post('bach/2bach/feedback/cidead/new',    ['uses' => 'BACH\TwoBACHController@newCidead']);
                $router->post('bach/2bach/feedback/cidead/update', ['uses' => 'BACH\TwoBACHController@updateCidead']);
                $router->post('bach/2bach/feedback/cidead/delete', ['uses' => 'BACH\TwoBACHController@deleteCidead']);
            });
        });
    });
});
