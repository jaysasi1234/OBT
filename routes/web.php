<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

// ADMIN
use App\Http\Controllers\Admin\DeploymentController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\RemarkController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\CadetController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\Admin\CourseManagementController;
use App\Http\Controllers\Admin\RequirementController as AdminRequirementController;
use App\Http\Controllers\Admin\ReportSettingsController;
use App\Http\Controllers\Admin\BatchManagementController;
use App\Http\Controllers\Admin\ComplaintTypeController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\OnboardRequirementController;
use App\Http\Controllers\Admin\BSRequirementController;
use App\Http\Controllers\Admin\CadetBSRequirementController;
use App\Http\Controllers\Admin\ShippedOnOrderController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\AccountCredentialController;
use App\Http\Controllers\Admin\CadetRequirementController;

// super admin
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\NotificationController as SuperAdminNotificationController;
use App\Http\Controllers\SuperAdmin\ProfileController as SuperAdminProfileController;
use App\Http\Controllers\SuperAdmin\RemarkController as SuperAdminRemarkController;
use App\Http\Controllers\SuperAdmin\SuperAdminForgotPasswordController;
use App\Http\Controllers\SuperAdmin\CadetRequirementController as SuperAdminCadetRequirementController;
use App\Http\Controllers\SuperAdmin\CadetBSRequirementController as SuperAdminCadetBSRequirementController;


// CADET
use App\Http\Controllers\Cadet\ProfileController as CadetProfileController;
use App\Http\Controllers\Cadet\DeploymentController as CadetDeploymentController;
use App\Http\Controllers\Cadet\RequirementController;
use App\Http\Controllers\Cadet\ComplaintController as CadetComplaintController;
use App\Http\Controllers\Cadet\DashboardController as CadetDashboardController;
use App\Http\Controllers\Cadet\NotificationController as CadetNotificationController;
use App\Http\Controllers\Cadet\OnboardRequirementController as CadetOnboardRequirementController;
use App\Http\Controllers\Cadet\BSRequirementController as CadetBSController;
use App\Http\Controllers\SuperAdmin\ShippedOnOrderController as SuperAdminShippedOnOrderController;

// CHAT
use App\Http\Controllers\ChatController;

// DEFAULT PROFILE
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

        // =========================
        // ADMIN LOGIN
        // =========================
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        // =========================
        // ADMIN TWO-FACTOR SETUP
        // =========================
        Route::get('/two-factor/setup', [AdminAuthController::class, 'showTwoFactorSetup'])->name('admin.two-factor.setup');
        Route::post('/two-factor/setup', [AdminAuthController::class, 'setupTwoFactor'])->name('admin.two-factor.setup.store');
        // =========================
        // ADMIN TWO-FACTOR CONFIRM
        // =========================
        Route::post('/two-factor/confirm', [AdminAuthController::class, 'confirmTwoFactorSetup'])->name('admin.two-factor.confirm');
        // =========================
        // ADMIN TWO-FACTOR CHALLENGE
        // =========================
        Route::get('/two-factor/challenge', [AdminAuthController::class, 'showTwoFactorChallenge'])->name('admin.two-factor.challenge');
        Route::post('/two-factor/challenge', [AdminAuthController::class, 'verifyTwoFactor'])->name('admin.two-factor.challenge.verify');



        // =========================
        // ADMIN FORGOT PASSWORD
        // =========================
        Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
        // =========================
        // ADMIN RESET PASSWORD
        // =========================
        Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset');
        Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('admin.password.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/locations', [LocationController::class, 'index'])->name('admin.locations');

        Route::get('/locations/data', [LocationController::class, 'data'])->name('admin.locations.data');

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
        Route::delete('/notifications/{id}',[NotificationController::class, 'destroy'])->name('notifications.delete');
        Route::delete('/notifications-delete-selected',[NotificationController::class, 'deleteSelected'])->name('notifications.deleteSelected');
        
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');

        Route::patch('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');

        Route::post('/profile/password', [AdminProfileController::class, 'changePassword'])->name('profile.password');

        Route::resource('cadets', CadetController::class);
        Route::get('/cadet-location/{id}', [CadetController::class, 'showLocation'])->name('cadets.location');
        Route::resource('users', UserController::class);
        Route::post('users/create-cadet-account',[UserController::class, 'createCadetAccount'])->name('users.createCadetAccount');
        Route::post('/users/create-batch-accounts',[UserController::class, 'createBatchAccounts'])->name('users.createBatchAccounts');

        Route::get('/deployment', [DeploymentController::class, 'index'])->name('deployment.index');
        Route::get('/deployment/{cadet}', [DeploymentController::class, 'show'])->name('deployment.show');

        Route::resource('settings/onboard-requirements',OnboardRequirementController::class)->names('settings.onboard-requirements');
        Route::resource('bs-requirements', BSRequirementController::class)->names('bs-requirements');
        Route::resource('shipped-so', ShippedOnOrderController::class)->names('shipped-so');
        Route::get('/cadet-bs-requirements',[CadetBSRequirementController::class,'index'])->name('cadet.bs.index');
        Route::put('/cadet-bs-requirements/{submission}',[CadetBSRequirementController::class,'update'])->name('cadet.bs.update');
        Route::put('/cadet-bs-requirements/{cadet}/legacy',[CadetBSRequirementController::class, 'approveLegacy'])->name('cadet.bs.legacy');
        Route::get('/cadet-requirements',[\App\Http\Controllers\Admin\CadetRequirementController::class, 'index'])->name('cadet.requirements.index');
