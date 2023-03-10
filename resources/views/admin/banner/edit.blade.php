@extends('admin.layouts.app')

@section('page', 'Edit Scheme')

@section('content')
<style>
    input::file-selector-button {
        display: none;
    }
    .veiwPDF{
        font-size: 12px;
        padding: 8px;
        width: 90px;
        display: flex;
        align-items: center;
        margin-right: 10px;
    }
</style>

<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.banner.update', $data->id) }}" enctype="multipart/form-data">@csrf
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="is_current" name="is_current">
                                            <option value="1" {{ ($data->is_current == 1) ? 'selected' : '' }}>Current</option>
                                            <option value="0" {{ ($data->is_current == 0) ? 'selected' : '' }}>Past</option>
                                        </select>
                                        <label for="is_current">Status *</label>
                                    </div>
                                    @error('is_current') <p class="small text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ? old('title') : $data->title }}">
                                        <label for="title">Title *</label>
                                    </div>
                                    @error('title') <p class="small text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="title" name="short_desc" value="{{ old('title') ? old('title') : $data->title }}">
                                        <label for="title">Title *</label>
                                    </div>
                                    @error('title') <p class="small text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="d-flex">
                                        @if (!empty($data->image) || file_exists($data->image))
                                            <img src="{{ asset($data->image) }}" alt="" class="img-thumbnail" style="height: 52px;margin-right: 10px;">
                                        @endif
                                        <div class="form-floating mb-3">
                                            <input type="file" class="form-control" id="image" name="image" value="">
                                            <label for="image">Preview Image *</label>
                                        </div>
                                    </div>
                                    @error('image') <p class="small text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger">Save changes</button>
                                <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
