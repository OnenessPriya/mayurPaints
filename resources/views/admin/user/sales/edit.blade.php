@extends('admin.layouts.app')
@section('page', 'Sales Person add')

@section('content')
<section>
    <div class="row">
        <div class="col-xl-12 order-1 order-xl-2">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.user.sales-person.update',$data->id) }}" enctype="multipart/form-data">
                        @csrf
                        <h4 class="page__subtitle">Edit New Sales Person</h4>
                        <div class="row">
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="form-group mb-3">
                                    <label class="label-control">Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="name" placeholder="" class="form-control" value="{{old('name',$data->name)}}">
                                    @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Mobile <span class="text-danger">*</span> </label>
                                    <input type="text" name="mobile" placeholder="" class="form-control" value="{{old('mobile',$data->mobile)}}">
                                    @error('mobile') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Whatsapp Number <span class="text-danger">*</span> </label>
                                    <input type="text" name="whatsapp_no" placeholder="" class="form-control" value="{{old('whatsapp_no',$data->whatsapp_no)}}">
                                    @error('whatsapp_no') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Email <span class="text-danger">*</span> </label>
                                    <input type="text" name="email" placeholder="" class="form-control" value="{{old('email',$data->email)}}">
                                    @error('email') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Address <span class="text-danger">*</span> </label>
                                    <input type="text" name="address" placeholder="" class="form-control" value="{{old('address',$data->address)}}">
                                    @error('address') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">City <span class="text-danger">*</span> </label>
                                    <input type="text" name="city" placeholder="" class="form-control" value="{{old('city',$data->city)}}">
                                    @error('city') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">State <span class="text-danger">*</span> </label>
                                    <input type="text" name="state" placeholder="" class="form-control" value="{{old('state',$data->state)}}">
                                    @error('state') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Pincode <span class="text-danger">*</span> </label>
                                    <input type="text" name="pin" placeholder="" class="form-control" value="{{old('pin',$data->pin)}}">
                                    @error('pin') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="row">
                                    <div class="col-md-6 card">
                                        <div class="card-header p-0 mb-3">Image <span class="text-danger">*</span></div>
                                        <div class="card-body p-0">
                                            <div class="w-100 product__thumb">
                                                <label for="icon"><img id="iconOutput" src="{{ asset($data->image) }}" /></label>
                                            </div>
                                            <input type="file" name="image" id="icon" accept="image/*" onchange="loadIcon(event)" class="d-none">
                                            <script>
                                                let loadIcon = function(event) {
                                                    let iconOutput = document.getElementById('iconOutput');
                                                    iconOutput.src = URL.createObjectURL(event.target.files[0]);
                                                    iconOutput.onload = function() {
                                                        URL.revokeObjectURL(iconOutput.src) // free memory
                                                    }
                                                };
                                            </script>
                                        </div>
                                        @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="col-md-6 card">
                                        <div class="card-header p-0 mb-3">Document <span class="text-danger">*</span></div>
                                        <div class="card-body p-0">
                                            <div class="w-100 product__thumb">
                                                <label for="icon"><img id="iconOutput" src="{{ asset($data->aadhar) }}" /></label>
                                            </div>
                                            <input type="file" name="aadhar" id="icon" accept="image/*" onchange="loadIcon(event)" class="d-none">
                                            <script>
                                                let loadIcon = function(event) {
                                                    let iconOutput = document.getElementById('iconOutput');
                                                    iconOutput.src = URL.createObjectURL(event.target.files[0]);
                                                    iconOutput.onload = function() {
                                                        URL.revokeObjectURL(iconOutput.src) // free memory
                                                    }
                                                };
                                            </script>
                                        </div>
                                        @error('aadhar') <p class="small text-danger">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-danger">Save</button>
                            </div>
                        </div>
                    </form>
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
