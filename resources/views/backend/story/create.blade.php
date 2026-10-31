@extends('backend.layout.app')

@section('content')
<div class="page-body">
    <div class="container-fluid"><div class="page-header"><h3>Add a Story<small>Publish an artisan, craft or impact video</small></h3></div></div>
    <div class="container-fluid"><div class="card"><div class="card-body">
        @include('backend.story._form', ['story' => null])
    </div></div></div>
</div>
@endsection

@include('backend.story._scripts', ['story' => null])
