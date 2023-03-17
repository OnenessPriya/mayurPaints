@extends('admin.layouts.app')

@section('page', 'About us')

@section('content')
<section>
    <div class="row">
        <div class="col-md-6">
            <h1><i class="fa fa-file"></i></h1>
            <p></p>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="example5">
                        <thead>
                            <tr>

                                <th>Name</th>
                                <th>Content</th>
                                <th>Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($about as $index => $item)
                            <tr>
                                <td>
                                    {{strtoupper($item->pretty_name)}}
                                    <div class="row__action">
                                        <a href="{{ route('admin.about.view', $item->id) }}">Edit</a>
                                        <a href="{{ route('admin.about.view', $item->id) }}">View</a>
                                    </div>
                                </td>
                                <td>
                                    {{$item->content}}
                                </td>
                                <td>Published<br/>{{date('d M Y', strtotime($item->created_at))}}</td>
                               
                            </tr>
                            @empty
                            <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
     {{-- New Add --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
  
    
@endpush
