<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class DistributionOfPositionChart extends ChartWidget
{
    // Determines widget order on the dashboard
    protected static ?int $sort = 1;

    // Determines widget heading
    protected static ?string $heading = 'Employee Distribution (%)';

    /**
     * Prepare and return chart dataset.
     */
    protected function getData(): array
    {
        // Fetch employee count grouped by division
        $divisionData = Employee::query()
            ->select('division')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('division')
            ->get();

        // Total number of employees
        $totalEmployees = $divisionData->sum('total');

        // Extract division labels for the chart
        $labels = $divisionData->pluck('division')->toArray();

        // Calculate percentage distribution for each division
        $percentages = $divisionData->map(
            fn($item) => round(($item->total / $totalEmployees) * 100, 2)
        )->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Employee Distribution (%)',
                    'data' => $percentages,

                    // Colors for each pie slice
                    'backgroundColor' => [
                        '#36A2EB',
                        '#FF6384',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40'
                    ],
                    'borderColor' => '#fff',
                ],
            ],
            // Chart labels (division names)
            'labels' => $labels,
        ];
    }


    /**
     * Configure chart options and styling.
     */
    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
        {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            return `${label}: ${value}%`;
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'bottom',
                },
            },
             scales: {
                x: {
                    display: false,
                    grid: { display: false },
                },
                y: {
                    display: false,
                    grid: { display: false },
                },
            },
 
        }
    JS);
    }


    /**
     * Chart type definition.
     */
    protected function getType(): string
    {
        return 'pie';
    }
}
