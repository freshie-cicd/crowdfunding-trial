<?php

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

Auth::routes();


Route::namespace("Administrator")
   ->prefix('administrator')
   ->group(function () {
      Route::get('/', [App\Http\Controllers\Administrator\DashboardController::class, 'index'])->name('home');
      Route::get('/home', [App\Http\Controllers\Administrator\DashboardController::class, 'index'])->name('administrator.home');

      Route::get('/team', [App\Http\Controllers\Administrator\AdminController::class, 'index'])->name('team.list');
      Route::get('/team/add', [App\Http\Controllers\Administrator\AdminController::class, 'create'])->name('team.create');
      Route::post('/team/store', [App\Http\Controllers\Administrator\AdminController::class, 'store'])->name('team.store');

      Route::namespace('Auth')->group(function () {
         Route::get('/login', [App\Http\Controllers\Administrator\Auth\LoginController::class, 'ShowLoginForm'])->name('administrator.login');
         Route::post('/login', [App\Http\Controllers\Administrator\Auth\LoginController::class, 'login'])->name('administrator.login.process');
         Route::post('logout', [App\Http\Controllers\Administrator\Auth\LoginController::class, 'logout'])->name('administrator.logout');
      });

      Route::get('/migration/{booking_code}/i/{investor_id}/p/{package_id}', [App\Http\Controllers\Administrator\ClosingController::class, 'migration'])->name('admin.migration');

      Route::get('/investor/profiles', [App\Http\Controllers\Administrator\UserController::class, 'index'])->name('admin.investor.profile');
      Route::get('/investor/profiles/{id}', [App\Http\Controllers\Administrator\UserController::class, 'show'])->name('administrator.investor.profile.show');

      Route::get('/bookings', [App\Http\Controllers\Administrator\BookingController::class, 'index'])->name('administrator.booking.index');
      Route::get('/bookings/create/{investor_id}', [App\Http\Controllers\Administrator\BookingController::class, 'create'])->name('administrator.booking.create');
      Route::post('/bookings', [App\Http\Controllers\Administrator\BookingController::class, 'store'])->name('administrator.booking.store');
      Route::get('/bookings/{id}', [App\Http\Controllers\Administrator\BookingController::class, 'show'])->name('administrator.booking.show');
      Route::get('/bookings/edit/{id}', [App\Http\Controllers\Administrator\BookingController::class, 'edit'])->name('administrator.booking.edit');
      Route::put('/bookings/edit/{id}', [App\Http\Controllers\Administrator\BookingController::class, 'update'])->name('administrator.booking.update');

      Route::get('/bookings/{id}/proof', [App\Http\Controllers\Administrator\PaymentController::class, 'proof'])->name('administrator.booking.proof');
      Route::post('/bookings/{id}/proof', [App\Http\Controllers\Administrator\PaymentController::class, 'proof_store'])->name('administrator.booking.proof.store');

      Route::get('/closing/{code}/edit', [App\Http\Controllers\Administrator\ClosingController::class, 'edit'])->name('administrator.closing.edit');
      Route::post('/closing/{code}/edit', [App\Http\Controllers\Administrator\ClosingController::class, 'update'])->name('administrator.closing.update');
   });



