@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">
        @include('errors.admin.includes.error_content', ['exception'=> $exception])
    </div>
</div>


@stop
