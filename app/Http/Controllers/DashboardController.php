<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Sale;
use App\Models\Target;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response {
        $employees = Employee::count();
        $targets = Target::sum('amount');
        $sales = Sale::sum('amount');
        return Inertia::render('Dashboard', [
            'employees' => $employees,
            'targets' => $targets,
            'sales' => $sales
        ]);
    }
}
