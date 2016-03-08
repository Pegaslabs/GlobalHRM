<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Main Menu</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ active_class(if_uri_pattern(['home']), 'active') }}"><a href="{!! URL::to('home') !!}"><i class='fa fa-dashboard'></i> <span>Dashboard</span></a></li>
            <li><a href="#"><i class='fa fa-link'></i> <span>Another Link</span></a></li>
            <li class="treeview {{ active_class(if_uri_pattern(['recruitments/*']), 'active') }}">
                <a href="#"><i class='fa fa-briefcase'></i> <span>{{ trans('labels.sidebar.recruitments.main_menu')}}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu {{ active_class(if_uri_pattern(['recruitments/*']), 'menu-open') }}">
                    <li class="{{ active_class(if_uri_pattern(['recruitments/jobs*']), 'active') }}"><a href="{!! route('recruitments.jobs.index') !!}"><i class='fa fa-reorder '></i>{{ trans('labels.sidebar.recruitments.sub_menu.jobs')}}</a></li>
                    <li><a href="{{ route('recruitments.candidates.index') }}"><i class='fa fa-group'></i>{{ trans('labels.sidebar.recruitments.sub_menu.candidates')}}</a></li>
                    <li><a href="#"><i class='fa fa-link'></i>{{ trans('labels.sidebar.recruitments.sub_menu.settings')}}</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
