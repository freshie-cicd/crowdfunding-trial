<aside id="sidebar" class="sidebar break-point-lg has-bg-image">
  <div class="sidebar-layout">
    <div class="sidebar-header align-self-center">
      <span style="text-transform: uppercase;font-size:12px;letter-spacing:4px; font-weight: bold;">{{ config('app.name', 'Laravel') }}</span>
    </div>
    <div class="sidebar-content">
      <nav class="menu open-current-submenu">
        <ul>
          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-gear"></i></span><span class="menu-title">Basic Setup</span>
            </a>
<!--Sub Menu Starts-->

                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Grid</span></a></li>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Grid</span></a></li>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Grid</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Starts-->

          </li>
          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-boxes-stacked"></i></span><span class="menu-title">Purchase/Supply</span>
            </a>
<!--Sub Menu Starts-->
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Dark</span></a></li>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Dark</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Ends-->
          </li>

          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-cash-register"></i></span><span class="menu-title">Sales and Stock</span>
            </a>
<!--Sub Menu Starts-->
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Dark</span></a></li>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Dark</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Ends-->
          </li>

          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-receipt"></i></span><span class="menu-title">Expense Tracker</span>
            </a>
<!--Sub Menu Starts-->
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Dark</span></a></li>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Dark</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Ends-->
          </li>

          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-money-bill-transfer"></i></span><span class="menu-title">Transactions</span>
            </a>
<!--Sub Menu Starts-->
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Dark</span></a></li>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Dark</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Ends-->
          </li>

          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-chart-pie"></i></span><span class="menu-title">Reports</span>
            </a>
<!--Sub Menu Starts-->
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Dark</span></a></li>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Dark</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Ends-->
          </li>

          <li class="menu-item">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-book"></i></span><span class="menu-title">Documentation</span>
            </a>
          </li>

        </ul>
      </nav>
    </div>
    <div class="sidebar-footer d-grid gap-2">
        <a class="btn btn-sm btn-danger" style="color:white;" href="{{ route('logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="menu-title"> <i class="fa-solid fa-sign-out"></i> {{ __('Logout') }} </span></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
    </div>
  </div>
</aside>
