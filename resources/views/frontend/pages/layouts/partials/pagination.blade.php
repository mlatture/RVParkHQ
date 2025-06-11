@props(['paginator'])

@php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $start = max(1, $currentPage - 2);
    $end = min($lastPage, $currentPage + 2);
@endphp

@if ($lastPage > 1)
    <ul class="pagination justify-content-end mt-4">
        {{-- Previous Button --}}
        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() ?? '#' }}">
                <i class="fa fa-angle-left"></i>
            </a>
        </li>

        {{-- First Page --}}
        @if ($start > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>
            @if ($start > 2)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
        @endif

        {{-- Page Number Loop --}}
        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        {{-- Last Page --}}
        @if ($end < $lastPage)
            @if ($end < $lastPage - 1)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a>
            </li>
        @endif

        {{-- Next Button --}}
        <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() ?? '#' }}">
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
    </ul>
@endif
