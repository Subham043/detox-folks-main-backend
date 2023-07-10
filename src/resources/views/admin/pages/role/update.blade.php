@extends('admin.layouts.dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @can('list permissions')
        @include('admin.includes.breadcrumb', ['page'=>'Roles', 'page_link'=>route('role.paginate.get'), 'list'=>['Create']])
        @endcan
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('role.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('role.update.post', $data->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Roles Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>old('name') ? old('name') : $data->name])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.select_multiple', ['key'=>'permissions', 'label'=>'Permissions'])
                                    </div>

                                    <div class="col-xxl-12 col-md-12">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitBtn">Update</button>
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <!--end col-->
        </div>
        <!--end row-->



    </div> <!-- container-fluid -->
</div><!-- End Page-content -->



@stop


@section('javascript')
<script src="{{ asset('admin/js/pages/choices.min.js') }}"></script>

<script type="text/javascript" nonce="{{ csp_nonce() }}">

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
  .addField('#name', [
    {
      rule: 'required',
      errorMessage: 'Name is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Name is invalid',
    },
  ])
  .addField('#permissions', [
    {
      rule: 'required',
      errorMessage: 'Please select atleast one permissions',
    },
  ])
  .onSuccess(async (event) => {
    event.target.submit();
  });

  const permissionChoice = new Choices('#permissions', {
        choices: [
            @foreach($permissions as $val)
                {
                    value: '{{$val->name}}',
                    label: '{{$val->name}}',
                    selected: {{(in_array($val->name, $role_permissions)) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a permissions',
        ...CHOICE_CONFIG
    });
</script>

@stop
