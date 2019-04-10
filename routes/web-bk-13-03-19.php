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

//ROUTE
Route::get('/', 'FrontEndController@index');
Route::get('logout', 'Auth\LoginController@logout');
 
//Route::group(['middleware' => 'auth'], function(){
Route::get('/main', 'MainController@index');
Route::post('/main/checklogin', 'MainController@checklogin');
Route::get('/main/successlogin', 'MainController@successlogin');
Route::get('main/logout', 'MainController@logout');

//ADMIN USER
Route::get('view-adminusers', 'AdminuserController@index');
Route::get('addadminuser', 'AdminuserController@addadminuser');
Route::post('registeradminuser', 'AdminuserController@store');
Route::get('destroyadminuser/{id}', 'AdminuserController@destroy');
Route::get('adminuserupdate/{id}', 'AdminuserController@show');
Route::post('adminuseredit/{id}', 'AdminuserController@edit');
Route::match(['GET', 'POST'], 'adminuser/filter', 'AdminuserController@filter');

//ADMIN USER PROFILE
Route::get('superadminshow/{id}', 'AdminuserController@showadmin');
Route::post('superadminedit/{id}', 'AdminuserController@editadmin');

//MANUFACTURER
Route::get('view-manufacturer', 'ManufacturerController@index');
Route::get('addmanufacturer', 'ManufacturerController@addmanufacturer');
Route::post('storemanufacturer', 'ManufacturerController@store');
Route::get('destroymanufacturer/{id}', 'ManufacturerController@destroy');
Route::get('manufacturerupdate/{id}', 'ManufacturerController@show');
Route::post('manufactureredit/{id}', 'ManufacturerController@edit');
Route::match(['GET', 'POST'], 'manufacturer/filter', 'ManufacturerController@filter');

//CATEGORY
Route::get('view-category', 'CategoryController@index');
Route::get('addcategory', 'CategoryController@addcategory');
Route::post('storecategory', 'CategoryController@store');
Route::get('destroycategory/{id}', 'CategoryController@destroy');
Route::get('categoryupdate/{id}', 'CategoryController@show');
Route::post('categoryedit/{id}', 'CategoryController@edit');
Route::match(['GET', 'POST'], 'category/filter', 'CategoryController@filter');

//IMPORTEXPORT
Route::get('importexport', 'ImportexportController@index');
Route::post('storeexport', 'ImportexportController@export');
Route::post('storeimport', 'ImportexportController@import');

//CUSTOMER
Route::get('view-customers', 'CustomerController@index');
Route::get('addcustomer', 'CustomerController@addcustomer');
Route::post('registercustomer', 'CustomerController@store');
Route::get('destroycustomer/{id}', 'CustomerController@destroy');
Route::get('customerupdate/{id}', 'CustomerController@show');
Route::post('customeredit/{id}', 'CustomerController@edit');
Route::match(['GET', 'POST'], 'customer/filter', 'CustomerController@filter');

//UNIT
Route::get('view-unit', 'UnitController@index');
Route::get('addunit', 'UnitController@addunit');
Route::post('storeunit', 'UnitController@store');
Route::get('destroyunit/{id}', 'UnitController@destroy');
Route::get('unitupdate/{id}', 'UnitController@show');
Route::post('unitedit/{id}', 'UnitController@edit');
Route::match(['GET', 'POST'], 'unit/filter', 'UnitController@filter');

//SLUG
Route::get('creatslug/{id}/{title}', 'CategoryController@slug');
Route::get('categoryupdate/creatslug/{id}/{title}', 'CategoryController@slug');

//SLIDER
Route::get('view-slider', 'SliderController@index');
Route::get('addslider', 'SliderController@addslider');
Route::post('storeslider', 'SliderController@store');
Route::get('destroyslider/{id}', 'SliderController@destroy');
Route::get('sliderupdate/{id}', 'SliderController@show');
Route::post('slideredit/{id}', 'SliderController@edit');
Route::match(['GET', 'POST'], 'slider/filter', 'SliderController@filter');

//CONTENT
Route::get('view-content', 'ContentController@index');
Route::get('addcontent', 'ContentController@addcontent');
Route::post('storecontent', 'ContentController@store');
Route::get('destroycontent/{id}', 'ContentController@destroy');
Route::get('contentupdate/{id}', 'ContentController@show');
Route::post('contentdit/{id}', 'ContentController@edit');
Route::match(['GET', 'POST'], 'content/filter', 'ContentController@filter');

