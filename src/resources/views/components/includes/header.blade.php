<header id="page-topbar">
				<div class="layout-width">
								<div class="navbar-header">
												<div class="d-flex">
																<!-- LOGO -->
																<div class="navbar-brand-box horizontal-logo">
																				<a href="index.html" class="logo logo-dark">
																								<span class="logo-sm">
																												<img src="{{ asset("admin/images/logo.webp") }}" alt="" height="22">
																								</span>
																								<span class="logo-lg">
																												<img src="{{ asset("admin/images/logo.webp") }}" alt="" height="17">
																								</span>
																				</a>

																				<a href="index.html" class="logo logo-light">
																								<span class="logo-sm">
																												<img src="{{ asset("admin/images/logo.webp") }}" alt="" height="22">
																								</span>
																								<span class="logo-lg">
																												<img src="{{ asset("admin/images/logo.webp") }}" alt="" height="17">
																								</span>
																				</a>
																</div>

																<button type="button" class="btn btn-sm fs-16 header-item vertical-menu-btn topnav-hamburger px-3"
																				id="topnav-hamburger-icon">
																				<span class="hamburger-icon">
																								<span></span>
																								<span></span>
																								<span></span>
																				</span>
																</button>

												</div>

												<div class="d-flex align-items-center">

																<div class="header-item d-none d-sm-flex ms-1">
																				<button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
																								data-toggle="fullscreen">
																								<i class='bx bx-fullscreen fs-22'></i>
																				</button>
																</div>

																<div class="header-item d-none d-sm-flex ms-1">
																				<button type="button"
																								class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
																								<i class='bx bx-moon fs-22'></i>
																				</button>
																</div>

																<div class="dropdown ms-sm-3 header-item topbar-user">
																				<button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
																								aria-haspopup="true" aria-expanded="false">
																								<span class="d-flex align-items-center">
																												<img class="rounded-circle header-profile-user" src="{{ asset("admin/images/avatar.png") }}"
																																alt="Header Avatar">
																												<span class="ms-xl-2 text-start">
																																<span
																																				class="d-none d-xl-inline-block fw-medium user-name-text ms-1">{{ Auth::user()->name }}</span>
																																<span
																																				class="d-none d-xl-block fs-12 text-muted user-name-sub-text ms-1">{{ Auth::user()->current_role }}</span>
																												</span>
																								</span>
																				</button>
																				<div class="dropdown-menu dropdown-menu-end">
																								<!-- item-->
																								<h6 class="dropdown-header">Welcome {{ Auth::user()->current_role }}!</h6>
																								<a class="dropdown-item" href="{{ route("profile.get") }}"><i
																																class="mdi mdi-account-circle text-muted fs-16 me-1 align-middle"></i> <span
																																class="align-middle">Profile</span></a>
																								<a class="dropdown-item" href="{{ route("password.get") }}"><i
																																class="ri-tools-fill text-muted fs-16 me-1 align-middle"></i> <span
																																class="align-middle">Setting</span></a>

																								<a class="dropdown-item" href="{{ route("logout.get") }}"><i
																																class="mdi mdi-logout text-muted fs-16 me-1 align-middle"></i> <span
																																class="align-middle" data-key="t-logout">Logout</span></a>
																				</div>
																</div>
												</div>
								</div>
				</div>
</header>
