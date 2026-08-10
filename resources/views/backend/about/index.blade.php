@extends('backend.layout.app')

@section('content')

<div class="page-body">

    <div class="container-fluid">
        <div class="page-header">
            <h3>About Page</h3>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">

            <!-- HEADER -->
            <div class="card-header d-flex justify-content-between align-items-center">

                <form class="form-inline">
                    <input class="form-control" type="search" placeholder="Search..">
                </form>

                <a href="{{ route('about.create') }}" class="btn btn-primary">
                    + Add New Page
                </a>

            </div>

            <!-- BODY -->
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($pages as $key => $page)
                            <tr>

                                <td>{{ $key + 1 }}</td>

                                <!-- IMAGE -->
                                <td>
                                    @if($page->image)
                                        <img src="{{ asset('uploads/about/'.$page->image) }}" width="60">
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>{{ $page->title }}</td>

                                <td>{{ $page->slug }}</td>

                                <td>{{ $page->created_at->format('d M Y') }}</td>

                                <td>

                                    <!-- EDIT -->
                                    <a href="{{ route('about.edit', $page->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>

                                    <!-- DELETE -->
                                    <button onclick="deleteConfirm({{ $page->id }})"
                                            class="btn btn-sm btn-danger">
                                        Delete
                                    </button>

                                    <form id="delete-form-{{ $page->id }}"
                                          action="{{ route('about.destroy', $page->id) }}"
                                          method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>

                            </tr>

                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No Data Found</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@section('js')

<!-- SWEET ALERT CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// DELETE CONFIRM
function deleteConfirm(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Ye data permanently delete ho jayega!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

// SUCCESS MESSAGE
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
@endif

</script>

@endsection