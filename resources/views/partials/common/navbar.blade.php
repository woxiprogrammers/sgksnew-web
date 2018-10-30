@section('navBar')
<div class="page-header">
    <div class="page-header-top">
        <div class="container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/">
                    <img src="/assets/global/img/sgkks_logo.png" alt="logo" class="logo-default">
                </a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-hoverable" class after "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                    <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN TODO DROPDOWN -->
                    <!-- END TODO DROPDOWN -->
                    <li class="droddown dropdown-separator">
                        <span class="separator"></span>
                    </li>
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="/assets/layouts/layout3/img/no-user.jpg">
                            <span class="username username-hide-mobile">{{ \Illuminate\Support\Facades\Auth::user()->first_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="/logout">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>

                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->

                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->
    <div class="page-header-menu">
        <div class="container" style="width: 100%">
            <!-- BEGIN HEADER SEARCH BOX -->
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN MEGA MENU -->
            <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
            <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
            <div class="hor-menu">
                <ul class="nav navbar-nav">
                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
                        <a href="/dashboard"> Dashboard
                            <span class="arrow"></span>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav">
                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
                        <a href="/member/manage"> Manage Members
                            <span class="arrow"></span>
                        </a>
                    </li>
                </ul>
                {{--<ul class="nav navbar-nav">
                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
                        <a href="/committee/manage"> Manage Committee
                            <span class="arrow"></span>
                        </a>
                    </li>
                </ul>--}}
            </li>
        </div>
            <!-- END MEGA MENU -->
    </li>
</ul>
</div>
</div>
    <!-- END HEADER MENU -->
</div>
</div>
@endsection
