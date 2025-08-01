<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile not-navigation-link">
            <div class="nav-link">
                <div class="user-wrapper">
                    <div class="profile-image" style="height: 50px; width: 50px; border-radius: 50%; overflow: hidden;">
                        <img src="{{ filter_var(Auth::user()->image, FILTER_VALIDATE_URL) ? Auth::user()->image : (Auth::user()->image && file_exists(public_path('storage/images/' . Auth::user()->image)) ? asset('storage/images/' . Auth::user()->image) : asset('images/default.png')) }}"
                            style="width: 100%; height: 100%; object-fit: cover;" alt="profile image" />
                    </div>

                    <div class="mt-2 text-wrapper">
                        <p class="profile-name">{{ Auth::user()->name }}</p>
                        <div class="dropdown" data-display="static">
                            <a href="#" class="nav-link d-flex user-switch-dropdown-toggler"
                                id="UsersettingsDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                <small class="designation text-muted">Manager</small>
                                <span class="status-indicator online"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="UsersettingsDropdown">
                                <a class="p-0 dropdown-item">
                                    <div class="d-flex border-bottom">
                                        <div class="px-4 py-3 d-flex align-items-center justify-content-center">
                                            <i class="mr-0 mdi mdi-bookmark-plus-outline text-gray"></i>
                                        </div>
                                        <div
                                            class="px-4 py-3 d-flex align-items-center justify-content-center border-left border-right">
                                            <i class="mr-0 mdi mdi-account-outline text-gray"></i>
                                        </div>
                                        <div class="px-4 py-3 d-flex align-items-center justify-content-center">
                                            <i class="mr-0 mdi mdi-alarm-check text-gray"></i>
                                        </div>
                                    </div>
                                </a>
                                <a class="mt-2 dropdown-item"> Manage Accounts </a>
                                <a class="dropdown-item"> Change Password </a>
                                <a class="dropdown-item"> Check Inbox </a>
                                <a class="dropdown-item"> Sign Out </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('get#data') }}">
                <i class="menu-icon mdi mdi-television"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('manage#acc') }}">
                <i class="menu-icon mdi mdi-lock-outline"></i>
                <span class="menu-title">User Pages</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('change#password') }}">
                <svg xmlns="http://www.w3.org/2000/svg" height="23px" viewBox="0 -960 960 960" width="23px"
                    fill="#5f6368">
                    <path
                        d="M80-200v-80h800v80H80Zm46-242-52-30 34-60H40v-60h68l-34-58 52-30 34 58 34-58 52 30-34 58h68v60h-68l34 60-52 30-34-60-34 60Zm320 0-52-30 34-60h-68v-60h68l-34-58 52-30 34 58 34-58 52 30-34 58h68v60h-68l34 60-52 30-34-60-34 60Zm320 0-52-30 34-60h-68v-60h68l-34-58 52-30 34 58 34-58 52 30-34 58h68v60h-68l34 60-52 30-34-60-34 60Z" />
                </svg>
                <span class="ml-2 menu-title">Change Password</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin#acc', Auth::id()) }}">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#5f6368">
                    <path
                        d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z" />
                </svg>
                <span class="ml-2 menu-title">Admin Account</span>
            </a>
        </li>
        {{-- <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#basic-ui" aria-expanded="" aria-controls="basic-ui">
        <i class="menu-icon mdi mdi-dna"></i>
        <span class="menu-title">Basic UI Elements</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse " id="basic-ui">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item ">
            <a class="nav-link" href="{{ route('basic-ui#buttons') }}">Buttons</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="">Dropdowns</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="">Typography</a>
          </li>
        </ul>
      </div>
    </li> --}}

        {{-- <li class="nav-item ">
      <a class="nav-link" >
        <i class="menu-icon mdi mdi-chart-line"></i>
        <span class="menu-title">Charts</span>
      </a>
    </li>
    <li class="nav-item ">
      <a class="nav-link" href="{{ url('/tables/basic-table') }}">
        <i class="menu-icon mdi mdi-table-large"></i>
        <span class="menu-title">Tables</span>
      </a>
    </li>
    <li class="nav-item ">
      <a class="nav-link" href="{{ url('/icons/material') }}">
        <i class="menu-icon mdi mdi-emoticon"></i>
        <span class="menu-title">Icons</span>
      </a>
    </li>
    <li class="nav-item ">
      <a class="nav-link" data-toggle="collapse" href="#user-pages" aria-expanded="" aria-controls="user-pages">
        <i class="menu-icon mdi mdi-lock-outline"></i>
        <span class="menu-title">User Pages</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse " id="user-pages">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item ">
            <a class="nav-link" href="{{ url('/user-pages/login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/user-pages/register') }}">Register</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="{{ url('/user-pages/lock-screen') }}">Lock Screen</a>
          </li>
        </ul>
      </div>
    {{-- </li> --}}
        {{-- <li class="nav-item">
      <a class="nav-link" href="https://www.bootstrapdash.com/demo/star-laravel-free/documentation/documentation.html" target="_blank">
        <i class="menu-icon mdi mdi-file-outline"></i>
        <span class="menu-title">Documentation</span>
      </a>
    </li>  --}}
    </ul>
</nav>
