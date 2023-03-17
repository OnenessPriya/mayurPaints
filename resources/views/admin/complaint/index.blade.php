@extends('admin.layouts.app')
@section('page', 'Complaint')

@section('content')
<section>
    <div class="card card-body">
        <div class="search__filter mb-0">
            <div class="row">
                <div class="col-md-3">
                    <p class="text-muted mt-1 mb-0">Showing {{$data->count()}} out of {{$data->total()}} Entries</p>
                </div>
                <div class="col-md-9 text-end">
                    <form class="row align-items-end" action="{{ route('admin.complaint.index') }}">
                        <div class="col">
                            <input type="search" name="term" id="term" class="form-control form-control-sm" placeholder="Search by  name." value="{{app('request')->input('term')}}" autocomplete="off">
                        </div>
                        <div class="col">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Filter
                                </button>

                                <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Clear Filter">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
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
                <th>Name</th>
                <th>User Type</th>
                <th>Mobile</th>
                <th>Whatsapp No</th>
            </tr>
        </thead>
        <tbody>
                @forelse ($data as $index => $item)
               
            <tr>
                <td>{{($data->firstItem()) + $index}}</td>
                <td>
                    {{$item->name}}
                    <div class="row__action">
                        <a href="{{ route('admin.complaint.view', $item->id) }}">View</a>
                    </div>
                </td>
                <td>
                    {{-- {{dd($item->userDetails )}} --}}
                    @if(!empty($item->user))
                    @if($item->user->type==1)<span class="badge bg-success">Painter </span>
                    @elseif($item->user->type==2)<span class="badge bg-danger">Sales Person </span>
                    @elseif($item->user->type==3)<span class="badge bg-primary">Customer </span>
                    @endif
                    @endif
                </td>
                <td>
					 {{$item->mobile}}
                </td>
                <td> {{$item->whatsapp_no}}</td>
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
