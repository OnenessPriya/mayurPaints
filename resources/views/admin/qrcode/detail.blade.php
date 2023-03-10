@extends('admin.layouts.app')

@section('page', 'Barcode detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">    
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="text-muted">{{ $data->name }}</h3>
                            {{-- <h6>{{ $data->name }}</h6> --}}
                        </div>
                        <div class="col-md-4 text-end">
                            @if ($data->end_date < \Carbon\Carbon::now() )
                            <h3 class="text-danger mt-3 fw-bold">EXPIRED</h3>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-8">
                            <p class="small text-muted mt-4 mb-2">Details</p>
                            <table class="">
                                <tr>
                                    <td class="text-muted">No of qrcodes: </td>
                                    <td>{{count($coupons)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Points: </td>
                                    <td>{{$data->type == 1 ? $data->points.' ' : ' '. $data->points}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Max time usage : </td>
                                    <td>{{$data->max_time_of_use}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Max time usage for single user :  </td>
                                    <td>{{$data->max_time_one_can_use}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">No of usage : </td>
                                    <td>{{$data->no_of_usage}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Start date: </td>
                                    <td>{{ date('j M Y', strtotime($data->start_date)) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">End date: </td>
                                    <td>{{ date('j M Y', strtotime($data->end_date)) }}</td>
                                </tr>
                            </table>

                            <hr>

                            <p class="small text-muted mt-4 mb-2">QRcodes</p>
                            <div class="col-auto">
                                <a type="button" id="basic" class="btn btn-outline-danger btn-sm">Download pdf</a>
                            </div>
                            <table class="table table-sm print-code">
                                <tr>
                                    <th>#SR</th>
                                    <th>Code</th>
                                    <th>QR</th>
                                    <th>Points</th>
                                    <th>Usage</th>
                                </tr>
                                @forelse ($coupons as $couponKey => $coupon)
                                <tr>
                                    <td>{{$couponKey+1}}</td>
                                    <td>{{$coupon->code}}</td>
                                    <td><div class="card-body ">
                                        {!! QrCode::size(100)->generate($coupon->code) !!}
                                    </div></td>
                                    <td>{{$coupon->points}}</td>
                                    <td>
                                        @if($coupon->no_of_usage >= $coupon->max_time_use)
                                            {{$coupon->no_of_usage}}</a>
                                                
                                        @else
                                            <p class="small text-danger">Not used yet</p>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                                @endforelse
                            </table>
                            <p class="small text-muted mt-4 mb-2">QRcode Usage</p>

                            <table class="table table-sm">
                                <tr>
                                    <th>#SR</th>
                                    <th>Total points</th>
                                    <th>Final points</th>
                                    <th>User details</th>
                                    <th>Time</th>
                                </tr>
                                @forelse ($usage as $usageKey => $usageValue)
                                <tr>
                                    <td>{{$usageKey+1}}</td>
                                    <td>{{$usageValue->amount}}</td>
                                    <td>{{$usageValue->amount}}</td>
                                    <td>
                                        @if($usageValue->user_id != 0)
                                            {{$usageValue->users->name}}
                                        @endif
                                        <p class="small mb-0">{{$usageValue->email}} </p>
                                    </td>
                                    <td>{{ date('j M Y H:i a', strtotime($usageValue->created_at)) }}</td>
                                   
                                </tr>
                                @empty
                                <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                                @endforelse
                            </table>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.qrcode.update', $data->id) }}" enctype="multipart/form-data">
                    @csrf
                        <h4 class="page__subtitle">Edit</h4>
                        <div class="form-group mb-3">
                            <label class="label-control">Name <span class="text-danger">*</span> </label>
                            <input type="text" name="name" placeholder="" class="form-control" value="{{ $data->name }}">
                            @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        {{-- <div class="form-group mb-3">
                            <label class="label-control"> code <span class="text-danger">*</span> </label>
                            <input type="text" name="code" placeholder="" class="form-control" value="{{ $data->code }}">
                            @error('code') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div> --}}
                        <div class="form-group mb-3">
                            <label class="label-control">Points <span class="text-danger">*</span> </label>
                            <input type="number" name="points" placeholder="" class="form-control" value="{{ $data->points }}">
                            @error('points') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Max time of use <span class="text-danger">*</span> </label>
                            <input type="number" name="max_time_of_use" placeholder="" class="form-control" value="{{ $data->max_time_of_use }}">
                            @error('max_time_of_use') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Max time one can use <span class="text-danger">*</span> </label>
                            <input type="number" name="max_time_one_can_use" placeholder="" class="form-control" value="{{ $data->max_time_one_can_use }}">
                            @error('max_time_one_can_use') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Start date <span class="text-danger">*</span> </label>
                            <input type="date" name="start_date" placeholder="" class="form-control" value="{{ date('Y-m-d', strtotime($data->start_date)) }}">
                            @error('start_date') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">End date <span class="text-danger">*</span> </label>
                            <input type="date" name="end_date" placeholder="" class="form-control" value="{{ date('Y-m-d', strtotime($data->end_date)) }}">
                            @error('end_date') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-danger">Update</button>
                            <a type="submit" class="btn btn-sm btn-secondary" href="{{route('admin.qrcode.index')}}">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@section('script')
<script src="{{ asset('admin/js/printThis.js') }}"></script>
<script>
 $('#basic').on("click", function () {
      $('.print-code').printThis();
    });
</script>
@endsection
