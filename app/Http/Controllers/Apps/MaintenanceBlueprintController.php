<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceBlueprintController extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia('Apps/Maintenance/Blueprint');
    }
}
