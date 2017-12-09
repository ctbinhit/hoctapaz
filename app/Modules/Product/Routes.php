<?php

$namespace = 'App\Modules\Product\Controllers';

Route::group(
        ['module' => 'Category', 'namespace' => $namespace], function() {
    Route::get('binhcao', [
        # middle here
        'as' => 'index',
        'uses' => 'ProductController@get_index'
    ]);
}
);
