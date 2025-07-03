<div id="search"><a id="btn-search-close" class="btn-search-close" aria-label="Close search form"><i class="icon-x"></i></a>
    <form class="search-form" action="{{ route('rv-park.all-parks') }}" method="get">
        <input class="form-control" name="global_search" type="text" placeholder="Type & Search..." />
        <span class="text-muted">Start typing & press "Enter" or "ESC" to close</span>
    </form>
</div>
