<aside id="sidebar" class="sidebar break-point-lg has-bg-image">

    <div class="sidebar-layout">

        <div class="sidebar-header align-self-center">

            <span
                style="text-transform: uppercase;font-size:12px;letter-spacing:4px; font-weight: bold;">{{ config('app.name', 'Laravel') }}</span>

        </div>

        <div class="sidebar-content">

            <nav class="menu open-current-submenu">

                <ul>

                    @if (Auth::user() && Auth::user()->role == 'superadmin')
                        <li class="menu-item">
                            <a href="{{ route('administrator.home') }}">
                                <span class="menu-icon"><i class="fa-solid fa-house"></i></span><span
                                    class="menu-title">Dashboard</span>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('administrator.booking.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-calendar-day"></i></span><span
                                    class="menu-title">Bookings</span>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('project.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-calendar-day"></i></span><span
                                    class="menu-title">Projects</span>
                            </a>
                        </li>

                        {{-- <li class="menu-item sub-menu {{request()->is('administrator/projects') || request()->is('administrator/batches') ? 'open' : ''}}">

            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-gear"></i></span><span class="menu-title">Projects</span>
            </a>

            <div class="sub-menu-list">
              <ul>
                <li class="menu-item"><a href="{{ route('project.index') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Projects</span></a></li>
                <li class="menu-item"><a href="{{ route('batch.index') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Batches</span></a></li>
              </ul>
            </div>
          </li> --}}

                        <li class="menu-item">
                            <a href="{{ route('package.index') }}">
                                <span class="menu-icon"><i class="fa-solid fa-calendar-day"></i></span><span
                                    class="menu-title">Packages</span>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('admin.investor.profile') }}">
                                <span class="menu-icon"><i class="fa-solid fa-receipt"></i></span><span
                                    class="menu-title">Investor Profiles</span>
                            </a>
                        </li>

                        <li
                            class="menu-item sub-menu {{ request()->is('administrator/payment/approved') || request()->is('administrator/payment/pending') ? 'open' : '' }}">
                            <a href="#">
                                <span class="menu-icon"><i class="fa-solid fa-money-bill-transfer"></i></span><span
                                    class="menu-title">Payment Proof</span>
                            </a>

                            <!--Sub Menu Starts-->
                            <div class="sub-menu-list">
                                <ul>
                                    <li class="menu-item">
                                        <a href="{{ route('admin.payment.approved') }}">
                                            <!-- icon checkmark -->
                                            <span class="menu-icon"><i class="fa-solid fa-check"></i></span><span
                                                class="menu-title">All Approved
                                            </span>
                                        </a>
                                    </li>
                                    <li class="menu-item"><a href="{{ route('admin.payment.index') }}"><span
                                                class="menu-icon"><i class="fa-solid fa-clock"></i></span><span
                                                class="menu-title">Pending Approvals</span></a></li>
                                </ul>
                            </div>
                            <!--Sub Menu Ends-->
                        </li>
                    @endif
                    <li class="menu-item sub-menu {{ request()->is('administrator/reports/*') ? 'open' : '' }}">
                        <a href="#">
                            <span class="menu-icon"><i class="fa-solid fa-chart-pie"></i></span><span
                                class="menu-title">Reports</span>
                        </a>

                        <!--Sub Menu Starts-->
                        <div class="sub-menu-list">
                            <ul>
                                <li class="menu-item"><a href="{{ route('admin.agreement.requests') }}"><span
                                            class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span
                                            class="menu-title">Agreement Paper Requests</span></a></li>
                                <li class="menu-item"><a href="{{ route('reports.closing') }}"><span
                                            class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span
                                            class="menu-title">Closing Report</span></a></li>
                                <li class="menu-item"><a href="{{ route('reports.closing.sheet') }}"><span
                                            class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span
                                            class="menu-title">Closing Bank Sheet</span></a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="menu-item sub-menu ">
                        <a href="#">
                            <span class="menu-icon"><i class="fa-solid fa-route"></i></span><span
                                class="menu-title">Routing Numbers</span>
                        </a>

                        <!--Sub Menu Starts-->
                        <div class="sub-menu-list">
                            <ul>
                                <li class="menu-item">
                                    <a href="{{ route('administrator.routingNumbers') }}">
                                        <span class="menu-icon"><i class="fa-solid fa-add"></i></span><span
                                            class="menu-title">Add Routing Numbers</span>
                                    </a>
                                </li>
                                <li class="menu-item"><a href="{{ route('administrator.viewRoutingNums') }}"><span
                                            class="menu-icon"><i class="fa-solid fa-display"></i></span>
                                        <span class="menu-title">View Routing Numbers</span></a>
                                </li>
                               
                            </ul>
                        </div>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('admin.website.settings') }}">  
                            <span class="menu-icon"><i class="fa-solid fa-setting"></i></span><span
                                class="menu-title">App Setting</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="sidebar-footer d-grid gap-2">
            @if (Auth::user() && Auth::user()->name)
                <span class="mx-auto">{{ Auth::user()->name }}</span>
            @endif

            <a class="btn btn-sm btn-danger" style="color:white;" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span
                    class="menu-title"> <i class="fa-solid fa-sign-out"></i> {{ __('Logout') }} </span></a>
            <form id="logout-form" action="{{ route('administrator.logout') }}" method="POST" class="d-none"> @csrf
            </form>
        </div>
    </div>
</aside>
