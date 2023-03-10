@extends('admin.layouts.app')
@section('page', 'Products')

@section('content')
<section>
    <div class="card card-body">
        <div class="search__filter mb-0">
            <div class="row">
                <div class="col-md-3">
                    <p class="text-muted mt-1 mb-0">Showing {{$data->count()}} out of {{$data->total()}} Entries</p>
                </div>
                <div class="col-md-9 text-end">
                    <form class="row align-items-end" action="{{ route('admin.product.index') }}">
                        <div class="col">
                            <select class="form-select form-select-sm" aria-label="Default select example" name="cat_id" id="category">
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($category as $cat)
                                    <option value="{{$cat->id}}" {{request()->input('cat_id') == $cat->name ? 'selected' : ''}}> {{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <input type="search" name="keyword" id="term" class="form-control form-control-sm" placeholder="Search by name." value="{{app('request')->input('keyword')}}" autocomplete="off">
                        </div>
                        <div class="col">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Filter
                                </button>

                                <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Clear Filter">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </a>

                                <a href="{{ route('admin.product.export.csv',['cat_id'=>$request->cat_id,'keyword'=>$request->keyword]) }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Export data in CSV">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                    CSV
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table" id="example5">
        <thead>
            <tr>
                <th>#SR</th>
                <th class="text-center"><i class="fi fi-br-picture"></i></th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
                @forelse ($data as $index => $item)
                @php
                    if (!empty($_GET['status'])) {
                        if ($_GET['status'] == 'active') {
                            if ($item->status == 0) continue;
                        } else {
                            if ($item->status == 1) continue;
                        }
                    }
                @endphp
            <tr>
                <td>{{($data->firstItem()) + $index}}</td>
                 @if($item->image == "uploads/product/polo_tshirt_front.png" ||
                                                    !file_exists($item->image))
					 <td class="text-center column-thumb">
						<img src="{{asset('img/default-placeholder-product-image.png')}}" />
					</td>
                
                @else
				   <td class="text-center column-thumb">
						<img src="{{asset($item->image)}}" />
					</td>
                @endif
                <td>
                    {{$item->name}}
                    <div class="row__action">
                        <a href="{{ route('admin.product.edit', $item->id) }}">Edit</a>
                        <a href="{{ route('admin.product.view', $item->id) }}">View</a>
                        <a href="{{ route('admin.product.status', $item->id) }}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</a>
                        <a href="{{ route('admin.product.delete', $item->id) }}" class="text-danger">Delete</a>
                    </div>
                </td>
                <td>
                    <a href="{{ route('admin.category.view', $item->category->id) }}">{{$item->category ? $item->category->name : ''}}</a>
                </td>
                <td>
					Rs. {{$item->price}}
                </td>
                <td><span class="badge bg-{{($item->status == 1) ? 'success' : 'danger'}}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</span></td>
            </tr>
            @empty
            <tr><td colspan="100%" class="small text-muted text-center">No data found</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        {{ $data->appends($_GET)->links() }}
    </div>
</section>
@endsection
@section('script')
    
@endsection
