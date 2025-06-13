<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminInviteController;
use App\Http\Controllers\CompanyUserInviteController;
use App\Http\Controllers\MemberInviteController;
use App\Http\Controllers\ShortUrlController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SuperAdmin → Invite Admin
    // Route::get('/superadmin/invite', [AdminInviteController::class, 'create'])->name('superadmin.invite');
    // Route::post('/superadmin/invite', [AdminInviteController::class, 'store'])->name('superadmin.invite.store');
    // Route::get('/superadmin/dashboard', [AdminInviteController::class, 'superadminDashboard'])->name('superadmin.dashboard');
    // Route::get('/superadmin/export/csv', [AdminInviteController::class, 'exportCsv'])->name('superadmin.export.csv');
    // Route::get('/superadmin/clients', [AdminInviteController::class, 'clientList'])->name('superadmin.clients');
    Route::get('/superadmin/export-urls', [AdminInviteController::class, 'exportShortUrls'])->name('superadmin.export.urls');
    // Route::get('/superadmin/urls', [AdminInviteController::class, 'urlsIndex'])->name('superadmin.urls.index');


    // // Admin → Invite Member
    // Route::get('/admin/dashboard', [CompanyUserInviteController::class, 'dashboard'])->name('admin.dashboard');
    // Route::get('/admin/invite', [CompanyUserInviteController::class, 'create'])->name('admin.invite');
    // Route::post('/admin/invite', [CompanyUserInviteController::class, 'store'])->name('admin.invite.store');
    Route::get('/admin/export-urls', [CompanyUserInviteController::class, 'exportUrls'])->name('admin.export.urls');
    // Route::get('/admin/members', [CompanyUserInviteController::class, 'membersList'])->name('admin.members.index');
    Route::get('/admin/urls', [CompanyUserInviteController::class, 'urls'])->name('admin.urls.index');


    // // Short URL management
    Route::get('/urls', [ShortUrlController::class, 'index'])->name('urls.index');
    // Route::get('/urls/create', [ShortUrlController::class, 'create'])->name('urls.create');
    // Route::post('/urls', [ShortUrlController::class, 'store'])->name('urls.store');
    // Route::get('/urls/download', [ShortUrlController::class, 'download'])->name('urls.download');
   

});

Route::middleware('auth')->group(function () {

    // SuperAdmin Routes
    Route::get('/superadmin/invite', function () {
        abort_unless(auth()->user()->role === 'superadmin', 403);
        return app(AdminInviteController::class)->create();
    })->name('superadmin.invite');

    Route::post('/superadmin/invite', function () {
        abort_unless(auth()->user()->role === 'superadmin', 403);
        return app(AdminInviteController::class)->store(request());
    })->name('superadmin.invite.store');

    Route::get('/superadmin/dashboard', function () {
        // abort_unless(auth()->user()->role === 'superadmin', 403);
        return app(AdminInviteController::class)->superadminDashboard();
    })->name('superadmin.dashboard');

    Route::get('/superadmin/export/csv', function () {
        abort_unless(auth()->user()->role === 'superadmin', 403);
        return app(AdminInviteController::class)->exportCsv();
    })->name('superadmin.export.csv');

    Route::get('/superadmin/clients', function () {
        abort_unless(auth()->user()->role === 'superadmin', 403);
        return app(AdminInviteController::class)->clientList();
    })->name('superadmin.clients');

    // Route::get('/superadmin/export-urls', function () {
    //     // abort_unless(auth()->user()->role === 'superadmin', 403);
    //     return app(AdminInviteController::class)->exportShortUrls();
    // })->name('superadmin.export.urls');

    Route::get('/superadmin/urls', function () {
        abort_unless(auth()->user()->role === 'superadmin', 403);
        return app(AdminInviteController::class)->urlsIndex();
    })->name('superadmin.urls.index');


    // Admin Routes
    Route::get('/admin/dashboard', function () {
        abort_unless(auth()->user()->role === 'admin', 403);
        return app(CompanyUserInviteController::class)->dashboard();
    })->name('admin.dashboard');

    Route::get('/admin/invite', function () {
        abort_unless(auth()->user()->role === 'admin', 403);
        return app(CompanyUserInviteController::class)->create();
    })->name('admin.invite');

    Route::post('/admin/invite', function () {
        abort_unless(auth()->user()->role === 'admin', 403);
        return app(CompanyUserInviteController::class)->store(request());
    })->name('admin.invite.store');

    // Route::get('/admin/export-urls', function () {
    //     // abort_unless(auth()->user()->role === 'admin', 403);
    //     return app(CompanyUserInviteController::class)->exportUrls();
    // })->name('admin.export.urls');

    Route::get('/admin/members', function () {
        abort_unless(auth()->user()->role === 'admin', 403);
        return app(CompanyUserInviteController::class)->membersList();
    })->name('admin.members.index');

    // Route::get('/admin/urls', function () {
    //     abort_unless(auth()->user()->role === 'admin', 403);
    //     return app(CompanyUserInviteController::class)->urls();
    // })->name('admin.urls.index');


    // Member & Admin shared routes
    // Route::get('/urls', function () {
    //     // abort_unless(in_array(auth()->user()->role, ['admin', 'member']), 403);
    //     return app(ShortUrlController::class)->index();
    // })->name('urls.index');

    Route::get('/urls/create', function () {
        abort_unless(in_array(auth()->user()->role, ['admin', 'member']), 403);
        return app(ShortUrlController::class)->create();
    })->name('urls.create');

    Route::post('/urls', function () {
        abort_unless(in_array(auth()->user()->role, ['admin', 'member']), 403);
        return app(ShortUrlController::class)->store(request());
    })->name('urls.store');

    Route::get('/urls/download', function () {
        abort_unless(in_array(auth()->user()->role, ['admin', 'member']), 403);
        return app(ShortUrlController::class)->download();
    })->name('urls.download');

});


Route::get('/s/{code}', [ShortUrlController::class, 'redirect'])->name('urls.redirect');



require __DIR__.'/auth.php';
