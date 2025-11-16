<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Widgets\ChartWidget;

class EmployeesPerDivisionChart extends ChartWidget
{
    // Determines widget heading
    protected static ?string $heading = 'Employees per Division';

    // Determines widget order on the dashboard
    protected static ?int $sort = 2;

    /**
     * Prepare the chart data and dataset structure.
     */
    protected function getData(): array
    {
        // Fetch employee counts grouped by division
        $divisionData = Employee::query()
            ->select('division')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('division')
            ->get();

        // Extract division names (labels)
        $labels = $divisionData->pluck('division')->toArray();

        // Extract employee totals for each division
        $totals = $divisionData->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Employees',
                    'data' => $totals,

                    // Bar color styles
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'borderWidth' => 1,
                ],
            ],

            // Chart x-axis labels
            'labels' => $labels,
        ];
    }

    /**
     * Define the chart type.
     */
    protected function getType(): string
    {
        return 'bar';
    }
}
