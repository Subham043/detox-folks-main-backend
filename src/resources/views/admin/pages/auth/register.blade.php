@extends("admin.layouts.auth")

@section("content")

				<div class="row justify-content-center">
								<div class="col-md-8 col-lg-6 col-xl-5">
												<div class="card mt-4">

																<div class="card-body p-4">
																				<div class="mt-2 text-center">
																								<h5 class="text-primary">Registration</h5>
																								<p class="text-muted">Sign up to continue to DETOX FOLKS.</p>
																				</div>
																				<div class="mt-4 p-2">
																								<form id="loginForm" method="post" action="{{ route("register.post") }}">
																												@csrf
																												<div class="mb-3">
																																@include("admin.includes.input", [
																																				"key" => "name",
																																				"label" => "Name",
																																				"value" => old("name"),
																																])
																												</div>
																												<div class="mb-3">
																																@include("admin.includes.input", [
																																				"key" => "email",
																																				"label" => "Email",
																																				"value" => old("email"),
																																])
																												</div>
																												<div class="mb-3">
																																@include("admin.includes.input", [
																																				"key" => "phone",
																																				"label" => "Phone",
																																				"value" => old("phone"),
																																])
																												</div>

                                                                                                                <div class="mb-3">
                                                                                                                                @include("admin.includes.select", [
                                                                                                                                                "key" => "role",
                                                                                                                                                "label" => "Role",
                                                                                                                                ])
                                                                                                                </div>

																												<div class="mb-3">
																																@include("admin.includes.password_input", [
																																				"key" => "password",
																																				"label" => "Password",
																																				"value" => "",
																																])
																												</div>

																												<div class="mb-3">
																																@include("admin.includes.password_input", [
																																				"key" => "confirm_password",
																																				"label" => "Confirm Password",
																																				"value" => "",
																																])
																												</div>

																												<div class="mt-4">
																																<button class="btn btn-success w-100" type="submit">Sign Up</button>
																												</div>
																												<div class="mt-4 text-center">
																																<p class="mb-0">Already have an account? <a href="{{ route("login.get") }}"
																																								class="fw-semibold text-primary text-decoration-underline"> Click here</a> To Login</p>
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

@section("javascript")
                <script src="{{ asset("admin/js/pages/choices.min.js") }}"></script>
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
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
								// initialize the validation library
								const validation = new JustValidate('#loginForm', {
												errorFieldCssClass: 'is-invalid',
												focusInvalidField: true,
												lockForm: true,
								});
								// apply rules to form fields
								validation
												.addField('#name', [{
																				rule: 'required',
																				errorMessage: 'Name is required',
																},
												])
												.addField('#email', [{
																				rule: 'required',
																				errorMessage: 'Email is required',
																},
																{
																				rule: 'email',
																				errorMessage: 'Email is invalid!',
																},
												])
												.addField('#phone', [{
																				rule: 'required',
																				errorMessage: 'Phone is required',
																},
												])
                                                .addField('#role', [{
																rule: 'required',
																errorMessage: 'Please select a role',
												}, ])
												.addField('#password', [{
																rule: 'required',
																errorMessage: 'Password is required',
												}])
                                                .addField('#confirm_password', [{
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

                                                const categoryChoice = new Choices('#role', {
                                                    choices: [{
                                                                                    value: '',
                                                                                    label: 'Select a role',
                                                                                    selected: {{ empty(old("role")) ? "true" : "false" }},
                                                                                    disabled: true,
                                                                    },
                                                                    @foreach ($roles as $val)
                                                                                    {
                                                                                                    value: '{{ $val->name }}',
                                                                                                    label: '{{ $val->name }}',
                                                                                                    selected: {{ old("role") == $val->name ? "true" : "false" }},
                                                                                    },
                                                                    @endforeach
                                                    ],
                                                    placeholderValue: 'Select a role',
                                                    ...CHOICE_CONFIG
								                });
				</script>

@stop
