<?php
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DummyController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* ----------------------------------- WEB API PANEL --------------------------------------------- */
Route::get('/clear', function() {
    // $exitCode = Artisan::call('route:list');
    // echo 'Routes cache cleared'; echo "<br>";
    // exit;
    
    //$exitCode = Artisan::call('route:cache');
    //echo 'Routes cache cleared'; echo "<br>";

    $exitCode = Artisan::call('route:clear');
    echo 'Routes cache cleared'; echo "<br>";
     
    $exitCode = Artisan::call('config:cache');
    echo 'Config cache cleared'; echo "<br>";
    
    $exitCode = Artisan::call('cache:clear');
    echo 'Application cache cleared';  echo "<br>";
    
    $exitCode = Artisan::call('view:clear');
    echo 'View cache cleared';  echo "<br>";

    // $Command = Artisan::call('make:middleware Cors');
    Session::flash('message', 'Cache Cleared!'); 
    Session::flash('alert-class', 'alert-danger'); 
    return redirect('/admin/dashboard');
});


//USER AUTHENTICATION
Route::post('/signin', [ApiController::class, 'users_customers_login']);
Route::post('/signup', [ApiController::class, 'users_customers_signup']);
Route::post('/update_profile', [ApiController::class, 'update_profile']);
Route::post('/email_exist', [ApiController::class, 'email_exist']);
Route::post('/forgot_password', [ApiController::class, 'forgot_password']);
Route::post('/modify_password', [ApiController::class, 'modify_password']);

Route::post('/change_password', [ApiController::class, 'change_password']);
Route::post('/delete_account', [ApiController::class, 'delete_account']);
//USER AUTHENTICATION

//LIVE CHAT MESSAGES
Route::post('/getAllChatLive', [ApiController::class, 'getAllChatLive']);
Route::post('/user_chat_live', [ApiController::class, 'user_chat_live']);
Route::get('/get_admin_list', [ApiController::class, 'get_admin_list']);
//LIVE CHAT MESSAGES

//USER CHAT MESSAGES
Route::post('/getAllChat', [ApiController::class, 'getAllChat']);
Route::post('/user_chat', [ApiController::class, 'user_chat']);
//USER CHAT MESSAGES

//GET NOTIFICATIONS
Route::post('/notifications', [ApiController::class, 'notifications']);
Route::post('/notifications_unread', [ApiController::class, 'notifications_unread']);
Route::post('/messages_permission', [ApiController::class, 'messages_permission']);
Route::post('/notification_permission', [ApiController::class, 'notification_permission']);
//GET NOTIFICATIONS

//GET DATA
Route::post('/users_customers_profile', [ApiController::class, 'users_customers_profile']);
Route::get('/system_settings', [ApiController::class, 'system_settings'])->name('system_settings');
Route::post('/all_users', [ApiController::class, 'all_users']);  
Route::post('/all_users_suggested', [ApiController::class, 'all_users_suggested']);  
Route::get('/all_currencies', [ApiController::class, 'all_currencies']);
Route::get('/all_countries', [ApiController::class, 'all_countries']);
//GET DATA

//CREATE JOBS
Route::post('/jobs_create', [ApiController::class, 'jobs_create']);
//CREATE JOBS

//GET JOBS CUSTOMERS
Route::post('/get_pending_jobs', [ApiController::class, 'get_pending_jobs']);
Route::post('/get_ongoing_jobs', [ApiController::class, 'get_ongoing_jobs']);
Route::post('/get_previous_jobs', [ApiController::class, 'get_previous_jobs']);
//GET JOBS CUSTOMERS

//GET JOBS EMPLOYEE
Route::post('/get_jobs_employees', [ApiController::class, 'get_jobs_employees']);
Route::post('/jobs_action_employees', [ApiController::class, 'jobs_action_employees']);
Route::post('/get_previous_jobs_employees', [ApiController::class, 'get_previous_jobs_employees']);
//GET JOBS EMPLOYEE

//COMPLETE JOBS CUSTOMERS
Route::post('/jobs_customers_complete', [ApiController::class, 'jobs_customers_complete']);
//COMPLETE JOBS CUSTOMERS

//CATEGORY
Route::get('/categories', [ApiController::class, 'categories']);
//CATEGORY

//BOOKS
Route::get('/books', [ApiController::class, 'books']);
Route::post('/popular_books', [ApiController::class, 'popular_books']);
Route::post('/book_view', [ApiController::class, 'book_view']);
Route::post('/book_download', [ApiController::class, 'book_download']);
Route::post('/search_book', [ApiController::class, 'search_book']);
Route::post('/search_book_by_author', [ApiController::class, 'search_book_by_author']);
Route::post('/search_book_by_bookname', [ApiController::class, 'search_book_by_bookname']);
Route::post('/related_books', [ApiController::class, 'related_books']);
//BOOKS

//  BOOKMARK
Route::post('/add_book_bookmark', [ApiController::class, 'add_book_bookmark']);
Route::post('/remove_book_bookmark', [ApiController::class, 'remove_book_bookmark']);
Route::post('/all_bookmarked_books', [ApiController::class, 'all_bookmarked_books']);
//  BOOKMARK
/* ----------------------------------- WEB API PANEL --------------------------------------------- */



// Routes For Dummy Work Not Included in the Project

 // routes for categories

Route::post('/insert_catogery', [DummyController::class, 'savedata']);
Route::get('/get_catogery', [DummyController::class, 'getdata']);
Route::post('/upd_data', [DummyController::class, 'upd_data']);
Route::post('/delete_cat', [DummyController::class, 'delete_cat']);

// Routes for productucts
Route::post('/insert_product', [DummyController::class, 'insert_product_data']);
Route::get('/get_product', [DummyController::class, 'get_products']);
Route::post('/upd_product', [DummyController::class, 'upd_products']);
Route::post('/delete_product', [DummyController::class, 'delete_products']);


