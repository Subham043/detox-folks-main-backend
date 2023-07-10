<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover" data-sidebar-image="none" data-preloader="disable" data-sidebar-visibility="show" data-layout-style="default" data-layout-mode="light" data-layout-width="fluid" data-layout-position="fixed">


    @include('admin.includes.common_head')

    <body>

        <!-- Begin page -->
        <div id="layout-wrapper">

            @include('admin.includes.header')

            @include('admin.includes.menu')

             <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                @yield('content')

                @include('admin.includes.footer')

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->



        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

        <!-- JAVASCRIPT -->
        @include('admin.includes.common_script')

        <!-- App js -->
        <script src="{{ asset('admin/js/app.js') }}"></script>
        <script src="{{ asset('admin/js/main.js') }}"></script>

        <script nonce="{{ csp_nonce() }}">
            const COMMON_REGEX = /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\?\r\n+=,]+$/i;

            const CHOICE_CONFIG = {
                silent: false,
                items: [],
                renderChoiceLimit: -1,
                maxItemCount: -1,
                addItems: true,
                addItemFilter: null,
                removeItems: true,
                removeItemButton: false,
                editItems: false,
                allowHTML: true,
                duplicateItemsAllowed: true,
                delimiter: ',',
                paste: true,
                searchEnabled: true,
                searchChoices: true,
                searchFloor: 1,
                searchResultLimit: 4,
                searchFields: ['label', 'value'],
                position: 'auto',
                resetScrollPosition: true,
                shouldSort: true,
                shouldSortItems: false,
                // sorter: () => {...},
                placeholder: true,
                searchPlaceholderValue: null,
                prependValue: null,
                appendValue: null,
                renderSelectedChoices: 'auto',
                loadingText: 'Loading...',
                noResultsText: 'No results found',
                noChoicesText: 'No choices to choose from',
                itemSelectText: 'Press to select',
                addItemText: (value) => {
                    return `Press Enter to add <b>"${value}"</b>`;
                },
                maxItemText: (maxItemCount) => {
                    return `Only ${maxItemCount} values can be added`;
                },
                valueComparer: (value1, value2) => {
                    return value1 === value2;
                },
                classNames: {
                    containerOuter: 'choices',
                    containerInner: 'choices__inner',
                    input: 'choices__input',
                    inputCloned: 'choices__input--cloned',
                    list: 'choices__list',
                    listItems: 'choices__list--multiple',
                    listSingle: 'choices__list--single',
                    listDropdown: 'choices__list--dropdown',
                    item: 'choices__item',
                    itemSelectable: 'choices__item--selectable',
                    itemDisabled: 'choices__item--disabled',
                    itemChoice: 'choices__item--choice',
                    placeholder: 'choices__placeholder',
                    group: 'choices__group',
                    groupHeading: 'choices__heading',
                    button: 'choices__button',
                    activeState: 'is-active',
                    focusState: 'is-focused',
                    openState: 'is-open',
                    disabledState: 'is-disabled',
                    highlightedState: 'is-highlighted',
                    selectedState: 'is-selected',
                    flippedState: 'is-flipped',
                    loadingState: 'is-loading',
                    noResults: 'has-no-results',
                    noChoices: 'has-no-choices'
                },
                // Choices uses the great Fuse library for searching. You
                // can find more options here: https://fusejs.io/api/options.html
                fuseOptions: {
                    includeScore: true
                },
                labelId: '',
                callbackOnInit: null,
                callbackOnCreateTemplates: null
            };

            const QUILL_TOOLBAR_OPTIONS = [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [ 'link', 'video'],
                [{ 'align': [] }],
                ['clean']
            ];

            const QUILL_TOOLBAR_OPTIONS_WITH_IMAGE = [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [ 'link', 'image', 'video' ],
                [{ 'align': [] }],
                ['clean']
            ];

            document.querySelectorAll('.remove-item-btn').forEach(el => {
                el.addEventListener('click', function(){
                    deleteHandler(event.target.getAttribute('data-link'))
                })
            });

            function deleteHandler(url){
                iziToast.question({
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',
                    message: 'Are you sure about that?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {

                            window.location.replace(url);
                            // instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],
                    onClosing: function(instance, toast, closedBy){
                        console.info('Closing | closedBy: ' + closedBy);
                    },
                    onClosed: function(instance, toast, closedBy){
                        console.info('Closed | closedBy: ' + closedBy);
                    }
                });
            }
        </script>

        @yield('javascript')
    </body>


</html>