//SLUG2
Route::get('creatslug2/{id}/{title}', 'ContentController@slug');
Route::get('contentupdate/creatslug2/{id}/{title}', 'ContentController@slug');

//FACILITY
Route::get('view-facility', 'FacilityController@index');
Route::get('addfacility', 'FacilityController@addfacility');
Route::post('storefacility', 'FacilityController@store');
Route::get('destroyfacility/{id}', 'FacilityController@destroy');
Route::get('facilityupdate/{id}', 'FacilityController@show');
Route::post('facilityedit/{id}', 'FacilityController@edit');
Route::match(['GET', 'POST'], 'facility/filter', 'FacilityController@filter');

//TESTIMONIAL
Route::get('view-testimonial', 'TestimonialController@index');
Route::get('addtestimonial', 'TestimonialController@addtestimonial');
Route::post('storetestimonial', 'TestimonialController@store');
Route::get('destroytestimonial/{id}', 'TestimonialController@destroy');
Route::get('testimonialupdate/{id}', 'TestimonialController@show');
Route::post('testimonialedit/{id}', 'TestimonialController@edit');
Route::match(['GET', 'POST'], 'testimonial/filter', 'TestimonialController@filter');

//USER ADDRESSES
//Route::post('addresses', 'UseraddressesController@store');
//Route::resource('addresses', 'UseraddressesController');
Route::resource('b-address', 'UbsController');
Route::get('destroyubs/{id}', 'UbsController@destroy');
Route::match(['GET', 'POST'], 'ubs/filter', 'UbsController@filter');

//REVIEWS
Route::match(['GET', 'POST'], 'review/filter', 'ReviewController@filter');
Route::resource('review', 'ReviewController');
Route::get('review/destroy/{id}', 'ReviewController@destroy');
Route::get('review/edit/{id}', 'ReviewController@edit');
Route::post('review/update', 'ReviewController@update');

//PRODUCTS
Route::match(['GET', 'POST'], 'product/filter', 'ProductController@filter');
Route::resource('product', 'ProductController');
Route::get('product/edit/{id}', 'ProductController@edit');
Route::get('product/destroy/{id}', 'ProductController@destroy');
Route::get('/addproduct/getAttributeSet', 'ProductController@getAttributeSet');
Route::get('addproduct', 'ProductController@add');
Route::post('storeproduct', 'ProductController@add');
Route::post('product/update', 'ProductController@update');
Route::get('product/getAttributeItem/{attr_id}', 'ProductController@getAttributeItem');
Route::get('product/delete_pdf/{id}', 'ProductController@delete_pdf');
Route::get('product/delete_video/{id}', 'ProductController@delete_video');
Route::get('product/delete_images/{id}', 'ProductController@delete_images');

//BEST SELLER
Route::get('bestsellerupdate/{id}', 'BestsellerController@show');
Route::post('bestselleredit/{id}', 'BestsellerController@edit');

//SEARCH KEYWORDS
Route::get('view-keyword', 'KeywordController@index');
Route::get('addkeyword', 'KeywordController@addkeyword');
Route::post('storekeyword', 'KeywordController@store');
Route::get('destroykeyword/{id}', 'KeywordController@destroy');
Route::get('keywordupdate/{id}', 'KeywordController@show');
Route::post('keywordedit/{id}', 'KeywordController@edit');
Route::post('saveAttributes', 'ProductController@saveValues');
Route::post('deleteAttributes', 'ProductController@deleteAttr');
Route::post('deletefilelinker', 'ProductController@deleteFileUnlink');
Route::resource('osc', 'OscoSettingsController');
Route::resource('sitesettings', 'SiteSettingsController');
Route::match(['GET', 'POST'], 'keyword/filter', 'KeywordController@filter');

//STATISTICS
Route::get('view-statistics', 'StatisticsController@index');
Route::get('view-piechart', 'StatisticsController@piechart');
Route::get('view-barhart', 'StatisticsController@barchart');
Route::get('order_report', 'StatisticsController@order_report');
Route::get('visitor_stats', 'StatisticsController@visitor_stats');
Route::get('visitor_stats_listing/{user_id}/{ip_address}', 'StatisticsController@visitor_stats_listing');
Route::get('visitor_carts_listing/{user_id}', 'StatisticsController@visitor_carts_listing');

