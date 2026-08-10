@extends('backend.layout.app')
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Create About
                            <small>ScanGuard Admin panel</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card tab2-card">
            <div class="card-body">

                <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h4>General</h4>

                    <!-- TITLE + SLUG -->
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">Title</label>
                        <div class="col-xl-8 col-md-7">
                            <input class="form-control" id="title" name="title" type="text" required>

                            <input class="form-control mt-2" id="slug" name="slug" type="text" readonly>
                        </div>
                    </div>

                    <!-- IMAGE -->
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">Image</label>
                        <div class="col-xl-8 col-md-7">
                            <input type="file" name="image" class="form-control" accept="image/*">

                            <!-- PREVIEW -->
                            <img id="preview" style="margin-top:10px; width:120px; display:none;">
                        </div>
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="form-group row editor-label">
                        <label class="col-xl-3 col-md-4">Description</label>
                        <div class="col-xl-8 col-md-7">
                            <textarea id="editor1" name="description"></textarea>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
// CKEDITOR
ClassicEditor
    .create(document.querySelector('#editor1'))
    .catch(error => console.error(error));

// SLUG AUTO
document.getElementById('title').addEventListener('keyup', function () {
    let slug = this.value
        .toLowerCase()
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '');

    document.getElementById('slug').value = slug;
});

// IMAGE PREVIEW
document.querySelector('input[name="image"]').addEventListener('change', function(e){
    let reader = new FileReader();
    reader.onload = function(){
        let img = document.getElementById('preview');
        img.src = reader.result;
        img.style.display = 'block';
    }
    reader.readAsDataURL(e.target.files[0]);
});
</script>

@endsection