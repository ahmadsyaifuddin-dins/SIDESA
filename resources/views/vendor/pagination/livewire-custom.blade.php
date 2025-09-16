@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        {{-- Info Jumlah Data --}}
        <div class="hidden sm:block">
            <p class="text-sm text-light">
                Menampilkan
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                sampai
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-medium">{{ $paginator->total() }}</span>
                hasil
            </p>
        </div>

        {{-- Tombol-tombol Paginasi --}}
        <div class="flex justify-between flex-1 sm:justify-end">
            {{-- Tombol "Previous" --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-white border border-slate-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <button wire:click="previousPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-main bg-white border border-slate-300 leading-5 rounded-md hover:text-slate-500 focus:outline-none focus:ring-primary focus:border-primary active:bg-slate-100 active:text-main transition ease-in-out duration-150">
                    {!! __('pagination.previous') !!}
                </button>
            @endif

            {{-- Tombol "Next" --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled" class="ms-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-main bg-white border border-slate-300 leading-5 rounded-md hover:text-slate-500 focus:outline-none focus:ring-primary focus:border-primary active:bg-slate-100 active:text-main transition ease-in-out duration-150">
                    {!! __('pagination.next') !!}
                </button>
            @else
                <span class="ms-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-white border border-slate-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>
    </nav>
@endif