Route::get('/', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

Route::get('/packages', [App\Http\Controllers\HomeController::class, 'index'])->name('packages');

Route::get('profile/change_password', [App\Http\Controllers\HomeController::class, 'change_password'])->name('change_password');
Route::post('profile/change_password/update', [App\Http\Controllers\HomeController::class, 'change_password_update'])->name('change_password.update');



Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::get('/profile/edit', [App\Http\Controllers\HomeController::class, 'profile_edit'])->name('profile.edit');
Route::post('/profile/update', [App\Http\Controllers\HomeController::class, 'profile_update'])->name('profile.update');


Route::get('/investor/bank', [App\Http\Controllers\HomeController::class, 'bank_details'])->name('investor.bank.details');
Route::post('/investor/update', [App\Http\Controllers\HomeController::class, 'bank_details_update'])->name('investor.bank.details.update');



Route::get('/book/{id}/package', [App\Http\Controllers\HomeController::class, 'book'])->name('book');
Route::post('/book/store', [App\Http\Controllers\HomeController::class, 'store'])->name('book.store');


Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('mybookings');
Route::get('/bookings/{status}', [App\Http\Controllers\BookingController::class, 'myBookings'])->name('mybookings_');

Route::get('/payment-proof/{booking_id}/submit', [App\Http\Controllers\BookingController::class, 'proof'])->name('paymentProof');
Route::post('/payment-proof/store', [App\Http\Controllers\BookingController::class, 'proof_store'])->name('paymentProofStore');




Route::get('/agreements', [App\Http\Controllers\AgreementController::class, 'index'])->name('agreement.index');
Route::get('/agreement/{booking_id}/download', [App\Http\Controllers\AgreementController::class, 'download'])->name('agreement.download');

Route::get('/agreement/hard-copy/request/{id}', [App\Http\Controllers\AgreementController::class, 'hard_copy_request'])->name('agreement.hard_copy');
Route::post('/agreement/hard-copy/store', [App\Http\Controllers\AgreementController::class, 'hard_copy_request_store'])->name('agreement.hard_copy.store');


Route::get('/mature-batches', [App\Http\Controllers\ClosingController::class, 'index'])->name('mature.index');
Route::get('/mature-batches/request/{code}/withdrawal', [App\Http\Controllers\ClosingController::class, 'withdrawal_request'])->name('withdrawal.request');
Route::post('/mature-batches/request/store', [App\Http\Controllers\ClosingController::class, 'withdrawal_request_store'])->name('withdrawal.request.store');




Route::get('/administrator/closing/requests', [App\Http\Controllers\Administrator\ClosingController::class, 'index'])->name('admin.closing.requests');
Route::get('/administrator/closing/profit-return', [App\Http\Controllers\Administrator\ClosingController::class, 'profitReturn'])->name('admin.closing.profitReturn');


Route::get('/administrator/closing/capital', [App\Http\Controllers\Administrator\ClosingController::class, 'capital_return_report'])->name('admin.capital_return.report');

Route::get('/administrator/projects', [App\Http\Controllers\Administrator\ProjectController::class, 'index'])->name('project.index');
Route::get('/administrator/project/create', [App\Http\Controllers\Administrator\ProjectController::class, 'create'])->name('project.create');
Route::post('/administrator/project/store', [App\Http\Controllers\Administrator\ProjectController::class, 'store'])->name('project.store');
Route::get('/administrator/project/edit/{id}', [App\Http\Controllers\Administrator\ProjectController::class, 'edit'])->name('project.edit');
Route::post('/administrator/project/update', [App\Http\Controllers\Administrator\ProjectController::class, 'update'])->name('project.update');
Route::get('/administrator/project/delete/{id}', [App\Http\Controllers\Administrator\ProjectController::class, 'destroy'])->name('project.delete');


Route::get('/administrator/batches', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'index'])->name('batch.index');
Route::get('/administrator/batch/create', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'create'])->name('batch.create');
Route::post('/administrator/batch/store', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'store'])->name('batch.store');
Route::get('/administrator/batch/edit/{id}', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'edit'])->name('batch.edit');
Route::post('/administrator/batch/update', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'update'])->name('batch.update');
Route::get('/administrator/batch/delete/{id}', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'destroy'])->name('batch.delete');


Route::get('/administrator/packages', [App\Http\Controllers\Administrator\PackageController::class, 'index'])->name('package.index');
Route::get('/administrator/package/create', [App\Http\Controllers\Administrator\PackageController::class, 'create'])->name('package.create');
Route::post('/administrator/package/store', [App\Http\Controllers\Administrator\PackageController::class, 'store'])->name('package.store');
Route::get('/administrator/package/edit/{id}', [App\Http\Controllers\Administrator\PackageController::class, 'edit'])->name('package.edit');
Route::post('/administrator/package/update', [App\Http\Controllers\Administrator\PackageController::class, 'update'])->name('package.update');
Route::get('/administrator/package/delete/{id}', [App\Http\Controllers\Administrator\PackageController::class, 'destroy'])->name('package.delete');


Route::get('/administrator/assets', [App\Http\Controllers\Administrator\AssetController::class, 'index'])->name('asset.index');
Route::get('/administrator/asset/create', [App\Http\Controllers\Administrator\AssetController::class, 'create'])->name('asset.create');
Route::post('/administrator/asset/store', [App\Http\Controllers\Administrator\AssetController::class, 'store'])->name('asset.store');
Route::get('/administrator/asset/edit/{id}', [App\Http\Controllers\Administrator\AssetController::class, 'edit'])->name('asset.edit');
Route::post('/administrator/asset/update', [App\Http\Controllers\Administrator\AssetController::class, 'update'])->name('asset.update');
Route::get('/administrator/asset/delete/{id}', [App\Http\Controllers\Administrator\AssetController::class, 'destroy'])->name('asset.delete');


