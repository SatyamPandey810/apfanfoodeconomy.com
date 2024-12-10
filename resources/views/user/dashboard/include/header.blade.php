<div class="horizontal-menu">
    <nav class="navbar top-navbar col-lg-12 col-12 p-0 d-block d-md-none">
        <div class="container">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                
                
                    <div>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                            data-toggle="horizontal-menu-toggle">
                            <span class="mdi mdi-menu"></span>
                        </button>
                    </div>
                    <li class="nav-item d-block d-md-none">
                        <ul class="navbar-nav navbar-nav-right">
                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link" id="profileDropdown" href="" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <div class="nav-profile-img fs-2 ">
                                        <i class="fa-solid fa-user "></i>
                                        <span class="font-13 online-color">online <i
                                                class="mdi mdi-chevron-down"></i></span>
                                    </div>

                                </a>
                                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                                    <a class="dropdown-item" href="{{route('profile')}}">
                                        <i class="mdi mdi-account mr-2 text-success"></i> Profile </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{route('user.logout')}}">
                                        <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>
                                </div>
                            </li>
                        </ul>
                    </li>

            </div>
        </div>
    </nav>
    <nav class="bottom-navbar p-3">
        <div class="container">
            <ul class="nav page-navigation">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{route('user.dashboard.index')}}">
<img src="{{asset('public/website/img/title1.png')}}" >
                        
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.dashboard.index')}}">
                        <i class="mdi mdi-compass-outline menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('network-list')}}">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title">Direct Referral</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="mdi mdi-monitor-dashboard menu-icon"></i>
                        <span class="menu-title">Network</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user-tree')}}">Feerder</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user-tree-stage1')}}">Stage-1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user-tree-stage2')}}">Stage-2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user-tree-stage3')}}">Stage-3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user-tree-stage4')}}">Stage-4</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user-tree-stage5')}}">Stage-5</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('reward')}}">
                        <i class="mdi mdi-contacts menu-icon"></i>
                        <span class="menu-title">Reward Bonus</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('food')}}">
                        <i class="mdi mdi-contacts menu-icon"></i>
                        <span class="menu-title">Food Bonus</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('withdrawal.request')}}">
                        <i class="mdi mdi-chart-bar menu-icon"></i>
                        <span class="menu-title">Withdrawal Request</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('withdrawal.history')}}">
                        <i class="mdi mdi-table-large menu-icon"></i>
                        <span class="menu-title">Withdrawal History</span>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block "
                    style="display: flex; justify-content: center; align-items: center;">
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link" id="profileDropdown" href="" data-toggle="dropdown"
                                aria-expanded="false">
                                <div class="nav-profile-img fs-2">
                                    <i class="fa-solid fa-user "></i>
                                    <span class="font-13 online-color">online <i
                                            class="mdi mdi-chevron-down"></i></span>
                                </div>

                            </a>
                            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                                <a class="dropdown-item" href="{{route('profile')}}">
                                    <i class="mdi mdi-account mr-2 text-success"></i> Profile </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('user.logout')}}">
                                    <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- <script src="{{asset('/public/user/panel/assets/vendors/js/vendor.bundle.base.js')}}"></script>
<script src="{{asset('/public/user/panel/assets/vendors/chart.js/Chart.min.js')}}"></script> -->