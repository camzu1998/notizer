<?php

namespace App\Observers;

use App\Models\Dashboard;

class DashboardObserver
{
    /**
     * Handle the Dashboard "deleted" event.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return void
     */
    public function deleted(Dashboard $dashboard)
    {
        $dashboard->notes()->delete();
    }
}