Route::post(
    '/cadet-requirements/{cadet}/approve-legacy',
    [CadetRequirementController::class, 'approveLegacy']
)->name('cadet.requirements.approve-legacy');
        Route::get('/cadet-requirements/{cadet}',[\App\Http\Controllers\Admin\CadetRequirementController::class, 'show'])->name('cadet.requirements.show');
        Route::put('/cadet-requirements/{requirement}',[\App\Http\Controllers\Admin\CadetRequirementController::class, 'update'])->name('cadet.requirements.update');

        Route::get('/verification', [VerificationController::class, 'index'])->name('verification.index');
        Route::get('/verification/{id}', [\App\Http\Controllers\Admin\VerificationController::class, 'show'])->name('verification.show');
        Route::post('/verification/approve-legacy',[VerificationController::class, 'approveLegacy'])->name('verification.approve-legacy');
        Route::post('/verification/upload', [VerificationController::class, 'upload'])->name('verification.upload');

        Route::post('/verification/status', [VerificationController::class, 'updateStatus'])->name('verification.updateStatus');
        Route::get('/cadets-map', [CadetController::class, 'map'])->name('cadets.map');
    
        Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
        Route::post('/complaints/store', [ComplaintController::class, 'store'])->name('complaints.store');
        Route::put('/complaints/{complaint}',[ComplaintController::class,'update'])->name('complaints.update');

        Route::get('/reports/verification/pdf',[ReportController::class, 'verificationPdf'])->name('reports.verification.pdf');
        Route::get('/reports/complaint/pdf', [ReportController::class, 'complaintPdf'])->name('reports.complaint.pdf');
        Route::get('/reports/cadet-masterlist/pdf',[ReportController::class, 'cadetMasterlistPdf'])->name('reports.cadet.pdf');
        Route::get('/reports/deployment/pdf',[ReportController::class,'deploymentPdf'])->name('reports.deployment.pdf');
        

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/cadet-masterlist', [ReportController::class, 'cadetMasterlist'])->name('reports.cadet');
        Route::get('/reports/deployment', [ReportController::class, 'deployment'])->name('reports.deployment');
        Route::get('/reports/verification',[ReportController::class, 'verification'])->name('reports.verification');
        Route::get('/reports/complaint', [ReportController::class, 'complaint'])->name('reports.complaint');
        Route::put('/deployment/{cadet}', [DeploymentController::class, 'update'])->name('deployment.update');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

        Route::get('/remarks', [RemarkController::class, 'index'])->name('remarks.index');
        Route::post('/remarks/update/{id}', [RemarkController::class, 'update'])->name('remarks.update');
        Route::delete('/remarks/delete/{id}', [RemarkController::class, 'destroy'])->name('remarks.delete');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system.settings');
        Route::post('/system-settings/save', [SystemSettingsController::class, 'save'])->name('system.settings.save');
        Route::get('/course-management', [CourseManagementController::class, 'index'])->name('course.management');
        Route::get('/settings/account-credentials',[AccountCredentialController::class, 'index'])->name('settings.account-credentials');
        Route::post('/settings/account-credentials/generate',[AccountCredentialController::class, 'generate'])->name('settings.account-credentials.generate');
        Route::get('/settings/account-credentials/download',[AccountCredentialController::class, 'download'])->name('settings.account-credentials.download');

        Route::post('/course-management/store', [CourseManagementController::class, 'store'])->name('course.store');
        Route::put('/course-management/update/{id}', [CourseManagementController::class, 'update'])->name('course.update');
        Route::delete('/course-management/delete/{id}', [CourseManagementController::class, 'destroy'])->name('course.delete');

        Route::get('/requirements-management', [AdminRequirementController::class, 'index'])->name('requirements.index');
        Route::post('/requirements-management/store', [AdminRequirementController::class, 'store'])->name('requirements.store');
        Route::put('/requirements-management/update/{id}', [AdminRequirementController::class, 'update'])->name('requirements.update');
        Route::delete('/requirements-management/delete/{id}', [AdminRequirementController::class, 'destroy'])->name('requirements.delete');

        Route::get('/report-settings', [ReportSettingsController::class, 'index'])->name('report.settings');
        Route::post('/report-settings/store', [ReportSettingsController::class, 'store'])->name('report.settings.store');
        Route::get('/report-settings/edit/{id}', [ReportSettingsController::class, 'edit'])->name('report.settings.edit');
        Route::put('/report-settings/update/{id}', [ReportSettingsController::class, 'update'])->name('report.settings.update');
        Route::delete('/report-settings/delete/{id}', [ReportSettingsController::class, 'destroy'])->name('report.settings.delete');
        Route::post('/report-settings/save', [ReportSettingsController::class, 'saveSettings'])->name('report.settings.save');

        Route::get('/batch-management', [BatchManagementController::class, 'index'])->name('batch.management');
        Route::post('/batch-management/store', [BatchManagementController::class, 'store'])->name('batch.store');
        Route::put('/batch-management/update/{id}', [BatchManagementController::class, 'update'])->name('batch.update');
        Route::delete('/batch-management/delete/{id}', [BatchManagementController::class, 'destroy'])->name('batch.delete');

        Route::get('/complaint-types', [ComplaintTypeController::class, 'index'])->name('complaint.types.index');
        Route::post('/complaint-types/store', [ComplaintTypeController::class, 'store'])->name('complaint.types.store');
        Route::put('/complaint-types/update/{id}', [ComplaintTypeController::class, 'update'])->name('complaint.types.update');
        Route::delete('/complaint-types/delete/{id}', [ComplaintTypeController::class, 'destroy'])->name('complaint.types.delete');

});

