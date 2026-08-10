@extends('backend.layout.app')
@section('content')

            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Add Products
                                        <small>Multikart Admin panel</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ol class="breadcrumb pull-right">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">
                                            <i data-feather="home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">Digital</li>
                                    <li class="breadcrumb-item active">Add Product</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="page-body">
<div class="container-fluid">

<div class="row product-adding">

<!-- LEFT -->
<div class="col-xl-6">
<div class="card">
<div class="card-header">
<h5>General</h5>
</div>

<div class="card-body digital-add needs-validation">

<!-- NAME -->
<div class="form-group">
<label class="col-form-label pt-0"><span>*</span> Product Name</label>
<input class="form-control" name="name" type="text" required>
</div>

<!-- SKU -->
<div class="form-group">
<label class="col-form-label pt-0">SKU</label>
<input class="form-control" name="sku" type="text">
</div>

<!-- CATEGORY -->
<div class="form-group">
<label class="col-form-label categories-basic"><span>*</span> Category</label>
<select name="category_id" id="category" class="custom-select form-control" required>
<option value="">--Select--</option>
@foreach($categories as $cat)
<option value="{{ $cat->id }}">{{ $cat->name }}</option>
@endforeach
</select>
</div>

<!-- SUBCATEGORY -->
<div class="form-group">
<label class="col-form-label">Subcategory</label>
<select name="subcategory_id" id="subcategory" class="custom-select form-control">
<option value="">--Select--</option>
</select>
</div>

<!-- PRICE -->
<div class="form-group">
<label class="col-form-label"><span>*</span> Product Price</label>
<input class="form-control" name="price" type="number" required>
</div>

<!-- SALE PRICE -->
<div class="form-group">
<label class="col-form-label">Sale Price</label>
<input class="form-control" name="sale_price" type="number">
</div>

<!-- STOCK -->
<div class="form-group">
<label class="col-form-label">Stock</label>
<input class="form-control" name="stock" type="number">
</div>

<!-- STATUS -->
<div class="form-group">
<label class="col-form-label"><span>*</span> Status</label>
<div class="m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
<label class="d-block">
<input class="radio_animated" type="radio" name="status" value="1" checked> Enable
</label>
<label class="d-block">
<input class="radio_animated" type="radio" name="status" value="0"> Disable
</label>
</div>
</div>

<!-- THUMBNAIL -->
<div class="form-group">
<label class="col-form-label pt-0">Thumbnail</label>
<input type="file" name="thumbnail" class="form-control">
</div>

<!-- GALLERY -->
<div class="form-group">
<label class="col-form-label pt-0">Product Gallery</label>
<input type="file" name="images[]" multiple class="form-control">
</div>

</div>
</div>
</div>

<!-- RIGHT -->
<!-- RIGHT -->
<div class="col-xl-6">

<!-- DESCRIPTION -->
<div class="card">
<div class="card-header">
<h5>Add Description</h5>
</div>

<div class="card-body">
<textarea id="editor1" name="description" class="form-control"></textarea>
</div>
</div>

<!-- 🔥 VARIANTS (MOVE HERE) -->
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

<tbody id="variantBody"></tbody>

</table>

<button type="button" class="btn btn-success" onclick="addVariant()">
+ Add Variant
</button>

</div>
</div>

<!-- BUTTON -->
<div class="card">
<div class="card-body text-center">
<button type="submit" class="btn btn-primary">Save Product</button>
<button type="reset" class="btn btn-light">Discard</button>
</div>
</div>

</div>

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
ClassicEditor
    .create(document.querySelector('#editor1'))
    .then(editor => {
        console.log('Editor ready', editor);
    })
    .catch(error => {
        console.error(error);
    });
</script>
           <script>
document.getElementById('category').addEventListener('change', function () {

    let id = this.value;

    fetch('/admin/get-subcategories/' + id)
    .then(res => res.json())
    .then(data => {

        let sub = document.getElementById('subcategory');
        sub.innerHTML = '<option value="">--Select--</option>';

        data.forEach(item => {
            sub.innerHTML += `<option value="${item.id}">${item.name}</option>`;
        });

    });

});
</script>

<script>
function addVariant() {

    let row = `
    <tr>
        <td><input type="text" name="variants[size][]" class="form-control"></td>
        <td><input type="text" name="variants[color][]" class="form-control"></td>
        <td><input type="number" name="variants[price][]" class="form-control"></td>
        <td><input type="number" name="variants[stock][]" class="form-control"></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-danger">X</button></td>
    </tr>
    `;

    document.getElementById('variantBody').insertAdjacentHTML('beforeend', row);
}

function removeRow(btn) {
    btn.closest('tr').remove();
}
</script>

@endsection