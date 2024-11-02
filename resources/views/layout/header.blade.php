<nav class="flex-row p-0 navbar default-layout col-lg-12 col-12 fixed-top d-flex">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">

        <h3 class="mt-3 fs-5 font-weight-bold">Admin</h3>

    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="background-color:#00DC82">
        <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-left header-links">
            <li class="nav-item d-none d-xl-flex">
                <a href="#" class="nav-link"> {{ \Carbon\Carbon::today()->format('F j, Y') }}<span class="ml-1 badge badge-primary">Today</span>
                </a>
            </li>
            {{-- <li class="nav-item active d-none d-lg-flex">
        <a href="#" class="nav-link">
          <i class="mdi mdi-elevation-rise"></i>Reports</a>
      </li>
      <li class="nav-item d-none d-md-flex">
        <a href="#" class="nav-link">
          <i class="mdi mdi-bookmark-plus-outline"></i>Score</a>
      </li>
      <li class="nav-item dropdown d-none d-lg-flex">
        <a class="px-0 nav-link dropdown-toggle" id="quickDropdown" href="#" data-toggle="dropdown" aria-expanded="false"> Quick Links </a>
        <div class="pt-3 dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="quickDropdown">
          <a href="#" class="dropdown-item">Schedule <span class="ml-1 badge badge-primary">New</span></a>
          <a href="#" class="dropdown-item"><i class="mdi mdi-elevation-rise"></i>Reports</a>
          <a href="#" class="dropdown-item"><i class="mdi mdi-bookmark-plus-outline"></i>Score</a>
        </div>
      </li> --}}
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            {{-- <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-file-outline"></i>
          <span class="count">7</span>
        </a>
        <div class="pb-0 dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          <a class="py-3 dropdown-item">
            <p class="float-left mb-0 font-weight-medium">You have 7 unread mails </p>
            <span class="float-right badge badge-pill badge-primary">View all</span>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="{{ url('assets/images/faces/face10.jpg') }}" alt="image" class="img-sm profile-pic"> </div>
            <div class="flex-grow py-2 preview-item-content">
              <p class="preview-subject ellipsis font-weight-medium text-dark">Marian Garner </p>
              <p class="font-weight-light small-text"> The meeting is cancelled </p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="{{ url('assets/images/faces/face12.jpg') }}" alt="image" class="img-sm profile-pic"> </div>
            <div class="flex-grow py-2 preview-item-content">
              <p class="preview-subject ellipsis font-weight-medium text-dark">David Grey </p>
              <p class="font-weight-light small-text"> The meeting is cancelled </p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="{{ url('assets/images/faces/face3.jpg') }}" alt="image" class="img-sm profile-pic"> </div>
            <div class="flex-grow py-2 preview-item-content">
              <p class="preview-subject ellipsis font-weight-medium text-dark">Travis Jenkins </p>
              <p class="font-weight-light small-text"> The meeting is cancelled </p>
            </div>
          </a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-bell-outline"></i>
          <span class="count bg-success">4</span>
        </a>
        <div class="pb-0 dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <a class="py-3 dropdown-item border-bottom">
            <p class="float-left mb-0 font-weight-medium">4 new notifications </p>
            <span class="float-right badge badge-pill badge-primary">View all</span>
          </a>
          <a class="py-3 dropdown-item preview-item">
            <div class="preview-thumbnail">
              <i class="m-auto mdi mdi-alert text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="mb-1 preview-subject font-weight-normal text-dark">Application Error</h6>
              <p class="mb-0 font-weight-light small-text"> Just now </p>
            </div>
          </a>
          <a class="py-3 dropdown-item preview-item">
            <div class="preview-thumbnail">
              <i class="m-auto mdi mdi-settings text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="mb-1 preview-subject font-weight-normal text-dark">Settings</h6>
              <p class="mb-0 font-weight-light small-text"> Private message </p>
            </div>
          </a>
          <a class="py-3 dropdown-item preview-item">
            <div class="preview-thumbnail">
              <i class="m-auto mdi mdi-airballoon text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="mb-1 preview-subject font-weight-normal text-dark">New user registration</h6>
              <p class="mb-0 font-weight-light small-text"> 2 days ago </p>
            </div>
          </a>
        </div>
      </li> --}}
            <li class="nav-item d-none d-xl-inline-block">
                <form method="POST" action="{{ route('logout#log') }}">
                    @csrf
                    <button type="submit" class="flex items-center mt-1.5  text-white bg-transparent border-0 border-none cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                            <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                        </svg>
                        Log Out
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
