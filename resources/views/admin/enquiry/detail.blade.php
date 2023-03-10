@extends('admin.layouts.app')

@section('page', 'Enquiry detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if($data->userDetails->type==1)<span class="badge bg-success">Painter </span>
                            @elseif($data->userDetails->type==2)<span class="badge bg-danger">Sales Person </span>
                            @elseif($data->userDetails->type==3)<span class="badge bg-primary">Customer </span>
                            @endif
                            <h3>User Name : {{ $data->name }}</h3>
                           
                            <p class="text-muted">Product name: {{ $data->product->name ?? ''}}</p>
                            <p class="small">Mobile: {{ $data->mobile }}</p>
                            <hr>
                            <p class="small">Whatsapp No : {{ $data->whatsapp_no }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <p class="text-muted">Message</p>
                            <p class="small">{{ $data->message }}</p>
                        </div>
                    </div>
                    <hr>
                   
                </div>
            </div>
        </div>
    </div>
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