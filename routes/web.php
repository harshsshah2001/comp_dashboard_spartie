<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolesPermission;
use App\Http\Controllers\SubProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Countdowns;
use App\Http\Controllers\InfocardsController;
use App\Http\Controllers\MailstoreController;


Route::get('/roles', [RolesPermission::class, 'roles'])->name('roles');
Route::post('/roles', [RolesPermission::class, 'rolesubmit'])->name('rolesubmit');
Route::get('/roles/edit/{id}', [RolesPermission::class, 'edit'])->name('roleedit');
Route::post('/roles/update/{id}', [RolesPermission::class, 'update']);
Route::delete('roles/delete/{id}', [RolesPermission::class, 'roledelete'])->name('roledelete');
Route::get('/role/list', [RolesPermission::class, 'rolelist'])->name('role.list');

Route::get('/permissions', [RolesPermission::class, 'permissions'])->name('permissions');
Route::post('/permissions', [RolesPermission::class, 'permissionsubmit'])->name('permissionsubmit');

// fetch permissions list
Route::get('/permissions/list', [RolesPermission::class, 'getPermissions'])
    ->name('permissions.list');

// save role permissions
Route::post('/permissions/assign', [RolesPermission::class, 'assignPermissions'])
    ->name('permissions.assign');


Route::post('/roles', [RolesPermission::class, 'rolesubmit'])->name('rolesubmit');
Route::get('/permission/edit/{id}', [RolesPermission::class, 'permissionedit'])->name('permissionedit');
Route::post('/permission/update/{id}', [RolesPermission::class, 'permissionupdate']);
Route::delete('permission/delete/{id}', [RolesPermission::class, 'permissiondelete'])->name('permissiondelete');
Route::get('/role-permission-list', [RolesPermission::class, 'role_permission_list'])->name('role_permission_list');
Route::get('/user-lists', [RolesPermission::class, 'user_list'])->name('userlist');
Route::post('/user/submit', [RolesPermission::class, 'usersubmit'])->name('user.submit');
Route::delete('user/delete/{id}', [RolesPermission::class, 'userdelete'])->name('userdelete');



// Roles and permissions routes


Route::get('/roles', [RolesPermission::class, 'roles'])->name('roles');
Route::post('/roles', [RolesPermission::class, 'rolesubmit'])->name('rolesubmit');
Route::get('/roles/edit/{id}', [RolesPermission::class, 'edit'])->name('roleedit');
Route::post('/roles/update/{id}', [RolesPermission::class, 'update']);
Route::delete('roles/delete/{id}', [RolesPermission::class, 'roledelete'])->name('roledelete');
Route::get('/role/list', [RolesPermission::class, 'rolelist'])->name('role.list');
Route::get('/permissions', [RolesPermission::class, 'permissions'])->name('permissions');
Route::post('/permissions', [RolesPermission::class, 'permissionsubmit'])->name('permissionsubmit');

// fetch permissions list
Route::get('/permissions/list', [RolesPermission::class, 'getPermissions'])
    ->name('permissions.list');

Route::post('/roles', [RolesPermission::class, 'rolesubmit'])->name('rolesubmit');
Route::get('/permission/edit/{id}', [RolesPermission::class, 'permissionedit'])->name('permissionedit');
Route::post('/permission/update/{id}', [RolesPermission::class, 'permissionupdate']);
Route::delete('permission/delete/{id}', [RolesPermission::class, 'permissiondelete'])->name('permissiondelete');
Route::get('/role-permission-list', [RolesPermission::class, 'role_permission_list'])->name('role_permission_list');
Route::post('/permissions/assign', [RolesPermission::class, 'assignPermissions'])
    ->name('permissions.assign');

Route::get('/user-lists', [RolesPermission::class, 'user_list'])->name('userlist');
Route::post('/user/submit', [RolesPermission::class, 'usersubmit'])->name('user.submit');
Route::delete('user/delete/{id}', [RolesPermission::class, 'userdelete'])->name('userdelete');





// Admin Login Routes
Route::get('/loginform', [AdminController::class, 'signinform'])->name('loginform');
Route::get('/registerform', [AdminController::class, 'signupinform'])->name('registerform');
Route::post('/registerform/post', [AdminController::class, 'registerpost'])->name('register.post');
Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');

// Admin Dashboard
Route::middleware('auth:userlist')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


    // Category Routes
    Route::get('/category/create', [CategoryController::class, 'categoryform'])->name('category.create');
    Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/admin/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    Route::get('/admin/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/admin/category/update/{id}', [CategoryController::class, 'update']);
    Route::get('/admin/category/list', [CategoryController::class, 'list'])->name('category.list');
    Route::post('/admin/product/upload-multiple', [ProductController::class, 'uploadMultiple'])->name('product.multiple.upload');


    //for refresh a category dropdown
    Route::get('/category/titles', [CategoryController::class, 'titles'])->name('category.titles');

    Route::get('/admin/category/chart', [CategoryController::class, 'chart'])->name('category.chart');

    // Product Routes
    Route::get('/product/create', [ProductController::class, 'productform'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/admin/product/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/admin/product/update/{id}', [ProductController::class, 'update']);
    Route::get('/admin/product/list', [ProductController::class, 'list'])->name('product.list');
    Route::delete('/admin/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    // SubProduct Routes
    Route::get('sub/product/create', [SubProductController::class, 'subproductform'])->name('sub.product.create');


    // Roles and permissions routes


    //ImageBox Routes

    Route::get('/admin/imagebox', [AdminController::class, 'imagebox'])->name('admin.imagebox');
    Route::post('/admin/imagebox/store', [AdminController::class, 'storeImagebox'])->name('imagebox.store');


    // Slider Routes
    Route::get('/admin/slider', [AdminController::class, 'slider'])->name('admin.slider');
    Route::post('/admin/slider', [AdminController::class, 'storeslider'])->name('slider.store');


    // CountDown Routes
    Route::get('/admin/countdown/create', [Countdowns::class, 'countdown'])->name('countdown.create');
    Route::post('/admin/countdown/store', [Countdowns::class, 'storecountdown'])->name('countdown.store');

    // InfoCards Routes
    Route::get('/admin/infocards/create', [InfocardsController::class, 'infocards'])->name('infocards.create');
    Route::post('/admin/infocards/store', [InfocardsController::class, 'storeinfocards'])->name('infocards.store');

    // Blogs Routes
    Route::get('/admin/blogs/create', [BlogController::class, 'blog'])->name('blog.create');
    Route::post('/admin/blog/store', [BlogController::class, 'storeblog'])->name('blog.store');
});

// Frontend Routes

Route::get('/Homepage', [UserController::class, 'Homepage'])->name('homepage');

Route::post('/mail', [MailstoreController::class, 'Mail'])->name('mail.store');
