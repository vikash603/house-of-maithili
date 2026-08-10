@extends('backend.layout.app')

@section('content')

<div class="page-body">

    <!-- HEADER -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Terms Page
                            <small>ScanGuard Admin panel</small>
                        </h3>
                    </div>
                </div>

                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item">
                            <a href="#"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Pages</li>
                        <li class="breadcrumb-item active">List Terms</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <div class="card">

                    <!-- CARD HEADER -->
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <!-- SEARCH (optional) -->
                        <form class="form-inline search-form search-box">
                            <input class="form-control" type="search" placeholder="Search..">
                        </form>

                        <!-- ADD BUTTON -->
                        <a href="{{ route('terms.create') }}" class="btn btn-primary">
                            + Add New Page
                        </a>

                    </div>

                    <!-- CARD BODY -->
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Created On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($pages as $key => $page)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>{{ $page->title }}</td>

                                        <td>{{ $page->slug }}</td>

                                        <td>{{ $page->created_at->format('d M Y') }}</td>

                                        <td>

                                            <!-- EDIT -->
                                            <a href="{{ route('terms.edit', $page->id) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>

                                            <!-- DELETE -->
                                            <button type="button" onclick="confirmDelete({{ $page->id }})" class="btn btn-danger btn-sm">
    Delete
</button>

<form id="delete-form-{{ $page->id }}" 
      action="{{ route('terms.delete', $page->id) }}" 
      method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

                                        </td>
                                    </tr>
                                    @empty

                                    <tr>
                                        <td colspan="5" class="text-center">No Data Found</td>
                                    </tr>

                                    @endforelse

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

@endsection
@section('js')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Delete ho jayega permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection