@extends('backend.layout.app')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header"><h3>Edit Home Banner<small>Update its placement, artwork and display settings</small></h3></div>
    </div>
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <div class="card"><div class="card-body">
            <form action="{{ route('banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('backend.banner._fields', ['banner' => $banner])
            </form>
        </div></div>
    </div>
</div>
@endsection
