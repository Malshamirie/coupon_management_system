<div class="left-side-menu">

  <div class="h-100" data-simplebar>

    <!-- User box -->
    <div class="user-box text-center">

      <img src="{{ asset('backend/avatar.png') }}" alt="user-img" title="Mat Helme"
        class="rounded-circle img-thumbnail avatar-md">
      <div class="dropdown">
        <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown"
          aria-expanded="false">{{ auth('web')->user()->name }}</a>
        <div class="dropdown-menu user-pro-dropdown">

          <!-- item-->
          {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-user me-1"></i>
                            <span>My Account</span>
                        </a> --}}




          <!-- item-->
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="javascript:void(0);" class="dropdown-item notify-item"
              onclick="event.preventDefault(); this.closest('form').submit();">
              <i class="fe-log-out"></i>
              <span>{{ trans('back.Logout') }} </span>
            </a>
          </form>


        </div>
      </div>


      <ul class="list-inline">
        <li class="list-inline-item">
          <a href="#" class="text-muted left-user-info">
            <i class="mdi mdi-cog"></i>
          </a>
        </li>

        <li class="list-inline-item">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="javascript:void(0);" class=""
              onclick="event.preventDefault(); this.closest('form').submit();">
              <i class="mdi mdi-power"></i>
            </a>
          </form>
          {{-- <a href="#">
                        <i class="mdi mdi-power"></i>
                    </a> --}}
        </li>
      </ul>
    </div>

    <!--- Sidemenu -->
    <div id="sidebar-menu">

      <ul id="side-menu">


        <li>
          <a href="{{ route('dashboard.index') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> {{ trans('back.dashboard') }} </span>
          </a>
        </li>

        @can('users')
          <li>
            <a href="{{ route('users.index') }}">
              <i class="mdi mdi-account-multiple-plus-outline"></i>
              <span>{{ trans('back.users') }}</span>
            </a>
          </li>
        @endcan

        @can('containers')
          <li>
            <a href="{{ route('admin.containers.index') }}">
              <i class="mdi mdi-gift-outline"></i>
              <span> {{ trans('back.containers') }} </span>
            </a>
          </li>
        @endcan


        {{-- --}}
        @can('coupons')
          <li>
            <a href="{{ route('admin.coupons.index') }}">
              <i class="mdi mdi-gift-outline"></i>
              <span> {{ trans('back.coupons') }} </span>
            </a>
          </li>
        @endcan

        @can('campaigns')
          <li>
            <a href="{{ route('admin.campaigns.index') }}">
              <i class="mdi mdi-gift-outline"></i>
              <span> {{ trans('back.campaigns') }} </span>
            </a>
          </li>
        @endcan
        <li>
          <a href="{{ route('usercodes') }}">
            <i class="mdi mdi-account-multiple-plus-outline"></i>
            <span> {{ trans('back.usercoupons') }} </span>
          </a>
        </li>

        <hr>

        <li> <a> <span class="" style="font-size: 15px; color: #8f8e8e;"> {{ trans('back.section_loyalty_campaigns') }} </span> </a> </li>


                @can('loyalty_containers')
                  <li><a
                      href="{{ route('admin.loyalty_containers.index') }}"><span>{{ trans('back.loyalty_containers') }}</span></a>
                  </li>
                @endcan
                @can('loyalty_cards')
                  <li><a
                      href="{{ route('admin.loyalty_cards.index') }}"><span>{{ trans('back.loyalty_cards') }}</span></a>
                  </li>
                @endcan
                @can('loyalty_campaigns')
                  <li><a
                      href="{{ route('admin.loyalty_campaigns.index') }}"><span>{{ trans('back.loyalty_campaigns') }}</span></a>
                  </li>
                @endcan
                {{-- @can('loyalty_campaign_recipients') --}}
                  <li>
                    <a href="{{ route('admin.loyalty_campaign_recipients.index') }}">
                      <span>{{ trans('back.loyalty_campaign_recipients') }}</span>
                    </a>
                  </li>
                {{-- @endcan --}}

                <li>
                  <a href="{{ route('admin.loyalty_card_requests.index') }}">
                    <span>{{ trans('back.loyalty_card_requests') }}</span>
                  </a>
                </li>
                @can('cities')
                  <li><a href="{{ route('admin.cities.index') }}"><span>{{ trans('back.cities') }}</span></a></li>
                @endcan
                @can('groups')
                  <li><a href="{{ route('admin.groups.index') }}"><span>{{ trans('back.groups') }}</span></a></li>
                @endcan
                @can('branches')
                  <li><a href="{{ route('admin.branches.index') }}"><span>{{ trans('back.branches') }}</span></a></li>
                @endcan
                @can('customers')
                  <li><a href="{{ route('admin.customers.index') }}"><span>{{ trans('back.customers') }}</span></a></li>
                @endcan
             

        

        {{-- اعدادات النظام --}}
        @can('setting')
          <li>
            <a href="#setting" data-bs-toggle="collapse">
              <i class="fe-settings noti-icon"></i>
              <span>{{ trans('back.setting') }}</span>
              <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="setting">
              <ul class="nav-second-level">

                @can('roles')
                  <li><a href="{{ route('roles.index') }}"><span> {{ trans('back.roles') }} </span></a></li>
                @endcan
                @can('setting')
                  <li><a href="{{ route('setting.index') }}"> <span>{{ trans('back.setting') }} </span> </a></li>
                @endcan

              </ul>
            </div>
          </li>
        @endcan
      </ul>
    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

  </div>
  <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
