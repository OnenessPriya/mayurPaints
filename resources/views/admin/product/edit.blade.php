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
              
                    <div class="col-sm-4">
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
                    <input type="text" name="price" placeholder="Add price" class="form-control" value="{{old('price')}}">
                    @error('price') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="card shadow-sm">
                    <div class="card-header">
                        Apply On
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
                    <input type="text" name="coverage" placeholder="Coverage" class="form-control" value="{{old('coverage')}}">
                    @error('coverage') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="text" name="size" placeholder="Size" class="form-control" value="{{old('size')}}">
                    @error('size') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="text" name="self_life" placeholder="Self Life" class="form-control" value="{{old('self_life')}}">
                    @error('self_life') <p class="small text-danger">{{ $message }}</p> @enderror
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

<div class="modal fade" tabindex="-1" id="addColorModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add new color</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('admin.product.variation.color.add')}}" method="post">@csrf
                <input type="hidden" name="product_id" value="{{$id}}">
                {{-- <input type="hidden" name="color" value="{{$productColorGroupVal->color}}"> --}}
                <div class="form-group mb-3">
                <select class="form-control" name="color" id="">
                    <option value="" selected>Select color...</option>
                    @php
                        $color = \App\Models\Color::orderBy('name', 'asc')->get();
                        foreach ($color as $key => $value) {
                            echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                        }
                    @endphp
                </select>
                </div>
                <div class="form-group mb-3">
                <select class="form-control" name="size" id="">
                    <option value="" selected>Select size...</option>
                    @php
                        $sizes = \App\Models\Size::get();
                        foreach ($sizes as $key => $value) {
                            echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                        }
                    @endphp
                </select>
                </div>
                <div class="form-group mb-3">
                    <input class="form-control" type="text" name="price" id="" placeholder="Price">
                </div>
                <div class="form-group mb-3">
                    <input class="form-control" type="text" name="sku_code" id="" placeholder="SKU code">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-success">+ Save changes</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>

{{-- edit color modal --}}
<div class="modal fade" tabindex="-1" id="editColorModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.product.variation.color.edit')}}" method="post">@csrf
                    <input type="hidden" name="product_id" value="{{$id}}">
                    <input type="hidden" name="current_color" value="">
                    <div class="form-group">
                        <p>Style no: <strong>{{$data->style_no}}</strong></p>
                        <p>Product: <strong>{{$data->name}}</strong></p>
                        <p>Current Color: <strong><span id="colorName"></span></strong></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="editColorCode">Change color</label>
                        <select class="form-control" name="update_color" id="editColorCode">
                            <option value="" disabled selected>Select color...</option>
                            @php
                                $color = \App\Models\Color::orderBy('name', 'asc')->get();
                                foreach ($color as $key => $value) {
                                    echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                                }
                            @endphp
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">Change color</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- rename color modal --}}
<div class="modal fade" tabindex="-1" id="renameColorModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rename color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.product.variation.color.rename')}}" method="post">@csrf
                    <input type="hidden" name="product_id" value="{{$id}}">
                    <input type="hidden" name="current_color2" value="">
                    <div class="form-group">
                        <p>Style no: <strong>{{$data->style_no}}</strong></p>
                        <p>Product: <strong>{{$data->name}}</strong></p>
                        <p>Current name: <strong><span id="colorName2"></span></strong></p>
                    </div>
                    <div class="form-group mb-3">
                        <label>Enter new name</label>
                        <input type="text" class="form-control" name="update_color_name" id="">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">Rename color</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- rename color modal --}}
