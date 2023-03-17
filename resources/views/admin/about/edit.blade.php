@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.about-us.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="pretty_name"> Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('pretty_name') is-invalid @enderror" type="text" name="pretty_name" id="pretty_name" value="{{ old('pretty_name', $about->pretty_name) }}"/>
                            <input type="hidden" name="id" value="{{ $about->id }}">
                            @error('pretty_name') {{ $message }} @enderror
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="content">Content</label>
                            <textarea class="form-control" rows="4" name="content" id="content">{{ old('content', $about->content) }}</textarea>
                            <input type="hidden" name="id" value="{{ $about->id }}">
                            @error('content') {{ $message }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content1">Content 1</label>
                            <textarea class="form-control" rows="4" name="content1" id="content1">{{ old('content1', $about->content1) }}</textarea>
                            <input type="hidden" name="id" value="{{ $about->id }}">
                            @error('content1') {{ $message }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content2">Content 2</label>
                            <textarea class="form-control" rows="4" name="content2" id="content">{{ old('content2', $about->content2) }}</textarea>
                            <input type="hidden" name="id" value="{{ $about->id }}">
                            @error('content2') {{ $message }} @enderror

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($about->banner_image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('AboutusBanner/'.$about->banner_image) }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Banner Image</label>
                                    <input class="form-control @error('banner_image') is-invalid @enderror" type="file" id="banner_image" name="banner_image"/>
                                    @error('banner_image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($about->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('Aboutus/'.$about->image) }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label"> Image</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                    @error('image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Settings</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.about-us.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
