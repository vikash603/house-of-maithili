@php
    $desktopDimensions = $banner->desktopDimensions();
    $mobileDimensions = $banner->mobile_image ? $banner->mobileDimensions() : null;
    $bannerStyle = $desktopDimensions
        ? '--banner-ratio: '.$desktopDimensions['width'].' / '.$desktopDimensions['height'].';'
        : '';
    if ($mobileDimensions) {
        $bannerStyle .= ' --mobile-banner-ratio: '.$mobileDimensions['width'].' / '.$mobileDimensions['height'].';';
    }
    $destination = $banner->destinationUrl() ?: ($destinationFallback ?? null);
    $contentExists = filled($banner->title) || filled($banner->subtitle) || filled($banner->cta_text);
@endphp
<div class="maithili-managed-banner {{ $class ?? '' }} {{ $mobileDimensions ? 'has-mobile-banner' : '' }} {{ $desktopDimensions ? 'has-desktop-ratio' : '' }}" @if($bannerStyle) style="{{ $bannerStyle }}" @endif>
    @if($destination)<a class="maithili-managed-banner-link" href="{{ $destination }}" @if($contentExists && $banner->cta_text) aria-label="{{ $banner->cta_text }}: {{ $banner->title ?: $banner->alt_text ?: 'Explore this collection' }}" @endif>@endif
        <picture class="maithili-managed-banner-picture">
            @if($banner->mobile_image)
                <source media="(max-width: 767px)" srcset="{{ asset($banner->mobile_image) }}" @if($mobileDimensions) width="{{ $mobileDimensions['width'] }}" height="{{ $mobileDimensions['height'] }}" @endif>
            @endif
            <img src="{{ asset($banner->image) }}"
                 alt="{{ $banner->alt_text ?? '' }}"
                 @if($desktopDimensions) width="{{ $desktopDimensions['width'] }}" height="{{ $desktopDimensions['height'] }}" @endif
                 loading="{{ $loading ?? 'lazy' }}">
        </picture>
        @if($contentExists)
            <span class="maithili-managed-banner-content">
                @if($banner->title)<span class="maithili-managed-banner-title">{{ $banner->title }}</span>@endif
                @if($banner->subtitle)<span class="maithili-managed-banner-subtitle">{{ $banner->subtitle }}</span>@endif
                @if($banner->cta_text)<span class="maithili-managed-banner-cta">{{ $banner->cta_text }} <span aria-hidden="true">→</span></span>@endif
            </span>
        @endif
    @if($destination)</a>@endif
</div>
