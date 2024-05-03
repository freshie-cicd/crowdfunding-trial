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
      Route::get('/', [App\Http\Controllers\Administrator\DashboardController::class, 'index'])->name('administrator.home');
      Route::get('/home-unauthorized', [App\Http\Controllers\Administrator\DashboardController::class, 'indexUnauthorized'])->name('administrator.unauthorized');

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

      Route::get('/projects', [App\Http\Controllers\Administrator\ProjectController::class, 'index'])->name('project.index');
      Route::get('/project/create', [App\Http\Controllers\Administrator\ProjectController::class, 'create'])->name('project.create');
      Route::post('/project/store', [App\Http\Controllers\Administrator\ProjectController::class, 'store'])->name('project.store');
      Route::get('/project/edit/{id}', [App\Http\Controllers\Administrator\ProjectController::class, 'edit'])->name('project.edit');
      Route::post('/project/update', [App\Http\Controllers\Administrator\ProjectController::class, 'update'])->name('project.update');
      Route::get('/project/delete/{id}', [App\Http\Controllers\Administrator\ProjectController::class, 'destroy'])->name('project.delete');

      Route::get('/batches', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'index'])->name('batch.index');
      Route::get('/batch/create', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'create'])->name('batch.create');
      Route::post('/batch/store', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'store'])->name('batch.store');
      Route::get('/batch/edit/{id}', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'edit'])->name('batch.edit');
      Route::post('/batch/update', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'update'])->name('batch.update');
      Route::get('/batch/delete/{id}', [App\Http\Controllers\Administrator\ProjectBatchController::class, 'destroy'])->name('batch.delete');

      Route::get('/packages', [App\Http\Controllers\Administrator\PackageController::class, 'index'])->name('package.index');
      Route::get('/package/create', [App\Http\Controllers\Administrator\PackageController::class, 'create'])->name('package.create');
      Route::post('/package/store', [App\Http\Controllers\Administrator\PackageController::class, 'store'])->name('package.store');
      Route::get('/package/edit/{id}', [App\Http\Controllers\Administrator\PackageController::class, 'edit'])->name('package.edit');
      Route::post('/package/update', [App\Http\Controllers\Administrator\PackageController::class, 'update'])->name('package.update');
      Route::get('/package/delete/{id}', [App\Http\Controllers\Administrator\PackageController::class, 'destroy'])->name('package.delete');

      Route::get('/assets', [App\Http\Controllers\Administrator\AssetController::class, 'index'])->name('asset.index');
      Route::get('/asset/create', [App\Http\Controllers\Administrator\AssetController::class, 'create'])->name('asset.create');
      Route::post('/asset/store', [App\Http\Controllers\Administrator\AssetController::class, 'store'])->name('asset.store');
      Route::get('/asset/edit/{id}', [App\Http\Controllers\Administrator\AssetController::class, 'edit'])->name('asset.edit');
      Route::post('/asset/update', [App\Http\Controllers\Administrator\AssetController::class, 'update'])->name('asset.update');
      Route::get('/asset/delete/{id}', [App\Http\Controllers\Administrator\AssetController::class, 'destroy'])->name('asset.delete');

      Route::get('/updates', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'index'])->name('update.index');
      Route::get('/update/create', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'create'])->name('update.create');
      Route::post('/update/store', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'store'])->name('update.store');
      Route::get('/update/edit/{id}', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'edit'])->name('update.edit');
      Route::post('/update/update', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'update'])->name('update.update');
      Route::get('/update/delete/{id}', [App\Http\Controllers\Administrator\AssetUpdateController::class, 'destroy'])->name('update.delete');

      Route::get('/payment/pending', [App\Http\Controllers\Administrator\BookingController::class, 'payment_pending'])->name('admin.payment.index');
      Route::get('/payment/approve/{booking_id}', [App\Http\Controllers\Administrator\BookingController::class, 'payment_approve'])->name('admin.payment.approve');
      Route::get('/payment/reject/{booking_id}', [App\Http\Controllers\Administrator\BookingController::class, 'payment_reject'])->name('admin.payment.reject');
      Route::post('/payment/decision', [App\Http\Controllers\Administrator\BookingController::class, 'decision'])->name('admin.payment.decision');

      Route::get('/bookings/info/{id}', [App\Http\Controllers\Administrator\BookingController::class, 'modal_info'])->name('admin.booking.modal_info');

      Route::get('/payment/approved', [App\Http\Controllers\Administrator\BookingController::class, 'paymentProof'])->name('admin.payment.approved');
      Route::get('/payment/approved/batch', [App\Http\Controllers\Administrator\BookingController::class, 'approved_list_bybatch'])->name('admin.payment.approved_bybatch');

      Route::get('/investor/change_password/{id}', [App\Http\Controllers\Administrator\UserController::class, 'change_password'])->name('admin.investor.change_password');
      Route::post('/investor/cp/store', [App\Http\Controllers\Administrator\UserController::class, 'store_password'])->name('admin.investor.store_password');
      Route::get('/investor/info/{uid}', [App\Http\Controllers\Administrator\UserController::class, 'investment_activity'])->name('admin.investor.activity');

      Route::get('/reports/hard-copy-requests', [App\Http\Controllers\Administrator\Reports::class, 'agreementRequests'])->name('admin.agreement.requests');
      Route::put('/reports/agreement-status/update', [App\Http\Controllers\Administrator\Reports::class, 'updateAgreementRequestStatus'])->name('admin.agreement.status-update');
      Route::get('/reports/hard-copy/{code}/download', [App\Http\Controllers\Administrator\Reports::class, 'hard_copy_download'])->name('admin.agreement.download');

      Route::get('/reports/closing-investor', [App\Http\Controllers\Administrator\Reports::class, 'closingReport'])->name('reports.closing');
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
