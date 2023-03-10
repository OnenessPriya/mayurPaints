@extends('admin.app')

@section('page', 'Settings detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted small mb-1">Page</p>
                            <p class="text-dark small">{{strtoupper($contact->key)}}</p>
                            <p class="text-muted small mb-1">Name</p>
                            <p class="text-dark small">{{strtoupper($contact->pretty_name)}}</p>
                            <p class="text-muted small mb-1">Content</p>
                            <p class="text-dark small">{!! $contact->content !!}</p>
                            <p class="text-muted small mb-1">Banner Image</p>
                            <p class="text-dark small">@if($contact->banner_image!='')
                                <img style="width: 100px;height: 100px;" src="{{URL::to('/').'/ContactusBanner/'}}{{$contact->banner_image}}">
                                @endif</p>
                            <p class="text-muted small mb-1">Image Field</p>
                            <p class="text-dark small">@if($contact->image!='')
                                <img style="width: 70px;height: 70px;" src="{{URL::to('/').'/Contactus/'}}{{$contact->image}}">
                                @endif</p>
                        </div>
                    </div>

                </div>
            </div>
            <a class="btn btn-secondary" href="{{ route('admin.contact-us.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
        </div>


    </div>
</section>
@endsection
