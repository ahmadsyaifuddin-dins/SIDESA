<div x-data="{ showFilters: false }">
    <x-slot:title>
        Histori Kependudukan
    </x-slot:title>

    @include('livewire.history.partials._header')

    <div class="space-y-6">
        {{-- @include('livewire.history.partials._dashboard') --}}
        @include('livewire.history.partials._controls')
        @include('livewire.history.partials._filters')
        @include('livewire.history.partials._table')
        @include('livewire.history.partials._pagination')
    </div>
</div>