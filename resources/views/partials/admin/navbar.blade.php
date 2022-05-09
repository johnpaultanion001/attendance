<nav class="navbar navbar-expand-lg bg-primary">
              <div class="container">
                <div class="navbar-translate">
                  <a class="navbar-brand" href="/admin/announcements">{{ trans('panel.site_title') }}</a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#example-navbar-danger" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                  </button>
                </div>
                <div class="collapse navbar-collapse" id="example-navbar-danger">
                  <ul class="navbar-nav ml-auto">
                  @if(request()->is('email/verify'))

                  @else
                    @if (Auth::user())
                       <li class="nav-item">
                          <a class="nav-link {{ request()->is('admin/user')  ? 'active' : '' }}" href="/admin/user">
                            <p>HOME</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link {{ request()->is('admin/user/offboarding') || request()->is('admin/user/offboarding/*') ? 'active' : '' }}" href="/admin/user/offboarding">
                            <p>OFFBOARDING</p>
                          </a>
                        </li>
                    
                      
                      @can('admin_access')
                        <li class="nav-item">
                          <a class="nav-link {{ request()->is('admin/appointments') || request()->is('admin/appointments/*') ? 'active' : '' }}" href="/admin/appointments">
                            <p>APPLICATIONS</p>
                          </a>
                        </li>
                      @endcan
                    
                    @else
                      <li class="nav-item">
                        <a class="nav-link {{ request()->is('login') || request()->is('login/*') ? 'active' : '' }}" href="/login">
                          <p>Login</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link {{ request()->is('register') || request()->is('register/*') ? 'active' : '' }}" href="/register">
                          <p>Register</p>
                        </a>
                      </li>
                     
                    @endif
                    
                      
                      @if (Auth::user())
                        <li class="nav-item dropdown ml-4">
                          <a href="#" class="nav-link dropdown-toggle font-weight-bold" id="navbarDropdownMenuLink" data-toggle="dropdown">
                           {{Auth::user()->application->name ?? 'ADMIN'}}
                            <i class="now-ui-icons ui-1_settings-gear-63" aria-hidden="true"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                          
                            <a class="dropdown-item" href="/admin/edit_account">Edit Account</a>
                         
                            <a class="dropdown-item" href="/admin/change_password">Change Password?</a>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">Logout</a>
                          </div>
                        </li>
                      @endif
                  @endif   
                  </ul>
                </div>
              </div>
            </nav>