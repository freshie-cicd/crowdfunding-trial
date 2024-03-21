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
              <span class="menu-icon"><i class="fa-solid fa-gear"></i></span><span class="menu-title">Projects</span>
            </a>
<!--Sub Menu Starts-->

                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="{{ route('project.index') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">All Projects</span></a></li>
                      <li class="menu-item"><a href="{{ route('project.create') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Add a Project</span></a></li>
                      <li class="menu-item"><a href="{{ route('batch.index') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">All Batches</span></a></li>
                      <li class="menu-item"><a href="{{ route('batch.create') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Add New Batch</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Starts-->

          </li>
          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-boxes-stacked"></i></span><span class="menu-title">Packages</span>
            </a>
<!--Sub Menu Starts-->
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="{{ route('package.index') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">All Packages</span></a></li>
                      <li class="menu-item"><a href="{{ route('package.create') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Add New Package</span></a></li>
                      <li class="menu-item"><a href="{{ route('asset.index') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">All Assets/Livestocks</span></a></li>
                      <li class="menu-item"><a href="{{ route('asset.create') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">New Asset/Livestock</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Ends-->
          </li>

          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-cash-register"></i></span><span class="menu-title">Expense Tracker</span>
            </a>
<!--Sub Menu Starts-->
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="{{ route('expense_head.index') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Chart of Expenses</span></a></li>
                      <li class="menu-item"><a href="{{ route('expense.index') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">New Expense Entry</span></a></li>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Expense Report</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Ends-->
          </li>

          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-cash-register"></i></span><span class="menu-title">Updates Tracker</span>
            </a>
<!--Sub Menu Starts-->
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="{{ route('update.index') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Updates</span></a></li>
                      <li class="menu-item"><a href="{{ route('update.create') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">New Update Entry</span></a></li>
                      <li class="menu-item"><a href="#"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Report</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Ends-->
          </li>

          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-receipt"></i></span><span class="menu-title">Investor Profiles</span>
            </a>
<!--Sub Menu Starts-->
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="{{ route('admin.investor.profile') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">All Investors</span></a></li>
                      <li class="menu-item"><a href="{{ route('admin.investor.active') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Active Investors</span></a></li>
                      <li class="menu-item"><a href="{{ route('admin.investor.inactive') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Add New Investor</span></a></li>
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
                      <li class="menu-item"><a href="{{ route('admin.payment.approved') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">All Transactions</span></a></li>
                      <li class="menu-item"><a href="{{ route('admin.payment.index') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Pending Approvals</span></a></li>
                      <li class="menu-item"><a href="{{ route('admin.payment.approved') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Approved Investors</span></a></li>
                    </ul>
                  </div>
<!--Sub Menu Ends-->
          </li>

          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon"><i class="fa-solid fa-money-bill-transfer"></i></span><span class="menu-title">Project Borga</span>
            </a>
<!--Sub Menu Starts-->
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item"><a href="{{ route('admin.borga.cow_profile') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Cow Profiles </span></a></li>
                      <li class="menu-item"><a href="{{ route('admin.borga.cow_profile_create') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Add New Cow Profile</span></a></li>
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
                      <li class="menu-item"><a href="{{ route('admin.agreement.requests') }}"><span class="menu-icon"><i class="fa-solid fa-caret-right"></i></span><span class="menu-title">Agreement Paper Requests</span></a></li>
                      
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
