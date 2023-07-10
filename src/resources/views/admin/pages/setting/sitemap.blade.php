@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Sitemap', 'page_link'=>route('sitemap.get'), 'list'=>['Update']])
        <!-- end page title -->

        <div class="row" id="image-container">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Sitemap</h4>
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{asset('sitemap.xml')}}" target="_blank" type="button" class="btn btn-primary add-btn" id="create-btn">View</a>
                                <a href="{{route('sitemap.generate')}}" type="button" class="btn btn-success add-btn" id="create-btn">Re-Generate</a>
                            </div>
                        </div>
                    </div><!-- end card header -->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->



    </div> <!-- container-fluid -->
</div><!-- End Page-content -->



@stop
