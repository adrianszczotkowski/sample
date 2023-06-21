<?php

use Illuminate\Support\Facades\Route;

Route
    ::permanentRedirect('/', '/graphiql')
    ->name('redirect');
