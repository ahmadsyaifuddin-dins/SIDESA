{{-- Paginasi --}}
@if ($warga->hasPages())
<div class="mt-6">
    {{ $warga->links('vendor.pagination.livewire-custom') }}
</div>
@endif
