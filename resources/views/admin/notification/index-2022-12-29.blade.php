@extends('admin.layouts.app')
@section('page', 'Notification')

@section('content')
<section>
     <div class="card card-body">
        <div class="search__filter mb-0">
            <div class="row">
                <div class="col-md-3">
                    <p class="text-muted mt-1 mb-0">Showing {{$data->count()}} out of {{$data->total()}} Notification</p> 
                </div>
                
				
				<div class="col-md-9 text-end">
                    <form class="row align-items-end" action="{{ route('admin.user.notification.index') }}">
						 <div class="col">
                                        <label for="dateFrom"><h5 class="small text-muted mb-0">Date from</h5></label>
                                        <input type="date" name="from" id="dateFrom" class="form-control form-control-sm" value="{{ (request()->input('from')) ? request()->input('from') : '' }}">
                                    </div>
                                    <div class="col">
                                        <label for="dateTo"><h5 class="small text-muted mb-0">Date to</h5></label>
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
                        <div class="col">
                            <input type="search" name="keyword" id="keyword" class="form-control form-control-sm" placeholder="Search by keyword" value="{{app('request')->input('keyword')}}" autocomplete="off">
                        </div>
                        <div class="col">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg> -->
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
		 <div class="col-12">
				@if (request()->input('from') || request()->input('to'))
					<p class="text-dark">Notification from <strong>{{ date('j F, Y', strtotime(request()->input('from'))) }}</strong> - <strong>{{ date('j F, Y', strtotime(request()->input('to'))) }}</strong></p>
				@else
					<p class="text-dark">Notification from <strong>{{date('01 F, Y')}}</strong> to <strong>{{date('j F, Y')}}</strong></p>
				@endif
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
				<th>Read Time</th>
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
               {{-- <td>{{($data->firstItem()) + $index}}</td> --}}
				<td>{{$index+1}}</td> 
				<td>
					@if($item->type == "secondary-order-place")
					<span class="badge bg-success">Secondary Order Place</span>
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
				{{-- <td>
					@if($item->receiverDetails ? $item->receiverDetails->user_type ==1 : '') <span class="badge bg-success">VP </span>
					@elseif($item->receiverDetails ? $item->receiverDetails->user_type ==2 : '') <span class="badge bg-danger">RSM </span>
					@elseif($item->receiverDetails ? $item->receiverDetails->user_type ==3 : '') <span class="badge bg-primary">ASM </span>
					@elseif ($item->receiverDetails ? $item->receiverDetails->user_type ==4 : '')<span class="badge bg-secondary">RSE </span>
					@elseif ($item->receiverDetails ? $item->receiverDetails->user_type==5 : '')<span class="badge bg-warning text-dark">Distributor</span>
					@elseif ($item->receiverDetails ? $item->receiverDetails->user_type ==6 : '')<span class="badge bg-dark">Retailer </span>
					@endif
				</td> --}}
				
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
				<td>
                    <p class="mb-0 text-muted small">{{$item->read_at}}</p>
                </td>
                
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
		$('select[id="collection"]').on('change', (event) => {
			var value = $('select[id="collection"]').val();

			$.ajax({
				url: '{{url("/")}}/api/category/product/collection/'+value,
                method: 'GET',
                success: function(result) {
					var content = '';
					var slectTag = 'select[id="category"]';
					var displayCollection = (result.data.collection_name == "all") ? "All category" : "All "+result.data.collection_name+" categories";

					content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.category, (key, value) => {
						content += '<option value="'+value.cat_id+'">'+value.cat_name+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});
    </script>
    <script>
    function htmlToCSV() {
        var data = [];
        var rows = document.querySelectorAll("#example5 tbody tr");
        @php
            if (!request()->input('page')) {
                $page = '1';
            } else {
                $page = request()->input('page');
            }
        @endphp

        var page = "{{ $page }}";

        data.push("SRNO,,Name,StyleNo,Range,Category,Price,CreatedDate,Status");

        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].querySelectorAll("td");

            for (var j = 0; j < cols.length ; j++) {

                var text = cols[j].innerText.split(' ');
                var new_text = text.join('-');
                if (j == 3||j==5)
                    var comtext = new_text.replace(/\n/g, "-");
                else
                    var comtext = new_text.replace(/\n/g, " ");
                row.push(comtext);

            }
            data.push(row.join(","));

        }

        downloadCSVFile(data.join("\n"), 'Product-{{date("Y-m-d")}}.csv');
    }

    function downloadCSVFile(csv, filename) {
        var csv_file, download_link;

        csv_file = new Blob([csv], {
            type: "text/csv"
        });

        download_link = document.createElement("a");

        download_link.download = filename;

        download_link.href = window.URL.createObjectURL(csv_file);

        download_link.style.display = "none";

        document.body.appendChild(download_link);

        download_link.click();
    }


</script>
 @if (request()->input('export_all') == true)
                <script>
                    htmlToCSV();
                    window.location.href = "{{ route('admin.product.index') }}";
                </script>
            @endif


 <script>
         $('select[id="type"]').on('change', (event) => {
			var value = $('select[id="type"]').val();
            console.log(value);
			$.ajax({
				url: '{{url("/")}}/type-wise-name/'+value,
                method: 'GET',
                success: function(result) {
					var content = '';
					var slectTag = 'select[id="name"]';
					  var displayCollection = (result.data.type == "all") ? "All " : "All "+" name";
                      console.log(result.data.area);
					 content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.name, (key, value) => {
						content += '<option value="'+value.id+'">'+value.name+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});
    </script>
@endsection
