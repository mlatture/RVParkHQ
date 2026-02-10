@props(['url', 'title', 'description' => '', 'image' => ''])

@php
    $encodedUrl = urlencode($url);
    $encodedTitle = urlencode($title);
    $encodedDesc = urlencode($description);
    $encodedImage = urlencode($image);
@endphp

<style>
    .social-share { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .social-share-label { font-size: 0.85rem; font-weight: 600; color: #555; margin-right: 4px; }
    .social-share a, .social-share button {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 50%; border: 1px solid #ddd;
        background: #fff; color: #555; transition: all 0.2s; cursor: pointer;
        text-decoration: none; padding: 0;
    }
    .social-share a:hover, .social-share button:hover { background: #333; color: #fff; border-color: #333; }
    .social-share svg { width: 16px; height: 16px; fill: currentColor; }
    .copy-tooltip { font-size: 0.75rem; color: #28a745; margin-left: 4px; display: none; }
</style>

<div class="social-share">
    <span class="social-share-label">Share:</span>

    {{-- Facebook --}}
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" target="_blank" rel="noopener" title="Share on Facebook">
        <svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
    </a>

    {{-- X/Twitter --}}
    <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" target="_blank" rel="noopener" title="Share on X">
        <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
    </a>

    {{-- LinkedIn --}}
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedUrl }}" target="_blank" rel="noopener" title="Share on LinkedIn">
        <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
    </a>

    {{-- Pinterest --}}
    @if($image)
    <a href="https://pinterest.com/pin/create/button/?url={{ $encodedUrl }}&media={{ $encodedImage }}&description={{ $encodedTitle }}" target="_blank" rel="noopener" title="Pin on Pinterest">
        <svg viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12.017 24c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641 0 12.017 0z"/></svg>
    </a>
    @endif

    {{-- Email --}}
    <a href="mailto:?subject={{ $encodedTitle }}&body=Check%20this%20out:%20{{ $encodedUrl }}" title="Share via Email">
        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
    </a>

    {{-- Copy Link --}}
    <button onclick="navigator.clipboard.writeText('{{ $url }}').then(()=>{let t=this.nextElementSibling;t.style.display='inline';setTimeout(()=>t.style.display='none',2000)})" title="Copy Link">
        <svg viewBox="0 0 24 24"><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg>
    </button>
    <span class="copy-tooltip">Copied!</span>
</div>
