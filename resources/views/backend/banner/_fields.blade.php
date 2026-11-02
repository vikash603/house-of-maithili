<div class="form-row">
    <div class="form-group col-lg-6">
        <label for="placement">Homepage placement <span class="text-danger">*</span></label>
        <select id="placement" name="placement" class="form-control @error('placement') is-invalid @enderror" required>
            @foreach(\App\Models\Banner::PLACEMENTS as $value => $label)
                <option value="{{ $value }}" @selected(old('placement', $banner->placement ?? 'hero') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('placement')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <small class="form-text text-muted">Existing banners remain in the Hero Slider unless you assign another placement.</small>
    </div>
    <div class="form-group col-lg-6">
        <label for="title">Optional banner title</label>
        <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror" maxlength="160" value="{{ old('title', $banner->title ?? '') }}">
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    <label for="subtitle">Optional subtitle</label>
    <textarea id="subtitle" name="subtitle" rows="3" maxlength="2000" class="form-control @error('subtitle') is-invalid @enderror">{{ old('subtitle', $banner->subtitle ?? '') }}</textarea>
    @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="image">Desktop image @if(!isset($banner))<span class="text-danger">*</span>@else <span class="text-muted">(optional replacement)</span>@endif</label>
        <input id="image" type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp" @required(!isset($banner))>
        <small class="form-text text-muted">JPG, PNG or WebP; up to 5 MB. Keep the artwork's original aspect ratio.</small>
        @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <img id="banner-preview-desktop" src="{{ isset($banner) ? asset($banner->image) : '' }}" alt="Desktop banner preview" @if(!isset($banner)) hidden @endif style="display:block;max-width:100%;max-height:230px;margin-top:12px;object-fit:contain;background:#f8f3eb">
    </div>
    <div class="form-group col-md-6">
        <label for="mobile_image">Mobile image <span class="text-muted">(optional)</span></label>
        <input id="mobile_image" type="file" name="mobile_image" class="form-control-file @error('mobile_image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
        <small class="form-text text-muted">Optional mobile-specific artwork; the desktop image is used when omitted.</small>
        @error('mobile_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <img id="banner-preview-mobile" src="{{ isset($banner) && $banner->mobile_image ? asset($banner->mobile_image) : '' }}" alt="Mobile banner preview" @if(!isset($banner) || !$banner->mobile_image) hidden @endif style="display:block;max-width:100%;max-height:230px;margin-top:12px;object-fit:contain;background:#f8f3eb">
        @if(isset($banner) && $banner->mobile_image)
            <div class="form-check mt-2">
                <input id="remove_mobile_image" type="checkbox" name="remove_mobile_image" value="1" class="form-check-input" @checked(old('remove_mobile_image'))>
                <label for="remove_mobile_image" class="form-check-label">Remove mobile image and use desktop fallback</label>
            </div>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="alt_text">Image alt text</label>
        <input id="alt_text" type="text" name="alt_text" class="form-control @error('alt_text') is-invalid @enderror" maxlength="255" value="{{ old('alt_text', $banner->alt_text ?? '') }}" placeholder="Describe the banner for screen readers">
        @error('alt_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group col-md-6">
        <label for="link_url">Banner destination URL</label>
        <input id="link_url" type="text" name="link_url" class="form-control @error('link_url') is-invalid @enderror" maxlength="2048" value="{{ old('link_url', $banner->link_url ?? '') }}" placeholder="/shop or https://example.com/collection">
        @error('link_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="cta_text">Optional CTA text</label>
        <input id="cta_text" type="text" name="cta_text" class="form-control @error('cta_text') is-invalid @enderror" maxlength="80" value="{{ old('cta_text', $banner->cta_text ?? '') }}" placeholder="Explore collection">
        @error('cta_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group col-md-4">
        <label for="sort_order">Display order</label>
        <input id="sort_order" type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" min="0" max="65535" value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
        <small class="form-text text-muted">Lower numbers appear first within a placement.</small>
        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group col-md-4">
        <label for="is_active">Status</label>
        <select id="is_active" name="is_active" class="form-control @error('is_active') is-invalid @enderror" required>
            <option value="1" @selected(old('is_active', isset($banner) ? (string) $banner->is_active : '1') === '1')>Active</option>
            <option value="0" @selected(old('is_active', isset($banner) ? (string) $banner->is_active : '1') === '0')>Inactive</option>
        </select>
        @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ isset($banner) ? 'Update Banner' : 'Save Banner' }}</button>
<a href="{{ route('banners.index') }}" class="btn btn-light">Cancel</a>

<script>
    (() => {
        ['image', 'mobile_image'].forEach((field) => {
            const input = document.getElementById(field);
            const preview = document.getElementById(field === 'image' ? 'banner-preview-desktop' : 'banner-preview-mobile');
            let previousUrl;
            input?.addEventListener('change', () => {
                if (previousUrl) URL.revokeObjectURL(previousUrl);
                const file = input.files?.[0];
                if (!file) return;
                previousUrl = URL.createObjectURL(file);
                preview.src = previousUrl;
                preview.hidden = false;
            });
        });
    })();
</script>
