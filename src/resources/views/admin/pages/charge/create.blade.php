@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @can('list charges')
        @include('admin.includes.breadcrumb', ['page'=>'Charge', 'page_link'=>route('charge.paginate.get'), 'list'=>['Create']])
        @endcan
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('charge.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('charge.create.post')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Charge Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'charges_name', 'label'=>'Charge Name', 'value'=>old('charges_name')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'charges_slug', 'label'=>'Charges Slug', 'value'=>old('charges_slug')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'charges_in_amount', 'label'=>'Charge In Amount', 'value'=>old('charges_in_amount')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'include_charges_for_cart_price_below', 'label'=>'Include Charges For Cart Price Below', 'value'=>old('include_charges_for_cart_price_below')])
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" checked>
                                                    <label class="form-check-label" for="is_active">Charge Status</label>
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
  .addField('#charges_name', [
    {
      rule: 'required',
      errorMessage: 'Charge Name is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Charge Name is invalid',
    },
  ])
  .addField('#charges_slug', [
    {
      rule: 'required',
      errorMessage: 'Charges Slug is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Charges Slug is invalid',
    },
  ])
  .addField('#charges_in_amount', [
    {
        rule: 'required',
        errorMessage: 'Charges In Amount is required',
    },
  ])
  .addField('#include_charges_for_cart_price_below', [
    {
        rule: 'required',
        errorMessage: 'Exclude Charges is required',
    },
  ])
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('is_active',document.getElementById('is_active').checked ? 1 : 0)
        formData.append('charges_name',document.getElementById('charges_name').value)
        formData.append('charges_slug',document.getElementById('charges_slug').value)
        formData.append('include_charges_for_cart_price_below',document.getElementById('include_charges_for_cart_price_below').value)
        formData.append('charges_in_amount',document.getElementById('charges_in_amount').value)
        const response = await axios.post('{{route('charge.create.post')}}', formData)
        successToast(response.data.message)
        event.target.reset();
    }catch (error){
        if(error?.response?.data?.errors?.charges_name){
            validation.showErrors({'#charges_name': error?.response?.data?.errors?.charges_name[0]})
        }
        if(error?.response?.data?.errors?.charges_slug){
            validation.showErrors({'#charges_slug': error?.response?.data?.errors?.charges_slug[0]})
        }
        if(error?.response?.data?.errors?.include_charges_for_cart_price_below){
            validation.showErrors({'#include_charges_for_cart_price_below': error?.response?.data?.errors?.include_charges_for_cart_price_below[0]})
        }
        if(error?.response?.data?.errors?.charges_in_amount){
            validation.showErrors({'#charges_in_amount': error?.response?.data?.errors?.charges_in_amount[0]})
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
