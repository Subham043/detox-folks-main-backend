@extends('admin.layouts.auth')



@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Reset Password !</h5>
                    <p class="text-muted">Enter the following details to reset password.</p>
                </div>
                <div class="p-2 mt-4">
                    <form id="loginForm" method="post" action="{{Request::getRequestUri()}}">
                    @csrf

                        <div class="mb-3">
                            @include('admin.includes.input', ['key'=>'email', 'label'=>'Email', 'value'=>old('email')])
                        </div>

                        <div class="mb-3">
                            @include('admin.includes.password_input', ['key'=>'password', 'label'=>'Password', 'value'=>''])
                        </div>

                        <div class="mb-3">
                            @include('admin.includes.password_input', ['key'=>'password_confirmation', 'label'=>'Confirm Password', 'value'=>''])
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-success w-100" type="submit">Reset</button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

    </div>
</div>

@stop

@section('javascript')
<script type="text/javascript" nonce="{{ csp_nonce() }}">

// initialize the validation library
const validation = new JustValidate('#loginForm', {
      errorFieldCssClass: 'is-invalid',
      focusInvalidField: true,
        lockForm: true,
});
// apply rules to form fields
validation
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
  .addField('#password', [
    {
      rule: 'required',
      errorMessage: 'Password is required',
    }
  ])
  .addField('#password_confirmation', [
    {
      rule: 'required',
      errorMessage: 'Confirm Password is required',
    },
    {
        validator: (value, fields) => {
        if (fields['#password'] && fields['#password'].elem) {
            const repeatPasswordValue = fields['#password'].elem.value;

            return value === repeatPasswordValue;
        }

        return true;
        },
        errorMessage: 'Password and Confirm Password must be same',
    },
  ])
  .onSuccess((event) => {
    event.target.submit();
  });
</script>

@stop
