@extends('admin.layouts.app')

@section('page', 'Order report')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<section>
    <div class="card card-body">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="GET">
                    <div class="row g-3 align-items-end mb-4">
                        <div class="col-auto">
                            <label for="date_from" class="text-muted small">Date from</label>
                            <input type="date" name="date_from" id="date_from" class="form-control form-control-sm" aria-label="Default select example" value="{{request()->input('date_from') ?? date('Y-m-01') }}">
                        </div>
                        <div class="col-auto">
                            <label for="date_to" class="text-muted small">Date to</label>
                            <input type="date" name="date_to" id="date_to" class="form-control form-control-sm" aria-label="Default select example" value="{{request()->input('date_to') ?? date('Y-m-d') }}">
                        </div>

                        <div class="col-auto">
                            <label for="user_id" class="small text-muted">User</label>
                            <select class="form-control select2" id="user_id" name="user_id">
                                <option value="" selected disabled>Select</option>
                                @foreach ($allUser as $item)
                                    <option value="{{$item->id}}" {{ (request()->input('user_id') == $item->id) ? 'selected' : '' }}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="product" class="small text-muted">Product</label>
                            <select name="product" class="form-control select2" id="product">
                                <option value="" disabled>Select</option>
                                <option value="" {{request()->input('product') == 'all' ? 'selected' : ''}}>All</option>
                                @foreach ($products as $product)
                                    <option value="{{$product->name}}" {{request()->input('product') == $product->name ? 'selected' : ''}}>{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-auto">
                            <label for="" class="small text-muted">Search for Order No</label>
                            <input type="search" name="term" id="orderNo" class="form-control" placeholder="Search here.." value="{{app('request')->input('term')}}" autocomplete="off">
                        </div>

                        <div class="col-auto">
                            {{-- <button type="submit" class="btn btn-outline-danger btn-sm">Search</button> --}}
                            <div class="btn-group">
                                <button type="submit" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-danger" data-bs-original-title="Search">   Filter </button>

                                <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Clear Filter">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </a>

                                <a href="{{route('admin.order.export.csv',['date_from'=>$request->date_from,'date_to'=>$request->date_to,'user_id'=>$request->user_id,'product'=>$request->product,'term'=>$request->term])}}" data-bs-toggle="tooltip" class="btn btn-sm btn-danger" title="" data-bs-original-title="Export"> <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                    CSV </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th>#SR</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Order No</th>
                    <th>Painter</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $all_orders_total_amount = 0;
                    @endphp

                    @forelse ($data as $index => $item)
                        @php
                            $all_orders_total_amount += ($item->qty);
                        @endphp
                        <tr id="row_{{$item->id}}">
                            <td>
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <p class="text-dark mb-1"> {{$item->product_name}}</p>

                            </td>
                            
                            <td>
                                <p class="text-dark mb-1">{{$item->qty}}</p>
                            </td>
                            <td>
                                <p class="small text-dark mb-1">#{{$item->order_no}}</p>
                                <div class="row__action">
                                    <a href="{{ route('admin.order.view', $item->id) }}">View</a>
                                   
                                </div>
                            </td>

                            <td>
                                <p class="small text-dark mb-1">{{$item->user->name ?? ''}}</p>
                            </td>

                            <td>
                                <p class="small text-dark mb-1">{{$item->email}}</p>
                            </td>
                            <td>
                                <p class="small text-dark mb-1">{{$item->mobile}}</p>
                            </td>
                            <td>
                                <div class="order-time">
                                    <p class="small text-muted mb-0">
                                        <span class="text-dark font-weight-bold mb-2">
                                            {{date('j M Y g:i A', strtotime($item->created_at))}}
                                        </span>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                    @endforelse
                    <tr>
                        <td></td>
                        
                        <td>
                            <p class="small text-dark mb-1 fw-bold">TOTAL</p>
                        </td>
                        <td>
                            <p class="small text-dark mb-1 fw-bold">{{ number_format($all_orders_total_amount) }}</p>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        function stateWiseArea(value) {
            $.ajax({
                url: '{{url("/")}}/state-wise-area/'+value,
                method: 'GET',
                success: function(result) {
                    var content = '';
                    var slectTag = 'select[name="area"]';
                    var displayCollection = (result.data.state == "all") ? "All Area" : "All "+" area";
                    content += '<option value="" selected>'+displayCollection+'</option>';
                    
                    let cat = "{{ app('request')->input('area') }}";
    
                    $.each(result.data.area, (key, value) => {
                        if(value.area == '') return;
                        if (value.area == cat) {
                            content += '<option value="'+value.area+'" selected>'+value.area+'</option>';
                        } else {
                            content += '<option value="'+value.area+'">'+value.area+'</option>';
                        }
                        //content += '<option value="'+value.area+'">'+value.area+'</option>';
                    });
                    $(slectTag).html(content).attr('disabled', false);
                }
            });
        }
    
        $('select[name="state"]').on('change', (event) => {
            var value = $('select[name="state"]').val();
            stateWiseArea(value);
        });
    
        @if(request()->input('state'))
            stateWiseArea("{{ request()->input('state') }}");
        @endif
    </script>
@endsection