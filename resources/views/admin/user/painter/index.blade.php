@extends('admin.layouts.app')

@section('page', 'Painter')

@section('content')
<style>
    .badge.bg-success {
        background-color: #8bc34a !important;
    }
    .badge.bg-warning {
        background-color: #ffc107 !important;
    }
    .badge.bg-danger {
        color: #fff;
        background-color: #ff4a21 !important;
    }
</style>

<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="search__filter">
                        <div class="row align-items-center justify-content-between">
                            <div class="col">
                                <ul>
                                    <li class="active"><a href="{{ route('admin.user.painter.index') }}">All <span class="count">({{$data->count()}})</span></a></li>
                                    @php
                                    $activeCount = $inactiveCount = 0;
                                    foreach ($data as $catKey => $catVal) {
                                    if ($catVal->is_approve == 1) $activeCount++;
                                    else $inactiveCount++;
                                    }
                                    @endphp
                                    <li><a href="{{ route('admin.user.painter.index')}}">Verified <span class="count">({{$activeCount}})</span></a></li>
                                    <li><a href="{{ route('admin.user.painter.index')}}">Not Verified <span class="count">({{$inactiveCount}})</span></a></li>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <form action="{{ route('admin.user.painter.index') }}" method="GET">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <input type="search" name="term" class="form-control" placeholder="Search here.." id="term" value="{{ request()->input('term') }}" autocomplete="off">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Filter</button>
                                            <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Clear Filter">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                            <div class="col-auto">
                            <a href="{{ route('admin.user.painter.export.all',['term'=>$request->term]) }}"  class="btn btn-outline-danger btn-sm float-right"><i class="fa fa-cloud-download"></i> CSV Export</a>
                            </div>
                        </div>
                    </div>
                    <table class="table" id="example5">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Contact</th>
                                <th>WhatsApp</th>
                                {{-- <th>Status</th> --}}
                                <th>Account Verification</th>
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
                                <td>
                                    {{$item->name}}
                                    <div class="row__action">
                                        <a href="{{ route('admin.user.painter.view', $item->id) }}">View</a>
                                        {{-- <a href="{{ route('admin.user.painter.status', $item->id) }}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</a> --}}
                                        <a href="{{ route('admin.user.painter.delete', $item->id) }}" class="text-danger">Delete</a>
                                        <a href="{{ route('admin.user.painter.verification', $item->id) }}">{{($item->is_approve == 1) ? 'Verified' : 'Not verified'}}</a>
                                    </div>
                                </td>
                                <td>
                                   Painter
                                </td>
                                <td>{{ $item->mobile }} <br> {{ $item->email }}</td>
                                <td>{{ $item->whatsapp_no }}</td>
                                {{-- <td><span class="badge bg-{{($item->status == 1) ? 'success' : 'danger'}}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</span></td> --}}
                                <td><span class="badge bg-{{($item->is_approve == 1) ? 'success' : 'danger'}}">{{($item->is_approve == 1) ? 'Verified' : 'Not verified'}}</span></td>
                            </tr>
                            @empty
                                <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end">
                        {{ $data->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
@section('script')

@endsection