/*
 * api routes for angular response 
 */
Route::prefix('angular')->group(function(){
	Route::any('/slider', 'AngularController@slider');
});

//NEWS
Route::get('news', 'NewsController@index');
Route::get('news/create', 'NewsController@create');
Route::get('news/edit/{id}', 'NewsController@edit');
Route::get('news/destroy/{id}', 'NewsController@destroy');
Route::post('news/update', 'NewsController@update');
Route::post('news/store', 'NewsController@store');
Route::match(['GET', 'POST'], 'news/filter', 'NewsController@filter');
Route::get('news/delete_img/{id}', 'NewsController@delete_img');
/*other front controller routes */
Route::get('category/{id}', 'FrontEndController@category');
Route::any('product-detail/{id}', 'FrontEndController@detailpage');

//CART
Route::post('addto_cart', 'CartController@index2');
Route::get('addto_cart', 'CartController@index2');
Route::get('product_remove/{product_id}/{unit_id}', 'CartController@product_remove');
Route::get('product_removeAll', 'CartController@product_removeAll');
//Route::get('/checkoutpage', 'CheckOutController@index');
Route::prefix('cart', function(){
	Route::get('checkout', 'CartController@index');
});
Route::post('cart_update', 'CartController@update');
Route::get('cart_update2/{product_id}/{quantity}/{unit_id}', 'CartController@updateCart2');
Route::post('cart/ajax_cart_items', 'CartController@ajax_cart_items');
Route::post('cart/ajax_cart', 'CartController@ajax_cart');
Route::post('cart/ajax', 'CartController@ajax');

Route::get('login_user/{pid}', 'LoginController@indexlogin');

//WISH LIST
Route::post('favorites/add_wishlist', 'FavouritesController@add_wishlist');
Route::get('favorites/add_wishlist', 'FavouritesController@add_wishlist');
Route::any('favorites/manage_wishlist/{id}', 'FavouritesController@manage_wishlist');
Route::any('favorites/manage_wishlist', 'FavouritesController@manage_wishlist');
Route::post('favorites/index', 'FavouritesController@index');
Route::get('favorites/remove/{fav_id}', 'FavouritesController@remove');

//QUOTE
Route::any('quote/index', 'QuoteController@index');
Route::get('updateQuote/{product_id}/{quantity}/{unit_id}', 'QuoteController@updateQuote');
Route::get('removeQuote/{product_id}/{unit_id}', 'QuoteController@removeQuote');
Route::any('quote/sendEmail', 'QuoteController@sendEmail');
Route::any('quote/thanks', 'QuoteController@thanks');

//FRONT LOGIN
Route::get('login_user', 'LoginController@index');
Route::post('/main/frontlogin', 'LoginController@checklogin');
Route::get('/login/successlogin', 'FrontEndController@index');
Route::get('frontlogout', 'LoginController@logout');
Route::post('addaddress', 'CheckOutController@add');

//FRONT REGISTER
Route::any('register/index', 'RegisterController@index');
Route::any('register/success', 'RegisterController@success');

//PROFILE
Route::any('profile/index', 'ProfileController@index');

//ACCOUNT
Route::any('account/index', 'AccountController@index');
Route::any('account/billing', 'AccountController@billing');

//BILLING
Route::any('billship/add/{billing}', 'BillshipController@add');
Route::any('billship/add', 'BillshipController@add');
Route::any('billship/edit/{id}', 'BillshipController@edit');
Route::any('billship/edit', 'BillshipController@edit');
Route::any('billship/remove/{id}', 'BillshipController@remove');

//ORDER
Route::any('order/index', 'OrderController@index');
Route::any('order/detail/{id}', 'OrderController@detail');
Route::any('order/reorder/{id}', 'OrderController@reorder');
Route::any('cart/index/reorder', 'CartController@index2');

//SAVE ORDER
Route::any('saveorder/index', 'SaveorderController@index');

//KIT QUOTE
Route::any('kit_quote/listing', 'Kit_quoteController@listing');

//});

//MAIN

/*Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/
