<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('front.index');
})->name('home-1');

Route::get('home', 'TagController@home');

Auth::routes();

Route::get('login', function () {
    return view('auth.login');
})->name('login');
Route::post('login', 'UserController@authenticate')->name('authenticate');
Route::get('logout', 'UserController@logout')->name('logout');

Route::post('calc-acompte', 'OrderController@calc_acompte');

/**
 * @Strict Keep those routers in this order.
 */
Route::get('sub-tags/{id}', 'SubTagController@getSubTags')->where('id', '[0-9]+');

Route::get('products/fetch/{id}', 'ProductController@fetch')->where('id', '[0-9]+');
Route::get('products/search/{keyword}', 'ProductController@search');
Route::get('products/{type?}/{cat?}/{sort?}', 'ProductController@all');
Route::post('products/items', 'ProductController@items');

Route::get('cart', 'CartController@index');
Route::post('cart/remove', 'CartController@remove');
Route::post('cart/qty', 'CartController@qty');
Route::post('cart/add/{save}', 'CartController@cart')->where('save', '[0,1]');
Route::get('cart/order/{id}', 'CartController@order')->where('id', '[0-9]+')->middleware('auth');
Route::get('cart/destroy', 'CartController@destroy');
    
Route::post('order/submit', 'OrderController@store')->middleware('auth');
Route::get('order/print/{id}', 'OrderController@imprimer')->where('id', '[0-9]+')->middleware('auth');


// Route::group(['prefix' => 'backend',  'middleware' => 'auth'], function() {
Route::group(['prefix' => 'backend',  'middleware' => 'auth'], function() {
    
    Route::get('dashboard', function () {
        return view('backend.dashboard');
    })->name('dashboard');


    Route::resources([
        'administrators' => 'AdministratorController',
    ]);

    
    Route::resource('companies', 'CompanyController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('companies/update/status', 'CompanyController@status');
    Route::post('companies/delete/{id}', 'CompanyController@destroy')->where('id', '[0-9]+');
        
    Route::get('company', 'CompanyController@company');
    Route::post('company/update', 'CompanyController@company_update');

    Route::resource('company-sections', 'CompanySectionController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('company-sections/update/status', 'CompanySectionController@status');
    Route::post('company-sections/delete/{id}', 'CompanySectionController@destroy')->where('id', '[0-9]+');

    Route::resource('users', 'UserController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('users/update/status', 'UserController@status');
    Route::post('users/delete/{id}', 'UserController@destroy')->where('id', '[0-9]+');

    Route::resource('components', 'ComponentController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('components/update/status', 'ComponentController@status');
    Route::post('components/delete/{id}', 'ComponentController@destroy')->where('id', '[0-9]+');

    /*
    Route::resource('component-groups', 'ComponentGroupController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('component-groups/update/status', 'ComponentGroupController@status');
    Route::post('component-groups/delete/{id}', 'ComponentGroupController@destroy')->where('id', '[0-9]+');
    */

    /**
     * @source Customers 
     */
    Route::resource('customers', 'CustomerController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('customers/update/status', 'CustomerController@status');
    Route::post('customers/delete/{id}', 'CustomerController@destroy')->where('id', '[0-9]+');

    Route::post('orders/filter', 'OrderFilterController@filter');
    Route::get('orders/filter', function () {
        return redirect('backend/orders');
    });

    Route::resource('orders', 'OrderController', ['only' => [
        'index', 'show'
    ]]);
    Route::post('orders/calc-reste', 'OrderController@calc_reste');
    Route::post('orders/edit-order', 'OrderController@edit_order');
    
    Route::post('orders/status/update', 'OrderController@status');
    Route::get('orders/status/get/{id}', 'OrderController@status_get')->where('id', '[0-9]+');
    Route::get('orders/update/{id}', 'OrderController@update_order')->where('id', '[0-9]+');
    Route::post('orders/remove/item/{id}', 'OrderController@remove_item')->where('id', '[0-9]+');
    Route::post('orders/item/save/{id}', 'OrderController@update_item')->where('id', '[0-9]+');

    /**
     * @source Products 
     */
    Route::resource('products', 'ProductController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('products/update/status', 'ProductController@status');
    Route::post('products/delete/{id}', 'ProductController@destroy')->where('id', '[0-9]+');

    Route::resources([
        'product-components' => 'ProductComponentController',
    ]);

    Route::resources([
        'product-component-groups' => 'ProductComponentGroupController',
    ]);

    Route::resources([
        'product-component-prices' => 'ProductComponentPriceController',
    ]);

    Route::resources([
        'product-imgs' => 'ProductImgController',
    ]);

    Route::resources([
        'product-sales' => 'ProductSaleController',
    ]);

    Route::resources([
        'product-size-prices' => 'ProductSizePriceController',
    ]);

    Route::resources([
        'product-tags' => 'ProductTagController',
    ]);

    /**
     * @source Sizes 
     */
    Route::resource('sizes', 'SizeController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('sizes/update/status', 'SizeController@status');
    Route::post('sizes/delete/{id}', 'SizeController@destroy')->where('id', '[0-9]+');

    /**
     * @source Tags 
     */
    Route::resource('tags', 'TagController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('tags/update/status', 'TagController@status');
    Route::post('tags/delete/{id}', 'TagController@destroy')->where('id', '[0-9]+');

    /**
     * @source SubTags
     */
    Route::resource('sub-tags', 'SubTagController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('sub-tags/update/status', 'SubTagController@status');
    Route::post('sub-tags/get-items', 'SubTagController@get_items');
    Route::post('sub-tags/delete/{id}', 'SubTagController@destroy')->where('id', '[0-9]+');

    /**
     * @source Modules 
     */
    Route::resource('modules', 'ModuleController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('modules/update/status', 'ModuleController@status');
    Route::post('modules/delete/{id}', 'ModuleController@destroy')->where('id', '[0-9]+');

    /**
     * @source Module-Groups
     */
    Route::resource('module-groups', 'ModuleGroupController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::get('module-groups/add/group', 'ModuleGroupController@add');
    Route::post('module-groups/update/status', 'ModuleGroupController@status');
    Route::post('module-groups/delete/{id}', 'ModuleGroupController@destroy')->where('id', '[0-9]+');
    
    /**
     * @source user-permission
     */
    Route::resource('user-permissions', 'UserPermissionController', ['only' => [
        'index', 'show', 'update', 'store'
    ]]);
    Route::post('user-permissions/update/status', 'UserPermissionController@status');
    Route::post('user-permissions/delete/{id}', 'UserPermissionController@destroy')->where('id', '[0-9]+');
    
    Route::get('profile', 'UserController@profile');
    Route::post('profile/update', 'UserController@profile_update');

});
