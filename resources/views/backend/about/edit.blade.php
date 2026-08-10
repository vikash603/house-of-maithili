@extends('backend.layout.app')

@section('content')
<div class="page-body">

    <div class="container-fluid">
        <div class="page-header">
            <h3>Edit About</h3>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('about.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h4>General</h4>

                    <!-- TITLE + SLUG -->
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">Title</label>

                        <div class="col-xl-8 col-md-7">
                            <input class="form-control" id="title" name="title" type="text" 
                                   value="{{ $page->title }}" required>

                            <input class="form-control mt-2" id="slug" name="slug" type="text" 
                                   value="{{ $page->slug }}">
                        </div>
                    </div>

                    <!-- IMAGE -->
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">Image</label>

                        <div class="col-xl-8 col-md-7">

                            <input type="file" name="image" class="form-control" accept="image/*">

                            <!-- OLD IMAGE -->
                            @if($page->image)
                                <img src="{{ asset('uploads/about/'.$page->image) }}" 
                                     style="width:120px; margin-top:10px;">
                            @endif

                            <!-- PREVIEW -->
                            <img id="preview" style="width:120px; margin-top:10px; display:none;">
                        </div>
                    </div>

                    <!-- DESCRIPTION -->
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

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
// CKEDITOR
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