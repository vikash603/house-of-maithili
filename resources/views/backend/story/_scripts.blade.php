@section('js')
<script>
(() => {
    const type = document.getElementById('video_type');
    const fileInput = document.getElementById('video_file');
    const thumbnailInput = document.getElementById('thumbnail');
    const preview = document.getElementById('story-thumbnail-preview');
    const hasExistingLocalVideo = @json($story !== null && $story->video_type === 'local' && (bool) $story->video_file);
    const hasExistingThumbnail = @json($story !== null && (bool) $story->thumbnail);

    if (!type) return;
    const updateSourceFields = () => {
        document.querySelectorAll('[data-story-source]').forEach((field) => {
            const visible = field.dataset.storySource === type.value;
            field.hidden = !visible;
            field.querySelectorAll('input').forEach((input) => input.disabled = !visible);
        });
        fileInput.required = type.value === 'local' && !hasExistingLocalVideo;
        thumbnailInput.required = type.value === 'local' && !hasExistingThumbnail;
    };
    type.addEventListener('change', updateSourceFields);
    updateSourceFields();

    thumbnailInput.addEventListener('change', () => {
        const file = thumbnailInput.files?.[0];
        if (!file) return;
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    });
})();
</script>
@endsection
