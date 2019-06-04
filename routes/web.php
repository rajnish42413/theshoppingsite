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
//temporary
Route::get('/cron/product-slug','CronController@create_product_slug')->name('cron/product-slug');


Route::get('/home','HomeController@index')->name('home');

Route::any('/all-categories','HomeController@all_categories')->name('all-categories');
Route::any('/all-categories-ajax','HomeController@get_all_categories_ajax')->name('all-categories-ajax');
Route::any('/get-search','HomeController@search_form')->name('get-search');
Route::any('/search','HomeController@search_data')->name('search');

//Cron Live
Route::any('/cron/category-live','CronController@getCategory_live')->name('cron/category-live');
Route::any('/cron/by-category-live/{id}','CronController@getProductsByCategory_live')->name('cron/by-category-live');
Route::any('/cron/single-item-live/{id}','CronController@getSingleItem_live')->name('cron/single-item-live');
Route::any('/cron/product-by-category-ebay','CronController@by_category_ebay')->name('product-by-category-ebay');


Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('/profile', 'DashboardController@profile')->name('profile');
Route::any('/profile-update', 'DashboardController@profile_update')->name('profile-update');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::any('/change-password', 'DashboardController@change_password')->name('change-password');
Route::any('/password-update', 'DashboardController@password_update')->name('password-update');
Route::any('/image-update', 'DashboardController@image_update')->name('image-update');

Route::any('/contact', 'HomeController@contact')->name('contact');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/terms-of-use', 'HomeController@terms')->name('terms-of-use');
Route::get('/privacy-policy', 'HomeController@privacy_policy')->name('privacy-policy');
Route::get('/services', 'HomeController@services')->name('services');

Route::get('category/{id}', 'HomeController@search_list')->name('category');
Route::get('category/{id}/{brand}', 'HomeController@search_list')->name('category');
Route::get('product/{id}', 'HomeController@product_detail')->name('product');
Route::get('brand/{id}', 'HomeController@search_by_brands')->name('brand');
Route::post('get-products-ajax', 'HomeController@get_products_ajax')->name('get-products-ajax');
Route::post('get-products-search-ajax', 'HomeController@get_products_search_ajax')->name('get-products-search-ajax');

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
 	Route::get('parent-categories-list', 'CategoriesController@index2')->name('parent-categories-list');	
	Route::get('searchajaxcategories', 'CategoriesController@ajax_list')->name('searchajaxcategories');	
	Route::get('searchajaxparentcategories', 'CategoriesController@ajax_list2')->name('searchajaxparentcategories');	
	Route::any('categories-add', 'CategoriesController@add')->name('categories-add');	
	Route::any('categories-edit/{id?}', 'CategoriesController@add');	
	Route::any('categories-save', 'CategoriesController@save_data')->name('categories-save');	
	Route::any('categories-delete', 'CategoriesController@delete_data')->name('categories-delete'); 
	Route::any('get-categories-by-parent', 'CategoriesController@get_category_by_parent')->name('get-categories-by-parent'); 	
	Route::any('get-sub-categories-by-parent', 'CategoriesController@get_sub_category_by_parent')->name('get-sub-categories-by-parent'); 	
	Route::any('get-sub2-categories-by-parent', 'CategoriesController@get_sub2_category_by_parent')->name('get-sub2-categories-by-parent'); 
	Route::any('categories-status', 'CategoriesController@status_update')->name('categories-status');
	Route::any('categories-status-multiple', 'CategoriesController@status_multiple_update')->name('categories-status-multiple');	
	
	// Products 
 	Route::get('products-list', 'ProductsController@index')->name('products-list');	
	Route::get('searchajaxproducts', 'ProductsController@ajax_list')->name('searchajaxproducts');	
	Route::any('products-add', 'ProductsController@add')->name('products-add');	
	Route::any('products-import', 'ProductsController@import')->name('products-import');	
	Route::any('products-import-save', 'ProductsController@import_save_data')->name('products-import-save');	
	Route::any('excel-generate', 'ProductsController@excel_genrate')->name('excel-generate');	
	Route::any('products-edit/{id?}', 'ProductsController@add');	
	Route::any('products-save', 'ProductsController@save_data')->name('products-save');	
	Route::any('products-delete', 'ProductsController@delete_data')->name('products-delete');
	Route::any('products-status', 'ProductsController@status_update')->name('products-status');
	Route::any('products-status-multiple', 'ProductsController@status_multiple_update')->name('products-status-multiple');
	
	// Navigation Menu 
	Route::get('navigation-menu-list', 'NavigationMenuController@index')->name('navigation-menu-list');	
	Route::get('searchajaxnavmenu', 'NavigationMenuController@ajax_list')->name('searchajaxnavmenu');	
	Route::any('navigation-menu-add', 'NavigationMenuController@add')->name('navigation-menu-add');	
	Route::any('navigation-menu-edit/{id?}', 'NavigationMenuController@add');	
	Route::any('navigation-menu-save', 'NavigationMenuController@save_data')->name('navigation-menu-save');	
	Route::any('navigation-menu-delete', 'NavigationMenuController@delete_data')->name('navigation-menu-delete');
	
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
	
 	Route::any('settings-home', 'FrontPagesController@home')->name('settings-home');	
 	Route::any('settings-about', 'FrontPagesController@about')->name('settings-about');	
 	Route::any('settings-faq', 'FrontPagesController@faq')->name('settings-faq');	
 	Route::any('settings-terms', 'FrontPagesController@terms')->name('settings-terms');	
 	Route::any('settings-privacy-policy', 'FrontPagesController@privacy_policy')->name('settings-privacy-policy');	
 	Route::any('settings-contact', 'FrontPagesController@contact')->name('settings-contact');	


	// Enquiry 
 	Route::get('enquiries-list', 'EnquiryController@index')->name('enquiries-list');	
	Route::get('searchajaxenquiries', 'EnquiryController@ajax_list')->name('searchajaxenquiries');
	Route::any('enquiries-delete', 'EnquiryController@delete_data')->name('enquiries-delete');		
		
	// Settings 
	Route::any('settings-edit', 'SettingsController@add')->name('settings-edit');	
	Route::any('settings-save', 'SettingsController@save_data')->name('settings-save');	
	Route::any('social-settings-save', 'SettingsController@save_data2')->name('social-settings-save');
	Route::any('api-settings-save', 'SettingsController@save_data3')->name('api-settings-save');	
	Route::any('social-settings-delete', 'SettingsController@social_link_delete')->name('social-settings-delete');	

	// Users 
 	Route::get('users-list', 'UsersController@index')->name('users-list');	
	Route::get('searchajaxusers', 'UsersController@ajax_list')->name('searchajaxusers');	
	Route::any('users-add', 'UsersController@add')->name('users-add');	
	Route::any('users-edit/{id?}', 'UsersController@add');	
	Route::any('users-save', 'UsersController@save_data')->name('users-save');	
	Route::any('users-delete', 'UsersController@delete_data')->name('users-delete'); 
	Route::any('users-status', 'UsersController@status_update')->name('users-status');
	Route::any('users-status-multiple', 'UsersController@status_multiple_update')->name('users-status-multiple');	
		
});