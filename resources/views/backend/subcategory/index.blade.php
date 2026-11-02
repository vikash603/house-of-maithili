@extends('backend.layout.app')

@section('content')

            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Sub Category
                                        <small>Thofa Guru Admin panel</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ol class="breadcrumb pull-right">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.orders.dashboard') }}">
                                            <i data-feather="home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">Digital</li>
                                    <li class="breadcrumb-item active">Sub Category</li>
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

                                    <button class="btn btn-primary" onclick="openAddSubModal()">
    Add Subcategory
</button>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive table-desi">
                                        <table class="table all-package table-category " id="editableTable">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Category</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>

                                            <tbody>

@forelse($subcategories as $sub)
<tr>

    <!-- Image -->
    <td>
        <img src="{{ $sub->image ? asset('uploads/subcategory/'.$sub->image) : asset('assets/images/no-image.png') }}"
             width="50" height="50" style="object-fit:cover;">
    </td>

    <!-- Name -->
    <td>{{ $sub->name }}</td>

    <!-- Status -->
    <td class="{{ $sub->status ? 'order-success' : 'order-pending' }}">
        <span>{{ $sub->status ? 'Active' : 'Inactive' }}</span>
    </td>

    <!-- Category Name -->
    <td>{{ $sub->category->name ?? '-' }}</td>

    <!-- Action -->
    <td>

        <!-- Edit -->
        <a href="#"
onclick="openEditSubModal(
    {{ $sub->id }},
    {{ $sub->category_id }},
    '{{ $sub->name }}',
    {{ $sub->status }},
    '{{ $sub->image }}'
); return false;">
    <i class="fa fa-edit text-primary"></i>
</a>



        <!-- Delete -->
        <a href="javascript:void(0)" onclick="deleteConfirm({{ $sub->id }})">
            <i class="fa fa-trash text-danger" title="Delete"></i>
        </a>

        <!-- Hidden Form -->
        <form id="delete-form-{{ $sub->id }}"
              action="{{ route('subcategories.destroy', $sub->id) }}"
              method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>

    </td>

</tr>

@empty
<tr>
    <td colspan="5" class="text-center text-muted">
        No Subcategories Found
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


                <!-- Modal -->
                <div class="modal fade" id="subcategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Subcategory</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="subcategoryForm" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- PUT method inject -->
                <div id="methodContainer"></div>

                <div class="modal-body">

                    <!-- CATEGORY -->
                    <div class="form-group mb-3">
                        <label>Category</label>
                        <select name="category_id" id="cat_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- NAME -->
                    <div class="form-group mb-3">
                        <label>Subcategory Name</label>
                        <input type="text" name="name" id="sub_name"
                               class="form-control" placeholder="Enter name" required>
                    </div>

                    <!-- IMAGE -->
                    <div class="form-group mb-3">
                        <label>Subcategory Image</label>
                        <input type="file" name="image" class="form-control"
                               onchange="previewSubImage(event)">

                        <div class="mt-2">
                            <img id="previewSubImg"
                                 style="display:none; width:70px; height:70px; object-fit:cover;">
                        </div>
                    </div>

                    <!-- STATUS -->
                    <div class="form-group mb-3">
                        <label>Status</label>
                        <select name="status" id="sub_status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </form>

        </div>
    </div>
</div>



    @endsection

    @section('js')

<script>
function openAddSubModal() {

    let form = document.getElementById('subcategoryForm');

    form.action = "{{ route('subcategories.store') }}";

    document.getElementById('methodContainer').innerHTML = '';

    document.getElementById('sub_name').value = '';
    document.getElementById('cat_id').value = '';
    document.getElementById('sub_status').value = 1;

    document.getElementById('previewSubImg').style.display = "none";

    new bootstrap.Modal(document.getElementById('subcategoryModal')).show();
}


function openEditSubModal(id, category_id, name, status, image) {

let form = document.getElementById('subcategoryForm');

// form action
form.action = "/admin/subcategories/" + id;

// method
document.getElementById('methodContainer').innerHTML =
    '<input type="hidden" name="_method" value="PUT">';

// name
document.getElementById('sub_name').value = name;

// ✅ category select FIX (simple way)
document.getElementById('cat_id').value = category_id;

// status
document.getElementById('sub_status').value = status;

// image preview
let img = document.getElementById('previewSubImg');

if (image && image !== '') {
    img.src = "/uploads/subcategory/" + image;
    img.style.display = "block";
} else {
    img.style.display = "none";
}

// show modal
new bootstrap.Modal(document.getElementById('subcategoryModal')).show();
}


// Image preview
function previewSubImage(event) {
    let file = event.target.files[0];
    if (!file) return;

    let reader = new FileReader();

    reader.onload = function(e){
        let img = document.getElementById('previewSubImg');
        img.src = e.target.result;
        img.style.display = "block";
    }

    reader.readAsDataURL(file);
}
</script>

@endsection