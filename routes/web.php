<?php

use Illuminate\Support\Facades\Route;
use App\Models\Prospectus;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProspectusController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SubjectController;

Route::prefix('registrar')->name('registrar.')->group(function () {
    Route::get('/', [RegistrarController::class, 'showLogin'])->name('login');
    Route::post('/login', [RegistrarController::class, 'login'])->name('login.submit');
    Route::post('/logout', [RegistrarController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [RegistrarController::class, 'showDashboard'])->name('dashboard');

    Route::get('/departments', [DepartmentController::class, 'showDepartment'])->name('department');
    Route::post('/departments', [DepartmentController::class, 'createDepartment'])->name('department.create');
    Route::post('/departments/{id}/update', [DepartmentController::class, 'updateDepartment'])->name('department.update');
    Route::post('/departments/{id}/delete', [DepartmentController::class, 'deleteDepartment'])->name('department.delete');

    Route::get('/programs', [ProgramController::class, 'showProgram'])->name('program');
    Route::post('/programs', [ProgramController::class, 'createProgram'])->name('program.create');
    Route::post('/programs/{id}/update', [ProgramController::class, 'updateProgram'])->name('program.update');
    Route::post('/programs/{id}/delete', [ProgramController::class, 'deleteProgram'])->name('program.delete');

    Route::get('/curricula', [CurriculumController::class, 'showCurriculum'])->name('curriculum');
    Route::post('/curricula', [CurriculumController::class, 'createCurriculum'])->name('curriculum.create');
    Route::post('/curricula/{id}/update', [CurriculumController::class, 'updateCurriculum'])->name('curriculum.update');
    Route::post('/curricula/{id}/delete', [CurriculumController::class, 'deleteCurriculum'])->name('curriculum.delete');

    Route::get('/semesters', [SemesterController::class, 'showSemester'])->name('semester');
    Route::post('/semesters', [SemesterController::class, 'createSemester'])->name('semester.create');
    Route::post('/semesters/{id}/update', [SemesterController::class, 'updateSemester'])->name('semester.update');
    Route::post('/semesters/{id}/delete', [SemesterController::class, 'deleteSemester'])->name('semester.delete');

    Route::get('/subjects', [SubjectController::class, 'showSubject'])->name('subject');
    Route::post('/subjects', [SubjectController::class, 'createSubject'])->name('subject.create');
    Route::post('/subjects/{id}/update', [SubjectController::class, 'updateSubject'])->name('subject.update');
    Route::post('/subjects/{id}/delete', [SubjectController::class, 'deleteSubject'])->name('subject.delete');

    Route::get('/prospectuses', [ProspectusController::class, 'showProspectus'])->name('prospectus');
    Route::match(['get', 'post'], '/prospectuses/search', [ProspectusController::class, 'searchProspectus'])->name('prospectus.search');
    Route::post('/prospectuses', [ProspectusController::class, 'insertProspectus'])->name('prospectus.insert');
    Route::post('/prospectuses/{id}/update', [ProspectusController::class, 'updateProspectus'])->name('prospectus.update');
    Route::post('/prospectuses/{id}/delete', [ProspectusController::class, 'deleteProspectus'])->name('prospectus.delete');
});