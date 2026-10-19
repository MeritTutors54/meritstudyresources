{{-- resources/views/frontend/dashboard/include/menu.blade.php --}}
@php
    use App\Enums\UserType;

    $u         = Auth::user();
    $fullName  = trim($u->name ?? '');
    $initials  = collect(explode(' ', $fullName))->filter()->take(2)
                    ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
    $typeName  = UserType::tryFrom($u->type)?->name;
    $typeClass = match ($u->type) {
        UserType::SCHOOL->value  => 'is-school',
        UserType::TEACHER->value => 'is-teacher',
        default                  => 'is-student',
    };
    $isSchool  = $u->type === UserType::SCHOOL->value;
@endphp

@once
<style>
    .msr-menu {
        --m-green: var(--merit-green, #168a45);
        --m-dark: var(--merit-dark-green, #0e6d39);
        --m-navy: var(--merit-navy, #102c46);
        --m-light: var(--merit-light-green, #f1f8f3);
        --m-line: var(--merit-line, #edf1f3);
        --m-text: var(--merit-text, #203344);
        --m-muted: var(--merit-muted, #6b7c89);
        --m-radius: 8px;
        font-family: "Inter", system-ui, -apple-system, "Segoe UI", sans-serif;
    }

    /* user card */
    .msr-menu-user {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 0 0 1rem;
        margin-bottom: .85rem;
        border-bottom: 1px solid var(--m-line);
    }
    .msr-menu-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: none;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--m-green);
        color: #fff;
        font-size: .9rem;
        font-weight: 700;
        box-shadow: 0 0 0 3px var(--m-light);
    }
    .msr-menu-who { min-width: 0; }
    .msr-menu-hello { display: block; font-size: .72rem; font-weight: 600; color: var(--m-muted); }
    .msr-menu-name {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: .95rem;
        font-weight: 700;
        line-height: 1.25;
        color: var(--m-navy);
    }
    .msr-menu-type {
        display: inline-block;
        margin-top: .3rem;
        padding: .12rem .6rem;
        border-radius: 999px;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }
    .msr-menu-type.is-student { background: #e9f4ee; color: #0e6d39; }
    .msr-menu-type.is-school  { background: #eaf0fe; color: #2f57ef; }
    .msr-menu-type.is-teacher { background: #f3ebfa; color: #7321b5; }

    /* downloads left */
    .msr-menu-credit {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .5rem;
        margin-bottom: 1rem;
        padding: .7rem .85rem;
        border: 1px solid #d9e9df;
        border-radius: var(--m-radius);
        background: var(--m-light);
    }
    .msr-menu-credit-label { font-size: .78rem; font-weight: 600; color: var(--m-muted); }
    .msr-menu-credit-num { font-size: 1.25rem; font-weight: 800; letter-spacing: -.02em; color: var(--m-dark); line-height: 1; }

    /* links */
    .msr-menu-heading {
        margin: 1.1rem .75rem .4rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--m-muted);
    }
    .msr-menu-list { display: grid; gap: .1rem; margin: 0; padding: 0; list-style: none; }
    .msr-menu-list li { margin: 0; padding: 0; }
    .msr-menu-link {
        position: relative;
        display: flex;
        align-items: center;
        gap: .7rem;
        padding: .62rem .75rem;
        border-radius: var(--m-radius);
        font-size: .9rem;
        font-weight: 500;
        line-height: 1.3;
        color: var(--m-text);
        text-decoration: none;
        transition: background .16s ease, color .16s ease;
    }
    .msr-menu-link i { flex: none; width: 18px; font-size: 1rem; text-align: center; color: #8aa096; transition: color .16s ease; }
    .msr-menu-link:hover,
    .msr-menu-link:focus-visible { background: var(--m-light); color: var(--m-dark); text-decoration: none; }
    .msr-menu-link:hover i { color: var(--m-green); }
    .msr-menu-link.is-active {
        background: var(--m-light);
        color: var(--m-dark);
        font-weight: 600;
        box-shadow: inset 3px 0 0 var(--m-green);
    }
    .msr-menu-link.is-active i { color: var(--m-green); }
    .msr-menu-link.is-logout:hover { background: #fbeef1; color: #b8304f; }
    .msr-menu-link.is-logout:hover i { color: #b8304f; }

    /* mobile: one swipeable row */
    @media (max-width: 991.98px) {
        .msr-menu-user { margin-bottom: .6rem; padding-bottom: .75rem; }
        .msr-menu-credit { margin-bottom: .6rem; }
        .msr-menu-links { display: flex; gap: .3rem; overflow-x: auto; scrollbar-width: none; }
        .msr-menu-links::-webkit-scrollbar { display: none; }
        .msr-menu-heading { display: none; }
        .msr-menu-list { display: flex; flex: none; gap: .3rem; }
        .msr-menu-link {
            white-space: nowrap;
            padding: .45rem .85rem;
            border: 1px solid #e3eae6;
            border-radius: 999px;
            font-size: .84rem;
        }
        .msr-menu-link.is-active { box-shadow: none; border-color: var(--m-green); background: var(--m-green); color: #fff; }
        .msr-menu-link.is-active i { color: #fff; }
    }
</style>
@endonce

<div class="msr-menu">
    <!-- User -->
    <div class="msr-menu-user">
        <span class="msr-menu-avatar" aria-hidden="true">{{ $initials }}</span>
        <div class="msr-menu-who">
            <span class="msr-menu-hello">Welcome,</span>
            <span class="msr-menu-name" title="{{ $fullName }}">{{ $fullName }}</span>
            @if($typeName)
                <span class="msr-menu-type {{ $typeClass }}">{{ ucfirst(strtolower($typeName)) }}</span>
            @endif
        </div>
    </div>

    <!-- Downloads left -->
    <div class="msr-menu-credit">
        <span class="msr-menu-credit-label"><i class="feather-download"></i> Downloads remaining</span>
        <span class="msr-menu-credit-num">{{ number_format($u->remaining_downloads ?? 0) }}</span>
    </div>

    <nav class="msr-menu-links" aria-label="Dashboard menu">
        <ul class="msr-menu-list">
            <li>
                <a class="msr-menu-link {{ request()->is('dashboard') ? 'is-active' : '' }}"
                   href="{{ url('/dashboard') }}" @if(request()->is('dashboard')) aria-current="page" @endif>
                    <i class="feather-home"></i><span>Dashboard</span>
                </a>
            </li>

            @if(empty($warning))
                <li>
                    <a class="msr-menu-link {{ request()->is('profile*') ? 'is-active' : '' }}"
                       href="{{ url('/profile') }}" @if(request()->is('profile*')) aria-current="page" @endif>
                        <i class="feather-user"></i><span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="msr-menu-link {{ request()->is('download/history*') ? 'is-active' : '' }}"
                       href="{{ route('user.download.history') }}" @if(request()->is('download/history*')) aria-current="page" @endif>
                        <i class="feather-download-cloud"></i><span>Download History</span>
                    </a>
                </li>
                @if($isSchool)
                    <li>
                        <a class="msr-menu-link {{ request()->is('users*') ? 'is-active' : '' }}"
                           href="{{ route('users.index') }}" @if(request()->is('users*')) aria-current="page" @endif>
                            <i class="feather-users"></i><span>User List</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a class="msr-menu-link {{ request()->is('subscription-list*') ? 'is-active' : '' }}"
                       href="{{ route('user.subscription.list') }}" @if(request()->is('subscription-list*')) aria-current="page" @endif>
                        <i class="feather-award"></i><span>Subscription List</span>
                    </a>
                </li>
                <li>
                    <a class="msr-menu-link {{ request()->is('order-history*') ? 'is-active' : '' }}"
                       href="{{ route('user.order.history') }}" @if(request()->is('order-history*')) aria-current="page" @endif>
                        <i class="feather-shopping-bag"></i><span>Order History</span>
                    </a>
                </li>
            @endif
        </ul>

        <p class="msr-menu-heading">User</p>
        <ul class="msr-menu-list">
            <li>
                <a class="msr-menu-link {{ request()->is('edit-profile*') ? 'is-active' : '' }}"
                   href="{{ url('/edit-profile') }}" @if(request()->is('edit-profile*')) aria-current="page" @endif>
                    <i class="feather-settings"></i><span>Edit Profile</span>
                </a>
            </li>
            <li>
                <a class="msr-menu-link is-logout" href="{{ route('user.logout') }}">
                    <i class="feather-log-out"></i><span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</div>