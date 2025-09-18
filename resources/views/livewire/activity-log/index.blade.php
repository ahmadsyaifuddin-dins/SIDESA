<div x-data="{ showFilters: false }">
    <x-slot:title>
        Log Aktivitas
    </x-slot:title>

    @include('livewire.activity-log.partials._header')
    
    @include('livewire.activity-log.partials._controls')

    @include('livewire.activity-log.partials._filters')

    @include('livewire.activity-log.partials._table')
    
    @include('livewire.activity-log.partials._pagination')
</div>
