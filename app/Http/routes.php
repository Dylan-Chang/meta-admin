<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

//默认页面
Route::get('/', 'Admin\HomeController@index');

//后台地址
Route::get('admin', function () {
    return view('admin/index');
});

Route::get('admin/item/upload', 'Admin\ItemController@upload');
Route::post('admin/item/upload', 'Admin\ItemController@upload');

//角色
Route::get('admin/role/index',['as' => 'admin.role.index', 'uses' => 'Admin\RoleController@index']);
Route::get('admin/role/create', 'Admin\RoleController@create');
Route::get('admin/role/assign', 'Admin\RoleController@assign');
Route::get('admin/role/addPermissions','Admin\RoleController@addPermissions');
Route::get('admin/role/check','Admin\RoleController@check');
Route::get('admin/role/create','Admin\RoleController@create');
Route::post('admin/role/store','Admin\RoleController@store');
Route::get('admin/role/edit/{id}','Admin\RoleController@edit');
Route::post('admin/role/update/{id}',['as' => 'admin.role.update', 'uses' => 'Admin\RoleController@update']);

//权限
Route::get('admin/permission/index',['as' => 'admin.permission.index', 'uses' => 'Admin\PermissionController@index']);
Route::get('admin/permission/create','Admin\PermissionController@create');
Route::post('admin/permission/store','Admin\permissionController@store');

//标签
Route::get('admin/tag/index',['as' => 'admin.tag.index', 'uses' => 'Admin\TagController@index']);
Route::get('admin/tag/create','Admin\TagController@create');
Route::post('admin/tag/store','Admin\TagController@store');
Route::get('admin/tag/edit/{id}','Admin\TagController@edit');
Route::post('admin/tag/update/{id}',['as' => 'admin.tag.update', 'uses' => 'Admin\TagController@update']);


/*
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
    Route::get('/', 'AdminController@welcome');
    Route::get('/manage', ['middleware' => ['permission:manage-admins'], 'uses' => 'AdminController@manageAdmins']);
});*/

Route::filter('manage_posts', function()
{
    // check the current user
    if (!Entrust::hasRole('admin')) {
        return Redirect::to('/');
    }
});
Route::when('admin/role*', 'manage_posts');
//  Route::get('admin/attribute/index','Admin\AttributeController@index');

//属性
Route::get('admin/attribute/index', 'Admin\AttributeController@index');
//Route::get('admin/attribute/index/{id}', 'Admin\AttributeController@index');
Route::post('admin/attribute/save', 'Admin\AttributeController@save');
Route::get('admin/attribute/create', 'Admin\AttributeController@create');
Route::get('admin/attribute/attrlist/{id}', 'Admin\AttributeController@attrlist');


Route::get('admin/itemcat/index', 'Admin\ItemCatController@index');
Route::get('admin/item/index', 'Admin\ItemController@index');
Route::post('admin/item/save', 'Admin\ItemController@save');
Route::get('admin/item/select', 'Admin\ItemController@select');

Route::get('admin/itemtype/index', ['as' => 'admin.itemtype.index', 'uses' => 'Admin\ItemTypeController@index']);
Route::get('admin/itemtype/create', 'Admin\ItemTypeController@create');
Route::post('admin/itemType/save', 'Admin\ItemTypeController@save');
Route::get('admin/item/getItemType', 'Admin\ItemController@getItemType');
Route::get('admin/item/details/{id}', 'Admin\ItemController@details');
Route::get('admin/item/edit/{id}', 'Admin\ItemController@edit');
Route::post('admin/item/destroy/{id}', 'Admin\ItemController@destroy');

Route::get('admin/coupon/index', ['as' => 'admin.coupon.index', 'uses' => 'Admin\CouponController@index']);
Route::get('admin/coupon/create', 'Admin\CouponController@create');
Route::post('admin/coupon/store', 'Admin\CouponController@store');
Route::get('admin/coupon/send/{id}', 'Admin\CouponController@send');
Route::post('admin/coupon/sendPrint', 'Admin\CouponController@sendPrint');




//后台登录判断
//$router->group(['namespace' => 'Admin', 'middleware' => ''], function () {

$router->group(['namespace' => 'Admin'], function () {
    resource('admin/item', 'ItemController');
    resource('admin/attribute', 'AttributeController');
    // get('admin/upload', 'UploadController@index');
});


