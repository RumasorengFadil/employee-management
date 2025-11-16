<x-filament-widgets::widget>
    <x-filament::section>
         <x-slot name="heading">
        Quick Actions
    </x-slot>

    <div class="flex gap-3">
        <x-filament::button
            icon="heroicon-o-user-plus"
            color="primary"
            tag="a"
            href="{{ route('filament.admin.resources.employees.create') }}"
        >
            Add New Employee
        </x-filament::button>

        <x-filament::button
            icon="heroicon-o-eye"
            tag="a"
            href="{{ route('filament.admin.resources.employees.index') }}"
            color="gray"
        >
            View All Employee
        </x-filament::button>
    </div>
    </x-filament::section>
</x-filament-widgets::widget>
