@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Activity Logs', 'page_link'=>route('activity_log.paginate.get'), 'list'=>['Detail']])
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <div id="customerList">
                            @include('admin.includes.back_button', ['link'=>route('activity_log.paginate.get')])

                            <div class="text-muted">
                                <div class="pt-3 pb-3 border-top border-top-dashed border-bottom border-bottom-dashed mt-4">
                                    <div class="row">

                                        <div class="col-lg-3 col-sm-6">
                                            <div>
                                                <p class="mb-2 text-uppercase fw-medium fs-13">Log Name :</p>
                                                <h5 class="fs-15 mb-0 text-capitalize">{{$data->log_name}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div>
                                                <p class="mb-2 text-uppercase fw-medium fs-13">Log Event :</p>
                                                <h5 class="fs-15 mb-0 text-capitalize">{{$data->event}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div>
                                                <p class="mb-2 text-uppercase fw-medium fs-13">Performed By :</p>
                                                <h5 class="fs-15 mb-0 text-capitalize">{{$data->causer->name}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div>
                                                <p class="mb-2 text-uppercase fw-medium fs-13">Performed :</p>
                                                <h5 class="fs-15 mb-0 text-capitalize">{{$data->created_at->diffForHumans()}}</h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="pb-3 border-bottom border-bottom-dashed mt-4">
                                    <div class="row">

                                        <div class="col-lg-12 col-sm-12">
                                            <div>
                                                <p class="mb-2 text-uppercase fw-medium fs-13">Log Description :</p>
                                                <h5 class="fs-15 mb-0 text-capitalize">{{$data->description}}</h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="pb-3 border-bottom border-bottom-dashed mt-4">
                                    <div class="row">

                                        <div class="col-lg-12 col-sm-12">
                                            <div>
                                                <p class="mb-2 text-uppercase fw-medium fs-13">Attributes Affected :</p>
                                                <h5 class="fs-15 mb-0">
                                                    <br/>
                                                    <ul>
                                                        @foreach($data->properties as $k=>$v)
                                                        <li>
                                                                <span class="badge badge-soft-dark text-uppercase">{{$k}}</span>
                                                                <br/>
                                                                <br/>
                                                                @if(gettype($v)=='array')
                                                                    @foreach($v as $key=>$val)
                                                                        <div class="px-3">
                                                                            <span class="badge badge-soft-primary text-uppercase">{{$key}}</span> : {{$val}}
                                                                            <br/>
                                                                            <br/>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                                <br/>
                                                                <br/>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@stop
