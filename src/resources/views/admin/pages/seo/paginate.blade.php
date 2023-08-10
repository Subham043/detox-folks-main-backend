@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Seo', 'page_link'=>route('seo.paginate.get'), 'list'=>['List']])
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Seo</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                </div>
                                <div class="col-sm">
                                    @include('admin.includes.search_list', ['link'=>route('seo.paginate.get'), 'search'=>$search])
                                </div>
                            </div>
                            <div class="table-responsive table-card mt-3 mb-1">
                                @if($data->total() > 0)
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Page Name</th>
                                            <th class="sort" data-sort="customer_name">Meta Title</th>
                                            <th class="sort" data-sort="customer_name">Meta Keywords</th>
                                            <th class="sort" data-sort="customer_name">Meta Description</th>
                                            <th class="sort" data-sort="date">Updated On</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($data->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{$item->page_name}}</td>
                                            <td class="customer_name">{{ Str::limit($item->meta_title, 20) }}</td>
                                            <td class="customer_name">{{ Str::limit($item->meta_keywords, 20) }}</td>
                                            <td class="customer_name">{{ Str::limit($item->meta_description, 20) }}</td>
                                            <td class="date">{{$item->updated_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @can('edit pages seo')
                                                    <div class="edit">
                                                        <a href="{{route('seo.update.get', $item->slug)}}" class="btn btn-sm btn-primary edit-item-btn">Edit</a>
                                                    </div>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @else
                                    @include('admin.includes.no_result')
                                @endif
                            </div>
                            {{$data->onEachSide(5)->links('admin.includes.pagination')}}
                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
</div>

@stop