<div class="modal fade" tabindex="-1" id="sizeDetailModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Size detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.product.variation.size.edit')}}" method="post">@csrf
                    {{-- <input type="hidden" name="product_id" value="{{$id}}"> --}}
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <p>Style no: <strong>{{$data->style_no}}</strong></p>
                        <p>Product: <strong>{{$data->name}}</strong></p>
                    </div>
                    <div class="form-group mb-3">
                        <label>Current Size: <span id="sizeNameDetail"></span> </label>
                        <select class="form-control" name="size" id="">
                            <option value="" selected>Change size...</option>
                            @php
                                $sizes = \App\Models\Size::get();
                                foreach ($sizes as $key => $value) {
                                    echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                                }
                            @endphp
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Size detail</label>
                        <input type="text" class="form-control" name="size_details" id="">
                    </div>
                    <div class="form-group mb-3">
                        <label>Price</label>
                        <input type="text" class="form-control" name="price" id="">
                    </div>
                    <div class="form-group mb-3">
                        <label>Code</label>
                        <input type="text" class="form-control" name="code" id="">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">Save size detail</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
		function renameColorModalOpen(colorId, colorName) {
            $('#colorName2').text(colorName);
            $('input[name="update_color_name"]').val(colorName);
            $('input[name="current_color2"]').val(colorId);
            $('#renameColorModal').modal('show');
        }

		function editColorModalOpen(colorId, colorName) {
            $('#colorName').text(colorName);
            $('input[name="current_color"]').val(colorId);
            $('#editColorModal').modal('show');
        }

		function editSizeFunc(size, id, name, price, code) {
            $('#sizeNameDetail').text(size);
            $('#colorName3').text(name);
            $('input[name="id"]').val(id);
            $('input[name="size_details"]').val(name);
            $('input[name="price"]').val(price);
            $('input[name="code"]').val(code);
            $('#sizeDetailModal').modal('show');
        }

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

        function sizeCheck(productId, colorId) {
            $.ajax({
                url : '{{route("admin.product.size")}}',
                method : 'POST',
                data : {'_token' : '{{csrf_token()}}', productId : productId, colorId : colorId},
                success : function(result) {
                    if (result.error === false) {
                        let content = '<div class="btn-group" role="group" aria-label="Basic radio toggle button group">';

                        $.each(result.data, (key, val) => {
                            content += `<input type="radio" class="btn-check" name="productSize" id="productSize${val.sizeId}" autocomplete="off"><label class="btn btn-outline-primary px-4" for="productSize${val.sizeId}">${val.sizeName}</label>`;
                        })

                        content += '</div>';

                        $('#sizeContainer').html(content);
                    }
                },
                error: function(xhr, status, error) {
                    // toastFire('danger', 'Something Went wrong');
                }
            });
        }

        function deleteImage(imgId, id1, id2) {
            $.ajax({
                url : '{{route("admin.product.variation.image.delete")}}',
                method : 'POST',
                data : {'_token' : '{{csrf_token()}}', id : imgId},
                beforeSend : function() {
                    $('#img__holder_'+id1+'_'+id2+' a').text('Deleting...');
                },
                success : function(result) {
                    $('#img__holder_'+id1+'_'+id2).hide();
                    toastFire('success', result.message);
                },
                error: function(xhr, status, error) {
                    // toastFire('danger', 'Something Went wrong');
                }
            });
        }

        $(".row_position").sortable({
            delay: 150,
            stop: function() {
                var selectedData = new Array();
                $('.row_position > .single-color-holder').each(function() {
                    selectedData.push($(this).attr("id"));
                });
                updateOrder(selectedData);
            }
        });

        function updateOrder(data) {
            // $('.loading-data').show();
            $.ajax({
                url : "{{route('admin.product.variation.color.position')}}",
                type : 'POST',
                data: {
                    _token : '{{csrf_token()}}',
                    position : data
                },
                success:function(data) {
                    // toastFire('success', 'Color position updated successfully');
                    // $('.loading-data').hide();
                    // console.log();
                    if (data.status == 200) {
                        toastFire('success', data.message);
                    } else {
                        toastFire('error', data.message);
                    }
                }
            });
        }

        // product color status change
        function colorStatusToggle(id, productId, colorId) {
            $.ajax({
                url : '{{route("admin.product.variation.color.status.toggle")}}',
                method : 'POST',
                data : {
                    _token : '{{csrf_token()}}',
                    productId : productId,
                    colorId : colorId,
                },
                success : function(result) {
                    if (result.status == 200) {
                        // toastFire('success', result.message);

                        if (result.type == 'active') {
                            $('#'+id+' .color_box').css('background', '#fff');
                        } else {
                            $('#'+id+' .color_box').css('background', '#c1080a59');
                        }
                    } else {
                        toastFire('error', result.message);
                    }
                }
            });
        }

        function addSizeModal(colorId, colorName) {
            $('#addColorModal .modal-title').text('Add new size');
            $('#addColorModal select[name="color"]').html('<option value="'+colorId+'">'+colorName+'</option>');
            $('#addColorModal').modal('show');
        }

        function addColorModal() {
            var contentData = `
            @php
                $color = \App\Models\Color::orderBy('name', 'asc')->get();
                foreach ($color as $key => $value) {
                    echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                }
            @endphp
            `;
            $('#addColorModal .modal-title').text('Add new color');
            $('#addColorModal select[name="color"]').html('<option value="" selected>Select color...</option>'+ contentData);
            $('#addColorModal').modal('show');
        }
    </script>
@endsection
