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
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        
                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>


                <form action="{{ route('admin.blog.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Blog Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="pin"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="blog_category_id">
                                <option value="" hidden selected>Select Categoy...</option>
                                @foreach ($blogcat as $index => $item)
                                    <option value="{{$item->id}}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('blog_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="pin"> Sub Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="blog_sub_category_id">
                                <option  value="" hidden selected>Select Sub Categoy...</option>
                                @foreach ($blogsubcat as $index => $item)
                                    <option value="{{$item->id}}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('blog_sub_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content">Content</label>
                            <textarea type="text" class="form-control" rows="4" name="content" id="content">{{ old('content') }}</textarea>
                            @error('content') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_title">Meta Title</label>
                            <input class="form-control" rows="4" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"/>
                            @error('meta_title') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_key">Meta Key</label>
                            <input class="form-control" rows="4" name="meta_key" id="meta_key"{{ old('meta_key') }}/>
                            @error('meta_key') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_description">Meta Description</label>
                            <textarea class="form-control" rows="4" name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
                            {{-- <input name="meta_description" type="text" id="upload" onchange="" hidden> --}}
                            @error('meta_description') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label">Blog Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Blog</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
                {{-- <form action="{{ route('admin.blog.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Blog Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="pin"> Category <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="blog_category_id">
                                    <option hidden selected>Select Categoy...</option>
                                    @foreach ($blogcat as $index => $item)
                                        <option value="{{$item->id}}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('blog_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="pin"> Sub Category <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="blog_sub_category_id">
                                    <option hidden selected>Select Sub Categoy...</option>
                                    @foreach ($blogsubcat as $index => $item)
                                        <option value="{{$item->id}}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('blog_sub_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content">Content</label>
                            <input type="text" class="form-control" rows="4" name="content" id="content"{{ old('content') }}/>@error('content') {{ $message ?? '' }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_title">Meta Title</label>
                            <input class="form-control" rows="4" name="meta_title" id="meta_title"{{ old('meta_title') }}/>@error('meta_title') {{ $message ?? '' }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_key">Meta Key</label>
                            <input class="form-control" rows="4" name="meta_key" id="meta_key"{{ old('meta_key') }}/>@error('meta_key') {{ $message ?? '' }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_description">Description</label>
                            <textarea class="form-control" rows="4" name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
                            <input name="meta_description" type="text" id="upload" onchange="" hidden>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Blog Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Blog</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
@endsection
