@extends('backend.layout.app')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header"><h3>Add Home Banner<small>Upload a wide image for your storefront</small></h3></div>
    </div>
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <div class="card"><div class="card-body">
            <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="image">Banner image <span class="text-danger">*</span></label>
                    <input id="image" type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp" required>
                    <small class="form-text text-muted">JPG, PNG or WebP, maximum 5 MB. A wide landscape image works best.</small>
                    @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    <img id="banner-preview" alt="Banner preview" style="display:none;max-width:100%;max-height:300px;margin-top:15px;border-radius:8px">
                </div>
                <div class="form-group"><label for="alt_text">Image alt text <span class="text-muted">(optional)</span></label><input id="alt_text" type="text" name="alt_text" class="form-control" maxlength="255" value="{{ old('alt_text') }}" placeholder="Describe the banner image for screen readers"></div>
                <div class="form-group"><label for="link_url">Banner link <span class="text-muted">(optional)</span></label><input id="link_url" type="text" name="link_url" class="form-control @error('link_url') is-invalid @enderror" maxlength="2048" value="{{ old('link_url') }}" placeholder="/shop or https://example.com/collection">@error('link_url')<div class="invalid-feedback">{{ $message }}</div>@enderror<small class="form-text text-muted">Clicking the banner will open this page. Use an internal path like /shop or a full https:// URL.</small></div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="sort_order">Display order</label><input id="sort_order" type="number" name="sort_order" class="form-control" min="0" max="65535" value="{{ old('sort_order', 0) }}"><small class="form-text text-muted">Lower numbers appear first.</small></div>
                    <div class="form-group col-md-6"><label for="is_active">Status</label><select id="is_active" name="is_active" class="form-control"><option value="1" @selected(old('is_active', '1') == '1')>Active</option><option value="0" @selected(old('is_active') == '0')>Inactive</option></select></div>
                </div>
                <button type="submit" class="btn btn-primary">Save Banner</button>
                <a href="{{ route('banners.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div></div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.getElementById('image')?.addEventListener('change', function () {
        const preview = document.getElementById('banner-preview');
        if (!this.files?.[0]) { preview.style.display = 'none'; return; }
        preview.src = URL.createObjectURL(this.files[0]);
        preview.style.display = 'block';
    });
</script>
@endsection
