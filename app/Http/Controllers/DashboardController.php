<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function __invoke(Request $request): InertiaResponse
    {
        $component = $request->user()->user_role;

        return Inertia::render('Dashboards/' . Str::ucfirst($component));
    }
}
