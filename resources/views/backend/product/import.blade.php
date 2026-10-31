@extends('backend.layout.app')
@section('content')
<div class="page-body"><div class="container-fluid catalog-page">
    <div class="catalog-page-header"><div><span class="catalog-eyebrow">CATALOG MANAGEMENT</span><h1>Bulk product upload</h1><p>Import a product catalog with size and colour inventory in one reviewable workflow.</p></div><a href="{{ route('products.index') }}" class="btn btn-light">Back to products</a></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('import_errors'))<div class="alert alert-danger"><strong>Please correct these issues and upload again:</strong><ul class="mb-0 mt-2">@foreach(session('import_errors') as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    <div class="row">
        <div class="col-lg-7"><div class="catalog-card"><div class="catalog-card-header"><h4>Upload your catalog</h4><span class="catalog-help">Nothing is saved until you review and confirm the preview.</span></div><div class="catalog-card-body">
            <form method="POST" action="{{ route('products.import.preview') }}" enctype="multipart/form-data">@csrf
                <div class="form-group"><label class="catalog-label" for="csv-file">Product CSV <span class="catalog-required">*</span></label><input id="csv-file" type="file" name="csv" class="form-control-file" accept=".csv,.txt" required><small class="catalog-help">Up to 10 MB. Use the template to keep column names and formatting consistent.</small></div>
                <div class="form-group"><label class="catalog-label" for="images-zip">Product images ZIP (optional)</label><input id="images-zip" type="file" name="images_zip" class="form-control-file" accept=".zip"><small class="catalog-help">Up to 50 MB compressed / 100 MB expanded. CSV image filenames must match files inside the ZIP.</small></div>
                <button class="btn btn-primary px-4">Validate and preview</button>
            </form>
        </div></div></div>
        <div class="col-lg-5"><div class="catalog-card"><div class="catalog-card-header"><h4>Import guide</h4></div><div class="catalog-card-body">
            <ol class="catalog-import-guide"><li><strong>Download the CSV template</strong><span>It includes the required columns and one example product with a size variant.</span><a href="{{ route('products.import.template') }}">Download template</a></li><li><strong>One row per variant</strong><span>Repeat the product SKU for each size/colour. Leave variant columns empty for a simple product.</span></li><li><strong>Match your images</strong><span>List a cover filename and optional gallery filenames separated by |, then put those images in the ZIP.</span></li><li><strong>Preview, then confirm</strong><span>We check category names, prices, duplicate SKUs and image references before anything is created.</span></li></ol>
            <div class="catalog-import-limit">Up to 200 products and 2,000 variant rows per import. Categories and subcategories must already exist.</div>
        </div></div></div>
    </div>
</div></div>
@endsection
