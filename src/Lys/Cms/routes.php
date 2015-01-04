<?php


Route::get('{all}', [
    'uses' => 'Lys\Cms\Controllers\RouteController@route'
])->where('all', '.*');