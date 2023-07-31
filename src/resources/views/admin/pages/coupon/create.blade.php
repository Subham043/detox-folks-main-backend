@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @can('list coupon')
        @include('admin.includes.breadcrumb', ['page'=>'Coupon', 'page_link'=>route('coupon.paginate.get'), 'list'=>['Create']])
        @endcan
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('coupon.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('coupon.create.post')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Coupon Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>old('name')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'code', 'label'=>'Code', 'value'=>old('code')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'discount', 'label'=>'Discount', 'value'=>old('discount')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'maximum_dicount_in_price', 'label'=>'Maximum Discount In Price', 'value'=>old('maximum_dicount_in_price')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'maximum_number_of_use', 'label'=>'Maximum Number Of Use', 'value'=>old('maximum_number_of_use')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'minimum_cart_value', 'label'=>'Minimum Cart Value', 'value'=>old('minimum_cart_value')])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('admin.includes.textarea', ['key'=>'description', 'label'=>'Description', 'value'=>old('description')])
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" checked>
                                                    <label class="form-check-label" for="is_active">Coupon Publish</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitBtn">Create</button>
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
  .addField('#code', [
    {
      rule: 'required',
      errorMessage: 'Code is required',
    },
  ])
  .addField('#discount', [
    {
      rule: 'required',
      errorMessage: 'Discount is required',
    },
  ])
  .addField('#maximum_dicount_in_price', [
    {
      rule: 'required',
      errorMessage: 'Maximum Discount In Price is required',
    },
  ])
  .addField('#maximum_number_of_use', [
    {
      rule: 'required',
      errorMessage: 'Maximum Number Of Use is required',
    },
  ])
  .addField('#minimum_cart_value', [
    {
      rule: 'required',
      errorMessage: 'Minimum Cart Value is required',
    },
  ])
  .addField('#description', [
    {
        rule: 'required',
        errorMessage: 'Description is required',
    },
  ])
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('is_active',document.getElementById('is_active').checked ? 1 : 0)
        formData.append('name',document.getElementById('name').value)
        formData.append('code',document.getElementById('code').value)
        formData.append('discount',document.getElementById('discount').value)
        formData.append('description',document.getElementById('description').value)
        formData.append('maximum_dicount_in_price',document.getElementById('maximum_dicount_in_price').value)
        formData.append('maximum_number_of_use',document.getElementById('maximum_number_of_use').value)
        formData.append('minimum_cart_value',document.getElementById('minimum_cart_value').value)

        const response = await axios.post('{{route('coupon.create.post')}}', formData)
        successToast(response.data.message)
        event.target.reset();
    }catch (error){
        if(error?.response?.data?.errors?.name){
            validation.showErrors({'#name': error?.response?.data?.errors?.name[0]})
        }
        if(error?.response?.data?.errors?.code){
            validation.showErrors({'#code': error?.response?.data?.errors?.code[0]})
        }
        if(error?.response?.data?.errors?.discount){
            validation.showErrors({'#discount': error?.response?.data?.errors?.discount[0]})
        }
        if(error?.response?.data?.errors?.description){
            validation.showErrors({'#description': error?.response?.data?.errors?.description[0]})
        }
        if(error?.response?.data?.errors?.minimum_cart_value){
            validation.showErrors({'#minimum_cart_value': error?.response?.data?.errors?.minimum_cart_value[0]})
        }
        if(error?.response?.data?.errors?.maximum_dicount_in_price){
            validation.showErrors({'#maximum_dicount_in_price': error?.response?.data?.errors?.maximum_dicount_in_price[0]})
        }
        if(error?.response?.data?.errors?.maximum_number_of_use){
            validation.showErrors({'#maximum_number_of_use': error?.response?.data?.errors?.maximum_number_of_use[0]})
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }finally{
        submitBtn.innerHTML =  `
            Create
            `
        submitBtn.disabled = false;
    }
  });

</script>

@stop
