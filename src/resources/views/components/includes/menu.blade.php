<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
				<!-- LOGO -->
				<div class="navbar-brand-box">
								<!-- Dark Logo-->
								<a href="{{ route("dashboard.get") }}" class="logo logo-dark">
												<span class="logo-sm">
																<img src="{{ asset("admin/images/logo-sm.png") }}" alt="" height="22">
												</span>
												<span class="logo-lg">
																<img src="{{ asset("admin/images/logo.png") }}" alt="" height="17">
												</span>
								</a>
								<!-- Light Logo-->
								<a href="{{ route("dashboard.get") }}" class="logo logo-light">
												<span class="logo-sm">
																<img src="{{ asset("admin/images/logo-sm.png") }}" alt="" height="30">
												</span>
												<span class="logo-lg">
																<img src="{{ asset("admin/images/logo.png") }}" alt="" height="60">
												</span>
								</a>
								<button type="button" class="btn btn-sm fs-20 header-item float-end btn-vertical-sm-hover p-0"
												id="vertical-hover">
												<i class="ri-record-circle-line"></i>
								</button>
				</div>

				<div id="scrollbar">
								<div class="container-fluid">

												<div id="two-column-menu">
												</div>
												<ul class="navbar-nav" id="navbar-nav">
																<li class="menu-title"><span data-key="t-menu">Menu</span></li>

																<li class="nav-item">
																				<a class="nav-link menu-link {{ strpos(url()->current(), route("dashboard.get")) !== false ? "active" : "" }}"
																								href="{{ route("dashboard.get") }}">
																								<i class="ri-dashboard-fill"></i> <span data-key="t-widgets">Dashboard</span>
																				</a>
																</li>

																@hasanyrole("Staff|Super-Admin")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), "enquiries") !== false ? "active" : "" }}"
																												href="#sidebarDashboards5" data-bs-toggle="collapse" role="button"
																												aria-expanded="{{ strpos(url()->current(), "enquiries") !== false ? "true" : "false" }}"
																												aria-controls="sidebarDashboards5">
																												<i class="ri-survey-line"></i> <span data-key="t-dashboards">Enquiries</span>
																								</a>
																								<div class="menu-dropdown {{ strpos(url()->current(), "enquiries") !== false ? "show" : "" }} collapse"
																												id="sidebarDashboards5">
																												<ul class="nav nav-sm flex-column">
																																<li class="nav-item">
																																				<a href="{{ route("enquiry.contact_form.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("enquiry.contact_form.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Contact Form </a>
																																</li>
																																<li class="nav-item">
																																				<a href="{{ route("enquiry.order_form.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("enquiry.order_form.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Order Form </a>
																																</li>

																												</ul>
																								</div>
																				</li>
																@endhasanyrole

																@hasanyrole("Super-Admin")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("user.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("user.paginate.get") }}">
																												<i class="ri-user-add-fill"></i> <span data-key="t-widgets">User Management</span>
																								</a>
																				</li>
																@endhasanyrole

																@hasanyrole("Delivery Agent")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("delivery_management.agent.order.get")) !== false ? "active" : "" }}"
																												href="{{ route("delivery_management.agent.order.get") }}">
																												<i class="ri-truck-line"></i> <span data-key="t-widgets">Orders</span>
																								</a>
																				</li>
																@endhasanyrole

																@hasanyrole("App Promoter|Reward Riders|Referral Rockstars")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("promoter.agent.app_installer.get")) !== false ? "active" : "" }}"
																												href="{{ route("promoter.agent.app_installer.get") }}">
																												<i class="ri-user-voice-line"></i> <span data-key="t-widgets">App Promoter</span>
																								</a>
																				</li>
																@endhasanyrole

																@hasanyrole("Warehouse Manager")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("warehouse_management.order.get")) !== false ? "active" : "" }}"
																												href="{{ route("warehouse_management.order.get") }}">
																												<i class="ri-truck-line"></i> <span data-key="t-widgets">Orders</span>
																								</a>
																				</li>
																@endhasanyrole

																@hasanyrole("Content Manager")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("testimonial.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("testimonial.paginate.get") }}">
																												<i class="ri-chat-1-line"></i> <span data-key="t-widgets">Testimonials</span>
																								</a>
																				</li>
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("blog.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("blog.paginate.get") }}">
																												<i class="ri-file-add-line"></i> <span data-key="t-widgets">Blogs</span>
																								</a>
																				</li>
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("legal.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("legal.paginate.get") }}">
																												<i class="ri-article-line"></i> <span data-key="t-widgets">Legal Pages</span>
																								</a>
																				</li>
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("feature.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("feature.paginate.get") }}">
																												<i class="ri-bookmark-3-line"></i> <span data-key="t-widgets">Features</span>
																								</a>
																				</li>
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("about.main.get")) !== false ? "active" : "" }}"
																												href="{{ route("about.main.get") }}">
																												<i class="ri-pages-line"></i> <span data-key="t-widgets">About Page</span>
																								</a>
																				</li>
																@endhasanyrole

																@hasanyrole("Super-Admin")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), "content-management") !== false ? "active" : "" }}"
																												href="#sidebarDashboards2" data-bs-toggle="collapse" role="button"
																												aria-expanded="{{ strpos(url()->current(), "content-management") !== false ? "true" : "false" }}"
																												aria-controls="sidebarDashboards2">
																												<i class="ri-slideshow-line"></i> <span data-key="t-dashboards">Content Managment</span>
																								</a>
																								<div class="menu-dropdown {{ strpos(url()->current(), "content-management") !== false ? "show" : "" }} collapse"
																												id="sidebarDashboards2">
																												<ul class="nav nav-sm flex-column">
																																<li class="nav-item">
																																				<a href="{{ route("testimonial.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("testimonial.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Testimonials </a>
																																</li>
																																<li class="nav-item">
																																				<a href="{{ route("blog.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("blog.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Blogs </a>
																																</li>
																																<li class="nav-item">
																																				<a href="{{ route("legal.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("legal.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Legal Pages </a>
																																</li>
																																<li class="nav-item">
																																				<a href="{{ route("feature.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("feature.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Features </a>
																																</li>
																																<li class="nav-item">
																																				<a href="{{ route("about.main.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("about.main.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> About Page </a>
																																</li>

																												</ul>
																								</div>
																				</li>
																@endhasanyrole

																@hasanyrole("Inventory Manager")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("category.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("category.paginate.get") }}">
																												<i class="ri-file-copy-2-line"></i> <span data-key="t-widgets">Categories</span>
																								</a>
																				</li>
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("sub_category.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("sub_category.paginate.get") }}">
																												<i class="ri-pages-line"></i> <span data-key="t-widgets">Sub-Categories</span>
																								</a>
																				</li>
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("product.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("product.paginate.get") }}">
																												<i class="ri-shopping-bag-3-line"></i> <span data-key="t-widgets">Products</span>
																								</a>
																				</li>
																@endhasanyrole

																@hasanyrole("Super-Admin")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), "product-management") !== false ? "active" : "" }}"
																												href="#sidebarDashboards3" data-bs-toggle="collapse" role="button"
																												aria-expanded="{{ strpos(url()->current(), "product-management") !== false ? "true" : "false" }}"
																												aria-controls="sidebarDashboards3">
																												<i class="ri-dropbox-line"></i> <span data-key="t-dashboards">Product Management</span>
																								</a>
																								<div class="menu-dropdown {{ strpos(url()->current(), "product-management") !== false ? "show" : "" }} collapse"
																												id="sidebarDashboards3">
																												<ul class="nav nav-sm flex-column">
																																<li class="nav-item">
																																				<a href="{{ route("category.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("category.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Categories </a>
																																</li>
																																<li class="nav-item">
																																				<a href="{{ route("sub_category.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("sub_category.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Sub-Categories </a>
																																</li>
																																<li class="nav-item">
																																				<a href="{{ route("product.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("product.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Products </a>
																																</li>

																												</ul>
																								</div>
																				</li>
																@endhasanyrole

																@hasanyrole("Super-Admin")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("charge.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("charge.paginate.get") }}">
																												<i class="ri-money-dollar-circle-line"></i> <span data-key="t-widgets">Cart Charges</span>
																								</a>
																				</li>
																@endhasanyrole

																@hasanyrole("Inventory Manager|Staff|Super-Admin")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("order_admin.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("order_admin.paginate.get") }}">
																												<i class="bx bx-shopping-bag"></i> <span data-key="t-widgets">Orders</span>
																								</a>
																				</li>
																@endhasanyrole

																@hasanyrole("Staff|Super-Admin")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("delivery_management.agent.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("delivery_management.agent.paginate.get") }}">
																												<i class="ri-truck-line"></i> <span data-key="t-widgets">Delivery Agent</span>
																								</a>
																				</li>
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("promoter.agent.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("promoter.agent.paginate.get") }}">
																												<i class="ri-user-voice-line"></i> <span data-key="t-widgets">App Promoter Agent</span>
																								</a>
																				</li>
																@endhasanyrole

																@hasanyrole("Super-Admin")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), "logs") !== false ? "active" : "" }}"
																												href="#sidebarDashboards4" data-bs-toggle="collapse" role="button"
																												aria-expanded="{{ strpos(url()->current(), "logs") !== false ? "true" : "false" }}"
																												aria-controls="sidebarDashboards4">
																												<i class="ri-alarm-warning-line"></i> <span data-key="t-dashboards">Application Logs</span>
																								</a>
																								<div class="menu-dropdown {{ strpos(url()->current(), "logs") !== false ? "show" : "" }} collapse"
																												id="sidebarDashboards4">
																												<ul class="nav nav-sm flex-column">
																																<li class="nav-item">
																																				<a href="{{ route("activity_log.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("activity_log.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Activity Logs </a>
																																</li>
																																<li class="nav-item">
																																				<a href="{{ route("error_log.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("error_log.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Error Logs </a>
																																</li>

																												</ul>
																								</div>
																				</li>
																@endhasanyrole

												</ul>
								</div>
								<!-- Sidebar -->
				</div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
