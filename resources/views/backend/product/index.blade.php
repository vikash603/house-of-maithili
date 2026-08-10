@extends('backend.layout.app')
@section('content')

            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Product List
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
                                    <li class="breadcrumb-item active">Product List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">
                    <div class="col-sm-12">
    <div class="card">

        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center">

            <!-- SEARCH -->
            <form method="GET" action="{{ route('products.index') }}" class="search-form">
                <input class="form-control" type="search" name="search"
                       placeholder="Search product..." value="{{ request('search') }}">
            </form>

            <!-- ADD BUTTON -->
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                Add New Product
            </a>

        </div>

        <!-- BODY -->
        <div class="card-body">
            <div class="table-responsive table-desi">

                <table class="table table-striped all-package">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($products as $key => $product)
                        <tr>

                            <!-- ID -->
                            <td>{{ $key+1 }}</td>

                            <!-- IMAGE -->
                            <td>
                                @if($product->thumbnail)
                                    <img src="{{ asset('uploads/products/'.$product->thumbnail) }}"
                                         width="50" height="50" style="object-fit:cover;">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>

                            <!-- NAME -->
                            <td>{{ $product->name }}</td>

                            <!-- CATEGORY -->
                            <td>
                                {{ $product->category->name ?? '-' }}
                                <br>
                                <small class="text-muted">
                                    {{ $product->subcategory->name ?? '' }}
                                </small>
                            </td>

                            <!-- PRICE -->
                            <td>
                                ₹{{ $product->price }}
                                @if($product->sale_price)
                                    <br>
                                    <small class="text-success">
                                        ₹{{ $product->sale_price }}
                                    </small>
                                @endif
                            </td>

                            <!-- STOCK -->
                            <td>{{ $product->stock }}</td>

                            <!-- STATUS -->
                            <td>
                                @if($product->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>

                            <!-- ACTION -->
                            <td>

                                <!-- EDIT -->
                                <a href="{{ route('products.edit', $product->id) }}">
                                    <i class="fa fa-edit text-primary"></i>
                                </a>

                                <!-- DELETE -->
                                <a href="javascript:void(0)"
                                   onclick="deleteConfirm({{ $product->id }})">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>

                                <form id="delete-form-{{ $product->id }}"
                                      action="{{ route('products.destroy', $product->id) }}"
                                      method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                No Products Found
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>

                

                <!-- PAGINATION -->
                <div class="mt-3">
                    {{ $products->links() }}
                </div>

            </div>
        </div>

    </div>
</div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
  
            @endsection

            @section('js')

            <script>
function deleteConfirm(id){
    if(confirm('Are you sure you want to delete?')){
        document.getElementById('delete-form-'+id).submit();
    }
}
</script>


@endsection