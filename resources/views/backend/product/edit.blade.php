@extends('backend.layout.app')
@section('content')
<div class="page-body"><div class="container-fluid catalog-page">
    <div class="catalog-page-header"><div><span class="catalog-eyebrow">CATALOG MANAGEMENT</span><h1>Edit product</h1><p>Update listing details, media, pricing and inventory.</p></div><a class="btn btn-light" href="{{ route('products.index') }}">Back to products</a></div>
    @include('backend.product._form')
</div></div>
@endsection
