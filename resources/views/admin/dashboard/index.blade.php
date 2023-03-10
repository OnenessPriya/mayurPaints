@extends('admin.app')
@section('title') Dashboard @endsection
@section('content')
@php
$users = App\Models\User::where('status','1')->get();
$states = App\Models\State::where('status','1')->get();
$suburbs = App\Models\Suburb::where('status','1')->get();
$categories = App\Models\BlogCategory::where('status','1')->get();
$blogs = App\Models\Blog::where('status','1')->get();
$collection = App\Models\Collection::where('status','1')->get();
$subcategory = App\Models\SubCategory::where('status','1')->get();
$directory =  App\Models\Directory::where('status','1')->get();
@endphp

<style type="text/css">
    .row-md-body.no-nav {
    margin-top: 70px;
}
</style>

<div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        </div>
    </div>
</div>

<div class="row section-mg row-md-body no-nav mt-5">
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-users fa-3x"></i>
            <div class="info">
                <h4>Active Users</h4>
                <p><b> {{count($users)}} </b></p>
            </div>
        </div>
    </div>


    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-star fa-3x"></i>
            <div class="info">
                <h4>State</h4>
                <p><b> {{count($states)}} </b></p>
            </div>
        </div>
    </div>


    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Suburb</h4>
                <p><b> {{count($suburbs)}} </b></p>
            </div>
        </div>
    </div>


    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Category</h4>
                <p><b> {{count($categories)}} </b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Sub Category</h4>
                <p><b> {{count($subcategory)}} </b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Directory</h4>
                <p><b> {{count($directory)}} </b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Collection</h4>
                <p><b> {{count($collection)}} </b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Blog</h4>
                <p><b> {{count($blogs)}} </b></p>
            </div>
        </div>
    </div>

</div>
@endsection
