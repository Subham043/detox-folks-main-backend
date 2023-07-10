@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @can('list home page testimonials')
        @include('admin.includes.breadcrumb', ['page'=>'Testimonial', 'page_link'=>route('testimonial.paginate.get'), 'list'=>['Update']])
        @endcan
        <!-- end page title -->

        <div class="row" id="image-container">
            @include('admin.includes.back_button', ['link'=>route('testimonial.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('testimonial.update.post', $data->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Testimonial Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>$data->name])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'designation', 'label'=>'Designation', 'value'=>$data->designation])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="star" class="form-label">Stars</label>
                                            <select class="form-control" name="star" id="star">
                                                @for($i=1; $i<=5; $i++)
                                                    <option value="{{$i}}" {{$i==$data->star ? 'selected' : ''}}>{{$i}} star</option>
                                                @endfor
                                            </select>
                                            @error('star')
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.file_input', ['key'=>'image', 'label'=>'Image'])
                                        @if(!empty($data->image_link))
                                            <img src="{{$data->image_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('admin.includes.textarea', ['key'=>'message', 'label'=>'Message', 'value'=>$data->message])
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="is_draft" name="is_draft" {{$data->is_draft==false ? '' : 'checked'}}>
                                                    <label class="form-check-label" for="is_draft">Testimonial Status</label>
                                                </div>
                                            </div>

                                        </div>
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
  .addField('#designation', [
    {
      rule: 'required',
      errorMessage: 'Designation is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Designation is invalid',
    },
  ])
  .addField('#message', [
    {
        rule: 'required',
        errorMessage: 'Message is required',
    },
  ])
  .addField('#star', [
    {
        rule: 'required',
        errorMessage: 'Star is required',
    },
  ])
  .addField('#image', [
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
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('is_draft',document.getElementById('is_draft').checked ? 1 : 0)
        formData.append('name',document.getElementById('name').value)
        formData.append('designation',document.getElementById('designation').value)
        formData.append('message',document.getElementById('message').value)
        formData.append('star',document.getElementById('star').value)
        if((document.getElementById('image').files).length>0){
            formData.append('image',document.getElementById('image').files[0])
        }
        const response = await axios.post('{{route('testimonial.update.post', $data->id)}}', formData)
        successToast(response.data.message)
    }catch (error){
        if(error?.response?.data?.errors?.name){
            validation.showErrors({'#name': error?.response?.data?.errors?.name[0]})
        }
        if(error?.response?.data?.errors?.designation){
            validation.showErrors({'#designation': error?.response?.data?.errors?.designation[0]})
        }
        if(error?.response?.data?.errors?.message){
            validation.showErrors({'#message': error?.response?.data?.errors?.message[0]})
        }
        if(error?.response?.data?.errors?.star){
            validation.showErrors({'#star': error?.response?.data?.errors?.star[0]})
        }
        if(error?.response?.data?.errors?.image){
            validation.showErrors({'#image': error?.response?.data?.errors?.image[0]})
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
