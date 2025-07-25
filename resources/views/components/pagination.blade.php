@props(['data' => null])
@if ($data && $data->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-4">
        <div class="flex-1 flex justify-between sm:hidden">
            @if ($data->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                    &laquo; Previous
                </span>
            @else
                <a href="{{ $data->previousPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    &laquo; Previous
                </a>
            @endif

            @if ($data->hasMorePages())
                <a href="{{ $data->nextPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    Next &raquo;
                </a>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                    Next &raquo;
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    Showing
                    <span class="font-medium">{{ $data->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $data->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $data->total() }}</span>
                    results
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($data->onFirstPage())
                        <span aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-default leading-5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $data->previousPageUrl() }}" rel="prev"
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                            aria-label="@lang('pagination.previous')">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($data->links()->elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $data->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 -ml-px border border-gray-300 bg-indigo-600 text-sm font-medium text-white leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="relative inline-flex items-center px-4 py-2 -ml-px border border-gray-300 bg-white text-sm font-medium text-gray-700 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                        aria-label="@lang('pagination.go_to_page', ['page' => $page])">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($data->hasMorePages())
                        <a href="{{ $data->nextPageUrl() }}" rel="next"
                            class="relative inline-flex items-center px-2 py-2 -ml-px rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                            aria-label="@lang('pagination.next')">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span
                                class="relative inline-flex items-center px-2 py-2 -ml-px rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-default leading-5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
