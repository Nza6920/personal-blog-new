<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ route('admin.show') }}">
                博客后台
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li>
                  <a href="{{ route('admin.create') }}">
                      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                  </a>
              </li>
              <li class="dropdown">

                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px;">
                          <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px">
                      </span>
                      {{ Auth::user()->name }} <span class="caret"></span>
                  </a>


                  <ul class="dropdown-menu" role="menu">
                      <li>
                          <a href="#"
                              onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                              退出登录
                          </a>
                          <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
                              {{ method_field('DELETE') }}
                              {{ csrf_field() }}
                          </form>
                      </li>

                  </ul>
              </li>
            </ul>
        </div>
    </div>
</nav>
