<div class="rbt-default-sidebar-wrapper">
    <div class="section-title mb--20">
        <div class="d-flex">
            <div>
                <h5 class="">Welcome, {{ Auth::user()->name }}</h5>
                <div class="mt-2 mb-0 d-flex">
                    @if(Auth::user()->type === \App\Enums\UserType::SCHOOL->value )
                        <span
                            style="background: #2f57ef; padding: 5px 15px; font-size: 12px; color: #fff; font-weight: bold; border-radius: 17px">
                            {{ \App\Enums\UserType::from(Auth::user()->type)->name }}
                        </span>
                    @endif
                    @if(Auth::user()->type === \App\Enums\UserType::STUDENT->value )
                        <span
                            style="background: #21b566; padding: 5px 15px; font-size: 12px; color: #fff; font-weight: bold; border-radius: 17px">
                            {{ \App\Enums\UserType::from(Auth::user()->type)->name }}
                        </span>
                    @endif
                    @if(Auth::user()->type === \App\Enums\UserType::TEACHER->value )
                        <span
                            style="background: #7321b5; padding: 5px 15px; font-size: 12px; color: #fff; font-weight: bold; border-radius: 17px">
                            {{ \App\Enums\UserType::from(Auth::user()->type)->name }}
                        </span>
                    @endif
                </div>

            </div>
            <div class="circle-container" style="margin-left: 80px">
                <div class="number-circle">{{ Auth::user()->remaining_downloads }}</div>
            </div>
        </div>

    </div>
    <nav class="mainmenu-nav">
        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
            <li>
                <a class="{{ request()->is('dashboard*') ? 'active' : '' }}"
                    href="{{ url('/dashboard') }}">
                    <i class="feather-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @if(empty($warning))
                <li><a class="{{ request()->is('profile*') ? 'active' : '' }}"
                       href="{{ url('/profile') }}">
                        <i class="feather-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->is('download/history') ? 'active' : '' }}"
                       href="{{ route('user.download.history') }}">
                        <i class="feather-book-open"></i>
                        <span>Download History</span>
                    </a>
                </li>
                @if(Auth::user()->type === \App\Enums\UserType::SCHOOL->value)
                    <li>
                        <a class="{{ request()->is('users') ? 'active' : '' }}"
                           href="{{ route('users.index') }}">
                            <i class="feather-book-open"></i>
                            <span>User List</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a class="{{ request()->is('subscription-list') ? 'active' : '' }}"
                       href="{{ route('user.subscription.list') }}">
                        <i class="feather-book-open"></i>
                        <span>Subscription List</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->is('order-history*') ? 'active' : '' }}"
                       href="{{ route('user.order.history') }}">
                        <i class="feather-book-open"></i>
                        <span>Order History</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>


    <div class="section-title mt--40 mb--20">
        <h6 class="rbt-title-style-2">User</h6>
    </div>

    <nav class="mainmenu-nav">
        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
            <li><a class="{{ request()->is('edit-profile*') ? 'active' : '' }}"
                    href="{{ url('/edit-profile') }}">
                    <i class="feather-settings"></i>
                    <span>Edit Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.logout') }}">
                    <i class="feather-log-out"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
