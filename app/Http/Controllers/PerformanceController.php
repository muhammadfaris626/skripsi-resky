<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Sale;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PerformanceController extends Controller {
    public function index(Request $request): Response {
        if (Gate::allows('performance: menu')) {
            $targets = Target::all();
            $salesData = Sale::select(
                'employee_id',
                DB::raw('DATE_FORMAT(sale_date, "%Y-%m") as period'),
                DB::raw('SUM(amount) as total_sales')
            )->groupBy('employee_id', 'period')->get();
            $performanceData = [];
            foreach ($targets as $target) {
                foreach ($salesData as $sale) {
                    if ($sale->period == $target->period) {
                        $employee = Employee::find($sale->employee_id);
                        $performanceData[] = [
                            'employee_id' => $employee->id,
                            'employee_name' => $employee->name,
                            'period' => $target->period,
                            'target_amount' => $target->amount,
                            'total_sales' => $sale->total_sales,
                            'performance_percentage' => ($sale->total_sales / $target->amount) * 100
                        ];
                    }
                }
            }
        }
        return Inertia::render('Performances/IndexPerformance', [
            'fetchData' => $performanceData
        ]);
    }
}
