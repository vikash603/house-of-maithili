@extends('backend.layout.app')
@section('content')

            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Edit Products
                                        <small>Tofa Guru Admin panel</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ol class="breadcrumb pull-right">
                                    <li class="breadcrumb-item">
                                        <a href="#">
                                            <i data-feather="home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">Product</li>
                                    <li class="breadcrumb-item active">Add Product</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row product-adding">

<!-- LEFT -->
<div class="col-xl-6">
<div class="card">
<div class="card-header">
<h5>Edit Product</h5>
</div>

<div class="card-body digital-add">

<!-- NAME -->
<div class="form-group">
<label><span>*</span> Product Name</label>
<input class="form-control" name="name" value="{{ $product->name }}" required>
</div>

<!-- SKU -->
<div class="form-group">
<label>SKU</label>
<input class="form-control" name="sku" value="{{ $product->sku }}">
</div>

<!-- CATEGORY -->
<div class="form-group">
<label><span>*</span> Category</label>
<select name="category_id" id="category" class="form-control" required>
@foreach($categories as $cat)
<option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
{{ $cat->name }}
</option>
@endforeach
</select>
</div>

<!-- SUBCATEGORY -->
<div class="form-group">
<label>Subcategory</label>
<select name="subcategory_id" id="subcategory" class="form-control"></select>
</div>

<!-- PRICE -->
<div class="form-group">
<label>Price *</label>
<input class="form-control" name="price" type="number" value="{{ $product->price }}" required>
</div>

<!-- SALE PRICE -->
<div class="form-group">
<label>Sale Price</label>
<input class="form-control" name="sale_price" type="number" value="{{ $product->sale_price }}">
</div>

<!-- STOCK -->
<div class="form-group">
<label>Stock</label>
<input class="form-control" name="stock" type="number" value="{{ $product->stock }}">
</div>

<!-- STATUS -->
<div class="form-group">
<label>Status</label><br>
<input type="radio" name="status" value="1" {{ $product->status == 1 ? 'checked' : '' }}> Enable
<input type="radio" name="status" value="0" {{ $product->status == 0 ? 'checked' : '' }}> Disable
</div>

<!-- THUMBNAIL -->
<div class="form-group">
<label>Thumbnail</label><br>

@if($product->thumbnail)
<img src="{{ asset('uploads/products/'.$product->thumbnail) }}"
width="70" class="mb-2">
@endif

<input type="file" name="thumbnail" class="form-control">
</div>

<!-- OLD IMAGES -->
@if($product->images->count())
<div class="row mt-3">

@foreach($product->images as $img)
<div class="col-md-3 mb-3 text-center" id="img-{{ $img->id }}">

<img src="{{ asset('uploads/products/'.$img->image) }}"
style="width:100%; height:100px; object-fit:cover; border-radius:6px;">

<button type="button"
class="btn btn-danger btn-sm mt-2"
onclick="deleteImage({{ $img->id }})">
Delete
</button>

</div>
@endforeach

</div>
@endif

<!-- NEW IMAGES -->
<div class="form-group">
<label>Add More Images</label>
<input type="file" name="images[]" id="imagesInput" multiple class="form-control">
</div>

<div class="row mt-2" id="preview-area"></div>

</div>
</div>
</div>

<!-- RIGHT -->
<div class="col-xl-6">

<!-- DESCRIPTION -->
<div class="card">
<div class="card-header">
<h5>Description</h5>
</div>

<div class="card-body">
<textarea id="editor1" name="description" class="form-control" rows="6">{{ $product->description }}</textarea>
</div>
</div>

<!-- VARIANTS -->
<div class="card mt-3">
<div class="card-header">
<h5>Product Variants</h5>
</div>

<div class="card-body">

<table class="table">
<thead>
<tr>
<th>Size</th>
<th>Color</th>
<th>Price</th>
<th>Stock</th>
<th>Action</th>
</tr>
</thead>

<tbody id="variantBody">

@foreach($product->variants as $v)
<tr>
<td><input name="variants[size][]" value="{{ $v->size }}" class="form-control"></td>
<td><input name="variants[color][]" value="{{ $v->color }}" class="form-control"></td>
<td><input name="variants[price][]" value="{{ $v->price }}" class="form-control"></td>
<td><input name="variants[stock][]" value="{{ $v->stock }}" class="form-control"></td>
<td>
<button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">
X
</button>
</td>
</tr>
@endforeach

</tbody>

</table>

<button type="button" class="btn btn-success" onclick="addVariant()">
+ Add Variant
</button>

</div>
</div>

<!-- BUTTON -->
<div class="card">
<div class="card-body text-center">
<button type="submit" class="btn btn-primary">Update Product</button>
<a href="{{ route('products.index') }}" class="btn btn-light">Back</a>
</div>
</div>

</div>

</div>
</form>




                <!-- Container-fluid Ends-->
            </div>

           @endsection

           @section('js')

           <script>
function addVariant() {

    let row = `
    <tr>
        <td><input type="text" name="variants[size][]" class="form-control"></td>
        <td><input type="text" name="variants[color][]" class="form-control"></td>
        <td><input type="number" name="variants[price][]" class="form-control"></td>
        <td><input type="number" name="variants[stock][]" class="form-control"></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">X</button></td>
    </tr>
    `;

    document.getElementById('variantBody').insertAdjacentHTML('beforeend', row);
}

function removeRow(btn) {
    btn.closest('tr').remove();
}
</script>

<script>
// CKEDITOR
ClassicEditor.create(document.querySelector('#editor1'));

// SUBCATEGORY AUTO LOAD (EDIT + CHANGE)
window.addEventListener('DOMContentLoaded', () => {
    loadSub({{ $product->category_id }}, {{ $product->subcategory_id ?? 'null' }});
});

document.getElementById('category').addEventListener('change', function () {
    loadSub(this.value);
});

function loadSub(catId, selectedId = null) {

    fetch('/admin/get-subcategories/' + catId)
    .then(res => res.json())
    .then(data => {

        let sub = document.getElementById('subcategory');
        sub.innerHTML = '<option value="">--Select--</option>';

        data.forEach(item => {
            let selected = (item.id == selectedId) ? 'selected' : '';
            sub.innerHTML += `<option value="${item.id}" ${selected}>${item.name}</option>`;
        });

    });
}


// DELETE IMAGE
function deleteImage(id) {

    if(!confirm("Delete image?")) return;

    fetch(`/admin/product-image/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(() => {
        document.getElementById('img-'+id).remove();
    });
}


// IMAGE PREVIEW (SAFE)
let input = document.getElementById('imagesInput');

if(input){
input.addEventListener('change', function(e){

    let preview = document.getElementById('preview-area');
    preview.innerHTML = '';

    Array.from(e.target.files).forEach(file => {

        let reader = new FileReader();

        reader.onload = function(e){
            preview.innerHTML += `
                <div class="col-md-3 mb-2">
                    <img src="${e.target.result}"
                    style="width:100%; height:100px; object-fit:cover;">
                </div>
            `;
        }

        reader.readAsDataURL(file);
    });

});
}

</script>

@endsection