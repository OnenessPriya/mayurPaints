@extends('admin.layouts.app')
@section('page', 'Category create')

@section('content')
<section>
    <div class="row">
        <div class="col-xl-12 order-1 order-xl-2">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.category.store') }}" enctype="multipart/form-data">
                        @csrf
                        <h4 class="page__subtitle">Add New Category</h4>
                        <div class="row">
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="form-group mb-3">
                                    <label class="label-control">Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="name" placeholder="" class="form-control" value="{{old('name')}}">
                                    @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Description </label>
                                    <textarea name="description" class="form-control">{{old('description')}}</textarea>
                                    @error('description') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="row">
                                    <div class="col-md-6 card">
                                        <div class="card-header p-0 mb-3">Image <span class="text-danger">*</span></div>
                                        <div class="card-body p-0">
                                            <div class="w-100 product__thumb">
                                                <label for="icon"><img id="iconOutput" src="{{ asset('admin/images/placeholder-image.jpg') }}" /></label>
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
                                <button type="submit" class="btn btn-sm btn-danger">Add New Category</button>
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
