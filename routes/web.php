<?php
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;

use Illuminate\Http\Request;
use App\Helpers\Helper;

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

/* ----------------------------------- WEB PANEL --------------------------------------------- */
// SIGNIN ADMIN
Route::get('/', [AdminController::class, 'index']);
// SIGNIN ADMIN
/* ----------------------------------- WEB PANEL --------------------------------------------- */

/* ----------------------------------- ADMIN PANEL --------------------------------------------- */
// Base Authentication Routes
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/clear_cache', [AdminController::class, 'clear_cache']);

Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/logout', [AdminController::class, 'logout']);
// Base Authentication Routes

// DASHBOARD
Route::get('/admin/dashboard', [AdminController::class, 'Dashboard']);
// DASHBOARD

// USERS CUSTOMERS
Route::get('/admin/users_customers', [AdminController::class, 'users_customers']);
Route::get('/admin/users_customers_view/{id}', [AdminController::class, 'users_customers_view'])->name('users_customers_view');
Route::get('/admin/users_customers_update/{id}/{status}', [AdminController::class, 'users_customers_update'])->name('users_customers_update');
Route::get('/admin/users_customers_delete/{id}', [AdminController::class, 'users_customers_delete'])->name('users_customers_delete');
// USERS CUSTOMERS

//SUPPORT MANAGEMENT
Route::get('/admin/support', [AdminController::class, 'support']);
//SUPPORT MANAGEMENT

// USERS SYSTEM
Route::get('/admin/users_system', [AdminController::class, 'users_system']);
Route::get('/admin/users_system_update/{id}/{status}', [AdminController::class, 'users_system_update'])->name('users_system_update');
Route::get('/admin/users_system_delete/{id}', [AdminController::class, 'users_system_delete'])->name('users_system_delete');

Route::get('/admin/users_system_add', [AdminController::class, 'users_system_add']);
Route::post('/admin/users_system_add_data', [AdminController::class, 'users_system_add_data'])->name('users_system_add_data');

Route::get('/admin/users_system_edit/{id}', [AdminController::class, 'users_system_edit'])->name('users_system_edit');
Route::post('/admin/users_system_edit_data', [AdminController::class, 'users_system_edit_data'])->name('users_system_edit_data');
// USERS SYSTEM

// USERS SYSTEM
Route::get('/admin/users_system_roles', [AdminController::class, 'users_system_roles']);
Route::get('/admin/users_system_roles_delete/{id}', [AdminController::class, 'users_system_roles_delete'])->name('users_system_roles_delete');

Route::get('/admin/users_system_roles_add', [AdminController::class, 'users_system_roles_add']);
Route::post('/admin/users_system_roles_add_data', [AdminController::class, 'users_system_roles_add_data'])->name('users_system_roles_add_data');

Route::get('/admin/users_system_roles_edit/{id}', [AdminController::class, 'users_system_roles_edit'])->name('users_system_roles_edit');
Route::post('/admin/users_system_roles_edit_data', [AdminController::class, 'users_system_roles_edit_data'])->name('users_system_roles_edit_data');
// USERS SYSTEM

//Start GENERAl Settings
Route::get('/admin/account_settings', [AdminController::class, 'account_settings']);
Route::post('/admin/account_settings_update/{id}', [AdminController::class, 'account_settings_update'])->name('account_settings_update');

Route::get('/admin/system_settings', [AdminController::class, 'system_settings']);
Route::post('/admin/system_settings_edit', [AdminController::class, 'system_settings_edit']);

Route::get('/admin/system_about_us', [AdminController::class, 'system_about_us']);
Route::get('/admin/system_terms', [AdminController::class, 'system_terms']);
Route::get('/admin/system_privacy', [AdminController::class, 'system_privacy']);
//End GENERAl Settings

// CATEGORY
Route::get('/admin/categories', [AdminController::class, 'categories'])->name('categories');
Route::get('/admin/categories_fetch', [AdminController::class, 'categories_fetch'])->name('categories_fetch');
Route::post('/admin/category_update', [AdminController::class, 'category_update'])->name('category_update');
Route::post('/admin/category_delete', [AdminController::class, 'category_delete'])->name('category_delete');
Route::post('/admin/category_add_data', [AdminController::class, 'category_add_data'])->name('category_add_data');
Route::get('/admin/category_edit/{id}', [AdminController::class, 'category_edit'])->name('category_edit');
Route::post('/admin/category_edit_data', [AdminController::class, 'category_edit_data'])->name('category_edit_data');
// CATEGORY

// AUTHOR
Route::get('/admin/authors', [AdminController::class, 'authors'])->name('authors');
Route::get('/admin/authors_fetch', [AdminController::class, 'authors_fetch'])->name('authors_fetch');
Route::post('/admin/author_update', [AdminController::class, 'author_update'])->name('author_update');
Route::post('/admin/author_delete', [AdminController::class, 'author_delete'])->name('author_delete');
Route::post('/admin/author_add_data', [AdminController::class, 'author_add_data'])->name('author_add_data');
Route::get('/admin/author_edit/{id}', [AdminController::class, 'author_edit'])->name('author_edit');
Route::post('/admin/author_edit_data', [AdminController::class, 'author_edit_data'])->name('author_edit_data');
// AUTHOR

// BOOK
Route::get('/admin/books', [AdminController::class, 'books'])->name('books');
Route::get('/admin/books_fetch', [AdminController::class, 'books_fetch'])->name('books_fetch');
Route::post('/admin/book_update', [AdminController::class, 'book_update'])->name('book_update');
Route::post('/admin/book_delete', [AdminController::class, 'book_delete'])->name('book_delete');
Route::post('/admin/book_add_data', [AdminController::class, 'book_add_data'])->name('book_add_data');
Route::get('/admin/book_edit/{id}', [AdminController::class, 'book_edit'])->name('book_edit');
Route::post('/admin/book_edit_data', [AdminController::class, 'book_edit_data'])->name('book_edit_data');
// BOOK
/* ----------------------------------- ADMIN PANEL --------------------------------------------- */