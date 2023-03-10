@extends('admin.layouts.app')

@section('page', 'customer detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h3>{{ $data->name }}</h3>
                            <p class="small text-muted" style="word-break: break-all;">
                                <span class="text-dark">Work Email: </span>
                                {{$data->email}}
                            </p>
                            <p class="small text-dark"><span class="text-muted">Contact Details:</span> {{$data->mobile}}</p>
                            <p><span class="small text-dark">WhatsApp Details:</span> {{ $data->whatsapp_no }}</p>
                            <p><span class="text-muted">Address : </span> {{ $data->address }}</p>
                            <p>Published<br/>{{date('d M Y', strtotime($data->created_at))}}</p>

                        </div>
                    </div>
                    <a type="submit" href="{{ route('admin.user.customer.index') }}" class="btn btn-sm btn-danger">Back</a>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
