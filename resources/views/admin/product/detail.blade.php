@extends('admin.layouts.app')

@section('page', 'Product detail')

@section('content')
<section>
    <form method="post" action="{{ route('admin.product.update', $data->id) }}" enctype="multipart/form-data">@csrf
        <div class="row">
            <div class="col-sm-3">
                <div class="card shadow-sm">
                    <div class="card-header">Main image</div>
                    <div class="card-body">
                        <div class="w-100 product__thumb">
                            <label for="thumbnail"><img id="output" src="{{ asset($data->image) }}"/></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <h2>@if($data->category) <span class="text-muted">Category : </span>{{$data->category->name}} @endif</h2>
                        </div>
                        <div class="form-group mb-3">
                            <h5 class="text-muted">{{$data->name}}</h5>
                        </div>

                        
                        <hr>
                        <div class="form-group mb-3">
                            <h4>
                                <span class="text-muted small">Rs {{$data->price}}</span>
                            </h4>
                        </div>
                        <hr>
                        <div class="form-group mb-3">
                            <p class="small">Short Description</p>
                            {!! $data->short_desc !!}
                        </div>
                        <hr>
                        <div class="form-group mb-3">
                            <p class="small"> Description</p>
                            {!! $data->desc !!}
                        </div>
                        <hr>
                        <div class="form-group mb-3">
                            <p class="small"> Applied on</p>
                            {!! $data->apply_on !!}
                        </div>
                        <hr>
                        <div class="form-group mb-3">
                            <p class="small"> Applied by</p>
                            {!! $data->apply_by !!}
                        </div>
                        <hr>
                        <div class="form-group mb-3">
                            <p class="small"> Coverage</p>
                            {!! $data->coverage !!}
                        </div>
                        <hr>
                        <div class="form-group mb-3">
                            <p class="small"> Size</p>
                            {!! $data->coverage !!}
                        </div>
                        <hr>
                        <div class="form-group mb-3">
                            <p class="small"> Self Life</p>
                            {!! $data->self_life !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@section('script')
    <script>
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
    </script>
@endsection