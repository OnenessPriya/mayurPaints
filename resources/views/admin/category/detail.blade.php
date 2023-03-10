@extends('admin.layouts.app')

@section('page', 'Category detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>{{ $data->name }}</h3>
                            <p class="text-muted">{{ $data->parentCatDetails->name ?? ''}}</p>
                            <p class="small">{{ $data->description }}</p>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <p class="text-muted">Image</p>
                            <img src="{{ asset($data->image) }}" alt="" style="height: 50px">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-muted">Products</h3>
                            <p>{{$data->ProductDetails->count()}} products total</p>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-center"><i class="fi fi-br-picture"></i></th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data->ProductDetails as $index => $item)
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
                                        <td class="text-center column-thumb">
                                            <img src="{{ asset($item->image) }}" />
                                        </td>
                                        <td>
                                            {{$item->name}}
                                            <div class="row__action">
                                                <a href="{{ route('admin.product.edit', $item->id) }}">Edit</a>
                                                <a href="{{ route('admin.product.view', $item->id) }}">View</a>
                                            </div>
                                        </td>
                                        <td>{!! $item->desc!!}</td>
                                        <td>
                                            {{$item->price}}
                                        </td>
                                        <td><span class="badge bg-{{($item->status == 1) ? 'success' : 'danger'}}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</span></td>
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
        </div>
    </div>
</section>
@endsection
