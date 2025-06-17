@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="sub_category.paginate.get" page="Sub-Category" :list='["Update"]' />
												<!-- end page title -->

												<div class="row" id="image-container">
																<x-includes.back-button link="sub_category.paginate.get" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post" action="{{ route("sub_category.update.post", $data->id) }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Sub-Category Detail</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "name",
																																																"label" => "Name",
																																																"value" => $data->name,
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "slug",
																																																"label" => "Slug",
																																																"value" => $data->slug,
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "heading",
																																																"label" => "Heading",
																																																"value" => $data->heading,
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.select_multiple", [
																																																"key" => "category",
																																																"label" => "Categories",
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.file_input", [
																																																"key" => "image",
																																																"label" => "Image",
																																												])
																																												@if (!empty($data->image))
																																																<img src="{{ asset($data->image) }}" alt="" class="img-preview">
																																												@endif
																																								</div>
																																								<div class="col-xxl-12 col-md-12">
																																												<x-includes.quill key="description" label="Description" :value='$data->description' />
																																								</div>
																																								<div class="col-lg-12 col-md-12">
																																												<div class="mt-md-0 mt-4">
																																																<div>
																																																				<div class="form-check form-switch form-check-right mb-2">
																																																								<input class="form-check-input" type="checkbox" role="switch"
																																																												id="is_draft" name="is_draft"
																																																												{{ $data->is_draft == false ? "" : "checked" }}>
																																																								<label class="form-check-label" for="is_draft">Sub-Category
																																																												Publish</label>
																																																				</div>
																																																</div>

																																												</div>
																																								</div>

																																				</div>
																																				<!--end row-->
																																</div>

																												</div>
																								</div>

																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Sub-Category Seo Detail</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.textarea", [
																																																"key" => "meta_title",
																																																"label" => "Meta Title",
																																																"value" => $data->meta_title,
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.textarea", [
																																																"key" => "meta_keywords",
																																																"label" => "Meta Keywords",
																																																"value" => $data->meta_keywords,
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.textarea", [
																																																"key" => "meta_description",
																																																"label" => "Meta Description",
																																																"value" => $data->meta_description,
																																												])
																																								</div>
																																								<div class="col-xxl-12 col-md-12">
																																												<button type="submit" class="btn btn-primary waves-effect waves-light"
																																																id="submitBtn">Update</button>
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

