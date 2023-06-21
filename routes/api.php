<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route
    ::middleware('auth:sanctum')
    ->get('/user', fn(Request $request) => $request->user());
