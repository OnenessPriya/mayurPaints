@extends('admin.layouts.app')
@section('page', 'Sales Person add')

@section('content')
<section>
    <div class="row">
        <div class="col-xl-12 order-1 order-xl-2">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.user.sales-person.store') }}" enctype="multipart/form-data">
                        @csrf
                        <h4 class="page__subtitle">Add New Sales Person</h4>
                        <div class="row">
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="form-group mb-3">
                                    <label class="label-control">Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="name" placeholder="" class="form-control" value="{{old('name')}}">
                                    @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Mobile <span class="text-danger">*</span> </label>
                                    <input type="text" name="mobile" placeholder="" class="form-control" value="{{old('mobile')}}">
                                    @error('mobile') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Whatsapp Number <span class="text-danger">*</span> </label>
                                    <input type="text" name="whatsapp_no" placeholder="" class="form-control" value="{{old('whatsapp_no')}}">
                                    @error('whatsapp_no') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Email <span class="text-danger">*</span> </label>
                                    <input type="text" name="email" placeholder="" class="form-control" value="{{old('email')}}">
                                    @error('email') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Address <span class="text-danger">*</span> </label>
                                    <input type="text" name="address" placeholder="" class="form-control" value="{{old('address')}}">
                                    @error('address') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">City <span class="text-danger">*</span> </label>
                                    <input type="text" name="city" placeholder="" class="form-control" value="{{old('city')}}">
                                    @error('city') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">State <span class="text-danger">*</span> </label>
                                    <input type="text" name="state" placeholder="" class="form-control" value="{{old('state')}}">
                                    @error('state') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Pincode <span class="text-danger">*</span> </label>
                                    <input type="text" name="pin" placeholder="" class="form-control" value="{{old('pin')}}">
                                    @error('pin') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Password <span class="text-danger">*</span> </label>
                                    <input type="password" name="password" placeholder="" class="form-control" value="{{old('password')}}">
                                    @error('password') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Confirm Password <span class="text-danger">*</span> </label>
                                    <input type="password" id="password" name="password_confirmation"  class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                                  
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="row">
                                    <div class="col-md-6 card">
                                        <div class="card-header p-0 mb-3">Image <span class="text-danger">*</span></div>
                                        <div class="card-body p-0">
                                            <div class="w-100 product__thumb">
                                                <label for="icon"><img id="iconOutput" src="{{ asset('admin/images/placeholder-image.jpg') }}" /></label>
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
                                                <label for="aadhar"><img id="sketchOutput" src="{{ asset('admin/images/placeholder-image.jpg') }}" /></label>
                                            </div>
                                            <input type="file" name="aadhar" id="aadhar" accept="image/*" onchange="loadaadhar(event)" class="d-none">
                                            <script>
                                                let loadaadhar = function(event) {
                                                    let sketchOutput = document.getElementById('sketchOutput');
                                                    sketchOutput.src = URL.createObjectURL(event.target.files[0]);
                                                    sketchOutput.onload = function() {
                                                        URL.revokeObjectURL(sketchOutput.src) // free memory
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
