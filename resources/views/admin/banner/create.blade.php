@extends('admin.layouts.app')
@section('page', 'Create new Scheme')

@section('content')
<style>
    input::file-selector-button {
        display: none;
    }
</style>

<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.banner.store') }}" enctype="multipart/form-data">@csrf
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="is_current" name="is_current">
                                            <option value="1" selected>Current</option>
                                            <option value="0">Past</option>
                                        </select>
                                        <label for="is_current">Status *</label>
                                    </div>
                                    @error('is_current') <p class="small text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="name@example.com" value="{{ old('title') }}">
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
                                        <input type="file" class="form-control" id="image" name="image" placeholder="Distributor name" value="">
                                        <label for="image">Preview Image *</label>
                                    </div>
                                    @error('image') <p class="small text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('script')
<script>
    
</script>
@endsection
