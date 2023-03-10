@extends('admin.layouts.app')
@section('page', 'Scheme')

@section('content')
<section>
    <div class="card card-body">
        <div class="search__filter mb-0">
            <div class="row align-items-center">
                <div class="col-12 text-end mb-3">
                    <a href="{{ route('admin.banner.create') }}" class="btn btn-danger btn-sm">
                        Create New Banner
                    </a>
                </div>
                <div class="col-md-3">
                    <p class="small text-muted mt-1 mb-0">Showing {{$data->firstItem()}} - {{$data->lastItem()}} out of {{$data->total()}} Entries</p>
                </div>

                <div class="col-md-9 text-end">
                    <form class="row align-items-end justify-content-end" action="" method="GET">
                        <div class="col-auto">
                            <label for="term" class="text-muted small">Keyword</label>
                            <input type="text" name="term" id="term" class="form-control form-control-sm" aria-label="Default select example" value="{{ (request()->input('term')) ? request()->input('term') : '' }}">
                        </div>
                        <div class="col-auto">
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

    <table class="table">
        <thead>
            <tr>
                <th>#SR</th>
                <th>Image</th>
                <th>Title</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $item)
                <tr>
                    <td>{{ $index + $data->firstItem() }}</td>
                    <td>
                        <img src="{{ asset($item->image) }}" style="height: 80px;">
                    </td>
                    <td>
                        <p class="text-dark mb-0">{{$item->title}}</p>
                        <div class="row__action">
                            <a href="{{ route('admin.banner.edit', $item->id) }}">Edit</a>
                            <a href="{{ route('admin.banner.view', $item->id) }}">View</a>
                            <a href="{{ route('admin.banner.delete', $item->id) }}" class="text-danger">Delete</a>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-{{($item->is_current == 1) ? 'success' : 'danger'}}">{{($item->is_current == 1) ? 'Current' : 'Past'}}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        {{$data->appends($_GET)->links()}}
    </div>

</section>
@endsection

@section('script')
<script>

</script>
@endsection
