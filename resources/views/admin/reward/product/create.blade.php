@extends('admin.layouts.app')

@section('page', 'Create Product')

@section('content')
<section>
    <form method="post" action="{{ route('admin.reward.product.store') }}" enctype="multipart/form-data">@csrf
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group mb-3">
                    <input type="text" name="name" placeholder="Add Product Title" class="form-control" value="{{old('name')}}">
                     @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>

                <div class="card shadow-sm">
                    <div class="card-header">
                        Short Description
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
                                    <input type="number" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="points" value="{{old('points')}}">
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
                        Product Main Image
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
    </form>
</section>
@endsection

@section('script')
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

    
    </script>
    <script>
        $('.add-responsibility-link').on('click', function() {
            var content = `
            <div class="multi-responsibility-links">
                <div class="input-group mb-3">
                    <input class="form-control" type="text" name="name" id="name" placeholder="Title">
                    <textarea class="form-control" type="text" name="description"
                    id="description" placeholder="Description"></textarea>
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
    </script>
@endsection
