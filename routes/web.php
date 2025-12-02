<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoriesDataTableController;
use App\Http\Controllers\Admin\CategoriesDataTableController as AdminCategoriesDataTableController;
use App\Http\Controllers\Staff\CategoriesDataTableController as StaffCategoriesDataTableController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Staff\CategoryController as StaffCategoryController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentManagementController;
use App\Http\Controllers\BookmarkController;

// Public Routes
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Routes - ALL USERS
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Comments - semua user bisa comment
    Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Bookmarks
    Route::post('articles/{article}/bookmark', [BookmarkController::class, 'toggle'])->name('articles.bookmark.toggle');
    Route::get('bookmarks', [BookmarkController::class, 'index'])->name('reader.bookmarks');

    // Reader Routes (Untuk User Biasa)
    Route::prefix('reader')->group(function () {
        Route::get('/dashboard', [ReaderController::class, 'dashboard'])->name('reader.dashboard');
        Route::get('/articles', [ReaderController::class, 'articles'])->name('reader.articles');
        Route::get('/articles/category/{category}', [ReaderController::class, 'articlesByCategory'])->name('reader.articles.category');
        Route::get('/articles/{article}', [ReaderController::class, 'showArticle'])->name('reader.article.show');
        Route::post('/articles/{article}/like', [ReaderController::class, 'toggleLike'])->name('reader.article.like');
        Route::get('/search', [ReaderController::class, 'search'])->name('reader.search');
    });

    // Admin Routes (Hanya Admin & Staff)
    Route::middleware(['staff'])->group(function () {
        // Articles Management
        Route::resource('articles', ArticleController::class);
        Route::get('articles/trash/list', [ArticleController::class, 'trash'])->name('articles.trash');
        Route::post('articles/{id}/restore', [ArticleController::class, 'restore'])->name('articles.restore');
        Route::delete('articles/{id}/force-delete', [ArticleController::class, 'forceDelete'])->name('articles.forceDelete');
        Route::get('/articles.export', [ArticleController::class, 'export'])->name('articles.export');

        // Categories Management
        Route::resource('categories', CategoryController::class);
        Route::get('/categories.export', [CategoryController::class, 'export'])->name('categories.export');

        // Categories DataTables
        Route::get('categories/datatables', [CategoriesDataTableController::class, 'index'])->name('categories.datatables');

        // Admin Categories
        Route::prefix('admin')->name('admin.')->group(function() {
            Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
            Route::get('categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
            Route::post('categories', [AdminCategoryController::class, 'store'])->name('categories.store');
            Route::get('categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
            Route::put('categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
            Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
            Route::get('categories/datatables', [AdminCategoriesDataTableController::class, 'index'])->name('categories.datatables');
            Route::get('export', [AdminCategoryController::class, 'export'])->name('admin.categories.export');
        });

        // Admin Articles
        Route::prefix('admin')->name('admin.')->group(function() {
            Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
        });

        // Staff Categories
        Route::prefix('staff')->name('staff.')->group(function() {
            Route::get('categories', [StaffCategoryController::class, 'index'])->name('categories.index');
            Route::get('categories/datatables', [StaffCategoriesDataTableController::class, 'index'])->name('categories.datatables');
        });

        // Comments Management
        Route::prefix('admin/comments')->name('admin.comments.')->group(function() {
            Route::get('/', [CommentManagementController::class, 'index'])->name('index');
            Route::get('/{comment}', [CommentManagementController::class, 'show'])->name('show');
            Route::get('/{comment}/edit', [CommentManagementController::class, 'edit'])->name('edit');
            Route::put('/{comment}', [CommentManagementController::class, 'update'])->name('update');
            Route::delete('/{comment}', [CommentManagementController::class, 'destroy'])->name('destroy');
            Route::post('/{comment}/approve', [CommentManagementController::class, 'approve'])->name('approve');
            Route::post('/{comment}/unapprove', [CommentManagementController::class, 'unapprove'])->name('unapprove');
            Route::get('.export', [CommentManagementController::class, 'export'])->name('export');
        });

        // Staff Comments Management
        Route::prefix('staff/comments')->name('staff.comments.')->group(function() {
            Route::get('/', [CommentManagementController::class, 'index'])->name('index');
            Route::get('/{comment}', [CommentManagementController::class, 'show'])->name('show');
            Route::get('/{comment}/edit', [CommentManagementController::class, 'edit'])->name('edit');
            Route::put('/{comment}', [CommentManagementController::class, 'update'])->name('update');
            Route::delete('/{comment}', [CommentManagementController::class, 'destroy'])->name('destroy');
            Route::get('/export', [CommentManagementController::class, 'export'])->name('export');
            Route::post('/import', [CommentManagementController::class, 'import'])->name('import');
        });

        // User Management (Hanya Admin)
        Route::middleware(['admin'])->group(function () {
            Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
            Route::get('/users/create-staff', [UserManagementController::class, 'createStaff'])->name('users.create-staff');
            Route::post('/users/store-staff', [UserManagementController::class, 'storeStaff'])->name('users.store-staff');
            Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
            Route::get('/users.export', [UserManagementController::class, 'export'])->name('users.export');
        });
    });
});
