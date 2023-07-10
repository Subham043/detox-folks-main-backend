<div class="row">
<div class="col-lg-12">
    <form id="sectionTitleForm" method="post" action="{{$link}}" enctype="multipart/form-data">
        @csrf
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{$section}} Section Title</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4 align-items-end">
                            <div class="col-xxl-11 col-md-11">
                                @include('admin.includes.input', ['key'=>'heading', 'label'=>'Heading', 'value'=>$heading_value])
                            </div>
                            <input type="hidden" name="key" value="{{$key}}">
                            <div class="col-xxl-1 col-md-1 m-0">
                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitBtn">Save</button>
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
