<?php

namespace App\Observers;

use App\Models\Dashboard;

class DashboardObserver
{
    /**
     * Change assigned notes to default user dashboard
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return void
     */
    public function deleted(Dashboard $dashboard)
    {
        $user = $dashboard->user;
        $notes = $dashboard->notes;

        $default_dashboard = $user->dasboards()->where('default', true)->first();

        $notes->toQuery()->update(['dashboard_id' => $default_dashboard->id]);
    }
}
