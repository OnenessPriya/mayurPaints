@extends('admin.layouts.app')

@section('page', 'Product detail')

@section('content')
<section>
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
                            <h5 class="text-muted">{{$data->name}}</h5>
                        </div>

                                  <hr>
                        <div class="form-group mb-3">
                            <h4>
                                <span class="text-muted small"> {{$data->points}}</span>
                            </h4>
                        </div>
                        <hr>
                        <div class="form-group mb-3">
                            <p class="small">Short Description</p>
                            {!! $data->short_desc !!}
                        </div>
                        <div class="form-group mb-3">
                            <p class="small">Description</p>
                            {!! $data->desc !!}
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@section('script')
@endsection