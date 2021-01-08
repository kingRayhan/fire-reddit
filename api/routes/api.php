<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;


Route::apiResource('threads', ThreadController::class);
Route::post('threads/{thread}/comment', [ThreadController::class, 'storeComment']);
Route::post('vote/{thread_id}/upvote', [VoteController::class, 'upVote']);
Route::post('vote/{thread_id}/downvote', [VoteController::class, 'downVote']);
Route::get('threads/user/{username}', [ThreadController::class, 'userThreads']);

/**
 * Notifications
 */
Route::get('notifications', [NotificationController::class, 'notifications']);
Route::get('notifications/reads', [NotificationController::class, 'readNotifications']);
Route::get('notifications/unreads', [NotificationController::class, 'unreadNotifications']);
Route::delete('notifications/destroy-all', [NotificationController::class, 'destroyAll']);
Route::delete('notifications/destroy-unreads', [NotificationController::class, 'destroyAllUnreads']);
Route::delete('notifications/destroy-reads', [NotificationController::class, 'destroyAllReads']);
Route::post('notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead']);
Route::post('notifications/mark-as-unread/{id}', [NotificationController::class, 'markAsUnread']);
Route::delete('notifications/delete/{id}', [NotificationController::class, 'destroy']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('delete', [AuthController::class, 'destroy']);
    Route::post('update-profile', [AuthController::class, 'updateProfile'])->name('auth.login');
    Route::get('me', [AuthController::class, 'me'])->name('auth.me');
    Route::post('password/update', [AuthController::class, 'updatePassword']);


    Route::get('/verification-email', [EmailVerificationController::class, 'verify'])
        ->name('verification.verify');

    Route::post('/resend-verification-email', [EmailVerificationController::class, 'resend'])
        ->name('verification.resend');
});
