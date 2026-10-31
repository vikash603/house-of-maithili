@extends('backend.layout.app')
@section('content')
<div class="page-body"><div class="container-fluid catalog-page">
    <div class="catalog-page-header"><div><span class="catalog-eyebrow">CATALOG MANAGEMENT</span><h1>Add a product</h1><p>Create a polished product listing with inventory and variants.</p></div><a class="btn btn-light" href="{{ route('products.index') }}">Back to products</a></div>
    @include('backend.product._form')
</div></div>
@endsection
