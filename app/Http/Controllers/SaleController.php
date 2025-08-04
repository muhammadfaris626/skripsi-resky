<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Employee;
use App\Models\History;
use App\Models\Sale;
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class SaleController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('sale_date', 'LIKE', '%' . $search . '%')
                ->orWhere('amount', 'LIKE', '%' . $search . '%')
                ->orWhere('target_amount', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Sale::class);
        if (Auth::user()->roles[0]->name == 'root') {
            $searchQuery = Sale::query();
        } else {
            $employee = Employee::where('employee_number', Auth::user()->username)->first();
            $searchQuery = Sale::query()->where('employee_id', $employee->id);
        }

        $this->applySearch($searchQuery, $request->search);
        $data = SaleResource::collection($searchQuery->orderBy('id', 'DESC')->paginate(12));
        return Inertia::render('Sales/IndexSale', [
            'fetchData' => $data,
            'search' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleRequest $request): RedirectResponse {
        Gate::authorize('create', Sale::class);
        $employee = Employee::where('employee_number', Auth::user()->username)->first();
        $create = Sale::create([
            'sale_date' => $request->sale_date,
            'amount' => $request->amount,
            'target_amount' => $request->target_amount,
            'employee_id' => $employee->id
        ]);
        $currentDate = Carbon::parse($create->sale_date)->format('Y-m');
        $checkPeriod = Target::where('period', $currentDate)->first();
        $status = ($checkPeriod && $create->amount == $checkPeriod->amount) ? 1 : 0;
        History::create([
            'sale_id' => $create->id,
            'target_id' => optional($checkPeriod)->id,
            'achieved' => $status
        ]);
        Session::flash('toast', 'Data added successfully.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
