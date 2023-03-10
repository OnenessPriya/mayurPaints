@extends('admin.layouts.app')

@section('page', 'Home')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card home__card bg-gradient-danger">
                <div class="card-body">
                        <h4>Total Sales Person</h4>
                        <p><b> {{$data->salesperson }} </b></p>
                    </div>
                </div>
            </div>
        
        
            <div class="col-sm-6 col-lg-3">
                <div class="card home__card bg-gradient-danger">
                    <div class="card-body">
                        <h4>Total painter</h4>
                        <p><b> {{ $data->painter}} </b></p>
                    </div>
                </div>
            </div>
        
        
            <div class="col-sm-6 col-lg-3">
                <div class="card home__card bg-gradient-danger">
                    <div class="card-body">
                        <h4>Product</h4>
                        <p><b> {{$data->product}} </b></p>
                    </div>
                </div>
            </div>
          
    </div>
</section>
@endsection

@section('script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script> --}}
@endsection
