<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentTopicController;
use App\Http\Controllers\StudentAssessmentController;
use App\Http\Controllers\StudentRemedialController;
use App\Http\Controllers\StudentRemedialAttemptController;
use App\Http\Controllers\StudentVerificationController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\TeacherStudentController;
use App\Http\Controllers\TeacherLearningMaterialController;
use App\Http\Controllers\TeacherQuestionController;
use App\Http\Controllers\QuestionReviewController;
use App\Http\Controllers\TeacherAnalysisController;
use App\Http\Controllers\TeacherAssessmentResultController;
use App\Http\Controllers\TeacherRemedialMaterialController;
use App\Http\Controllers\TeacherRemedialExerciseController;
use App\Http\Controllers\TeacherRemedialResultController;
use App\Http\Controllers\TeacherRemedialRecommendationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\SchoolCodeController;

Route::get('/', function () {
    if (!auth()->check()) return redirect()->route('login');
    return match (auth()->user()->role) {
        'student' => redirect()->route('student.dashboard'),
        'teacher' => redirect()->route('teacher.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        default => abort(403, 'Role akun tidak dikenali.'),
    };
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('schools', SchoolController::class)->except(['show']);
    Route::get('/teachers', [UserManagementController::class, 'teachers'])->name('teachers.index');
    Route::get('/teachers/create', [UserManagementController::class, 'createTeacher'])->name('teachers.create');
    Route::post('/teachers', [UserManagementController::class, 'storeTeacher'])->name('teachers.store');
    Route::get('/teachers/{user}/edit', [UserManagementController::class, 'editTeacher'])->name('teachers.edit');
    Route::put('/teachers/{user}', [UserManagementController::class, 'updateTeacher'])->name('teachers.update');
    Route::get('/students', [UserManagementController::class, 'students'])->name('students.index');
    Route::patch('/students/{user}', [UserManagementController::class, 'updateStudent'])->name('students.update');
    Route::get('/assignments', [UserManagementController::class, 'assignments'])->name('assignments.index');
    Route::post('/assignments', [UserManagementController::class, 'storeAssignment'])->name('assignments.store');
    Route::delete('/assignments/{assignment}', [UserManagementController::class, 'destroyAssignment'])->name('assignments.destroy');
    Route::get('/codes', [SchoolCodeController::class, 'index'])->name('codes.index');
    Route::post('/codes', [SchoolCodeController::class, 'store'])->name('codes.store');
    Route::patch('/codes/{code}/toggle', [SchoolCodeController::class, 'toggle'])->name('codes.toggle');
    Route::delete('/codes/{code}', [SchoolCodeController::class, 'destroy'])->name('codes.destroy');
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::get('/students', [TeacherStudentController::class, 'index'])->name('students.index');
    Route::get('/learning-materials', [TeacherLearningMaterialController::class, 'index'])->name('learning-materials.index');
    Route::get('/learning-materials/create', [TeacherLearningMaterialController::class, 'create'])->name('learning-materials.create');
    Route::post('/learning-materials', [TeacherLearningMaterialController::class, 'store'])->name('learning-materials.store');
    Route::get('/learning-materials/{material}/edit', [TeacherLearningMaterialController::class, 'edit'])->name('learning-materials.edit');
    Route::put('/learning-materials/{material}', [TeacherLearningMaterialController::class, 'update'])->name('learning-materials.update');
    Route::patch('/learning-materials/{material}/publish', [TeacherLearningMaterialController::class, 'publish'])->name('learning-materials.publish');

    Route::get('/questions', [TeacherQuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [TeacherQuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [TeacherQuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}/edit', [TeacherQuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [TeacherQuestionController::class, 'update'])->name('questions.update');
    Route::post('/questions/{question}/submit', [TeacherQuestionController::class, 'submitForReview'])->name('questions.submit');

   Route::get('/review-questions', [QuestionReviewController::class, 'index'])
    ->name('review.index');

Route::get('/review-questions/topics/{topic}', [QuestionReviewController::class, 'topic'])
    ->name('review.topic');

Route::get('/review-questions/{question}', [QuestionReviewController::class, 'show'])
    ->name('review.show');
    Route::post('/review-questions/{question}/approve', [QuestionReviewController::class, 'approve'])->name('review.approve');
    Route::post('/review-questions/{question}/revision', [QuestionReviewController::class, 'requestRevision'])->name('review.revision');

    Route::get('/results', [TeacherAssessmentResultController::class, 'index'])->name('results.index');
    Route::get('/results/{attempt}', [TeacherAssessmentResultController::class, 'show'])->name('results.show');
    Route::get('/analyses', [TeacherAnalysisController::class, 'index'])->name('analyses.index');
    Route::get('/analyses/{attempt}', [TeacherAnalysisController::class, 'show'])->name('analyses.show');
    Route::post('/analyses/{attempt}/review-topic', [TeacherAnalysisController::class, 'reviewTopic'])->name('analyses.review-topic');
    Route::post('/analyses/{analysis}/review', [TeacherAnalysisController::class, 'review'])->name('analyses.review');
    Route::post('/analyses/findings/{finding}/review', [TeacherAnalysisController::class, 'reviewFinding'])->name('analyses.findings.review');
    Route::post('/analyses/findings/{finding}/recommend', [TeacherRemedialRecommendationController::class, 'store'])->name('analyses.recommend');

    Route::get('/remedials', [TeacherRemedialMaterialController::class, 'index'])->name('remedials.index');
    Route::get('/remedials/create', [TeacherRemedialMaterialController::class, 'create'])->name('remedials.create');
    Route::post('/remedials', [TeacherRemedialMaterialController::class, 'store'])->name('remedials.store');
    Route::get('/remedials/{remedial}/edit', [TeacherRemedialMaterialController::class, 'edit'])->name('remedials.edit');
    Route::put('/remedials/{remedial}', [TeacherRemedialMaterialController::class, 'update'])->name('remedials.update');
    Route::patch('/remedials/{remedial}/publish', [TeacherRemedialMaterialController::class, 'togglePublish'])->name('remedials.publish');
    Route::delete('/remedials/{remedial}', [TeacherRemedialMaterialController::class, 'destroy'])->name('remedials.destroy');
    Route::get('/remedials/{remedial}/results', [TeacherRemedialResultController::class, 'index'])->name('remedials.results.index');
    Route::get('/remedials/{remedial}/results/{attempt}', [TeacherRemedialResultController::class, 'show'])->name('remedials.results.show');
    Route::get('/remedials/{remedial}/exercises', [TeacherRemedialExerciseController::class, 'index'])->name('remedials.exercises.index');
    Route::get('/remedials/{remedial}/exercises/create', [TeacherRemedialExerciseController::class, 'create'])->name('remedials.exercises.create');
    Route::post('/remedials/{remedial}/exercises', [TeacherRemedialExerciseController::class, 'store'])->name('remedials.exercises.store');
    Route::get('/remedials/{remedial}/exercises/{exercise}/edit', [TeacherRemedialExerciseController::class, 'edit'])->name('remedials.exercises.edit');
    Route::put('/remedials/{remedial}/exercises/{exercise}', [TeacherRemedialExerciseController::class, 'update'])->name('remedials.exercises.update');
    Route::patch('/remedials/{remedial}/exercises/{exercise}/toggle', [TeacherRemedialExerciseController::class, 'toggleActive'])->name('remedials.exercises.toggle');
    Route::delete('/remedials/{remedial}/exercises/{exercise}', [TeacherRemedialExerciseController::class, 'destroy'])->name('remedials.exercises.destroy');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/topics/domain/{domain}', [StudentTopicController::class, 'index'])->name('topics.index');
    Route::get('/topics/{topic}', [StudentTopicController::class, 'show'])->name('topics.show');
    Route::post('/topics/{topic}/start', [StudentAssessmentController::class, 'start'])->name('topics.start');
    Route::get('/assessments/{attempt}', [StudentAssessmentController::class, 'show'])->name('assessments.show');
    Route::post('/assessments/{attempt}/answers', [StudentAssessmentController::class, 'saveAnswers'])->name('assessments.answers.save');
    Route::post('/assessments/{attempt}/finish', [StudentAssessmentController::class, 'finish'])->name('assessments.finish');
    Route::get('/verifications/{analysis}', [StudentVerificationController::class, 'show'])->name('verifications.show');
    Route::post('/verifications/{analysis}', [StudentVerificationController::class, 'store'])->name('verifications.store');
    Route::get('/remedials/{remedial}', [StudentRemedialController::class, 'show'])->name('remedials.show');
    Route::post('/remedials/{remedial}/attempts/start', [StudentRemedialAttemptController::class, 'start'])->name('remedials.attempts.start');
    Route::get('/remedial-attempts/{attempt}', [StudentRemedialAttemptController::class, 'show'])->name('remedials.attempts.show');
    Route::post('/remedial-attempts/{attempt}/answer', [StudentRemedialAttemptController::class, 'saveAnswer'])->name('remedials.attempts.answer');
    Route::post('/remedial-attempts/{attempt}/submit', [StudentRemedialAttemptController::class, 'submit'])->name('remedials.attempts.submit');
    Route::get('/remedial-attempts/{attempt}/result', [StudentRemedialAttemptController::class, 'result'])->name('remedials.attempts.result');
});
