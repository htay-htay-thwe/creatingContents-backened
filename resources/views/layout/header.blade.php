<nav class="flex-row p-0 navbar fixed-top d-flex">
    <!-- Left side -->
    <div class="text-center navbar-brand-wrapper d-none d-lg-flex align-items-top justify-content-center">
        <h3 class="mt-3 fs-5 font-weight-bold">Admin</h3>
    </div>

    <!-- Right side -->
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end flex-grow-1">
        <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>

        <ul class="ml-3 navbar-nav navbar-nav-left header-links">
            <li class="nav-item d-none d-xl-flex">
                <a href="#" class="nav-link">
                    {{ \Carbon\Carbon::today()->format('F j, Y') }}
                    <span class="ml-1 badge badge-primary">Today</span>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item d-none d-xl-inline-block">
                <form method="POST" action="{{ route('logout#log') }}">
                    @csrf
                    <button type="submit" class="text-white btn btn-link d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#FFFFFF">
                            <path
                                d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                        </svg>
                        <span class="ml-2">Log Out</span>
                    </button>
                </form>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu icon-menu"></span>
        </button>
    </div>
</nav>
