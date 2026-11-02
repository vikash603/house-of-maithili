@extends('backend.layout.app')
@section('content')
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Create Refund
                                        <small>ScanGuard Admin panel</small>
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
                                    <li class="breadcrumb-item">Pages</li>
                                    <li class="breadcrumb-item active">Create Refund</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="card tab2-card">
                        <div class="card-body">
                            <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active show" id="general-tab"
                                        data-bs-toggle="tab" href="#general" role="tab" aria-controls="general"
                                        aria-selected="true" data-original-title="" title="">General</a></li>
                                
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="general" role="tabpanel"
                                    aria-labelledby="general-tab">
                                    <form action="{{ route('refund.store') }}" method="POST">
    @csrf

    <h4>General</h4>

    <!-- TITLE + SLUG -->
    <div class="form-group row">
        <label class="col-xl-3 col-md-4"><span>*</span> Name</label>

        <div class="col-xl-8 col-md-7">
            <input class="form-control" id="title" name="title" type="text" required>

            <input class="form-control mt-2" id="slug" name="slug" type="text">
        </div>
    </div>

    <!-- DESCRIPTION -->
    <div class="form-group row editor-label">
        <label class="col-xl-3 col-md-4"><span>*</span> Description</label>
        <div class="col-xl-8 col-md-7">
            <textarea id="editor1" name="description"></textarea>
        </div>
    </div>

    <!-- BUTTON -->
    <div class="pull-right">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>

</form>
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
ClassicEditor
    .create(document.querySelector('#editor1'))
    .then(editor => {
        console.log('Editor ready', editor);
    })
    .catch(error => {
        console.error(error);
    });
</script>
@endsection