<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\AdmissionDecisionController;
use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RoleController;

Route::get('/', [ SystemController::class, 'default' ]);
Route::group(['prefix' => 'admin'], function() {
Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () { return redirect('admin/home'); });
    Route::get('/home', [ SystemController::class, 'home' ]);
    Route::get('/profile', [ SystemController::class, 'profile' ]);
    Route::post('/updateProfile', [ SystemController::class, 'updateProfile' ]);
    Route::middleware('role:ADMIN')->resource('/userAccounts', UserAccountController::class);
    Route::middleware('role:ADMIN,USER')->resource('/userRoles', UserRoleController::class);
    Route::middleware('role:ADMIN,USER')->resource('/admissionDecisions', AdmissionDecisionController::class);
    Route::middleware('role:ADMIN,USER')->resource('/applicationses', ApplicationsController::class);
    Route::middleware('role:ADMIN,USER')->resource('/classes', ClassController::class);
    Route::middleware('role:ADMIN,USER')->resource('/courses', CourseController::class);
    Route::middleware('role:ADMIN,USER')->resource('/enrollments', EnrollmentController::class);
    Route::middleware('role:ADMIN,USER')->resource('/faculties', FacultyController::class);
    Route::middleware('role:ADMIN,USER')->resource('/programs', ProgramController::class);
    Route::middleware('role:ADMIN,USER')->resource('/students', StudentController::class);
    Route::middleware('role:ADMIN,USER')->resource('/roles', RoleController::class);
    Route::middleware('role:ADMIN,USER')->get('/userRoles/{user_id}/{role_id}', [ UserRoleController::class, 'show' ]);
    Route::middleware('role:ADMIN,USER')->get('/userRoles/{user_id}/{role_id}/edit', [ UserRoleController::class, 'edit' ]);
    Route::middleware('role:ADMIN,USER')->patch('/userRoles/{user_id}/{role_id}', [ UserRoleController::class, 'update' ]);
    Route::middleware('role:ADMIN,USER')->delete('/userRoles/{user_id}/{role_id}', [ UserRoleController::class, 'destroy' ]);
});
Route::get('/logout', [ LoginController::class, 'logout' ]);
Route::get('/resetPassword', [ LoginController::class, 'resetPassword' ]);
Route::post('/resetPassword', [ LoginController::class, 'resetPasswordPost' ]);
Route::get('/changePassword/{token}', [ LoginController::class, 'changePassword' ]);
Route::post('/changePassword/{token}', [ LoginController::class, 'changePasswordPost' ]);
Route::get('/stack', [ SystemController::class, 'stack' ]);
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
