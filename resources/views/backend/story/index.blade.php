@extends('backend.layout.app')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-7"><h3>Our Stories<small>Manage artisan, craft and impact videos on the home page</small></h3></div>
                <div class="col-md-5 text-md-right mt-3 mt-md-0"><a href="{{ route('stories.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-1"></i> Add Story</a></div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @if (session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between"><h5 class="mb-0">Story library</h5><span class="text-muted small">{{ $stories->total() }} {{ $stories->total() === 1 ? 'story' : 'stories' }}</span></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead><tr><th>Thumbnail</th><th>Story</th><th>Video source</th><th>Order</th><th>Status</th><th>Updated</th><th class="text-right">Actions</th></tr></thead>
                        <tbody>
                        @forelse ($stories as $story)
                            <tr>
                                <td>
                                    @if ($story->thumbnailUrl())<img src="{{ $story->thumbnailUrl() }}" alt="" style="width:112px;height:70px;object-fit:cover;border-radius:6px">@else<span class="text-muted">YouTube preview</span>@endif
                                </td>
                                <td><strong>{{ $story->title }}</strong>@if($story->description)<div class="small text-muted">{{ \Illuminate\Support\Str::limit($story->description, 90) }}</div>@endif</td>
                                <td>{{ $story->video_type === 'youtube' ? 'YouTube' : 'Uploaded video' }}</td>
                                <td>{{ $story->sort_order }}</td>
                                <td><span class="badge {{ $story->is_active ? 'badge-success' : 'badge-secondary' }}">{{ $story->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td>{{ $story->updated_at->format('d M Y') }}</td>
                                <td class="text-right text-nowrap">
                                    <a href="{{ route('stories.edit', $story) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('stories.destroy', $story) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this story and its uploaded files?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-5 text-center text-muted">No stories yet. Add a video to feature it on the home page.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $stories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
