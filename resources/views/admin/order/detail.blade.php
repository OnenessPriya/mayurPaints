@extends('admin.layouts.app')

@section('page', 'Order detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-5">
            <div class="card shadow-sm">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="row product__thumb">
                      
                            <div class="col-md-6">
                               @if(!empty($data->orderProducts->image)) <img src="{{ asset($data->orderProducts->image) }}" style="height:100px">@endif
                                <p class="small single-line mb-0">{{$data->product_name}}</p>
                                <hr class="my-1">
                                <p class="small text-dark mb-0"> <span class="text-muted">Qty : </span> {{$data->qty}}</p>
                                <p class="small text-dark mb-0"> <span class="text-muted">Price : </span> {{$data->orderProducts->points ?? ''}}</p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <a href="{{ route('admin.order.status', [$data->id, 1]) }}" type="button" class="btn btn-outline-primary btn-sm {{($data->status == 1) ? 'active' : ''}}">New</a>
                            <a href="{{ route('admin.order.status', [$data->id, 2]) }}" type="button" class="btn btn-outline-primary btn-sm {{($data->status == 2) ? 'active' : ''}}">Confirm</a>
                            <a href="{{ route('admin.order.status', [$data->id, 3]) }}" type="button" class="btn btn-outline-primary btn-sm {{($data->status == 3) ? 'active' : ''}}">Shipped</a>
                            <a href="{{ route('admin.order.status', [$data->id, 4]) }}" type="button" class="btn btn-outline-success btn-sm {{($data->status == 4) ? 'active' : ''}}">Delivered</a>
                            <a href="{{ route('admin.order.status', [$data->id, 5]) }}" type="button" class="btn btn-outline-danger btn-sm {{($data->status == 5) ? 'active' : ''}}">Cancelled</a>
                        </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <p class="small">Order Time : {{date('j M Y g:i A', strtotime($data->created_at))}}</p>
                        <h2>{{$data->fname.' '.$data->lname}}</h2>
                        <p class="small text-dark mb-0"> <span class="text-muted">Email : </span> {{$data->email}}</p>
                        <p class="small text-dark mb-0"> <span class="text-muted">Mobile : </span> {{$data->mobile}}</p>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="small text-dark mb-0"> <span class="text-muted">Billing address : </span> {{$data->billing_address}}</p>
                            <p class="small text-dark mb-0"> {{$data->billing_city.', '.$data->billing_pin.', '.$data->billing_state.', '.$data->billing_country}}</p>
                        </div>

                    </div>

                    <hr>

                    <div class="row mb-3 justify-content-end">
                        <div class="col-md-4 text-end">
                            <p class="small text-muted mb-2">Pricing</p>
                            <table class="w-100">
                                <tr>
                                    <td><p class="small text-muted mb-0">Amount : </p></td>
                                    <td><p class="small text-dark mb-0 text-end"> {{$data->final_amount}}</p></td>
                                </tr>
                                <tr class="border-top">
                                    <td><p class="small text-muted mb-0">Final Amount : </p></td>
                                    <td><p class="small text-dark mb-0 text-end"> {{$data->final_amount}}</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>

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