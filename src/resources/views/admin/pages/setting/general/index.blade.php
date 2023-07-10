@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'General Settings', 'page_link'=>route('general.settings.get'), 'list'=>['Update']])
        <!-- end page title -->

        <div class="row" id="image-container">
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('general.settings.post')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">General Settings</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'website_logo', 'label'=>'Webiste Header Logo'])
                                        @if(!empty($data->website_logo_link))
                                            <img src="{{$data->website_logo_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'website_footer_logo', 'label'=>'Webiste Footer Logo'])
                                        @if(!empty($data->website_footer_logo_link))
                                            <img src="{{$data->website_footer_logo_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'website_favicon', 'label'=>'Webiste Favicon'])
                                        @if(!empty($data->website_favicon_link))
                                            <img src="{{$data->website_favicon_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'website_logo_alt', 'label'=>'Website Logo Alt', 'value'=>!empty($data) ? (old('website_logo_alt') ? old('website_logo_alt') : $data->website_logo_alt) : old('website_logo_alt')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'website_logo_title', 'label'=>'Website Logo Title', 'value'=>!empty($data) ? (old('website_logo_title') ? old('website_logo_title') : $data->website_logo_title) : old('website_logo_title')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'website_name', 'label'=>'Website Name', 'value'=>!empty($data) ? (old('website_name') ? old('website_name') : $data->website_name) : old('website_name')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'email', 'label'=>'Email', 'value'=>!empty($data) ? (old('email') ? old('email') : $data->email) : old('email')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'phone', 'label'=>'Phone', 'value'=>!empty($data) ? (old('phone') ? old('phone') : $data->phone) : old('phone')])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'facebook', 'label'=>'Facebook Link', 'value'=>!empty($data) ? (old('facebook') ? old('facebook') : $data->facebook) : old('facebook')])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'linkedin', 'label'=>'Linkedin Link', 'value'=>!empty($data) ? (old('linkedin') ? old('linkedin') : $data->linkedin) : old('linkedin')])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'instagram', 'label'=>'Instagram Link', 'value'=>!empty($data) ? (old('instagram') ? old('instagram') : $data->instagram) : old('instagram')])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'youtube', 'label'=>'Youtube Link', 'value'=>!empty($data) ? (old('youtube') ? old('youtube') : $data->youtube) : old('youtube')])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('admin.includes.textarea', ['key'=>'address', 'label'=>'Address', 'value'=>!empty($data) ? (old('address') ? old('address') : $data->address) : old('address')])
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
    const myViewer = new ImgPreviewer('#image-container',{
      // aspect ratio of image
        fillRatio: 0.9,
        // attribute that holds the image
        dataUrlKey: 'src',
        // additional styles
        style: {
            modalOpacity: 0.6,
            headerOpacity: 0,
            zIndex: 99
        },
        // zoom options
        imageZoom: {
            min: 0.1,
            max: 5,
            step: 0.1
        },
        // detect whether the parent element of the image is hidden by the css style
        bubblingLevel: 0,

    });
</script>

