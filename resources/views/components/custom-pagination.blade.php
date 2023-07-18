<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-2 py-1 text-xs font-medium text-gray-500 bg-paleblue-light cursor-default leading-5">
                        < Halaman Sebelumnya
                    </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="relative inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-paleblue-light leading-5 hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        < Halaman Sebelumnya
                    </button>
                @endif
            </span>
 
            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="relative inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-paleblue-light leading-5 hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" >
                        Halaman Setelahnya >
                    </button>
                @else
                    <span class="relative inline-flex items-center px-2 py-1 text-xs font-medium text-gray-500 bg-paleblue-light cursor-default leading-5">
                        Halaman Setelahnya >
                    </span>
                @endif
            </span>
        </nav>
    @endif
</div>