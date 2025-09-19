@if ($histories->hasPages())
<div class="mt-6">
    {{ $histories->links('vendor.pagination.livewire-custom') }}
</div>
@endif
