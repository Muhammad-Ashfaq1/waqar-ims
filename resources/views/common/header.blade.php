@php $authUser = auth()->user(); @endphp

<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown ims-nav-user">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <div class="ims-avatar-wrapper">
              <img src="{{ $authUser ? $authUser->profile_image_url : asset('img/img.jpg') }}"
                   alt="{{ $authUser ? $authUser->name : 'Shop 1 Admin' }}"
                   class="ims-avatar-circle">
              <span class="ims-status-dot"></span>
            </div>
          </a>

          <ul class="dropdown-menu pull-right ims-dropdown-card">
            <li class="ims-dd-item">
              <div class="ims-dd-header">
                <div class="ims-dd-name">{{ $authUser ? $authUser->name : 'Shop 1 Admin' }}</div>
                <div class="ims-dd-email">{{ $authUser ? $authUser->email : 'admin1@pos.com' }}</div>
              </div>
            </li>
            <li class="ims-dd-divider"></li>
            <li class="ims-dd-item">
              <div class="ims-dd-role">Admin</div>
            </li>
            <li class="ims-dd-divider"></li>
            <li class="ims-dd-item">
              <a href="{{ url('profile') }}" class="ims-dd-profile">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>Profile</span>
              </a>
            </li>
            <li class="ims-dd-divider"></li>
            <li class="ims-dd-item">
              <form class="ims-dd-signout-form" action="{{ url('logout') }}" method="POST">
                @csrf
                <button type="submit" class="ims-dd-signout">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                  </svg>
                  <span>Sign out</span>
                </button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>
