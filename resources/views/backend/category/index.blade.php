@extends('backend.layout.app')

@section('content')

            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Category
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
                                    <li class="breadcrumb-item active">Category</li>
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
                                <div class="card-header">
                                    <form class="form-inline search-form search-box">
                                        <div class="form-group">
                                            <input class="form-control-plaintext" type="search" placeholder="Search..">
                                        </div>
                                    </form>

                                    <button class="btn btn-primary" onclick="openAddModal()">Add Category</button>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive table-desi">
                                        <table class="table all-package table-category " id="editableTable">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Display order</th>
                                                    <th>Status</th>
                                                    <th>Category</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>

                                            <tbody>
@forelse($categories as $category)
<tr>

    <!-- Image -->
    <td>
        <img src="{{ $category->image ? asset('uploads/category/'.$category->image) : asset('assets/images/no-image.png') }}"
             width="50" height="50" style="object-fit:cover;">
    </td>

    <!-- Name -->
    <td>{{ $category->name }}</td>

    <!-- Display Order -->
    <td>{{ $category->sort_order }}</td>

    <!-- Status -->
    <td class="{{ $category->status ? 'order-success' : 'order-pending' }}">
        <span>{{ $category->status ? 'Active' : 'Inactive' }}</span>
    </td>

    <!-- Category Type -->
    <td>Main</td>

    <!-- Actions -->
    <td>

        <!-- Edit -->
        <a href="javascript:void(0)"
   data-id="{{ $category->id }}"
   data-name="{{ $category->name }}"
   data-status="{{ (int) $category->status }}"
   data-image="{{ $category->image }}"
   data-sort-order="{{ $category->sort_order }}"
   onclick="openEditModalFromButton(this)">
    <i class="fa fa-edit"></i>
</a>

        <!-- Delete -->
        <a href="javascript:void(0)" onclick="deleteConfirm({{ $category->id }})">
            <i class="fa fa-trash text-danger" title="Delete"></i>
        </a>

        <form id="delete-form-{{ $category->id }}"
              action="{{ route('categories.destroy', $category->id) }}"
              method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>

    </td>

</tr>

@empty
<tr>
    <td colspan="6" class="text-center text-muted">
        No Categories Found
    </td>
</tr>
@endforelse
</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>

            @endsection
