@extends('admin.layouts.app')

@section('page', 'Create Product')

@section('content')
<section>
    <form method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">@csrf
        <div class="row">
        <div class="col-sm-9">
            <div class="row mb-3">
                <div class="col-sm-8">
                    <label class="label-control">Category <span class="text-danger">*</span> </label>
                    <select class="form-select form-select-sm" aria-label="Default select example" name="cat_id" id="category">
                        <option value="" selected disabled>Select Category</option>
                        @foreach ($category as $cat)
                            <option value="{{$cat->id}}" {{request()->input('cat_id') == $cat->name ? 'selected' : ''}}> {{$cat->name}}</option>
                        @endforeach
                    </select>
                    @error('cat_id') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="form-group mb-3">
                <label class="label-control">Title <span class="text-danger">*</span> </label>
                <input type="text" name="name" placeholder="Add Product Title" class="form-control" value="{{old('name')}}">
                @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    Short Description <span class="text-danger">*</span>
                </div>
                <div class="card-body">
                    <textarea id="product_short_des" name="short_desc">{{old('short_desc')}}</textarea>
                    @error('short_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    Description
                </div>
                <div class="card-body">
                    <textarea id="product_des" name="desc">{{old('desc')}}</textarea>
                    @error('desc') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="form-group mb-3">
                <input type="text" name="price" placeholder="Add price" class="form-control" value="{{old('price')}}">
                @error('price') <p class="small text-danger">{{ $message }}</p> @enderror
            </div>
            <div class="card shadow-sm">
                <div class="card-header">
                    Apply On
                    <span class="text-danger">*</span>
                </div>
                <div class="card-body">
                    <textarea id="apply_on" type="text" name="apply_on" placeholder="" class="form-control">{{old('apply_on')}}</textarea> 
                    @error('apply_on') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header">
                    Apply By
                </div>
                <div class="card-body">
                    <textarea id="apply_by" type="text" name="apply_by" placeholder="" class="form-control">{{old('apply_by')}}</textarea> 
                    @error('apply_by') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="form-group mb-3">
                <label class="label-control">Coverage <span class="text-danger">*</span> </label>
                <input type="text" name="coverage" placeholder="Coverage" class="form-control" value="{{old('coverage')}}">
                @error('coverage') <p class="small text-danger">{{ $message }}</p> @enderror
            </div>
            <div class="form-group mb-3">
                <label class="label-control">Size <span class="text-danger">*</span> </label>
                <input type="text" name="size" placeholder="Size" class="form-control" value="{{old('size')}}">
                @error('size') <p class="small text-danger">{{ $message }}</p> @enderror
            </div>
            <div class="form-group mb-3">
                <label class="label-control">Self Life <span class="text-danger">*</span> </label>
                <input type="text" name="self_life" placeholder="Self Life" class="form-control" value="{{old('self_life')}}">
                @error('self_life') <p class="small text-danger">{{ $message }}</p> @enderror
            </div>

        </div>
        <div class="col-sm-3">
			<div class="card shadow-sm">
                <div class="card-header">
                    Product Main Image
                    <span class="text-danger">*</span>
                </div>
                <div class="card-body">
                    <div class="w-100 product__thumb">
                    <label for="thumbnail"><img id="output" src="{{ asset('admin/images/placeholder-image.jpg') }}"/></label>
                    @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                    <input type="file" id="thumbnail" accept="image/*" name="image" onchange="loadFile(event)" class="d-none">
                    <script>
                    var loadFile = function(event) {
                        var output = document.getElementById('output');
                        output.src = URL.createObjectURL(event.target.files[0]);
                        output.onload = function() {
                        URL.revokeObjectURL(output.src) // free memory
                        }
                    };
                    </script>
                </div>
            </div>
            <div class="card shadow-sm">
            <div class="card-header">
                Publish
            </div>
            <div class="card-body text-end">
                <button type="submit" class="btn btn-sm btn-danger">Publish </button>
            </div>
            </div>
        </div>
        </div>
    </form>
</section>
@endsection

@section('script')

    <script>
		$('select[id="collection"]').on('change', (event) => {
			var value = $('select[id="collection"]').val();

			$.ajax({
				url: '{{url("/")}}/api/category/product/collection/'+value,
                method: 'GET',
                success: function(result) {
					var content = '';
					var slectTag = 'select[id="category"]';
					var displayCollection = (result.data.collection_name == "all") ? "All category" : "All "+result.data.collection_name+" categories";

					content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.category, (key, value) => {
						content += '<option value="'+value.cat_id+'">'+value.cat_name+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});
        ClassicEditor
        .create( document.querySelector( '#product_des' ) )
        .catch( error => {
            console.error( error );
        });
        ClassicEditor
        .create( document.querySelector( '#product_short_des' ) )
        .catch( error => {
            console.error( error );
        });
        ClassicEditor
        .create( document.querySelector( '#apply_on' ) )
        .catch( error => {
            console.error( error );
        });
        ClassicEditor
        .create( document.querySelector( '#apply_by' ) )
        .catch( error => {
            console.error( error );
        });
    </script>
@endsection