Route::get('/administrator/expense-heads', [App\Http\Controllers\Administrator\ExpenseController::class, 'head_index'])->name('expense_head.index');
Route::get('/administrator/expense-head/create', [App\Http\Controllers\Administrator\ExpenseController::class, 'head_create'])->name('expense_head.create');
Route::post('/administrator/expense-head/store', [App\Http\Controllers\Administrator\ExpenseController::class, 'head_store'])->name('expense_head.store');
Route::get('/administrator/expense-head/edit/{id}', [App\Http\Controllers\Administrator\ExpenseController::class, 'head_edit'])->name('expense_head.edit');
Route::post('/administrator/expense-head/update', [App\Http\Controllers\Administrator\ExpenseController::class, 'head_update'])->name('expense_head.update');
Route::get('/administrator/expense-head/delete/{id}', [App\Http\Controllers\Administrator\ExpenseController::class, 'head_destroy'])->name('expense_head.delete');


Route::get('/administrator/expenses', [App\Http\Controllers\Administrator\ExpenseController::class, 'index'])->name('expense.index');
Route::get('/administrator/expense/create', [App\Http\Controllers\Administrator\ExpenseController::class, 'create'])->name('expense.create');
Route::post('/administrator/expense/store', [App\Http\Controllers\Administrator\ExpenseController::class, 'store'])->name('expense.store');
Route::get('/administrator/expense/edit/{id}', [App\Http\Controllers\Administrator\ExpenseController::class, 'edit'])->name('expense.edit');
Route::post('/administrator/expense/update', [App\Http\Controllers\Administrator\ExpenseController::class, 'update'])->name('expense.update');
Route::get('/administrator/expense/delete/{id}', [App\Http\Controllers\Administrator\ExpenseController::class, 'destroy'])->name('expense.delete');


Route::get('/administrator/updates', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'index'])->name('update.index');
Route::get('/administrator/update/create', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'create'])->name('update.create');
Route::post('/administrator/update/store', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'store'])->name('update.store');
Route::get('/administrator/update/edit/{id}', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'edit'])->name('update.edit');
Route::post('/administrator/update/update', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'update'])->name('update.update');
Route::get('/administrator/update/delete/{id}', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'destroy'])->name('update.delete');




Route::get('/administrator/payment/pending', [App\Http\Controllers\Administrator\BookingController::class, 'payment_pending'])->name('admin.payment.index');
Route::get('/administrator/payment/approve/{booking_id}', [App\Http\Controllers\Administrator\BookingController::class, 'payment_approve'])->name('admin.payment.approve');
Route::get('/administrator/payment/reject/{booking_id}', [App\Http\Controllers\Administrator\BookingController::class, 'payment_reject'])->name('admin.payment.reject');

Route::post('/administrator/payment/decision', [App\Http\Controllers\Administrator\BookingController::class, 'decision'])->name('admin.payment.decision');


Route::get('/administrator/bookings/info/{id}', [App\Http\Controllers\Administrator\BookingController::class, 'modal_info'])->name('admin.booking.modal_info');

Route::get('/administrator/payment/approved', [App\Http\Controllers\Administrator\BookingController::class, 'paymentProof'])->name('admin.payment.approved');
Route::get('/administrator/payment/approved/batch', [App\Http\Controllers\Administrator\BookingController::class, 'approved_list_bybatch'])->name('admin.payment.approved_bybatch');

Route::get('/administrator/investor/change_password/{id}', [App\Http\Controllers\Administrator\UserController::class, 'change_password'])->name('admin.investor.change_password');
Route::post('/administrator/investor/cp/store', [App\Http\Controllers\Administrator\UserController::class, 'store_password'])->name('admin.investor.store_password');

Route::get('/administrator/investor/info/{uid}', [App\Http\Controllers\Administrator\UserController::class, 'investment_activity'])->name('admin.investor.activity');

Route::get('/administrator/agreement/hard-copy-requests', [App\Http\Controllers\Administrator\BookingController::class, 'hard_copy_agreement_requests'])->name('admin.agreement.requests');
Route::get('/administrator/agreement/hard-copy/{code}/download', [App\Http\Controllers\Administrator\BookingController::class, 'hard_copy_download'])->name('admin.agreement.download');


Route::get('/administrator/borga/cow-profiles', [App\Http\Controllers\Administrator\BorgaController::class, 'cow_profiles'])->name('admin.borga.cow_profile');
Route::get('/administrator/borga/cow-profile/create', [App\Http\Controllers\Administrator\BorgaController::class, 'cow_profile_create'])->name('admin.borga.cow_profile_create');
Route::post('/administrator/borga/cow-profile/store', [App\Http\Controllers\Administrator\BorgaController::class, 'cow_profile_store'])->name('admin.borga.cow_profile_store');
