<li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-1 me-xl-0">
    <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        <i class='mdi mdi-view-grid-plus-outline mdi-24px'></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end py-0">
        <div class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
                <h5 class="text-body mb-0 me-auto">Shortcuts</h5>
                <a href="javascript:void(0)" class="dropdown-shortcuts-add text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i class="mdi mdi-view-grid-plus-outline mdi-24px"></i></a>
            </div>
        </div>
        <div class="dropdown-shortcuts-list scrollable-container">
            <div class="row row-bordered overflow-visible g-0">
                <div class="dropdown-shortcuts-item col">
                  <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                    <i class="mdi mdi-calendar fs-4"></i>
                  </span>
                    <a href="{{url('app/calendar')}}" class="stretched-link">Calendar</a>
                    <small class="text-muted mb-0">Appointments</small>
                </div>
                <div class="dropdown-shortcuts-item col">
                  <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                    <i class="mdi mdi-file-document-outline fs-4"></i>
                  </span>
                    <a href="{{url('app/invoice/list')}}" class="stretched-link">Invoice App</a>
                    <small class="text-muted mb-0">Manage Accounts</small>
                </div>
            </div>
            <div class="row row-bordered overflow-visible g-0">
                <div class="dropdown-shortcuts-item col">
                  <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                    <i class="mdi mdi-account-outline fs-4"></i>
                  </span>
                    <a href="{{url('app/user/list')}}" class="stretched-link">User App</a>
                    <small class="text-muted mb-0">Manage Users</small>
                </div>
                <div class="dropdown-shortcuts-item col">
                  <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                    <i class="mdi mdi-shield-check-outline fs-4"></i>
                  </span>
                    <a href="{{url('app/access-roles')}}" class="stretched-link">Role Management</a>
                    <small class="text-muted mb-0">Permission</small>
                </div>
            </div>
            <div class="row row-bordered overflow-visible g-0">
                <div class="dropdown-shortcuts-item col">
                  <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                    <i class="mdi mdi-chart-pie-outline fs-4"></i>
                  </span>
                    <a href="{{url('/')}}" class="stretched-link">Dashboard</a>
                    <small class="text-muted mb-0">User Profile</small>
                </div>
                <div class="dropdown-shortcuts-item col">
                  <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                    <i class="mdi mdi-cog-outline fs-4"></i>
                  </span>
                    <a href="{{url('pages/account-settings-account')}}" class="stretched-link">Setting</a>
                    <small class="text-muted mb-0">Account Settings</small>
                </div>
            </div>
            <div class="row row-bordered overflow-visible g-0">
                <div class="dropdown-shortcuts-item col">
                  <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                    <i class="mdi mdi-help-circle-outline fs-4"></i>
                  </span>
                    <a href="{{url('pages/help-center-landing')}}" class="stretched-link">Help Center</a>
                    <small class="text-muted mb-0">FAQs & Articles</small>
                </div>
                <div class="dropdown-shortcuts-item col">
                  <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                    <i class="mdi mdi-dock-window fs-4"></i>
                  </span>
                    <a href="{{url('modal-examples')}}" class="stretched-link">Modals</a>
                    <small class="text-muted mb-0">Useful Popups</small>
                </div>
            </div>
        </div>
    </div>
</li>