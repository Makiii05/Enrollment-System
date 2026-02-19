<?php

use Illuminate\Support\Facades\Route;
use App\Models\Prospectus;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProspectusController;
use App\Http\Controllers\Auth\RegistrarAuthController;
use App\Http\Controllers\AcademicTermController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\Auth\AccountingAuthController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\Auth\AdmissionAuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdmissionProcessController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\DepartmentAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectOfferingController;
use App\Http\Controllers\EnlistmentController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RegistrarStudentController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\PaymentDetailsController;

Route::get('/', function () {return view('index');})->name('index');

Route::prefix('application')->name('applicant.')->group(function () {
    Route::get('/', [ApplicantController::class, 'showApplication'])->name('form');
    Route::post('/', [ApplicantController::class, 'createApplication'])->name('create');
});

Route::prefix('registrar')->name('registrar.')->group(function () {
    Route::get('/', [RegistrarAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [RegistrarAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [RegistrarAuthController::class, 'logout'])->name('logout');

    // Protected routes - require authentication and registrar type
    Route::middleware(['auth', 'can:access-registrar'])->group(function () {
        Route::get('/dashboard', [RegistrarAuthController::class, 'showDashboard'])->name('dashboard');

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
        Route::get('/students', [RegistrarStudentController::class, 'showStudents'])->name('student');
        Route::get('/api/students/search', [RegistrarStudentController::class, 'searchStudents'])->name('api.students.search');
        Route::get('/students/{id}/assessment', [RegistrarStudentController::class, 'showAssessment'])->name('student.assessment');
        Route::get('/students/{id}/print-assessment', [PdfController::class, 'printStudentAssessment'])->name('student.print-assessment');
        Route::post('/students/{id}/update-level', [RegistrarStudentController::class, 'updateLevel'])->name('student.update-level');
        Route::get('/api/enlistments/{studentId}/{academicTermId}', [RegistrarStudentController::class, 'getEnlistments'])->name('api.student.enlistments');
        Route::get('/api/student-fees/{studentId}/{academicTermId}', [RegistrarStudentController::class, 'getStudentFees'])->name('api.student.fees');
        Route::get('/api/existing-fees/{studentId}/{academicTermId}/{group}', [RegistrarStudentController::class, 'getExistingFees'])->name('api.existing.fees');
        Route::post('/api/student-fees/{studentId}/create', [RegistrarStudentController::class, 'createStudentFee'])->name('api.student.fees.create');
        Route::post('/api/student-fees/{studentId}/assign', [RegistrarStudentController::class, 'assignExistingFee'])->name('api.student.fees.assign');
        Route::delete('/api/student-fees/{studentFeeId}', [RegistrarStudentController::class, 'removeStudentFee'])->name('api.student.fees.remove');

        Route::get('/api/levels-by-department/{departmentId}', [ProspectusController::class, 'getLevelsByDepartment'])->name('api.levels');
        Route::get('/api/curricula-by-department/{departmentId}', [ProspectusController::class, 'getCurriculaByDepartment'])->name('api.curricula');
        Route::get('/api/prospectuses', [ProspectusController::class, 'getProspectusesApi'])->name('api.prospectuses');
    });
});

Route::prefix('accounting')->name('accounting.')->group(function () {
    Route::get('/', [AccountingAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AccountingAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AccountingAuthController::class, 'logout'])->name('logout');

    // Protected routes - require authentication and accounting type
    Route::middleware(['auth', 'can:access-accounting'])->group(function () {
        Route::get('/fee', [FeeController::class, 'showFees'])->name('fee');
        Route::match(['get', 'post'], '/fee/search', [FeeController::class, 'searchFee'])->name('fee.search');
        Route::post('/fee', [FeeController::class, 'createFee'])->name('fee.create');
        Route::post('/fee/{id}/update', [FeeController::class, 'updateFee'])->name('fee.update');
        Route::post('/fee/{id}/delete', [FeeController::class, 'deleteFee'])->name('fee.delete');

        Route::get('/api/academic-terms', [FeeController::class, 'getAcademicTermsByProgram'])->name('api.academic-terms');

        // Cashier routes
        Route::get('/cashier', [CashierController::class, 'showCashier'])->name('cashier');
        Route::get('/api/students/search', [CashierController::class, 'searchStudents'])->name('api.students.search');
        Route::get('/payment/{id}', [CashierController::class, 'showPayment'])->name('payment');
        Route::get('/api/student-fees/{studentId}/{academicTermId}', [CashierController::class, 'getStudentFees'])->name('api.student.fees');
        Route::get('/api/enlistments/{studentId}/{academicTermId}', [CashierController::class, 'getEnlistments'])->name('api.enlistments');
        
        // Transaction routes
        Route::get('/api/transactions/{studentId}/{academicTermId}', [CashierController::class, 'getTransactions'])->name('api.transactions');
        Route::post('/api/transactions/create', [CashierController::class, 'createTransaction'])->name('api.transactions.create');
        Route::delete('/api/transactions/{id}', [CashierController::class, 'deleteTransaction'])->name('api.transactions.delete');
        Route::get('/api/next-or-number', [CashierController::class, 'getNextOrNumber'])->name('api.next-or-number');

        // Print routes
        Route::get('/print/daily-transactions', [CashierController::class, 'printDailyTransactions'])->name('print.daily-transactions');
        Route::get('/print/sales-invoice/{id}', [CashierController::class, 'printSalesInvoice'])->name('print.sales-invoice');

        // Payment Details routes
        Route::get('/payment-details', [PaymentDetailsController::class, 'index'])->name('payment_details');
        Route::post('/payment-accounts', [PaymentDetailsController::class, 'storePaymentAccount'])->name('payment_accounts.store');
        Route::post('/payment-accounts/{id}/update', [PaymentDetailsController::class, 'updatePaymentAccount'])->name('payment_accounts.update');
        Route::post('/payment-accounts/{id}/delete', [PaymentDetailsController::class, 'deletePaymentAccount'])->name('payment_accounts.delete');
        Route::post('/payment-types', [PaymentDetailsController::class, 'storePaymentType'])->name('payment_types.store');
        Route::post('/payment-types/{id}/update', [PaymentDetailsController::class, 'updatePaymentType'])->name('payment_types.update');
        Route::post('/payment-types/{id}/delete', [PaymentDetailsController::class, 'deletePaymentType'])->name('payment_types.delete');
        Route::get('/api/payment-accounts', [PaymentDetailsController::class, 'getPaymentAccounts'])->name('api.payment_accounts');
        Route::get('/api/payment-types', [PaymentDetailsController::class, 'getPaymentTypes'])->name('api.payment_types');
    });
});

Route::prefix('admission')->name('admission.')->group(function () {
    Route::get('/', [AdmissionAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdmissionAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdmissionAuthController::class, 'logout'])->name('logout');

    // Protected routes - require authentication and admission type
    Route::middleware(['auth', 'can:access-admission'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admissionDashboard'])->name('dashboard');

        Route::get('/applicant', [ApplicantController::class, 'showApplicant'])->name('applicant');
        
        Route::get('/schedules', [ScheduleController::class, 'showSchedule'])->name('schedule');
        Route::post('/schedules', [ScheduleController::class, 'createSchedule'])->name('schedule.create');
        Route::post('/schedules/{id}/update', [ScheduleController::class, 'updateSchedule'])->name('schedule.update');
        Route::post('/schedules/{id}/delete', [ScheduleController::class, 'deleteSchedule'])->name('schedule.delete');
        Route::get('/api/schedules', [ScheduleController::class, 'getSchedulesByProcess'])->name('api.schedules');
        
        Route::get('/interview', [AdmissionProcessController::class, 'showInterview'])->name('interview');
        Route::get('/exam', [AdmissionProcessController::class, 'showExam'])->name('exam');
        Route::get('/evaluation', [AdmissionProcessController::class, 'showEvaluation'])->name('evaluation');
        
        Route::post('/interview/{id}/update', [AdmissionProcessController::class, 'updateInterview'])->name('interview.update');
        Route::post('/exam/{id}/update', [AdmissionProcessController::class, 'updateExam'])->name('exam.update');
        Route::post('/evaluation/{id}/update', [AdmissionProcessController::class, 'updateEvaluation'])->name('evaluation.update');
        
        Route::post('/applicant/mark-interview', [ApplicantController::class, 'createApplicantProcess'])->name('applicant.mark-interview');
        Route::post('/applicant/delete', [ApplicantController::class, 'deleteApplicants'])->name('applicant.delete');
        Route::post('/interview/process-action', [AdmissionProcessController::class, 'processInterviewAction'])->name('interview.process-action');
        Route::post('/exam/process-action', [AdmissionProcessController::class, 'processExamAction'])->name('exam.process-action');
        Route::post('/evaluation/process-action', [AdmissionProcessController::class, 'processEvaluationAction'])->name('evaluation.process-action');
        Route::post('/evaluation/admit', [AdmissionProcessController::class, 'admitStudents'])->name('evaluation.admit');
        
        Route::get('/student', [StudentController::class, 'showStudent'])->name('student');
        Route::get('/api/students/search', [StudentController::class, 'searchStudents'])->name('api.students.search');
        Route::get('/student/{id}/edit', [StudentController::class, 'editStudent'])->name('student.edit');
        Route::post('/student/{id}/update', [StudentController::class, 'updateStudent'])->name('student.update');
        
        Route::get('/print-admission-stats', [PdfController::class, 'printAdmissionStats'])->name('print.admission.stats');
        Route::get('/print-applicant-details/{id}', [PdfController::class, 'printApplicantDetails'])->name('print.applicant.details');
        Route::get('/print-interview-list', [PdfController::class, 'printInterviewList'])->name('print.interview.list');
        Route::get('/print-exam-list', [PdfController::class, 'printExamList'])->name('print.exam.list');
        Route::get('/print-evaluation-list', [PdfController::class, 'printEvaluationList'])->name('print.evaluation.list');
        Route::get('/print-schedule-applicants/{id}', [PdfController::class, 'printScheduleApplicants'])->name('print.schedule.applicants');
    });
});

Route::prefix('department')->name('department.')->group(function () {
    Route::get('/', [DepartmentAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [DepartmentAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [DepartmentAuthController::class, 'logout'])->name('logout');

    // Protected routes - require authentication and department type
    Route::middleware(['auth', 'can:access-department'])->group(function () {
        Route::get('/dashboard', [DepartmentAuthController::class, 'showDashboard'])->name('dashboard');
        
        Route::get('/student', [StudentController::class, 'showDepartmentStudents'])->name('student');
        Route::get('/api/students/search', [StudentController::class, 'searchDepartmentStudents'])->name('api.students.search');
        Route::get('/student/{id}/edit', [StudentController::class, 'editStudent'])->name('student.edit');
        Route::post('/student/{id}/update', [StudentController::class, 'updateStudent'])->name('student.update');

        Route::get('/enlistment', [EnlistmentController::class, 'showEnlistment'])->name('enlistment');
        Route::get('/enlistment/{student_id}/{academic_term_id}', [EnlistmentController::class, 'viewStudentSubjects'])->name('student.subjects');
        Route::post('/enlistment/{id}/update', [EnlistmentController::class, 'updateStudentEnlistmentApi'])->name('enlistment.update');
        
        // Enlistment API routes
        Route::get('/api/subject-offerings/{academicTermId}', [EnlistmentController::class, 'getSubjectOfferingsApi'])->name('api.enlistment.offerings');
        Route::get('/api/sections/{academicTermId}', [EnlistmentController::class, 'getSectionsApi'])->name('api.enlistment.sections');
        Route::get('/api/enlistments/{studentId}/{academicTermId}', [EnlistmentController::class, 'getStudentEnlistmentsApi'])->name('api.enlistment.list');
        Route::post('/api/enlistment/add', [EnlistmentController::class, 'addEnlistmentApi'])->name('api.enlistment.add');
        Route::post('/api/enlistment/add-section', [EnlistmentController::class, 'addEnlistmentBySectionApi'])->name('api.enlistment.add-section');
        Route::delete('/api/enlistment/{id}/remove', [EnlistmentController::class, 'removeEnlistmentApi'])->name('api.enlistment.remove');

        Route::get('/subject-offering', [SubjectOfferingController::class, 'showSubjectOffering'])->name('subject_offering');
        Route::post('/subject-offering/search', [SubjectOfferingController::class, 'searchOffering'])->name('subject_offering.search');
        Route::post('/subject-offering/add', [SubjectOfferingController::class, 'addSubjectOffering'])->name('subject_offering.add');
        Route::delete('/subject-offering/{id}/remove', [SubjectOfferingController::class, 'removeSubjectOffering'])->name('subject_offering.remove');
        Route::get('/print-subject-offerings', [PdfController::class, 'printSubjectOfferings'])->name('print.subject_offerings');
        Route::get('/api/curricula-by-department/{departmentId}', [SubjectOfferingController::class, 'getCurriculaByDepartment'])->name('api.curricula');
        Route::get('/api/subject-offering/{academicTermId}/{departmentId}', [SubjectOfferingController::class, 'getSubjectOffering'])->name('api.subject_offering');
        Route::get('/api/subjects/search', [SubjectOfferingController::class, 'searchSubjects'])->name('api.subjects.search');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected routes - require authentication and admin type
    Route::middleware(['auth', 'can:access-admin'])->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'showDashboard'])->name('dashboard');

        Route::get('/users', [AdminAuthController::class, 'showUsers'])->name('users');
        Route::post('/users', [AdminAuthController::class, 'createUser'])->name('users.create');
        Route::post('/users/{id}/update', [AdminAuthController::class, 'updateUser'])->name('users.update');
        Route::post('/users/{id}/delete', [AdminAuthController::class, 'deleteUser'])->name('users.delete');
    });
});