<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrderTable extends BaseWidget
{
    // Determines widget heading
    protected static ?string $heading = '5 Newest Employees';

    // Determines widget order on the dashboard
    protected static ?int $sort = 3;

    // Make this widget span the entire grid width
    protected int|string|array $columnSpan = 'full';

    /**
     * Build and configure the table widget.
     */
    public function table(Table $table): Table
    {
        return $table
            // Query the 5 most recently added employees
            ->query(
                Employee::query()
                    ->latest()     // Order by created_at DESC
                    ->limit(5)     // Only take the last 5
            )

            // Table columns definition
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name'),

                TextColumn::make('position')
                    ->label('Position')
                    ->badge(),

                TextColumn::make('division')
                    ->label('Division')
                    ->badge(),

                TextColumn::make('joined_at')
                    ->label('Joined At')
                    ->date(),
            ])

            // Disable pagination since only 5 items are displayed
            ->paginated(false);
    }
}
