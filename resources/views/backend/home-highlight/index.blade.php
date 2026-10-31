@extends('backend.layout.app')
@section('content')
<div class="page-body"><div class="container-fluid">
    <div class="page-header"><div class="row align-items-center"><div class="col-md-8"><h3>Home Page Highlights<small>Manage the service and value strip on the storefront</small></h3></div><div class="col-md-4 text-md-right mt-3 mt-md-0"><a href="{{ route('home-highlights.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-1"></i> Add Highlight</a></div></div></div>
    @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
    <div class="card"><div class="card-header d-flex align-items-center justify-content-between"><h5 class="mb-0">Highlights</h5><span class="text-muted small">{{ $highlights->total() }} total</span></div><div class="card-body"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>Label</th><th>Icon</th><th>Display order</th><th>Status</th><th class="text-right">Actions</th></tr></thead><tbody>
        @forelse($highlights as $highlight)<tr><td><strong>{{ $highlight->title }}</strong></td><td>{{ ucfirst($highlight->icon) }}</td><td>{{ $highlight->sort_order }}</td><td><span class="badge {{ $highlight->is_active ? 'badge-success' : 'badge-secondary' }}">{{ $highlight->is_active ? 'Visible' : 'Hidden' }}</span></td><td class="text-right text-nowrap"><a href="{{ route('home-highlights.edit', $highlight) }}" class="btn btn-sm btn-outline-primary">Edit</a><form action="{{ route('home-highlights.destroy', $highlight) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this highlight from the home page?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" type="submit">Delete</button></form></td></tr>
        @empty<tr><td colspan="5" class="py-5 text-center text-muted">No home page highlights yet. Add one to show it on the storefront.</td></tr>@endforelse
    </tbody></table></div>{{ $highlights->links() }}</div></div>
</div></div>
@endsection
