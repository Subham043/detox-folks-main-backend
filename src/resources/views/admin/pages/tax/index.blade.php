@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Tax', 'page_link'=>route('tax.get'), 'list'=>['Update']])
        <!-- end page title -->

        <div class="row" id="image-container">
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('tax.post')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Tax Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'tax_name', 'label'=>'Tax Name', 'value'=>!empty($data) ? (old('tax_name') ? old('tax_name') : $data->tax_name) : old('tax_name')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'tax_in_percentage', 'label'=>'Tax In Percentage', 'value'=>!empty($data) ? (old('tax_in_percentage') ? old('tax_in_percentage') : $data->tax_in_percentage) : old('tax_in_percentage')])
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

<script type="text/javascript" nonce="{{ csp_nonce() }}">

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
.addField('#tax_name', [
    {
      rule: 'required',
      errorMessage: 'Tax Name is required',
    },
  ])
  .addField('#tax_in_percentage', [
    {
        rule: 'required',
        errorMessage: 'Tax in Percentage is required',
    },
  ])
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('tax_name',document.getElementById('tax_name').value)
        formData.append('tax_in_percentage',document.getElementById('tax_in_percentage').value)

        const response = await axios.post('{{route('tax.post')}}', formData)
        successToast(response.data.message)
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.tax_name){
            validation.showErrors({'#tax_name': error?.response?.data?.errors?.tax_name[0]})
        }
        if(error?.response?.data?.errors?.tax_in_percentage){
            validation.showErrors({'#tax_in_percentage': error?.response?.data?.errors?.tax_in_percentage[0]})
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
  });
</script>
@stop
