<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json([
    'name' => 'Travel Checklist Demo',
    'description' => 'New AI-assisted PHP application sample. See README for API usage.',
]));
