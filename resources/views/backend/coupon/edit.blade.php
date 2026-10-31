@extends('backend.layout.app')
@section('content')
<div class="page-body"><div class="container-fluid catalog-page">
    <div class="catalog-page-header"><div><span class="catalog-eyebrow">PROMOTIONS</span><h1>Edit coupon</h1><p>Change its discount, validity or availability.</p></div><a class="btn btn-light" href="{{ route('coupons.index') }}">Back to coupons</a></div>
    @include('backend.coupon._form')
</div></div>
@endsection
