<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormDashboardRequest;
use App\Models\Dashboard;
use App\Repositories\DashboardRepository;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $repository;
    private $user;

    public function  __construct(DashboardRepository $repository)
    {
        $this->repository = $repository;
        $this->user = Auth::user();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FormDashboardRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormDashboardRequest $request)
    {
        $data = $request->validated();

        $dashboard = $this->user->dashboards()->create($data);

        return redirect()->route('dashboard')->with('status', 'Dashboard created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Dashboard $dashboard)
    {
        $data['dashboard'] = $dashboard;
        $data['notes'] = $dashboard->notes;

        return view('dashboard', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Contracts\View\View
     */
    public function home()
    {
        $dashboard = $this->repository->get_default_dashboard();

        $data['dashboard'] = $dashboard;
        $data['notes'] = $dashboard->notes;

        return view('dashboard', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FormDashboardRequest  $request
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FormDashboardRequest $request, Dashboard $dashboard)
    {
        $data = $request->validated();

        $dashboard->fill($data);
        $dashboard->isDirty() ? $dashboard->save() : $dashboard;

        return redirect()->route('dashboard', [$dashboard])->with('status', 'Dashboard updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Dashboard $dashboard)
    {
        $dashboard->delete();

        return redirect()->route('dashboard')->with('status', 'Dashboard deleted!');
    }
}
