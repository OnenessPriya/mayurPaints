@extends('admin.layouts.app')
@section('page', 'Notification')

@section('content')
<section>
     <div class="card card-body">
        <div class="search__filter mb-0">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <p class="small text-muted mt-1 mb-0">Showing {{$data->firstItem()}} - {{$data->lastItem()}} out of {{$data->total()}} entries</p> 
                </div>

				<div class="col-md-9 text-end">
                    <form class="row align-items-end justify-content-end" action="{{ route('admin.user.notification.index') }}">
                        <div class="col-auto">
                            <label for="dateFrom" class="small text-muted">Date from</label>
                            <input type="date" name="from" id="dateFrom" class="form-control form-control-sm" value="{{ (request()->input('from')) ? request()->input('from') : '' }}">
                        </div>
                        <div class="col-auto">
                            <label for="dateTo" class="small text-muted">Date to</label>
                            <input type="date" name="to" id="dateTo" class="form-control form-control-sm" value="{{ (request()->input('to')) ? request()->input('to') : '' }}">
                        </div>
                        {{-- <div class="col">
                            <select class="form-select form-select-sm" aria-label="Default select example"  name="user_type" id="type">
                                <option value=""  selected>Select Type</option>
									 <option value="1">VP</option>
                                     <option value="2">RSM</option>
                                    <option value="3">ASM</option>
                                    <option value="4">ASE</option>
                                    <option value="5">Distributor</option>
                                    <option value="6">Retailer</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-select form-select-sm" aria-label="Default select example" name="name" id="name" disabled>
								<option value="{{ $request->name }}">Select Name first</option>
							</select>
                        </div>--}}
                        <div class="col-auto">
                            <input type="search" name="keyword" id="keyword" class="form-control form-control-sm" placeholder="Search by keyword" value="{{app('request')->input('keyword')}}" autocomplete="off">
                        </div>
                        <div class="col-auto">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Filter
                                </button>

                                <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Clear Filter">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </a>

                                <a href="{{ route('admin.user.notification.export.csv') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Export data in CSV">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
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
				<th>Type</th>
                <th>Sender</th>
                <th>Receiver</th>
				{{-- <th>Receiver Type</th> --}}
                <th>Title</th>
                <th>Body</th>
                <th>Created At</th>
				 <th>Status</th>
				{{-- <th>Read Time</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $item)
            @php
                if (!empty($_GET['read_flag'])) {
                    if ($_GET['read_flag'] == 'read') {
                        if ($item->read_flag == 0) continue;
                    } else {
                        if ($item->read_flag == 1) continue;
                    }
                }
            @endphp
                <tr>
                <td>{{($data->firstItem()) + $index}}</td>
                    <td>
                        @if($item->type == "secondary-order-place")
                            <span class="badge bg-success">Secondary Order Place</span>
                        @elseif($item->type == "primary-order-place")
                        <span class="badge bg-danger">Primary Order Place</span>
                        @elseif($item->type == "store-add")
                            <span class="badge bg-primary">New Store Create</span>
                        @endif
                    </td>
                    <td>
                        @if($item->sender=='admin')
                            <p class="mb-0 text-danger small"><span class="text-danger">System generated</p>
                        @else
                            <p class="mb-0 text-muted small">{{$item->senderDetails->name ?? ''}}</p>
                        @endif
                    </td>
                    <td>
                        <p class="mb-0 text-muted small">{{$item->receiverDetails->name ?? ''}}</p>
                    </td>
                    <td>
                        <p class="mb-0 text-muted small">{{$item->title}}</p>
                    </td>
                    <td>
                        <p class="mb-0 text-muted small">{{$item->body}}</p>
                    </td>
                    <td>
                        <p class="mb-0 text-muted small">{{ date('j F, Y h:i A', strtotime($item->created_at)) }}</p>
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge bg-{{($item->read_flag == 1) ? 'success' : 'danger'}}">{{($item->read_flag == 1) ? 'Read' : 'Unread'}}</span>
                    </td>
                    {{-- <td>
                        <p class="mb-0 text-muted small">{{$item->read_at}}</p>
                    </td> --}}
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
    <script>
    </script>
@endsection