Route::get('user/index', 'UserController@index');
Route::get('user/create', 'UserController@create');

Route::get('item/index', 'ItemController@index');
Route::get('item/create', 'ItemController@create');
Route::post('item/save', 'ItemController@save');

Route::get('itemCat/index', 'ItemCatController@index');
Route::get('itemCat/create', 'ItemCatController@create');
Route::post('itemCat/save', 'ItemCatController@save');

/*
  Route::post('orders/index',['as'=>'order.index','uses'=>'OrdersController@index']);
  //Route::get('/orders/details/{id}','OrdersController@details');
  Route::get('/orders/details/{id}',['as' => 'order.details', 'uses' => 'OrdersController@details']);
  Route::get('orders/importExcel','OrdersController@importExcel');
  Route::get('orders/shippingCode/{id}','OrdersController@shippingCode');
  Route::get('/orders/showEdit/{id}','OrdersController@showEdit');
  Route::post('/orders/edit',['as' => 'order.edit', 'uses' => 'OrdersController@edit']);
  Route::get('/orders/redo/{taopixOrderId}','OrdersController@redo');

  Route::get('/orders/barcode', ['as' => 'order.barcode', 'uses' => 'OrdersController@barcode']);
  Route::post('/orders/barcodeInfo', ['as' => 'order.barcodeInfo', 'uses' => 'OrdersController@barcodeInfo']);
  Route::post('/orders/addShippingCode', ['as' => 'order.addShippingCode', 'uses' => 'OrdersController@addShippingCode']);
  Route::resource('orders','OrdersController'); */

Route::get('category/index', 'CategoryController@index');

Route::get('cart/add/{id}', 'CartController@add');
Route::get('cart/index', 'CartController@index');
Route::get('cart/checkout', 'CartController@checkout');
Route::get('cart/createOrder', 'CartController@createOrder');

Route::get('admin/upload', 'Admin\UploadController@index');
// 
Route::post('admin/upload/file', 'Admin\UploadController@uploadFile');
Route::delete('admin/upload/file', 'Admin\UploadController@deleteFile');
Route::post('admin/upload/folder', 'Admin\UploadController@createFolder');
Route::delete('admin/upload/folder', 'Admin\UploadController@deleteFolder');



Route::get('orders/index', ['as' => 'order.index', 'uses' => 'OrdersController@index']);
Route::post('orders/index', ['as' => 'order.index', 'uses' => 'OrdersController@index']);
//Route::get('/orders/details/{id}','OrdersController@details');
Route::get('/orders/details/{id}', ['as' => 'order.details', 'uses' => 'OrdersController@details']);
Route::post('orders/exportExcel', 'OrdersController@exportExcel');
Route::get('orders/importExcel', 'OrdersController@importExcel');

Route::get('orders/shippingCode/{id}', 'OrdersController@shippingCode');
Route::get('/orders/showEdit/{id}', 'OrdersController@showEdit');
Route::post('/orders/edit', ['as' => 'order.edit', 'uses' => 'OrdersController@edit']);
Route::get('/orders/redo/{taopixOrderId}', 'OrdersController@redo');

Route::get('/orders/getImgList', 'OrdersController@getImgList');

//$router->resource('orders', 'OrdersController');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::post('login/authenticate', 'LoginController@authenticate');

//日志

Route::get('admin/log/index', 'Admin\LogController@index');

//登录认证
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

// 
Route::get('/orders/barcode', ['as' => 'order.barcode', 'uses' => 'OrdersController@barcode']);
Route::post('/orders/barcodeInfo', ['as' => 'order.barcodeInfo', 'uses' => 'OrdersController@barcodeInfo']);
Route::post('/orders/addShippingCode', ['as' => 'order.addShippingCode', 'uses' => 'OrdersController@addShippingCode']);
Route::post('/orders/barcodePrintImg',['as' => 'order.barcodePrintImg', 'uses' =>'OrdersController@barcodePrintImg']);
Route::get('/orders/barcodeImg',['as' => 'order.barcodeImg', 'uses' =>'OrdersController@barcodeImg']);

//Route::get('notifications', 'OrdersController@');
Route::resource('orders', 'OrdersController');
//Route::controller('orders', 'OrdersController');




    