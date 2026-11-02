@extends('backend.layout.app')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-7"><h3>Home Banners<small>Manage every homepage banner placement</small></h3></div>
                <div class="col-md-5 text-md-right mt-3 mt-md-0"><a href="{{ route('banners.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-1" aria-hidden="true"></i> Add Banner</a></div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @if (session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Banner library</h5>
                <span class="text-muted small">{{ $banners->total() }} {{ $banners->total() === 1 ? 'banner' : 'banners' }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead><tr><th>Desktop / Mobile preview</th><th>Placement</th><th>Title / Alt text</th><th>Destination</th><th>Order</th><th>Status</th><th>Updated</th><th class="text-right">Actions</th></tr></thead>
                        <tbody>
                        @forelse ($banners as $banner)
                            <tr>
                                <td class="text-nowrap">
                                    <img src="{{ asset($banner->image) }}" alt="" style="width:150px;height:64px;object-fit:contain;border-radius:4px;background:#f8f3eb">
                                    @if($banner->mobile_image)<img src="{{ asset($banner->mobile_image) }}" alt="" title="Mobile image" style="width:46px;height:64px;margin-left:6px;object-fit:contain;border-radius:4px;background:#f8f3eb">@endif
                                </td>
                                <td>{{ $banner->placementLabel() }}</td>
                                <td>{{ $banner->title ?: ($banner->alt_text ?: '—') }}</td>
                                <td class="text-break">{{ $banner->link_url ?: '—' }}</td>
                                <td>{{ $banner->sort_order }}</td>
                                <td><span class="badge {{ $banner->is_active ? 'badge-success' : 'badge-secondary' }}">{{ $banner->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td>{{ $banner->updated_at->format('d M Y') }}</td>
                                <td class="text-right text-nowrap">
                                    <a href="{{ route('banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('banners.destroy', $banner) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this banner and its unreferenced uploaded images?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="py-5 text-center text-muted">No banners added yet. Add a banner to a homepage placement.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $banners->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
