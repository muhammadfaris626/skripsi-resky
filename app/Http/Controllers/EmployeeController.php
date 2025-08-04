<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeController extends Controller {

    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('employee_number', 'LIKE', '%' . $search . '%')
                ->orWhere('position', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Employee::class);
        $searchQuery = Employee::query();
        $this->applySearch($searchQuery, $request->search);
        $data = EmployeeResource::collection($searchQuery->orderBy('id', 'DESC')->paginate(12));
        return Inertia::render('Employees/IndexEmployee', [
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
    public function store(EmployeeRequest $request): RedirectResponse {
        Gate::authorize('create', Employee::class);
        Employee::create($request->validated());
        User::create([
            'name' => $request->name,
            'username' => $request->employee_number,
            'email' => $request->employee_number."@gmail.com",
            'password' => bcrypt($request->employee_number)
        ]);
        Session::flash('toast', 'Data added successfully.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee): RedirectResponse {
        Gate::authorize('update', $employee);
        $user = User::where('username', $employee->employee_number)->first();
        $employee->update($request->validated());
        $user->update([
            'name' => $request->name,
            'username' => $request->employee_number,
            'email' => $request->employee_number."@gmail.com",
            'password' => bcrypt($request->employee_number)
        ]);
        Session::flash('toast', 'Data successfully changed.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee): RedirectResponse {
        Gate::authorize('delete', $employee);
        User::where('username', $employee->employee_number)->delete();
        $employee->delete();
        Session::flash('toast', 'Data was successfully deleted.');
        return back();
    }
}
