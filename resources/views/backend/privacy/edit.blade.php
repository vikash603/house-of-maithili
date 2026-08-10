@extends('backend.layout.app')

@section('content')
<div class="page-body">

    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Edit Privacy</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('privacy.update', $page->id) }}" method="POST">
                    @csrf

                    <h4>General</h4>

                    <!-- TITLE + SLUG -->
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">Name</label>

                        <div class="col-xl-8 col-md-7">
                            <input class="form-control" id="title" name="title" type="text" 
                                   value="{{ $page->title }}" required>

                            <input class="form-control mt-2" id="slug" name="slug" type="text" 
                                   value="{{ $page->slug }}">
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">Description</label>
                        <div class="col-xl-8 col-md-7">
                            <textarea id="editor1" name="description">{!! $page->description !!}</textarea>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
@endsection

@section('js')

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
ClassicEditor
    .create(document.querySelector('#editor1'))
    .catch(error => console.error(error));

// SLUG AUTO
document.getElementById('title').addEventListener('keyup', function () {

    let slug = this.value.toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/--+/g, '-');

    document.getElementById('slug').value = slug;
});
</script>

@endsection