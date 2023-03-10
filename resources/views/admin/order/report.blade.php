@extends('admin.layouts.app')

@section('page', $data->order_no.' report')

@section('content')
<section>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('admin.order.index') }}" class="btn btn-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        Back to all Orders
                    </a>
                </div>
                <div class="col-6 text-end">
                    <a href="javascript: void(0)" class="btn btn-primary" onclick="printInvoice()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        Print
                    </a>
                </div>
            </div>

            <div class="printDiv" style="margin-top:25px;">
                <div style="border:2px solid #000; padding: 0px 27px;">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h3 style="margin: 28px 0;">Order Form</h3>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-6">
                            <div style="padding:0 15px;">
                                <h4 style="font-weight: 500;">Lux Industries Limited</h4>
                                <p style="margin-bottom:4px;">17th floor, North Wing</p>
                                <p style="margin-bottom:4px;">Adventz Infinity</p>
                                <p style="margin-bottom:4px;">BN - 5, Sector V</p>
                                <p>Kolkata - 700091, W.B., India</p>
                            </div>
                        </div>

                        <div class="col-6">
                            <div style="padding: 0 15px 14px; border-left:2px solid #000;">
                                <p style="margin-bottom: 5px;font-size: 14px"><strong>Order no./ Date:</strong> <u>{{$data->order_no}}/ {{date('d.m.Y', strtotime($data->created_at))}}</u></p>
                                <p style="margin-bottom: 5px;font-size: 14px"><strong>Print Date:</strong> <u>{{date('d.m.Y')}}</u></p>
                                <p style="margin-bottom: 5px;font-size: 14px"><strong>From:</strong></p>
                                <p style="margin-bottom: 5px;font-size: 14px"><strong>M/S: </strong> <u>{{$data->stores ? $data->stores->store_name : ''}}</u></p>
                                @if ($data->stores)
                                    <p style="margin-bottom: 5px;font-size: 14px"><u>{{ $data->stores->address.' '.$data->stores->area.' '.$data->stores->state.' '.$data->stores->city.' '.$data->stores->pin }}</u></p>
                                    <p style="margin-bottom: 5px;font-size: 14px"><strong>Booking Place:</strong> <u>{{ $data->stores->city ? $data->stores->city : $data->stores->area }}</u></p>
                                @endif
                                <p style="margin-bottom:0;"><strong>Agent:</strong> <u>{{$data->users ? $data->users->name : ''}}</u></p>
                            </div>

                            {{-- <div style="padding: 0 15px 14px; border-left:2px solid #000;">
                                <p><strong>Order no./ Date:</strong> <u>{{$data->order_no}}/ {{date('d.m.Y', strtotime($data->created_at))}}</u></p>
                                <p><strong>Print Date:</strong> <u>{{date('d.m.Y')}}</u></p>
                                <p><strong>From:</strong></p>
                                <p><strong>M/S: </strong> <u>{{$data->stores ? $data->stores->store_name : ''}}</u></p>
                                @if ($data->stores)
                                    <p><u>{{ $data->stores->address.' '.$data->stores->area.' '.$data->stores->state.' '.$data->stores->city.' '.$data->stores->pin }}</u></p>
                                    <p><strong>Booking Place:</strong> <u>{{ $data->stores->city ? $data->stores->city : $data->stores->area }}</u></p>
                                @endif
                                <p style="margin-bottom:0;"><strong>Agent:</strong> <u>{{$data->users ? $data->users->name : ''}}</u></p>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div style="border:2px solid #000;  margin-top:25px;">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-sm table-bordered" >
                                <thead>
                                    <tr>
                                        <th style="color: #6c757d; font-size: 13px; min-width:200px; border-bottom:2px solid #000; width: 242px;">Name of Quality Shape & Unit</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">0XS</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">00S</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">00M</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">00L</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">0XL</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">2XL</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">3XL</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">4XL</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">FREE SIZE</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(orderProductsUpdatedMatrix($data->orderProducts) as $productKey => $productValue)
                                    <tr>
                                        <td style="; border-bottom:2px solid #000;">
                                            <p class="small text-dark fw-bold mb-0">{{$productValue['product_name']}}</p>
                                            <p class="small text-dark fw-bold mb-0">{{$productValue['product_style_no']}}</p>
                                            <p class="small text-dark fw-bold mb-0">{{$productValue['color']}}</p>
                                        </td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['0XS'] ? $productValue['0XS'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['00S'] ? $productValue['00S'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['00M'] ? $productValue['00M'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['00L'] ? $productValue['00L'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['0XL'] ? $productValue['0XL'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['2XL'] ? $productValue['2XL'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['3XL'] ? $productValue['3XL'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['4XL'] ? $productValue['4XL'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['FREE SIZE'] ? $productValue['FREE SIZE'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{$productValue['total']}}</p></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @if(count(orderProductsUpdatedMatrixChild($data->orderProducts)) > 0)
                                <thead>
                                    <tr>
                                        <th style="color: #6c757d; font-size: 13px; min-width:200px; border-bottom:2px solid #000; width: 242px;">Name of Quality Shape & Unit</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">1-2</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">2-3</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">3-4</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">5-6</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">7-8</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">9-10</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">11-12</th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">13-14</th>
										<th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;"></th>
                                        <th style="color: #6c757d; font-size: 13px; border-left:2px solid #000; border-bottom:2px solid #000;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(orderProductsUpdatedMatrixChild($data->orderProducts) as $productKey => $productValue)
                                    <tr>
                                        <td style="; border-bottom:2px solid #000;">
                                            <p class="small text-dark fw-bold mb-0">{{$productValue['product_name']}}</p>
                                            <p class="small text-dark fw-bold mb-0">{{$productValue['product_style_no']}}</p>
                                            <p class="small text-dark fw-bold mb-0">{{$productValue['color']}}</p>
                                        </td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['1-2'] ? $productValue['1-2'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['2-3'] ? $productValue['2-3'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['3-4'] ? $productValue['3-4'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['5-6'] ? $productValue['5-6'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['7-8'] ? $productValue['7-8'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['9-10'] ? $productValue['9-10'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['11-12'] ? $productValue['11-12'] : '' }}</p></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{ $productValue['13-14'] ? $productValue['13-14'] : '' }}</p></td>
										<td style="border-left:2px solid #000; border-bottom:2px solid #000;"></td>
                                        <td style="border-left:2px solid #000; border-bottom:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{$productValue['total']}}</p></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @endif
                                <tbody>
                                    <tr>
                                        <td style="">
                                            <p class="small text-dark mb-0"><strong>Total</strong></p>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
										
                                        <td style="border-left:2px solid #000;"><p class="small text-dark fw-bold mb-0">{{$data->orderProducts->sum('qty')}}</p></td>
                                    </tr>
                                </tbody>
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
    <script src="{{ asset('js/printThis.js') }}"></script>

    <script>
        function printInvoice() {
            $('.printDiv').printThis();
        }
    </script>
@endsection
