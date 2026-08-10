@extends('backend.layout.app')

@section('content')

<div class="page-body">

    <div class="container-fluid">
        <div class="page-header">
            <h3>Contact Messages</h3>
        </div>
    </div>

    @if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

    <div class="container-fluid">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($contacts as $key => $contact)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->subject }}</td>

                                <td style="max-width:200px;">
                                    {{ \Illuminate\Support\Str::limit($contact->message, 50) }}
                                </td>

                                <td>{{ $contact->created_at->format('d M Y') }}</td>

                                <td>

                                    <button onclick="deleteConfirm({{ $contact->id }})"
                                        class="btn btn-danger btn-sm">
                                        Delete
                                    </button>

                                    <form id="delete-form-{{ $contact->id }}"
                                          action="{{ route('contact.destroy', $contact->id) }}"
                                          method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No Messages Found</td>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function deleteConfirm(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Delete ho jayega permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete!'
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