<script type="text/javascript" nonce="{{ csp_nonce() }}">

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
.addField('#email', [
    {
      rule: 'required',
      errorMessage: 'Email is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Email is invalid',
    },
  ])
  .addField('#phone', [
    {
      rule: 'required',
      errorMessage: 'Phone is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Phone is invalid',
    },
  ])
  .addField('#website_name', [
    {
      rule: 'required',
      errorMessage: 'Website Name is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Website Name is invalid',
    },
  ])
  .addField('#facebook', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#linkedin', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#instagram', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#youtube', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#address', [
    {
        rule: 'required',
        errorMessage: 'Address Link is required',
    },
  ])
  .addField('#website_logo', [
    {
        rule: 'minFilesCount',
        value: 0,
    },
    {
        rule: 'maxFilesCount',
        value: 1,
    },
    {
        rule: 'files',
        value: {
        files: {
            extensions: ['jpeg', 'jpg', 'png', 'webp'],
            maxSize: 500000,
            minSize: 1,
            types: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
        },
        },
    },
  ])
  .addField('#website_footer_logo', [
    {
        rule: 'minFilesCount',
        value: 0,
    },
    {
        rule: 'maxFilesCount',
        value: 1,
    },
    {
        rule: 'files',
        value: {
        files: {
            extensions: ['jpeg', 'jpg', 'png', 'webp'],
            maxSize: 500000,
            minSize: 1,
            types: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
        },
        },
    },
  ])
  .addField('#website_favicon', [
    {
        rule: 'minFilesCount',
        value: 0,
    },
    {
        rule: 'maxFilesCount',
        value: 1,
    },
    {
        rule: 'files',
        value: {
        files: {
            extensions: ['jpeg', 'jpg', 'png', 'webp'],
            maxSize: 500000,
            minSize: 1,
            types: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
        },
        },
    },
  ])
  .addField('#website_logo_alt', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#website_logo_title', [
    {
        validator: (value, fields) => true,
    },
  ])
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('website_logo_alt',document.getElementById('website_logo_alt').value)
        formData.append('website_logo_title',document.getElementById('website_logo_title').value)
        formData.append('facebook',document.getElementById('facebook').value)
        formData.append('instagram',document.getElementById('instagram').value)
        formData.append('linkedin',document.getElementById('linkedin').value)
        formData.append('youtube',document.getElementById('youtube').value)
        formData.append('address',document.getElementById('address').value)
        formData.append('email',document.getElementById('email').value)
        formData.append('phone',document.getElementById('phone').value)
        formData.append('website_name',document.getElementById('website_name').value)
        if((document.getElementById('website_logo').files).length>0){
            formData.append('website_logo',document.getElementById('website_logo').files[0])
        }
        if((document.getElementById('website_footer_logo').files).length>0){
            formData.append('website_footer_logo',document.getElementById('website_footer_logo').files[0])
        }
        if((document.getElementById('website_favicon').files).length>0){
            formData.append('website_favicon',document.getElementById('website_favicon').files[0])
        }

        const response = await axios.post('{{route('general.settings.post')}}', formData)
        successToast(response.data.message)
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.facebook){
            validation.showErrors({'#facebook': error?.response?.data?.errors?.facebook[0]})
        }
        if(error?.response?.data?.errors?.instagram){
            validation.showErrors({'#instagram': error?.response?.data?.errors?.instagram[0]})
        }
        if(error?.response?.data?.errors?.linkedin){
            validation.showErrors({'#linkedin': error?.response?.data?.errors?.linkedin[0]})
        }
        if(error?.response?.data?.errors?.youtube){
            validation.showErrors({'#youtube': error?.response?.data?.errors?.youtube[0]})
        }
        if(error?.response?.data?.errors?.phone){
            validation.showErrors({'#phone': error?.response?.data?.errors?.phone[0]})
        }
        if(error?.response?.data?.errors?.email){
            validation.showErrors({'#email': error?.response?.data?.errors?.email[0]})
        }
        if(error?.response?.data?.errors?.address){
            validation.showErrors({'#address': error?.response?.data?.errors?.address[0]})
        }
        if(error?.response?.data?.errors?.website_name){
            validation.showErrors({'#website_name': error?.response?.data?.errors?.website_name[0]})
        }
        if(error?.response?.data?.errors?.website_logo_alt){
            validation.showErrors({'#website_logo_alt': error?.response?.data?.errors?.website_logo_alt[0]})
        }
        if(error?.response?.data?.errors?.website_logo_title){
            validation.showErrors({'#website_logo_title': error?.response?.data?.errors?.website_logo_title[0]})
        }
        if(error?.response?.data?.errors?.website_logo){
            validation.showErrors({'#website_logo': error?.response?.data?.errors?.website_logo[0]})
        }
        if(error?.response?.data?.errors?.website_footer_logo){
            validation.showErrors({'#website_footer_logo': error?.response?.data?.errors?.website_footer_logo[0]})
        }
        if(error?.response?.data?.errors?.website_favicon){
            validation.showErrors({'#website_favicon': error?.response?.data?.errors?.website_favicon[0]})
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
