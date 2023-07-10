@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg profile-setting-img">
                <img src="{{ asset('admin/images/logo.png')}}" class="profile-wid-img" alt="">
            </div>
        </div>

        <div class="row mt-5">

            <!--end col-->
            <div class="col-xxl-12 mt-5">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                    <i class="fas fa-home"></i>
                                    Personal Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                    <i class="far fa-user"></i>
                                    Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="javascript:void(0);" id="profileForm">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            @include('admin.includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>Auth::user()->name])
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            @include('admin.includes.input', ['key'=>'email', 'label'=>'Email', 'value'=>Auth::user()->email])
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            @include('admin.includes.input', ['key'=>'phone', 'label'=>'Phone', 'value'=>Auth::user()->phone])
                                        </div>
                                        <!--end col-->

                                        <div class="col-lg-12 mt-2">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary" id="submitBtn">Update</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="changePassword" role="tabpanel">
                                <form action="javascript:void(0);" id="passwordForm">
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <div>
                                                @include('admin.includes.password_input', ['key'=>'old_password', 'label'=>'Old Password', 'value'=>''])
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                @include('admin.includes.password_input', ['key'=>'password', 'label'=>'Password', 'value'=>''])
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                @include('admin.includes.password_input', ['key'=>'confirm_password', 'label'=>'Confirm Password', 'value'=>''])
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12 mt-3">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success" id="submitBtn2">Change
                                                    Password</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>

                            </div>
                            <!--end tab-pane-->

                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->

@stop


@section('javascript')
<script type="text/javascript" nonce="{{ csp_nonce() }}">

// initialize the validation library
const validation = new JustValidate('#profileForm', {
    errorFieldCssClass: 'is-invalid',
    focusInvalidField: true,
    lockForm: true,
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
        value: /^[a-zA-Z\s]*$/,
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
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('name',document.getElementById('name').value)
        formData.append('email',document.getElementById('email').value)
        formData.append('phone',document.getElementById('phone').value)
        const response = await axios.post('{{route('profile.post')}}', formData)
        successToast(response.data.message)
    }catch (error){
        if(error?.response?.data?.errors?.name){
            validation.showErrors({'#name': error?.response?.data?.errors?.name[0]})
        }
        if(error?.response?.data?.errors?.email){
            validation.showErrors({'#email': error?.response?.data?.errors?.email[0]})
        }
        if(error?.response?.data?.errors?.phone){
            validation.showErrors({'#phone': error?.response?.data?.errors?.phone[0]})
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }finally{
        submitBtn.innerHTML =  `
        Update
        `
        submitBtn.disabled = false;
    }
})

  // initialize the validation library
const validationPassword = new JustValidate('#passwordForm', {
    errorFieldCssClass: 'is-invalid',
    focusInvalidField: true,
    lockForm: true,
});
// apply rules to form fields
validationPassword
.addField('#password', [
    {
      rule: 'required',
      errorMessage: 'Password is required',
    },
    {
      rule: 'strongPassword',
    }
  ])
  .addField('#confirm_password', [
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
  .addField('#old_password', [
    {
      rule: 'required',
      errorMessage: 'Old Password is required',
    }
  ])
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn2')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('old_password',document.getElementById('old_password').value)
        formData.append('password',document.getElementById('password').value)
        formData.append('confirm_password',document.getElementById('confirm_password').value)
        const response = await axios.post('{{route('password.post')}}', formData)
        successToast(response.data.message)
        event.target.reset();
    }catch (error){
        if(error?.response?.data?.errors?.old_password){
            validationPassword.showErrors({'#old_password': error?.response?.data?.errors?.old_password[0]})
        }
        if(error?.response?.data?.errors?.password){
            validationPassword.showErrors({'#password': error?.response?.data?.errors?.password[0]})
        }
        if(error?.response?.data?.errors?.confirm_password){
            validationPassword.showErrors({'#confirm_password': error?.response?.data?.errors?.confirm_password[0]})
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }finally{
        submitBtn.innerHTML =  `
            Change Password
            `
        submitBtn.disabled = false;
    }
  })

</script>
@stop
