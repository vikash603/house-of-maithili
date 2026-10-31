@if ($errors->any())
    <div class="alert alert-danger" role="alert"><strong>Please fix the following:</strong><ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form action="{{ $story ? route('stories.update', $story) : route('stories.store') }}" method="POST" enctype="multipart/form-data" id="story-form">
    @csrf
    @if ($story) @method('PUT') @endif
    <div class="form-group">
        <label for="title">Story title <span class="text-danger">*</span></label>
        <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" maxlength="140" value="{{ old('title', $story?->title) }}" placeholder="e.g. The hands behind Madhubani art" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="description">Short description <span class="text-muted">(optional)</span></label>
        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" maxlength="500" placeholder="A short introduction to this story">{{ old('description', $story?->description) }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="video_type">Video source <span class="text-danger">*</span></label>
        <select id="video_type" name="video_type" class="form-control @error('video_type') is-invalid @enderror" required>
            <option value="local" @selected(old('video_type', $story?->video_type ?? 'youtube') === 'local')>Upload a video file</option>
            <option value="youtube" @selected(old('video_type', $story?->video_type ?? 'youtube') === 'youtube')>YouTube link</option>
        </select>
        @error('video_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group" data-story-source="youtube">
        <label for="youtube_url">YouTube video URL <span class="text-danger">*</span></label>
        <input id="youtube_url" name="youtube_url" type="url" class="form-control @error('youtube_url') is-invalid @enderror" maxlength="512" value="{{ old('youtube_url', $story?->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
        <small class="form-text text-muted">Paste a standard YouTube link, youtu.be link, or Shorts link.</small>
        @error('youtube_url')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>
    <div class="form-group" data-story-source="local">
        <label for="video_file">Video file <span class="text-danger" data-local-required>*</span></label>
        <input id="video_file" name="video_file" type="file" class="form-control-file @error('video_file') is-invalid @enderror" accept="video/mp4,video/webm,video/quicktime">
        <small class="form-text text-muted">MP4, WebM or MOV, maximum 100 MB. Large uploads may also depend on the server’s PHP upload limits.</small>
        @if($story?->video_type === 'local' && $story->video_file)<div class="small text-muted mt-1">Current upload: {{ basename($story->video_file) }}. Leave blank to keep it.</div>@endif
        @error('video_file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="thumbnail">Thumbnail image <span class="text-muted">(optional for YouTube)</span></label>
        <input id="thumbnail" name="thumbnail" type="file" class="form-control-file @error('thumbnail') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
        <small class="form-text text-muted">JPG, PNG or WebP, maximum 5 MB. Local videos require a thumbnail; YouTube can use its video preview automatically.</small>
        @error('thumbnail')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <img id="story-thumbnail-preview" src="{{ $story?->thumbnailUrl() }}" alt="Thumbnail preview" style="{{ $story?->thumbnailUrl() ? '' : 'display:none;' }}max-width:240px;max-height:150px;object-fit:cover;margin-top:12px;border-radius:8px">
    </div>
    <div class="form-row">
        <div class="form-group col-md-6"><label for="sort_order">Display order</label><input id="sort_order" name="sort_order" type="number" class="form-control @error('sort_order') is-invalid @enderror" min="0" max="65535" value="{{ old('sort_order', $story?->sort_order ?? 0) }}"><small class="form-text text-muted">Lower numbers appear first.</small>@error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="form-group col-md-6"><label for="is_active">Status</label><select id="is_active" name="is_active" class="form-control"><option value="1" @selected(old('is_active', $story?->is_active ?? true) == true)>Active</option><option value="0" @selected(old('is_active', $story?->is_active ?? true) == false)>Inactive</option></select></div>
    </div>
    <button type="submit" class="btn btn-primary">{{ $story ? 'Save Story' : 'Add Story' }}</button>
    <a href="{{ route('stories.index') }}" class="btn btn-light">Cancel</a>
</form>
