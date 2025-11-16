<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Determines widget order on the dashboard
    protected static ?int $sort = 0;

    /**
     * Build and return all statistics displayed in this widget.
     */
    protected function getStats(): array
    {
        return [
            // Total number of employees in the system
            Stat::make('Total Employees', Employee::count())
                ->icon('heroicon-o-users'),

            // Count employees who are currently active
            Stat::make('Active Employees', Employee::where('status', 'aktif')->count())
                ->icon('heroicon-o-briefcase'),

            // Count how many distinct divisions exist among employees
            Stat::make('Filled Divisions', Employee::distinct('division')->count())
                ->icon('heroicon-o-building-office'),
        ];
    }
}
