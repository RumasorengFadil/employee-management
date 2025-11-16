<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickActions extends Widget
{
    // Determines widget order on the dashboard
    protected static ?int $sort = 4;

    // Make this widget span the entire grid width
    protected int|string|array $columnSpan = "full";

    protected static string $view = 'filament.widgets.quick-actions';
}