@section("javascript")
				<script src="{{ asset("admin/js/pages/plugins/quill.min.js") }}"></script>
				<script src="{{ asset("admin/js/pages/choices.min.js") }}"></script>

				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								const Delta = Quill.import('delta');

								function quillImageHandler() {
												let fileInput = this.container.querySelector('input.ql-image[type=file]');
												if (fileInput == null) {
																fileInput = document.createElement('input');
																fileInput.setAttribute('type', 'file');
																fileInput.setAttribute('accept', 'image/png, image/gif, image/jpeg, image/bmp, image/x-icon');
																fileInput.classList.add('ql-image');
																fileInput.addEventListener('change', async () => {
																				if (fileInput.files != null && fileInput.files[0] != null) {
																								try {
																												const data = new FormData();
																												data.append('image', fileInput.files[0]);
																												const response = await axios.post('{{ route("texteditor_image.post") }}', data);
																												let reader = new FileReader();
																												reader.onload = (e) => {
																																let range = this.quill.getSelection(true);
																																this.quill.updateContents(new Delta()
																																				.retain(range.index)
																																				.delete(range.length)
																																				.insert({
																																								image: response.data.image
																																				}));
																																console.log(fileInput.files[0]);
																												}
																												reader.readAsDataURL(fileInput.files[0]);
																								} catch (error) {
																												if (error?.response?.data?.message) {
																																errorToast(error?.response?.data?.message)
																												}
																								}

																				}
																});
																fileInput.value = "";
																this.container.appendChild(fileInput);
												}
												fileInput.click();
								}

								var quillDescription = new Quill('#description_quill', {
												theme: 'snow',
												modules: {
																toolbar: {
																				container: QUILL_TOOLBAR_OPTIONS_WITH_IMAGE,
																				handlers: {
																								image: quillImageHandler
																				},
																},
												},
								});

								quillDescription.on('text-change', function(delta, oldDelta, source) {
												if (source == 'user') {
																document.getElementById('description').value = quillDescription.root.innerHTML
												}
								});

								const myViewer = new ImgPreviewer('#image-container', {
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

								// initialize the validation library
								const validation = new JustValidate('#countryForm', {
												errorFieldCssClass: 'is-invalid',
								});
								// apply rules to form fields
								validation
												.addField('#name', [{
																				rule: 'required',
																				errorMessage: 'Name is required',
																},
																{
																				rule: 'customRegexp',
																				value: COMMON_REGEX,
																				errorMessage: 'Name is invalid',
																},
												])
												.addField('#slug', [{
																				rule: 'required',
																				errorMessage: 'Slug is required',
																},
																{
																				rule: 'customRegexp',
																				value: COMMON_REGEX,
																				errorMessage: 'Slug is invalid',
																},
												])
												.addField('#heading', [{
																rule: 'customRegexp',
																value: COMMON_REGEX,
																errorMessage: 'Heading is invalid',
												}, ])
												.addField('#description', [{
																rule: 'required',
																errorMessage: 'Description is required',
												}, ])
												.addField('#category', [{
																rule: 'required',
																errorMessage: 'Category is required',
												}, ])
												.addField('#image', [{
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
												.addField('#meta_title', [{
																validator: (value, fields) => true,
												}, ])
												.addField('#meta_keywords', [{
																validator: (value, fields) => true,
												}, ])
												.addField('#meta_description', [{
																validator: (value, fields) => true,
												}, ])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('is_draft', document.getElementById('is_draft').checked ? 1 : 0)
																				formData.append('name', document.getElementById('name').value)
																				formData.append('slug', document.getElementById('slug').value)
																				formData.append('heading', document.getElementById('heading').value)
																				formData.append('description', quillDescription.root.innerHTML)
																				formData.append('description_unfiltered', quillDescription.getText())
																				formData.append('meta_title', document.getElementById('meta_title').value)
																				formData.append('meta_keywords', document.getElementById('meta_keywords').value)
																				formData.append('meta_description', document.getElementById('meta_description').value)
																				if ((document.getElementById('image').files).length > 0) {
																								formData.append('image', document.getElementById('image').files[0])
																				}
																				if (document.getElementById('category')?.length > 0) {
																								for (let index = 0; index < document.getElementById('category').length; index++) {
																												formData.append('category[]', document.getElementById('category')[index].value)
																								}
																				}

																				const response = await axios.post('{{ route("sub_category.update.post", $data->id) }}', formData)
																				successToast(response.data.message)
																				setInterval(location.reload(), 1500);
																} catch (error) {
																				if (error?.response?.data?.errors?.name) {
																								validation.showErrors({
																												'#name': error?.response?.data?.errors?.name[0]
																								})
																				}
																				if (error?.response?.data?.errors?.slug) {
																								validation.showErrors({
																												'#slug': error?.response?.data?.errors?.slug[0]
																								})
																				}
																				if (error?.response?.data?.errors?.heading) {
																								validation.showErrors({
																												'#heading': error?.response?.data?.errors?.heading[0]
																								})
																				}
																				if (error?.response?.data?.errors?.description) {
																								validation.showErrors({
																												'#description': error?.response?.data?.errors?.description[0]
																								})
																				}
																				if (error?.response?.data?.errors?.category) {
																								validation.showErrors({
																												'#category': error?.response?.data?.errors?.category[0]
																								})
																				}
																				if (error?.response?.data?.errors?.image) {
																								validation.showErrors({
																												'#image': error?.response?.data?.errors?.image[0]
																								})
																				}
																				if (error?.response?.data?.errors?.meta_title) {
																								validation.showErrors({
																												'#meta_title': error?.response?.data?.errors?.meta_title[0]
																								})
																				}
																				if (error?.response?.data?.errors?.meta_keywords) {
																								validation.showErrors({
																												'#meta_keywords': error?.response?.data?.errors?.meta_keywords[0]
																								})
																				}
																				if (error?.response?.data?.errors?.meta_description) {
																								validation.showErrors({
																												'#meta_description': error?.response?.data?.errors?.meta_description[0]
																								})
																				}
																				if (error?.response?.data?.message) {
																								errorToast(error?.response?.data?.message)
																				}
																} finally {
																				submitBtn.innerHTML = `
            Update
            `
																				submitBtn.disabled = false;
																}
												});

								const categoryChoice = new Choices('#category', {
												choices: [
																@foreach ($category as $category)
																				{
																								value: '{{ $category->id }}',
																								label: '{{ $category->name }}',
																								selected: {{ in_array($category->id, $categories) ? "true" : "false" }}
																				},
																@endforeach
												],
												placeholderValue: 'Select categories',
												...CHOICE_CONFIG,
												shouldSort: false,
												shouldSortItems: false,
								});
				</script>

@stop
