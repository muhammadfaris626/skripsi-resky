<?php

namespace App\Http\Controllers;

use App\Http\Requests\TargetRequest;
use App\Http\Resources\TargetResource;
use App\Models\Target;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class TargetController extends Controller
{
    protected function applySearch($query, $search) {
        return $query->when($search, function($query, $search) {
            $query->where('period', 'LIKE', '%' . $search . '%')
                ->orWhere('amount', 'LIKE', '%' . $search . '%');
        });
    }

    public function index(Request $request): Response {
        Gate::authorize('viewAny', Target::class);
        $searchQuery = Target::query();
        $this->applySearch($searchQuery, $request->search);
        $data = TargetResource::collection($searchQuery->orderBy('id', 'DESC')->paginate(12));
        return Inertia::render('Targets/IndexTarget', [
            'fetchData' => $data,
            'search' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TargetRequest $request): RedirectResponse {
        Gate::authorize('create', Target::class);
        Target::create($request->validated());
        Session::flash('toast', 'Data added successfully.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Target $target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Target $target)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TargetRequest $request, Target $target): RedirectResponse {
        Gate::authorize('update', $target);
        $target->update($request->validated());
        Session::flash('update', 'Data successfully changed.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Target $target): RedirectResponse {
        Gate::authorize('delete', $target);
        $target->delete();
        Session::flash('toast', 'Data was successfully deleted.');
        return back();
    }
}
