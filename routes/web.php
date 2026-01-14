<?php

use Illuminate\Support\Facades\Route;
use App\Models\Prospectus;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProspectusController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\AcademicTermController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdmissionProcessController;

Route::get('/', function () {return view('index');})->name('index');

Route::prefix('application')->name('applicant.')->group(function () {
    Route::get('/', [ApplicantController::class, 'showApplication'])->name('form');
    Route::post('/', [ApplicantController::class, 'createApplication'])->name('create');
});

Route::prefix('registrar')->name('registrar.')->group(function () {
    Route::get('/', [RegistrarController::class, 'showLogin'])->name('login');
    Route::post('/login', [RegistrarController::class, 'login'])->name('login.submit');
    Route::post('/logout', [RegistrarController::class, 'logout'])->name('logout');

    // Protected routes - require authentication and registrar type
    Route::middleware(['auth', 'can:access-registrar'])->group(function () {
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

        Route::get('/academic-terms', [AcademicTermController::class, 'showAcademicTerm'])->name('academic_term');
        Route::post('/academic-terms', [AcademicTermController::class, 'createAcademicTerm'])->name('academic_term.create');
        Route::post('/academic-terms/{id}/update', [AcademicTermController::class, 'updateAcademicTerm'])->name('academic_term.update');
        Route::post('/academic-terms/{id}/delete', [AcademicTermController::class, 'deleteAcademicTerm'])->name('academic_term.delete');

        Route::get('/subjects', [SubjectController::class, 'showSubject'])->name('subject');
        Route::post('/subjects', [SubjectController::class, 'createSubject'])->name('subject.create');
        Route::post('/subjects/{id}/update', [SubjectController::class, 'updateSubject'])->name('subject.update');
        Route::post('/subjects/{id}/delete', [SubjectController::class, 'deleteSubject'])->name('subject.delete');

        Route::get('/levels', [LevelController::class, 'showLevel'])->name('level');
        Route::post('/levels', [LevelController::class, 'createLevel'])->name('level.create');
        Route::post('/levels/{id}/update', [LevelController::class, 'updateLevel'])->name('level.update');
        Route::post('/levels/{id}/delete', [LevelController::class, 'deleteLevel'])->name('level.delete');

        Route::get('/prospectuses', [ProspectusController::class, 'showProspectus'])->name('prospectus');
        Route::match(['get', 'post'], '/prospectuses/search', [ProspectusController::class, 'searchProspectus'])->name('prospectus.search');
        Route::post('/prospectuses', [ProspectusController::class, 'createProspectus'])->name('prospectus.create');
        Route::post('/prospectuses/{id}/update', [ProspectusController::class, 'updateProspectus'])->name('prospectus.update');
        Route::post('/prospectuses/{id}/delete', [ProspectusController::class, 'deleteProspectus'])->name('prospectus.delete');
        
        // API routes for dynamic loading
        Route::get('/api/levels-by-department/{departmentId}', [ProspectusController::class, 'getLevelsByDepartment'])->name('api.levels');
        Route::get('/api/prospectuses', [ProspectusController::class, 'getProspectusesApi'])->name('api.prospectuses');
    });
});

Route::prefix('accounting')->name('accounting.')->group(function () {
    Route::get('/', [AccountingController::class, 'showLogin'])->name('login');
    Route::post('/login', [AccountingController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AccountingController::class, 'logout'])->name('logout');

    // Protected routes - require authentication and accounting type
    Route::middleware(['auth', 'can:access-accounting'])->group(function () {
        Route::get('/fee', [FeeController::class, 'showFees'])->name('fee');
        Route::match(['get', 'post'], '/fee/search', [FeeController::class, 'searchFee'])->name('fee.search');
        Route::post('/fee', [FeeController::class, 'createFee'])->name('fee.create');
        Route::post('/fee/{id}/update', [FeeController::class, 'updateFee'])->name('fee.update');
        Route::post('/fee/{id}/delete', [FeeController::class, 'deleteFee'])->name('fee.delete');
    });
});

Route::prefix('admission')->name('admission.')->group(function () {
    Route::get('/', [AdmissionController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdmissionController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdmissionController::class, 'logout'])->name('logout');

    // Protected routes - require authentication and admission type
    Route::middleware(['auth', 'can:access-admission'])->group(function () {
        Route::get('/dashboard', [AdmissionController::class, 'showDashboard'])->name('dashboard');

        Route::get('/applicant', [ApplicantController::class, 'showApplicant'])->name('applicant');
        Route::post('/applicant/mark-interview', [ApplicantController::class, 'markForInterview'])->name('applicant.mark-interview');

        Route::get('/schedules', [ScheduleController::class, 'showSchedule'])->name('schedule');
        Route::post('/schedules', [ScheduleController::class, 'createSchedule'])->name('schedule.create');
        Route::post('/schedules/{id}/update', [ScheduleController::class, 'updateSchedule'])->name('schedule.update');
        Route::post('/schedules/{id}/delete', [ScheduleController::class, 'deleteSchedule'])->name('schedule.delete');

        Route::get('/interview', [AdmissionProcessController::class, 'showInterview'])->name('interview');
        Route::post('/interview/{id}/update', [AdmissionProcessController::class, 'updateInterview'])->name('interview.update');
        Route::get('/exam', [AdmissionProcessController::class, 'showExam'])->name('exam');
        Route::get('/evaluation', [AdmissionProcessController::class, 'showEvaluation'])->name('evaluation');
    });
});