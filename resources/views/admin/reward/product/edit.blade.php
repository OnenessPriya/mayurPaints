@extends('admin.layouts.app')
@section('page', 'Edit Product')

@section('content')
<section>
    <form method="POST" action="{{ route('admin.reward.product.update') }}" enctype="multipart/form-data">@csrf
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group mb-3">
                    <input type="text" name="name" placeholder="Add Product Title" class="form-control" value="{{$data->name}}">
                    <input type="hidden" name="product_id" value="{{$data->id}}">
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

                <div class="card shadow-sm">
                    <div class="card-header">
                        Product data
                    </div>
                    <div class="card-body pt-0">
                        <div class="admin__content">
                        <aside>
                            <nav>Points</nav>
                        </aside>
                        <content>
                            <div class="row mb-2 align-items-center">
                            <div class="col-3">
                                <label for="inputPassword6" class="col-form-label">Points</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="points" value="{{$data->points}}">
                                @error('points') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                            </div>
                        </content>
                        </div>
                    </div>
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
                        <input type="hidden" name="id" value="{{$data->id}}">
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
        $('.add-responsibility-link').on('click', function() {
            var content = `
            <div class="multi-responsibility-links">
                <div class="input-group mb-3">
                    <input class="form-control" type="text" name="name[]" id="name" placeholder="Title">
                    <textarea class="form-control" type="text" name="description[]" placeholder="Description"
                    id="description"></textarea>
                    <a href="javascript: void(0)" class="input-group-text remove-responsibility-link" id="basic-addon2">
                        <i class="fi fi-br-x"></i>
                    </a>
                </div>
            </div>
            `;
            $('#other-responsibility').append(content);
            $(document).on('click', '.remove-responsibility-link', function() {
            $(this).closest(".multi-responsibility-links").remove();
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
    </script>
@endsection
