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
                            <label for="ase" class="small text-muted">ASE</label>
                            <select class="form-control form-control-sm" id="ase" name="ase">
                                <option value="" selected disabled>Select</option>
                                @foreach ($allASEs as $item)
                                    <option value="{{$item->ase}}" {{ (request()->input('ase') == $item->ase) ? 'selected' : '' }}>{{$item->ase}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="state" class="text-muted small">State</label>
                            <select name="state" id="state" class="form-control form-control-sm">
                                <option value="" disabled>Select</option>
                                <option value="" selected>All</option>
                                @foreach ($state as $state)
                                    <option value="{{$state->state}}" {{ request()->input('state') == $state->state ? 'selected' : '' }}>{{$state->state}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="small text-muted">Area</label>
							<select class="form-control form-control-sm" name="area" disabled>
								<option value="{{ $request->region }}">Select state first</option>
							</select>
                        </div>
                        <div class="col-auto">
                            <label for="store_id" class="small text-muted">Store</label>
                            <select class="form-select form-select-sm" id="store_id" name="store_id">
                                <option value="" selected disabled>Select</option>
                                @foreach ($allStores as $item)
                                    <option value="{{$item->id}}" {{ (request()->input('store_id') == $item->id) ? 'selected' : '' }}>{{$item->store_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="product" class="small text-muted">Product</label>
                            <select name="product" class="form-control select2" id="product">
                                <option value="" disabled>Select</option>
                                <option value="" {{request()->input('product') == 'all' ? 'selected' : ''}}>All</option>
                                @foreach ($data->products as $product)
                                    <option value="{{$product->name}}" {{request()->input('product') == $product->name ? 'selected' : ''}}>({{$product->style_no}}) {{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-auto">
                            <label for="" class="small text-muted">Search for Order No</label>
                            <input type="search" name="orderNo" id="orderNo" class="form-control" placeholder="Search here.." value="{{app('request')->input('orderNo')}}" autocomplete="off">
                        </div>

                        <div class="col-auto">
                            {{-- <button type="submit" class="btn btn-outline-danger btn-sm">Search</button> --}}
                            <div class="btn-group">
                                <button type="submit" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-danger" data-bs-original-title="Search"> <i class="fi fi-br-search"></i> </button>

                                <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="" data-bs-original-title="Clear search"> <i class="fi fi-br-x"></i> </a>

                                <a href="{{route('admin.secondary.order.report.index.export',['date_from'=>$request->date_from,'date_to'=>$request->date_to,'ase'=>$request->ase,'state'=>$request->sate,'area'=>$request->area,'product'=>$request->product,'orderNo'=>$request->orderNo])}}" data-bs-toggle="tooltip" class="btn btn-sm btn-danger" title="" data-bs-original-title="Export"> <i class="fi fi-br-download"></i> </a>
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
                    <th>State</th>
                    <th>Area</th>
                    <th>ASE</th>
                    <th>Store</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $all_orders_total_amount = 0;
                    @endphp

                    @forelse ($data->all_orders as $index => $item)
                        @php
                            $all_orders_total_amount += ($item->qty);
                        @endphp
                        <tr id="row_{{$item->id}}">
                            <td>
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <p class="text-dark mb-1">({{$item->product_style_no}}) {{$item->product_name}}</p>
                                <p class="small text-muted mb-1">{{$item->color}}</p>
                                <p class="small text-muted mb-1">{{$item->size}}</p>

                            </td>
                            
                            <td>
                                <p class="text-dark mb-1">{{$item->qty}}</p>
                            </td>
                            <td>
                                <p class="small text-dark mb-1">#{{$item->order_no}}</p>
                            </td>
                            <td>
                                <p class="small text-dark mb-1">{{$item->state}}</p>
                            </td>
                            <td>
                                <p class="small text-dark mb-1">{{$item->area}}</p>
                            </td>

                            <td>
                                <p class="small text-dark mb-1">{{$item->fname.' '.$item->lname}}</p>
                            </td>

                            <td>
                                <p class="small text-dark mb-1">{{$item->store_name}}</p>
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