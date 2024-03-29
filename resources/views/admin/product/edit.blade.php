@extends('admin.layouts.app')

@section('page', 'Edit Product')

@section('content')

<style>
    .color_holder {
        display: flex;
        border: 1px dashed #ddd;
        border-radius: 6px;
        padding: 5px;
        background: #f0f0f0;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .color_holder_single {
        margin: 5px;
    }
    .color_box {
        display: flex;
        padding: 6px 10px;
        border-radius: 3px;
        align-items: center;
        margin: 0;
        background: #fff;
    }
    .color_box p {
        margin: 0;
    }
    .color_box span {
        margin-right: 10px;
    }
    .sizeUpload {
        margin-bottom: 10px;
    }
    .size_holder {
        padding: 10px 0;
        border-top: 1px solid #ddd;
    }
    .img_thumb {
        width: 100%;
        padding-bottom: calc((4/3)*100%);
        position: relative;
        border:  1px solid #ccc;
        max-width: 80px;
        min-width: 80px;
    }
    .img_thumb img {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        object-fit: contain;
    }
    .remove_image {
        display: inline-flex;
        width: 30px;
        height: 30px;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        position: absolute;
        top: 0;
        right: 0;
    }
    .remove_image i {
        line-height: 13px;
    }
    .image_upload {
        display: inline-flex;
        padding: 0 20px;
        border:  1px solid #ccc;
        background: #ddd;
        padding: 5px 12px;
        border-radius: 3px;
        vertical-align: top;
        cursor: pointer;
    }
    .status-toggle {
        padding: 6px 10px;
        border-radius: 3px;
        align-items: center;
        background: #fff;
    }
    .status-toggle a {
        text-decoration: none;
        color: #000
    }
</style>

<section>
    <form method="POST" action="{{ route('admin.product.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-9">

                <div class="row mb-3">
              
                    <div class="col-sm-8">
						<label class="label-control">Category </label>
                        <select class="form-control" name="cat_id">
                            <option hidden selected>Select category...</option>
                            @foreach ($categories as $index => $item)
                                <option value="{{$item->id}}" {{ ($data->cat_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('cat_id') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" name="name" placeholder="Add Product Title" class="form-control" value="{{$data->name}}">
                    @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>

                <div class="card shadow-sm">
                    <div class="card-header">
                        Product Short Description
                    </div>
                    <div class="card-body">
                        <textarea id="product_short_des" name="short_desc">{{$data->short_desc}}</textarea>
                        @error('short_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <textarea id="product_des" name="desc">{{$data->desc}}</textarea>
                    @error('desc') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>

                <div class="form-group mb-3">
                    <input type="text" name="price" placeholder="Add price" class="form-control" value="{{old('price',$data->price)}}">
                    @error('price') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="card shadow-sm">
                    <div class="card-header">
                        Apply On
                    </div>
                    <div class="card-body">
                        <textarea id="apply_on" type="text" name="apply_on" placeholder="" class="form-control">{{old('apply_on',$data->apply_on)}}</textarea> 
                        @error('apply_on') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-header">
                        Apply By
                    </div>
                    <div class="card-body">
                        <textarea id="apply_by" type="text" name="apply_by" placeholder="" class="form-control">{{old('apply_by',$data->apply_by)}}</textarea> 
                        @error('apply_by') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" name="coverage" placeholder="Coverage" class="form-control" value="{{old('coverage',$data->coverage)}}">
                    @error('coverage') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="text" name="size" placeholder="Size" class="form-control" value="{{old('size',$data->size)}}">
                    @error('size') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="text" name="self_life" placeholder="Self Life" class="form-control" value="{{old('self_life',$data->self_life)}}">
                    @error('self_life') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="col-sm-3">
                
                 <div class="card shadow-sm">
                    <div class="card-header">
                        Product Image
                    </div>
                    <div class="card-body">
                        <div class="w-100 product__thumb">
                            <label for="thumbnail"><img id="output" src="{{ asset($data->image) }}"/></label>
                            @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <input type="file" id="thumbnail" accept="image/*" name="image" onchange="loadFile(event)" class="d-none">
                        <p class="mb-2"><small class="text-muted">Click on the image to browse</small></p>
						<p class="mb-0"><small>Image Size: 870px X 1160px</small></p>
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
				<div class="card shadow-sm" style="position: sticky;top: 60px;">
                    <div class="card-body text-end">
                        <input type="hidden" name="product_id" value="{{$data->id}}">
                        <button type="submit" class="btn btn-danger w-100">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>









@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
		

		

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

        $(document).on('click','.removeTimePrice',function(){
            var thisClickedBtn = $(this);
            thisClickedBtn.closest('tr').remove();
        });

        
        

       

      
    </script>
@endsection
