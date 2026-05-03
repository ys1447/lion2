<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/dashboard', 'pages::dashboard.index')->middleware('auth');
Route::livewire('/users', 'pages::users.index')->middleware(['auth', 'role:admin']);
Route::livewire('/manage', 'pages::manage.index')->middleware('auth');
Route::livewire('/job-mixing', 'pages::job-mixing.index')->middleware('auth');
Route::livewire('/list-hold', 'pages::list-hold.index')->middleware('auth');
Route::livewire('/list-remix', 'pages::list-remix.index')->middleware('auth');
Route::livewire('/list-notification', 'pages::list-notification.index')->middleware('auth');
Route::livewire('/stock-reagent', 'pages::stock-reagent.index')->middleware('auth');
Route::livewire('/filling-issues', 'pages::filling-issues.index')->middleware('auth');
Route::livewire('/mqm', 'pages::mqm.index')->middleware('auth');
Route::livewire('/input-data/{slug}', 'pages::input.index')->middleware('auth')->name('input.data');
Route::livewire('/login', 'pages::auth.login')->middleware('guest')->name('login');
