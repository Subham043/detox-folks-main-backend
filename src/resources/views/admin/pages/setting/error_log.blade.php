@extends('admin.layouts.dashboard')

@section('css')
  {{-- <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"> --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/error_log/css/dataTables.bootstrap4.min.css') }}">
  <style nonce="{{ csp_nonce() }}">

    h1 {
      font-size: 1.5em;
      margin-top: 0;
    }

    #table-log {
        font-size: 0.85rem;
    }

    .sidebar {
        font-size: 0.85rem;
        line-height: 1;
    }

    .btn {
        font-size: 0.7rem;
    }

    .stack {
      font-size: 0.85em;
    }

    .date {
      min-width: 75px;
    }

    .text {
      word-break: break-all;
    }

    a.llv-active {
      z-index: 2;
      background-color: #f5f5f5;
      border-color: #777;
    }

    .list-group-item {
      word-break: break-word;
    }

    .folder {
      padding-top: 15px;
    }

    .div-scroll {
      height: 80vh;
      overflow: hidden auto;
    }
    .nowrap {
      white-space: nowrap;
    }
    .list-group {
            padding: 5px;
        }




    /**
    * DARK MODE CSS
    */

    body[data-theme="dark"] {
      background-color: #151515;
      color: #cccccc;
    }

    [data-theme="dark"] a {
      color: #4da3ff;
    }

    [data-theme="dark"] a:hover {
      color: #a8d2ff;
    }

    [data-theme="dark"] .list-group-item {
      background-color: #1d1d1d;
      border-color: #444;
    }

    [data-theme="dark"] a.llv-active {
        background-color: #0468d2;
        border-color: rgba(255, 255, 255, 0.125);
        color: #ffffff;
    }

    [data-theme="dark"] a.list-group-item:focus, [data-theme="dark"] a.list-group-item:hover {
      background-color: #273a4e;
      border-color: rgba(255, 255, 255, 0.125);
      color: #ffffff;
    }

    [data-theme="dark"] .table td, [data-theme="dark"] .table th,[data-theme="dark"] .table thead th {
      border-color:#616161;
    }

    [data-theme="dark"] .page-item.disabled .page-link {
      color: #8a8a8a;
      background-color: #151515;
      border-color: #5a5a5a;
    }

    [data-theme="dark"] .page-link {
      background-color: #151515;
      border-color: #5a5a5a;
    }

    [data-theme="dark"] .page-item.active .page-link {
      color: #fff;
      background-color: #0568d2;
      border-color: #007bff;
    }

    [data-theme="dark"] .page-link:hover {
      color: #ffffff;
      background-color: #0051a9;
      border-color: #0568d2;
    }

    [data-theme="dark"] .form-control {
      border: 1px solid #464646;
      background-color: #151515;
      color: #bfbfbf;
    }

    [data-theme="dark"] .form-control:focus {
      color: #bfbfbf;
      background-color: #212121;
      border-color: #4a4a4a;
  }

  .no-display-wrap{
    display: none; white-space: pre-wrap;
  }

  </style>

@stop


@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row project-wrapper">
            <div class="col-xxl-12">
                <div class="card card-height-100">

                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Application Error Logs</h4>
                        <div class="flex-shrink-0">
                            <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0 gap-2" role="tablist">
                                <li class="dropdown">
                                    <a href="#" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Available Log Files
                                    </a>
                                    <div class="dropdown-menu">
                                        @foreach($files as $file)
                                            <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                                                class="dropdown-item @if ($current_file == $file) active @endif">
                                                {{$file}}
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                                @if($current_file)
                                    <li class="nav-item" role="presentation">
                                        <a type="button" href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}" class="btn btn-success btn-label">
                                            <i class="ri-file-download-line label-icon align-middle fs-16 me-2"></i> Download file
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a type="button" href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}" class="btn btn-primary btn-label">
                                            <i class="ri-file-damage-fill label-icon align-middle fs-16 me-2"></i> Clean file
                                        </a>
                                    </li>

                                    <li class="nav-item ml-2" role="presentation">
                                        <a type="button" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}" class="btn btn-danger btn-label">
                                            <i class="ri-delete-bin-line label-icon align-middle fs-16 me-2"></i> Delete file
                                        </a>
                                    </li>
                                    @if(count($files) > 1)
                                        <li class="nav-item ml-2" role="presentation">
                                            <a type="button" href="?delall=true{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}" class="btn btn-dark btn-label">
                                                <i class="ri-delete-bin-3-fill label-icon align-middle fs-16 me-2"></i> Delete all file
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            </ul><!-- end ul -->
                        </div>
                    </div>

                    <div class="card-body px-0">
                        <div class="row">
                        {{-- <div class="col sidebar mb-3">
                                <h1><i class="fa fa-calendar" aria-hidden="true"></i> Laravel Log Viewer</h1>
                                <p class="text-muted"><i>by Rap2h</i></p>

                                <div class="custom-control custom-switch" style="padding-bottom:20px;">
                                    <input type="checkbox" class="custom-control-input" id="darkSwitch">
                                    <label class="custom-control-label" for="darkSwitch" style="margin-top: 6px;">Dark Mode</label>
                                </div>

                                <div class="list-group div-scroll">
                                    @foreach($folders as $folder)
                                        <div class="list-group-item">
                                            <?php
                                            \Rap2hpoutre\LaravelLogViewer\LaravelLogViewer::DirectoryTreeStructure( $storage_path, $structure );
                                            ?>

                                        </div>
                                    @endforeach
                                    @foreach($files as $file)
                                        <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                                            class="list-group-item @if ($current_file == $file) llv-active @endif">
                                            {{$file}}
                                        </a>
                                    @endforeach
                                </div>
                            </div> --}}
                            <div class="col-12 table-container">
                                @if ($logs === null)
                                    <div>
                                    Log file >50M, please download it.
                                    </div>
                                @else
                                    <table id="table-log" class="table table-striped" data-ordering-index="{{ $standardFormat ? 2 : 0 }}">
                                        <thead>
                                            <tr>
                                                @if ($standardFormat)
                                                    <th>Level</th>
                                                    <th>Context</th>
                                                    <th>Date</th>
                                                @else
                                                    <th>Line number</th>
                                                @endif
                                                    <th>Content</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($logs as $key => $log)
                                                <tr data-display="stack{{{$key}}}">
                                                @if ($standardFormat)
                                                    <td class="nowrap text-{{{$log['level_class']}}}">
                                                    <span class="fa fa-{{{$log['level_img']}}}" aria-hidden="true"></span>&nbsp;&nbsp;{{$log['level']}}
                                                    </td>
                                                    <td class="text">{{$log['context']}}</td>
                                                @endif
                                                <td class="date">{{{$log['date']}}}</td>
                                                <td class="text">
                                                    {{{$log['text']}}}

                                                    @if (isset($log['in_file']))
                                                    <br/>{{{$log['in_file']}}}
                                                    @endif
                                                    @if ($log['stack'])
                                                    <div class="stack no-display-wrap" id="stack{{{$key}}}"
                                                        >{{{ trim($log['stack']) }}}
                                                    </div>
                                                    @endif
                                                    @if ($log['stack'])
                                                    <button type="button"
                                                            class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2"
                                                            data-display="stack{{{$key}}}">
                                                        <span class="ri-search-eye-line"></span>
                                                    </button>
                                                    @endif
                                                </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')

<!-- Datatables -->
<script src="{{ asset('admin/error_log/js/jquery.js') }}"></script>
<script src="{{ asset('admin/error_log/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/error_log/js/dataTables.bootstrap4.min.js') }}"></script>

<script nonce="{{ csp_nonce() }}">



  $(document).ready(function () {
    $('.table-container tr').on('click', function () {
      $('#' + $(this).data('display')).toggle();
    });
    $('#table-log').DataTable({
      "order": [$('#table-log').data('orderingIndex'), 'desc'],
      "stateSave": true,
      "stateSaveCallback": function (settings, data) {
        window.localStorage.setItem("datatable", JSON.stringify(data));
      },
      "stateLoadCallback": function (settings) {
        var data = JSON.parse(window.localStorage.getItem("datatable"));
        if (data) data.start = 0;
        return data;
      }
    });
    $('#delete-log, #clean-log, #delete-all-log').click(function () {
      return confirm('Are you sure?');
    });
  });
</script>
@stop
