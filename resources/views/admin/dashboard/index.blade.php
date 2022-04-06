@extends('adminetic::admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Dashboard</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"> <i data-feather="home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Blog </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body shadow-lg p-3 bg-primary">
                    <h3><b>{{\App\Models\Admin\Post::count()}}</b></h3>
                    <br>
                    <h6>Total Posts</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body shadow-lg p-3 bg-primary">
                    <h3><b>{{\App\Models\Admin\Post::featured()->count()}}</b></h3>
                    <br>
                    <h6>Total Featured Posts</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body shadow-lg p-3 bg-primary">
                    <h3><b>{{\App\Models\Admin\Post::published()->count()}}</b></h3>
                    <br>
                    <h6>Total Published Posts</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body shadow-lg p-3 bg-primary">
                    <h3><b>{{\App\Models\Admin\Post::draft()->count()}}</b></h3>
                    <br>
                    <h6>Total Drafted Posts</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
@endsection

@section('custom_js')
@include('admin.layouts.modules.dashboard.scripts')
@endsection