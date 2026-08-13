<div id="search"><a id="btn-search-close" class="btn-search-close" aria-label="Close search form"><i class="icon-x"></i></a>
    <form class="search-form" action="{{ route('campgrounds.index') }}" method="get">
        <input class="form-control" name="search" type="text" placeholder="Search campgrounds by state..." />
        <span class="text-muted">Start typing & press "Enter" or "ESC" to close</span>
    </form>
</div>
