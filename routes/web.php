<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\studentcontroller;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Route::get('/login', function () {
    return view('/login');
});

Route::get('/register', [AuthController::class, 'loadregister']);
Route::post('/register', [AuthController::class, 'studentregister'])->name('studentRegister');
Route::get('/', [AuthController::class, 'loadlogin']);
Route::post('/login', [AuthController::class, 'userlogin'])->name('userlogin');
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/forget-password', [AuthController::class, 'forgetpasswordload']);
Route::post('/forget-password', [AuthController::class, 'forgetpassword'])->name('forget-password');

Route::get('/reset-password', [AuthController::class, 'resetpasswordload']);

Route::post('/reset-password', [AuthController::class, 'resetpassword'])->name('reset-password');




// Admin Routes
Route::group(['middleware' => ['web', 'checkadmin']], function () {
    Route::get('/admin/dashboard', [AuthController::class, 'admindashboard']);
    Route::post('/add-subject', [AdminController::class, 'addsubject'])->name('addsubject');
    Route::post('/edit-subject', [AdminController::class, 'editsubject'])->name('editsubject');
    Route::post('/delete-subject', [AdminController::class, 'deletesubject'])->name('deletesubject');


    //  exam route
    Route::get('/admin/exam', [AdminController::class, 'examdashboard']);
    Route::post('/add-exam', [AdminController::class, 'addexam'])->name('addexam');
    Route::get('/get-exam-detail/{id}', [AdminController::class, 'getexamdetail'])->name('getexamdetail');
    Route::post('/update-exam', [AdminController::class, 'updateexam'])->name('updateexam');
    Route::post('/delete-exam', [AdminController::class, 'deleteexam'])->name('deleteexam');

    // Question & Answer routes
    Route::get("/admin/qna-ans", [AdminController::class, 'qnadashboard']);
    Route::post("/add-qna-ans", [AdminController::class, 'addqna'])->name('addqna');
    Route::get("/get-qna-details", [AdminController::class, 'getqnadetails'])->name('getqnadetails');
    Route::get("/delete-ans", [AdminController::class, 'deleteans'])->name('deleteans');
    Route::post("/update-qna-ans", [AdminController::class, 'updateqna'])->name('updateqna');
    Route::post("/delete-qna-ans", [AdminController::class, 'deleteqna'])->name('deleteqna');
    Route::post("/import-qna-ans", [AdminController::class, 'importqna'])->name('importqna');

    // student Routes
    Route::get("/admin/students", [AdminController::class, 'studentdashboard'])->name('studentdashboard');
    Route::post("/admin/students", [AdminController::class, 'addstudent'])->name('addstudent');
    Route::post("/edit-students", [AdminController::class, 'editstudent'])->name('editstudent');
    Route::post("/delete-students", [AdminController::class, 'deletestudent'])->name('deletestudent');
    Route::get('export-student',[AdminController::class,'exportstudents'])->name('exportstudents');


    // Qna Exam Route
    Route::get("/get-question", [AdminController::class, 'getquestion'])->name('getquestion');
    Route::post("/add-question", [AdminController::class, 'addquestion'])->name('addquestion');
    Route::get("/get-exam-question", [AdminController::class, 'getexamquestion'])->name('getexamquestion');
    Route::get("/delete-exam-question", [AdminController::class, 'deleteexamquestion'])->name('deleteexamquestion');


    //  exam marks route
    Route::get('/admin/marks', [AdminController::class, 'loadmarks']);
    Route::post('/admin/marks', [AdminController::class, 'updatemarks'])->name('updatemarks');

    // exam-review
    Route::get('/admin/review-exam', [AdminController::class, 'reviewexam'])->name('reviewexam');
    Route::get('get-reviewed-qna', [AdminController::class, 'reviewqna'])->name('reviewqnaa');
    Route::post('/approved-qna', [AdminController::class, 'approvedqna'])->name('approvedqna');

    // crud packages
    route::get('/admin/pakages-dashboard',[AdminController::class,'loadpackages'])->name('packagedashboard');
    route::get('/admin/deletepkg',[AdminController::class,'deletepkg'])->name('deletepkg');
    Route::post('/addpackage', [AdminController::class, 'addpackage'])->name('addpackage');
    Route::post('/editpackage', [AdminController::class, 'editpackage'])->name('editpackage');

    // payment details
    Route::get('/admin/payment-details',[AdminController::class,'paymentdetails'])->name('paymentdetails');

});

// student Routes
Route::group(['middleware' => ['web', 'checkstudent']], function () {
    Route::get('/dashboard', [AuthController::class, 'loaddashboard'])->name('test');
    Route::get('/exam/{id}', [ExamController::class, 'loadexamdashboard']);

    Route::post('/exam-submit', [ExamController::class, 'examsubmit'])->name('exam-submit');

    Route::get('/results',[ExamController::class,'resultdashboard'])->name('resultdashboard');
    Route::get('/review-student-qna',[ExamController::class,'reviewqna'])->name('review-student-qna');
    Route::get('/paidexams',[studentcontroller::class,'paidexamsdash'])->name('paidexams');
    Route::get('/paidpackages',[studentcontroller::class,'paidpackage'])->name('paidpackage');

    // payment route
    Route::post('/payment-pkr', [studentcontroller::class, 'paymentpkr'])->name('paymentpkr');
    Route::post('/paymentdone', [studentcontroller::class, 'paymentdone'])->name('paymentdone');
    // package payament route
    Route::post('/packagepayment', [studentcontroller::class, 'packagepayment'])->name('packagepayment');

    Route::post('/packagepaymentdone', [studentcontroller::class, 'packagepaymentdone'])->name('packagepaymentdone');
    
  

});
