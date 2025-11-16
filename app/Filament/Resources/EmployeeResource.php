<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{
    DatePicker,
    Section,
    Select,
    Textarea,
    TextInput
};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Employee Data';

    /** 
     * Master Options 
     */
    public const GENDERS = [
        'laki-laki' => 'Laki-Laki',
        'perempuan' => 'Perempuan',
    ];

    public const POSITIONS = [
        'staff' => 'Staff',
        'admin' => 'Admin',
        'supervisor' => 'Supervisor',
        'manager' => 'Manager',
        'intern' => 'Intern',
    ];

    public const DIVISIONS = [
        'hrd' => 'HRD',
        'finance' => 'Finance',
        'IT' => 'IT',
        'marketing' => 'Marketing',
        'operation' => 'Operation',
        'GA' => 'GA',
    ];

    public const STATUSES = [
        'aktif' => 'Aktif',
        'non-aktif' => 'Non-Aktif',
        'resign' => 'Resign',
        'cuti' => 'Cuti',
    ];

    public static function form(Form $form): Form
    {
        return $form->schema([

            /** -------------------------
             * MAIN DATA
             * ------------------------- */
            Section::make('Main Data')->schema([
                TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->minLength(8)
                    ->maxLength(12)
                    ->rule('digits_between:8,12')
                    ->unique(ignoreRecord: true),

                TextInput::make('full_name')->label('Full Name')->required(),
                TextInput::make('email')->email()->required()->unique(ignoreRecord: true),

                Select::make('gender')
                    ->options(self::GENDERS)
                    ->required(),

                DatePicker::make('birth_day')->label('Birth Date'),

                Textarea::make('address'),

                TextInput::make('telp_number')
                    ->label('Phone Number')
                    ->minLength(10)
                    ->maxLength(13)
                    ->rule('digits_between:10,13'),
            ])->columns(2),

            /** -------------------------
             * JOB DATA 
             * ------------------------- */
            Section::make('Jobs Data')->schema([
                Select::make('position')
                    ->options(self::POSITIONS)
                    ->required(),

                Select::make('division')
                    ->options(self::DIVISIONS)
                    ->required(),

                DatePicker::make('joined_at')->label('Joined At')->required(),

                TextInput::make('salary')
                    ->numeric()
                    ->label('Salary'),

                Select::make('status')
                    ->options(self::STATUSES),
            ])->columns(2),
        ]);
    }

    /**
     * TABLE — Set the display of the main Employee table.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                self::textCol('nik', 'NIK', searchable: true),
                self::textCol('full_name', 'Full Name', searchable: true),
                self::textCol('telp_number', 'Phone Number', searchable: true),
                self::textCol('email', 'Email', searchable: true),
                self::badgeCol('gender', 'Gender'),
                self::badgeCol('position', 'Position'),
                self::badgeCol('division', 'Division'),

                Tables\Columns\TextColumn::make('joined_at')
                    ->label('Joined At')
                    ->date(),

                self::textCol('birth_day', 'Birth Day')
                    ->date(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aktif' => 'success',
                        'non-aktif' => 'secondary',
                        'resign' => 'danger',
                        'cuti' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('salary')
                    ->label('Salary')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->since(),
            ])

            // --- FILTERS ---
            ->filters([
                Tables\Filters\SelectFilter::make('gender')->options(self::GENDERS)->label('Jenis Kelamin'),
                Tables\Filters\SelectFilter::make('position')->options(self::POSITIONS)->label('Jabatan'),
                Tables\Filters\SelectFilter::make('division')->options(self::DIVISIONS)->label('Divisi'),
                Tables\Filters\SelectFilter::make('status')->options(self::STATUSES),

                // Date Range Filter
                Tables\Filters\Filter::make('joined_at')
                    ->label('Tanggal Masuk')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(
                        fn($query, array $data) =>
                        $query
                            ->when($data['from'], fn($q) => $q->whereDate('joined_at', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('joined_at', '<=', $data['until']))
                    ),

                // Salary Range Filter
                Tables\Filters\Filter::make('salary')
                    ->label('Gaji')
                    ->form([
                        TextInput::make('min')->numeric(),
                        TextInput::make('max')->numeric(),
                    ])
                    ->query(
                        fn($query, array $data) =>
                        $query
                            ->when($data['min'], fn($q) => $q->where('salary', '>=', $data['min']))
                            ->when($data['max'], fn($q) => $q->where('salary', '<=', $data['max']))
                    ),
            ])
            // --- COLUMN ACTIONS ---
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            // --- BULK ACTIONS ---
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Helper for column
     */
    protected static function textCol(string $field, string $label, bool $searchable = false)
    {
        $col = Tables\Columns\TextColumn::make($field)->label($label);

        if ($searchable) {
            $col->searchable();
        }

        return $col;
    }

    protected static function badgeCol(string $field, string $label)
    {
        return Tables\Columns\TextColumn::make($field)
            ->label($label)
            ->badge();
    }

    /**
     * RELATIONS — If Employee has a relationship, list it here.
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * PAGES — Set up CRUD page routes.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
