<div class="pcoded-main-container">

  <div class="pcoded-wrapper">

      <nav class="pcoded-navbar">

          <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>

          <div class="pcoded-inner-navbar main-menu">

              <div class="">

                <div class="main-menu-header" style="background: white;">

                      <img class="img-40 img-radius" src="{{asset('public/asset/img/admin.png')}}" style="border-radius:50%" alt="Admin">

                      <div class="user-details">

                        <span><h4>Admin</h4></span>

                      </div>

                  </div>

              </div>

              <ul class="pcoded-item pcoded-left-item">

                  <li class="">

                      <a href="{{route('dashboard')}}">

                          <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>

                          <span class="pcoded-mtext " data-i18n="nav.dash.main">Dashboard</span>

                          <span class="pcoded-mcaret"></span>

                      </a>

                  </li>

                  <li class="pcoded-hasmenu">

                    <a href="javascript:void(0)">

                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>

                        <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Pakeges</span>

                        <span class="pcoded-mcaret"></span>

                    </a>

                    <ul class="pcoded-submenu">

                        <li class=" ">

                            <a href="{{route('packages.create')}}">

                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>

                                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Create Pakege</span>

                                <span class="pcoded-mcaret"></span>

                            </a>

                        </li>

                        <li class="">

                            <a href="{{route('packages.index')}}">

                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>

                                <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Show Pakege</span>

                                <span class="pcoded-mcaret"></span>

                            </a>

                        </li>

                    </ul>

                </li>

                  <li class="pcoded-hasmenu">

                      <a href="javascript:void(0)">

                          <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>

                          <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Pin</span>

                          <span class="pcoded-mcaret"></span>

                      </a>

                      <ul class="pcoded-submenu">

                          <li class=" ">

                              <a href="{{route('dashboard.create-pin')}}">

                                  <span class="pcoded-micon"><i class="ti-angle-right"></i></span>

                                  <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Create Pin</span>

                                  <span class="pcoded-mcaret"></span>

                              </a>

                          </li>

                          <li class="">

                              <a href="{{route('dashboard.show-pin')}}">

                                  <span class="pcoded-micon"><i class="ti-angle-right"></i></span>

                                  <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Show Pin</span>

                                  <span class="pcoded-mcaret"></span>

                              </a>

                          </li>

                          <li class=" ">

                              <a href="{{route('dashboard.used-pin')}}">

                                  <span class="pcoded-micon"><i class="ti-angle-right"></i></span>

                                  <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Used Pin</span>

                                  <span class="pcoded-mcaret"></span>

                              </a>

                          </li>

                      </ul>

                  </li>

                  <li class="pcoded-hasmenu">

                    <a href="javascript:void(0)">

                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>

                        <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">User List</span>

                        <span class="pcoded-mcaret"></span>

                    </a>

                    <ul class="pcoded-submenu">

                        <li class=" ">

                            <a href="{{route('user')}}">

                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>

                                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">User list</span>

                                <span class="pcoded-mcaret"></span>

                            </a>

                        </li>


                    </ul>

                </li>


                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                        <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Withdrawal</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class=" ">
                            <a href="{{route('withdrawal.panding')}}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Withdrawal Request</span>
                                <span class="pcoded-mcaret"></span>
                            </a> 
                        </li>
                        <li class=" ">
                            <a href="{{route('withdrawal.success')}}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Withdrawal Success</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{route('withdrawal.cancel')}}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Withdrawal Cancel</span>
                                <span class="pcoded-mcaret"></span>
                            </a> 
                        </li>
                    </ul>
                </li> 
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                        <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Food Request</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class=" ">
                            <a href="{{route('foodrequest')}}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Food request</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li> 
                        <li class="">
                            <a href="{{route('foodsuccess')}}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Food Success</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li> 
                    </ul>
                </li>     

                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                        <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Gallery</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class=" ">
                            <a href="{{route('gallery')}}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Gallery</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li> 
                    </ul>
                </li>

              </ul>

          </div>

      </nav>

      