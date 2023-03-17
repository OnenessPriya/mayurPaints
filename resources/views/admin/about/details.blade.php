@extends('admin.layouts.app')

@section('page', 'About us detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <p class="text-muted small mb-1">Name</p>
                            <p class="text-dark small">{{strtoupper($about->pretty_name)}}</p>
                            <p class="text-muted small mb-1">Content</p>
                            <p class="text-dark small">{!! $about->content !!}</p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.about.update', $about->id) }}" enctype="multipart/form-data">
                    @csrf
                        <h4 class="page__subtitle">Edit</h4>
                        <div class="form-group mb-3">
                            <label class="label-control">Name <span class="text-danger">*</span> </label>
                            <input type="text" name="pretty_name" placeholder="" class="form-control" value="{{ $about->pretty_name }}" disabled>
                            @error('pretty_name') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="label-control">Content <span class="text-danger">*</span> </label>
                            <textarea type="text" name="content" placeholder="" class="form-control" >{{ $about->content }}</textarea>
                            @error('points') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-danger">Update</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
       
    </div>
    <br>
    <a class="btn btn-secondary" href="{{ route('admin.about.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
</section>
@endsection
