@extends('admin.layouts.app')

@section('page', 'Category Update')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.category.update', $data->id) }}" enctype="multipart/form-data">
                    @csrf
                        <h4 class="page__subtitle">Edit Category</h4>
                        <div class="form-group mb-3">
                            <label class="label-control">Name <span class="text-danger">*</span> </label>
                            <input type="text" name="name" placeholder="" class="form-control" value="{{ $data->name }}">
                            @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        {{-- <div class="form-group mb-3">
                            <label class="label-control">Parent </label>
                            <input type="text" name="parent" placeholder="" class="form-control" value="{{ $data->parent }}">
                            @error('parent') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div> --}}
                        <div class="form-group mb-3">
                            <label class="label-control">Description </label>
                            <textarea name="description" class="form-control">{{$data->description}}</textarea>
                            @error('description') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 card">
                                <div class="card-header p-0 mb-3">Icon <span class="text-danger">*</span></div>
                                <div class="card-body p-0">
                                    <div class="w-100 product__thumb">
                                        <label for="icon"><img id="iconOutput" src="{{ asset($data->image) }}" /></label>
                                    </div>
                                    <input type="file" name="image" id="icon" accept="image/*" onchange="loadIcon(event)" class="d-none">
                                    <script>
                                        let loadIcon = function(event) {
                                            let iconOutput = document.getElementById('iconOutput');
                                            iconOutput.src = URL.createObjectURL(event.target.files[0]);
                                            iconOutput.onload = function() {
                                                URL.revokeObjectURL(iconOutput.src) // free memory
                                            }
                                        };
                                    </script>
                                </div>
                                @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-danger">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
