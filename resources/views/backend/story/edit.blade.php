@extends('backend.layout.app')

@section('content')
<div class="page-body">
    <div class="container-fluid"><div class="page-header"><h3>Edit Story<small>Update video, thumbnail or display order</small></h3></div></div>
    <div class="container-fluid"><div class="card"><div class="card-body">
        @include('backend.story._form', ['story' => $story])
    </div></div></div>
</div>
@endsection

@include('backend.story._scripts', ['story' => $story])
