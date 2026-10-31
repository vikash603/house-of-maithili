@extends('backend.layout.app')
@section('content')
@php($variantCount = collect($products)->sum(fn($product) => count($product['variants'])))
<div class="page-body"><div class="container-fluid catalog-page">
    <div class="catalog-page-header"><div><span class="catalog-eyebrow">IMPORT REVIEW</span><h1>Review your products</h1><p>Check the catalog summary before creating these listings.</p></div></div>
    <div class="alert alert-success">Validation passed. No products have been saved yet.</div>
    <div class="catalog-import-stats"><div><strong>{{ count($products) }}</strong><span>Products</span></div><div><strong>{{ $variantCount }}</strong><span>Size / colour variants</span></div><div><strong>{{ collect($products)->sum(fn($product) => count(array_filter($product['images']))) }}</strong><span>Image references</span></div></div>
    <div class="catalog-card"><div class="table-responsive"><table class="table catalog-product-table mb-0"><thead><tr><th>Product</th><th>SKU</th><th>Category</th><th>Price</th><th>Variants</th><th>Images</th></tr></thead><tbody>
        @foreach($products as $product)<tr><td><strong>{{ $product['name'] }}</strong>@if($product['is_made_to_order'])<small class="d-block text-muted">Made to order · {{ $product['lead_time_days'] }} days</small>@endif</td><td>{{ $product['sku'] ?: 'Auto-generated' }}</td><td>{{ $product['category'] }}@if($product['subcategory'])<small class="d-block text-muted">{{ $product['subcategory'] }}</small>@endif</td><td>₹{{ number_format((float)$product['price'], 2) }}</td><td>{{ count($product['variants']) ?: 'Simple listing' }}</td><td>{{ count(array_filter($product['images'])) }}</td></tr>@endforeach
    </tbody></table></div></div>
    <div class="catalog-sticky-actions"><form method="POST" action="{{ route('products.import.cancel') }}">@csrf<button class="btn btn-light">Cancel import</button></form><form method="POST" action="{{ route('products.import.confirm') }}">@csrf<button class="btn btn-primary px-4">Confirm and import {{ count($products) }} products</button></form></div>
</div></div>
@endsection
