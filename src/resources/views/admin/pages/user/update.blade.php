@extends('admin.layouts.dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @can('list users')
        @include('admin.includes.breadcrumb', ['page'=>'User', 'page_link'=>route('user.paginate.get'), 'list'=>['Create']])
        @endcan
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('user.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('user.update.post', $data->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">User Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>old('name') ? old('name') : $data->name])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'email', 'label'=>'Email', 'value'=>old('email') ? old('email') : $data->email])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'phone', 'label'=>'Phone', 'value'=>old('phone') ? old('phone') : $data->phone])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.select', ['key'=>'role', 'label'=>'Role'])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.password_input', ['key'=>'password', 'label'=>'Password', 'value'=>''])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.password_input', ['key'=>'password_confirmation', 'label'=>'Confirm Password', 'value'=>''])
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
  .addField('#email', [
    {
        rule: 'required',
        errorMessage: 'Email is required',
    },
    {
        rule: 'email',
        errorMessage: 'Email is invalid!',
    },
  ])
  .addField('#phone', [
    {
        rule: 'required',
        errorMessage: 'Phone is required',
    },
  ])
  .addField('#role', [
    {
      rule: 'required',
      errorMessage: 'Please select a role',
    },
  ])
  .addField('#password', [
    {
      rule: 'strongPassword',
    }
  ])
  .onSuccess(async (event) => {
    event.target.submit();
  });

  const categoryChoice = new Choices('#role', {
        choices: [
            {
                value: '',
                label: 'Select a role',
                selected: {{empty(old('role')) || count($user_roles)==0 ? 'true' : 'false'}},
                disabled: true,
            },
            @foreach($roles as $val)
                {
                    value: '{{$val->name}}',
                    label: '{{$val->name}}',
                    selected: {{(in_array($val->name, $user_roles)) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a role',
        ...CHOICE_CONFIG
    });
</script>

@stop
