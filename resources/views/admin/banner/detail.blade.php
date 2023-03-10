@extends('admin.layouts.app')
@section('page', 'Scheme detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge bg-{{($data->is_current == 1) ? 'success' : 'danger'}}">{{($data->is_current == 1) ? 'Current' : 'Past'}}</span>
                    </div>

                    <div class="w-100 mb-3">
                        <img src="{{ asset($data->image) }}" class="img-thumbnail" style="height: 200px">
                    </div>
                    <h5 class="display-6">{{ $data->title }}</h5>
                    <h5 class="display-6">{{ $data->short_desc }}</h5>
                    <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary">Back</a>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
