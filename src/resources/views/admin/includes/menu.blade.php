
            <!-- ========== App Menu ========== -->
            <div class="app-menu navbar-menu">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <!-- Dark Logo-->
                    <a href="{{route('dashboard.get')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/images/logo-sm.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo.png') }}" alt="" height="17">
                        </span>
                    </a>
                    <!-- Light Logo-->
                    <a href="{{route('dashboard.get')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/images/logo-sm.png')}}" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo.png') }}" alt="" height="60">
                        </span>
                    </a>
                    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
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
                                <a class="nav-link menu-link {{strpos(url()->current(),route('dashboard.get')) !== false ? 'active' : ''}}" href="{{route('dashboard.get')}}">
                                    <i class="ri-dashboard-fill"></i> <span data-key="t-widgets">Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'enquiry') !== false ? 'active' : ''}}" href="#sidebarDashboards7" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'enquiry') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards7">
                                    <i class="ri-survey-line"></i> <span data-key="t-dashboards">Enquiries</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'enquiry') !== false ? 'show' : ''}}" id="sidebarDashboards7">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list enquiries')
                                            <li class="nav-item">
                                                <a href="{{route('enquiry.contact_form.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('enquiry.contact_form.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Contact Form </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>

                            @can('list roles')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('role.paginate.get')) !== false ? 'active' : ''}}" href="{{route('role.paginate.get')}}">
                                    <i class="ri-shield-user-fill"></i> <span data-key="t-widgets">Roles</span>
                                </a>
                            </li>
                            @endcan

                            @can('list users')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('user.paginate.get')) !== false ? 'active' : ''}}" href="{{route('user.paginate.get')}}">
                                    <i class="ri-user-add-fill"></i> <span data-key="t-widgets">Users</span>
                                </a>
                            </li>
                            @endcan

                            @can('list partners')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('partner.paginate.get')) !== false ? 'active' : ''}}" href="{{route('partner.paginate.get')}}">
                                    <i class="ri-user-5-line"></i> <span data-key="t-widgets">Partners</span>
                                </a>
                            </li>
                            @endcan

                            @can('list counters')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('counter.paginate.get')) !== false ? 'active' : ''}}" href="{{route('counter.paginate.get')}}">
                                    <i class="ri-timer-flash-line"></i> <span data-key="t-widgets">Counters</span>
                                </a>
                            </li>
                            @endcan

                            @can('list testimonials')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('testimonial.paginate.get')) !== false ? 'active' : ''}}" href="{{route('testimonial.paginate.get')}}">
                                    <i class="ri-chat-smile-3-line"></i> <span data-key="t-widgets">Testimonial</span>
                                </a>
                            </li>
                            @endcan

                            @can('list blogs')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('blog.paginate.get')) !== false ? 'active' : ''}}" href="{{route('blog.paginate.get')}}">
                                    <i class="ri-article-line"></i> <span data-key="t-widgets">Blogs</span>
                                </a>
                            </li>
                            @endcan

                            @can('list legal pages')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('legal.paginate.get')) !== false ? 'active' : ''}}" href="{{route('legal.paginate.get')}}">
                                    <i class="ri-draft-line"></i> <span data-key="t-widgets">Legal Pages</span>
                                </a>
                            </li>
                            @endcan

                            @can('list categories')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('category.paginate.get')) !== false ? 'active' : ''}}" href="{{route('category.paginate.get')}}">
                                    <i class="ri-collage-line"></i> <span data-key="t-widgets">Categories</span>
                                </a>
                            </li>
                            @endcan

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'home-page') !== false ? 'active' : ''}}" href="#sidebarDashboards1" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'home-page') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards1">
                                    <i class="ri-home-4-line"></i> <span data-key="t-dashboards">Home Page</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'home-page') !== false ? 'show' : ''}}" id="sidebarDashboards1">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list home page content')
                                            <li class="nav-item">
                                                <a href="{{route('home_page.banner.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('home_page.banner.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Banners Section </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'setting') !== false ? 'active' : ''}}" href="#sidebarDashboards6" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'setting') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards6">
                                    <i class="ri-tools-line"></i> <span data-key="t-dashboards">Application Settings</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'setting') !== false ? 'show' : ''}}" id="sidebarDashboards6">
                                    <ul class="nav nav-sm flex-column">
                                        @can('view general settings detail')
                                            <li class="nav-item">
                                                <a href="{{route('general.settings.get')}}" class="nav-link {{strpos(url()->current(), route('general.settings.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> General </a>
                                            </li>
                                        @endcan

                                        @can('update sitemap')
                                            <li class="nav-item">
                                                <a href="{{route('sitemap.get')}}" class="nav-link {{strpos(url()->current(), route('sitemap.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Sitemap </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'logs') !== false ? 'active' : ''}}" href="#sidebarDashboards2" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'logs') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards2">
                                    <i class="ri-alarm-warning-line"></i> <span data-key="t-dashboards">Application Logs</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'logs') !== false ? 'show' : ''}}" id="sidebarDashboards2">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list activity logs')
                                            <li class="nav-item">
                                                <a href="{{route('activity_log.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('activity_log.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Activity Logs </a>
                                            </li>
                                        @endcan

                                        @can('view application error logs')
                                            <li class="nav-item">
                                                <a href="{{route('error_log.get')}}" class="nav-link {{strpos(url()->current(), route('error_log.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Error Logs </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>
