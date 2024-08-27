<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lecturer\ListOfFormsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\Lecturer\ComponentPointsController;
use App\Http\Controllers\Lecturer\EnterComponentPointsController;
use App\Http\Controllers\Lecturer\ListRollCallController;
use App\Http\Controllers\Lecturer\StudentAttendanceController;


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
// });

//Giảng viên
Route::middleware(['auth', 'lecturer'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    // profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profilegiangvien');
    Route::get('/profile/update', [ProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profilegiangvien.update');
    Route::post('/profile/upload-avatar', [ProfileController::class, 'uploadProfilePicture'])->name('profile.uploadAvatar');

    // changepassword
    Route::get('/thay-doi-mat-khau', [ChangePasswordController::class, 'index'])->name('changepassword');

    // diem danh
    Route::get('/diem-danh-sinh-vien', [StudentAttendanceController::class, 'index'])->name('diemDanhSinhVien');
    Route::post('/diem-danh-sinh-vien', [StudentAttendanceController::class, 'filters']);

    // danh sach diem danh
    Route::get('/danh-sach-diem-danh/{id}', [ListRollCallController::class, 'index']);
    Route::post('/save-rollCall', [ListRollCallController::class, 'saveRollCall'])->name('save.rollcall');

    // import
    Route::post('/import-rollcall', [StudentAttendanceController::class, 'import'])->name('import.rollcall');
    // export
    Route::get('/export-rollcall/{monHocKyId}', [StudentAttendanceController::class, 'export'])->name('export.rollcall');

    // Điểm thành phần
    Route::get('/diem-thanh-phan', [ComponentPointsController::class, 'index'])->name('points.component');
    Route::post('/diem-thanh-phan', [ComponentPointsController::class, 'filters']);
    // export
    Route::get('/export-point/{monHocKyId}', [ComponentPointsController::class, 'export'])->name('export.point');

    // Nhập điểm thành phần
    Route::get('/nhap-diem-thanh-phan/{id}', [EnterComponentPointsController::class, 'index']);
    Route::post('/luu-diem', [EnterComponentPointsController::class, 'update'])->name('save.update');

    // Danh sách biểu mẫu
    Route::get('/danh-sach-bieu-mau', [ListOfFormsController::class, 'index']);

    Route::post('/danh-sach-bieu-mau/{id}', [ListOfFormsController::class, 'upload'])->name('files.upload');

    Route::get('/danh-sach-bieu-mau/{id}', [ListOfFormsController::class, 'download'])->name('files.download');

});

require __DIR__ . '/auth.php';