Route::middleware(['auth'])->group(function () {

    Route::get('/notifications/open/{id}', function ($id) {

        $notification = Auth::user()
            ->notifications()
            ->find($id);

        if (!$notification) {
            return back();
        }

        $notification->markAsRead();

        if (isset($notification->data['url'])) {
            return redirect($notification->data['url']);
        }

        return back();

    })->name('notifications.open');

    Route::post('/notifications/read', function () {

    $user = Auth::user();

    $user->unreadNotifications->markAsRead();

    return back()->with('success', 'All notifications marked as read.');

})->name('notifications.read');

});

Route::prefix('super-admin')->group(function () {

        // =========================
        // SUPER ADMIN LOGIN
        // =========================
        Route::get('/login', [SuperAdminAuthController::class, 'showLogin'])->name('superadmin.login');

        Route::post('/login', [SuperAdminAuthController::class, 'login'])->name('superadmin.login.submit');


        // =========================
        // SUPER ADMIN FORGOT PASSWORD
        // =========================
        Route::get('/forgot-password', [SuperAdminForgotPasswordController::class, 'showLinkRequestForm'])->name('superadmin.password.request');

        Route::post('/forgot-password', [SuperAdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('superadmin.password.email');
        // =========================
        // SUPER ADMIN RESET PASSWORD
        // =========================
        Route::get('/reset-password/{token}', [SuperAdminForgotPasswordController::class, 'showResetForm'])->name('superadmin.password.reset');
        Route::post('/reset-password', [SuperAdminForgotPasswordController::class, 'reset'])->name('superadmin.password.update');
        // =========================
        // SUPER ADMIN LOGOUT
        // =========================
        Route::post('/logout', [SuperAdminAuthController::class, 'logout'])->name('superadmin.logout');
});

// =========================
// SUPER ADMIN DASHBOARD
// =========================
Route::prefix('super-admin')
    ->name('superadmin.')
    ->middleware(['auth', 'superadmin'])
    ->group(function () {
        

        Route::get('/profile', [SuperAdminProfileController::class, 'index'])->name('profile');

        Route::patch('/profile/update', [SuperAdminProfileController::class, 'update'])->name('profile.update');

        Route::get('/dashboard', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');

        Route::get(
    '/cadet-requirements',
    [SuperAdminCadetRequirementController::class, 'index']
)->name('cadet-requirements.index');

Route::get(
    '/cadet-requirements/{id}',
    [SuperAdminCadetRequirementController::class, 'show']
)->name('cadet-requirements.show');

Route::get(
    '/cadet-bs-requirements',
    [SuperAdminCadetBSRequirementController::class, 'index']
)->name('cadet-bs-requirements.index');

Route::get(
    '/cadet-bs-requirements/{cadet}',
    [SuperAdminCadetBSRequirementController::class, 'show']
)->name('cadet-bs-requirements.show');

Route::get(
    '/shipped-so',
    [SuperAdminShippedOnOrderController::class, 'index']
)->name('shipped-so.index');

Route::get(
    '/shipped-so/{shippedOnOrder}',
    [SuperAdminShippedOnOrderController::class, 'show']
)->name('shipped-so.show');

        Route::get('/notifications', [SuperAdminNotificationController::class, 'index'])->name('notifications');

        
        Route::post('/notifications/read/{id}',[SuperAdminNotificationController::class, 'markAsRead'])->name('notifications.read');

        Route::post('/notifications/mark-all-read',[SuperAdminNotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

        Route::get('/notifications/{id}',[SuperAdminNotificationController::class, 'show'])->name('notifications.show');

        Route::delete('/notifications/delete/{id}',[SuperAdminNotificationController::class, 'delete'])->name('notifications.delete');

        Route::get('/cadets', [\App\Http\Controllers\SuperAdmin\CadetController::class, 'index'])->name('cadets.index');

        Route::get('/remarks', [SuperAdminRemarkController::class,'index'])->name('remarks.index');

        Route::get('/remarks/{remark}', [SuperAdminRemarkController::class,'show'])->name('remarks.show');


        Route::post('/logout', [SuperAdminAuthController::class, 'logout'])->name('logout');

        Route::get('/deployments', [\App\Http\Controllers\SuperAdmin\DeploymentController::class, 'index'])->name('deployments.index');

        Route::get('/verification', [\App\Http\Controllers\SuperAdmin\VerificationController::class, 'index'])->name('verification.index');

        Route::get('/superadmin/verification/{id}', [VerificationController::class, 'show'])->name('superadmin.verification.show');

        Route::get('/complaints', [\App\Http\Controllers\SuperAdmin\ComplaintController::class,'index'])->name('complaints.index');

        Route::get('/chat', [ChatController::class, 'index'])->name('chat');

    });
/*
|--------------------------------------------------------------------------
| CADET ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('cadet')
    ->name('cadet.')
    ->middleware(['auth'])
    ->group(function () {


        Route::get('/notifications',[CadetNotificationController::class,'index'])->name('notifications');
        Route::get('/notifications/open/{id}',[CadetNotificationController::class,'open'])->name('notifications.open');
        Route::post('/notifications/read-all',[CadetNotificationController::class,'markAllRead'])->name('notifications.readAll');
        Route::delete('/notifications/delete/{id}',[CadetNotificationController::class,'destroy'])->name('notifications.delete');
        Route::delete('/notifications/delete-selected',[CadetNotificationController::class,'deleteSelected'])->name('notifications.deleteSelected');

        Route::get('/profile', [CadetProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [CadetProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/upload', [CadetProfileController::class, 'upload'])->name('profile.upload');
        Route::put('/profile/update', [CadetProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/guardian', [CadetProfileController::class, 'updateGuardian'])->name('profile.guardian.update');
        Route::put('/profile/password', [CadetProfileController::class, 'updatePassword'])->name('profile.password.update');

        Route::get('/deployment', [CadetDeploymentController::class, 'index'])->name('deployment');

        Route::get('/requirements', [RequirementController::class, 'index'])->name('requirements');
        Route::post('/requirements/upload',[RequirementController::class, 'upload'])->name('requirements.upload');
        Route::get('/onboard-requirements',[CadetOnboardRequirementController::class, 'index'])->name('onboard.requirements');
        Route::post('/onboard-requirements/upload',[CadetOnboardRequirementController::class, 'upload'])->name('onboard.requirements.upload');
        Route::get('/bs-requirements',[CadetBSController::class, 'index'])->name('bs.requirements');
        Route::post('/bs-requirements/upload',[CadetBSController::class, 'upload'])->name('bs.requirements.upload');
        
        Route::get('/complaints', [CadetComplaintController::class, 'index'])->name('complaints');
        Route::post('/complaints/store', [CadetComplaintController::class, 'store'])->name('complaints.store');


        Route::post('/update-location', [CadetController::class, 'updateLocation'])->name('update.location');
    });

/*
|--------------------------------------------------------------------------
| CHAT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/chat',
        [ChatController::class, 'index']
    )->name('chat.index');

    Route::post(
        '/user/heartbeat',
        function () {

            $user = Auth::user();

            $user->updateQuietly([
                'last_activity' => now(),
                'is_online' => true,
            ]);

            return response()->json([
                'success' => true,
                'online' => true,
            ]);
        }
    )->name('user.heartbeat');

    Route::post(
        '/chat/send',
        [ChatController::class, 'send']
    )->name('chat.send');

    Route::post(
        '/chat/groups',
        [ChatController::class, 'createGroup']
    )->name('chat.groups.create');

    Route::post(
        '/chat/groups/{group}/members',
        [ChatController::class, 'addMember']
    )->name('chat.groups.members.add');

    Route::delete(
        '/chat/groups/{group}/members/{member}',
        [ChatController::class, 'removeMember']
    )->name('chat.groups.members.remove');

    Route::post(
        '/chat/groups/{group}/leave',
        [ChatController::class, 'leaveGroup']
    )->name('chat.groups.leave');

    Route::delete(
        '/chat/groups/{group}',
        [ChatController::class, 'deleteGroup']
    )->name('chat.groups.delete');

    Route::post(
        '/chat/read',
        [ChatController::class, 'markAsRead']
    )->name('chat.read');

});

/*
|--------------------------------------------------------------------------
| DASHBOARD (ROLE FIXED)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    $user = Auth::user();

    if ($user?->isDean()) {
        return redirect()->route('superadmin.dashboard');
    }

    if ($user?->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return app(CadetDashboardController::class)->index();

})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE (FIXED - NO CONFLICT)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| AUTH FILE
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';