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

Route::get('/','HomeController@index')->name('home');

Auth::routes();

Route::get('/home','HomeController@index')->name('home');
Route::any('/test','HomeController@test')->name('test');
Route::any('/cron/by-keyword','CronController@byKeyword')->name('cron/by-keyword');
Route::any('/cron/category','CronController@getCategory')->name('cron/category');
Route::any('/cron/by-category','CronController@getProductsByCategory')->name('cron/by-category');
Route::any('/cron/single-item/{id}','CronController@getSingleItem')->name('cron/single-item');


Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('/profile', 'DashboardController@profile')->name('profile');
Route::any('/profile-update', 'DashboardController@profile_update')->name('profile-update');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::any('/change-password', 'DashboardController@change_password')->name('change-password');
Route::any('/password-update', 'DashboardController@password_update')->name('password-update');
Route::any('/image-update', 'DashboardController@image_update')->name('image-update');
Route::post('hotel-get-cities', 'HotelController@get_hotel_cities')->name('hotel-get-cities');

Route::get('/blog', 'HomeController@blog')->name('blog');
Route::get('/pricing', 'HomeController@pricing')->name('pricing');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/terms-of-use', 'HomeController@terms')->name('terms-of-use');
Route::get('/privacy-policy', 'HomeController@privacy_policy')->name('privacy-policy');
Route::get('/services', 'HomeController@services')->name('services');


Route::post('hotel-get-cities', 'HotelController@get_hotel_cities')->name('hotel-get-cities');
Route::get('category/{id}', 'HomeController@search_list')->name('category');
Route::get('product/{id}', 'HomeController@product_detail')->name('product');




/*Admin Routes*/


Route::get('admin-login', 'Auth\AdminLoginController@showLoginForm')->name('admin-login');
Route::get('/admin/login_check', 'AdminController@login_check')->name('admin_login_check');
Route::get('/admin/logout', 'AdminController@logout')->name('admin_logout');

Route::group(['middleware'=>['Admin']],function(){
	Route::any('/admin', 'AdminController@index')->name('admin');
	Route::any('/admin-profile', 'UserController@admin_profile')->name('admin-profile');
	Route::any('/admin-profile-update', 'UserController@admin_profile_update')->name('admin-profile-update');
	Route::any('/admin-change-password', 'UserController@admin_change_password')->name('admin-change-password');
	Route::any('/admin-image-update', 'UserController@admin_image_update')->name('admin-image-update');

	Route::any('/admin-settings', 'UserController@settings')->name('admin-settings');
	Route::any('/admin-settings-update', 'UserController@settings_update')->name('admin-settings-update');
	
	/*SIDEBAR MENUS*/
	
	// Categories 
 	Route::get('categories-list', 'CategoriesController@index')->name('categories-list');	
	Route::get('searchajaxcategories', 'CategoriesController@ajax_list')->name('searchajaxcategories');	
	Route::any('categories-add', 'CategoriesController@add')->name('categories-add');	
	Route::any('categories-edit/{id?}', 'CategoriesController@add');	
	Route::any('categories-save', 'CategoriesController@save_data')->name('categories-save');	
	Route::any('categories-delete', 'CategoriesController@delete_data')->name('categories-delete'); 
	Route::any('get-categories-by-parent', 'CategoriesController@get_category_by_parent')->name('get-categories-by-parent'); 	
	
	// Products 
 	Route::get('products-list', 'ProductsController@index')->name('products-list');	
	Route::get('searchajaxproducts', 'ProductsController@ajax_list')->name('searchajaxproducts');	
	Route::any('products-add', 'ProductsController@add')->name('products-add');	
	Route::any('products-edit/{id?}', 'ProductsController@add');	
	Route::any('products-save', 'ProductsController@save_data')->name('products-save');	
	Route::any('products-delete', 'ProductsController@delete_data')->name('products-delete');
	
	// Banners 
 	Route::get('banners-list', 'BannersController@index')->name('banners-list');	
	Route::get('searchajaxbanners', 'BannersController@ajax_list')->name('searchajaxbanners');	
	Route::any('banners-add', 'BannersController@add')->name('banners-add');	
	Route::any('banners-edit/{id?}', 'BannersController@add');	
	Route::any('banners-save', 'BannersController@save_data')->name('banners-save');	
	Route::any('banners-delete', 'BannersController@delete_data')->name('banners-delete');	
		
	// Settings - Front Pages 
 	Route::any('settings-page-save', 'FrontPagesController@save_data')->name('settings-page-save');	
 	Route::any('settings-faq-delete', 'FrontPagesController@delete_faq_data')->name('settings-faq-delete');	
	
 	Route::any('settings-about', 'FrontPagesController@about')->name('settings-about');	
 	Route::any('settings-faq', 'FrontPagesController@faq')->name('settings-faq');	
 	Route::any('settings-terms', 'FrontPagesController@terms')->name('settings-terms');	
 	Route::any('settings-privacy-policy', 'FrontPagesController@privacy_policy')->name('settings-privacy-policy');	
 	Route::any('settings-contact', 'FrontPagesController@contact')->name('settings-contact');	
	
});