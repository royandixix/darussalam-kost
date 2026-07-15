<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
            <span class="icofont-close js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<nav class="site-nav">
    <div class="container">
        <div class="menu-bg-wrap">
            <div class="site-navigation d-flex align-items-center justify-content-between">

                <a href="{{ route('user.dashboard') }}" class="logo m-0">
                    Darussalam Kost
                </a>

                <div class="d-none d-lg-flex align-items-center">

                    <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mb-0">
                        <li class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>

                        <li class="{{ request()->routeIs('user.rooms.*') ? 'active' : '' }}">
                            <a href="{{ route('user.rooms.index') }}">Cari Kamar</a>
                        </li>

                        <li class="{{ request()->routeIs('user.bookings.*') ? 'active' : '' }}">
                            <a href="{{ route('user.bookings.index') }}">Sewa Saya</a>
                        </li>

                        <li class="{{ request()->routeIs('user.payments.*') ? 'active' : '' }}">
                            <a href="{{ route('user.payments.index') }}">Pembayaran</a>
                        </li>

                        <li class="{{ request()->routeIs('user.maintenance.*') ? 'active' : '' }}">
                            <a href="{{ route('user.maintenance.index') }}">Perbaikan</a>
                        </li>

                        <li class="{{ request()->routeIs('user.feedback.*') ? 'active' : '' }}">
                            <a href="{{ route('user.feedback.index') }}">Feedback</a>
                        </li>

                        <li class="{{ request()->routeIs('user.notifications.*') ? 'active' : '' }}">
                            <a href="{{ route('user.notifications.index') }}">
                                Notifikasi
                                @if(auth()->user()->unreadNotifications()->count() > 0)
                                    ({{ auth()->user()->unreadNotifications()->count() }})
                                @endif
                            </a>
                        </li>

                        <li class="d-lg-none">
                            <a href="#" class="open-profile-modal">
                                Masuk ke Akun
                            </a>
                        </li>

                        <li class="d-lg-none">
                            <form action="{{ route('user.logout') }}" method="POST">
                                @csrf

                                <button type="submit" class="btn btn-link p-0 text-start">
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>

                    <div class="user-dropdown-wrap ms-3">
                        <button type="button" class="btn btn-primary d-inline-flex align-items-center justify-content-center user-dropdown-button">
                            <span class="icon-person"></span>
                        </button>

                        <div class="user-dropdown-menu">
                            <button type="button" class="user-dropdown-item open-profile-modal">
                                Masuk ke Akun
                            </button>

                            <form action="{{ route('user.logout') }}" method="POST">
                                @csrf

                                <button type="submit" class="user-dropdown-item">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

                <a 
                    href="#" 
                    class="burger light site-menu-toggle js-menu-toggle d-inline-block d-lg-none" 
                    data-toggle="collapse" 
                    data-target="#main-navbar"
                >
                    <span></span>
                </a>

            </div>
        </div>
    </div>
</nav>

@include('user.partials.profile-modal')

@push('scripts')
<script>
    document.addEventListener('click', function (event) {
        const trigger = event.target.closest('.open-profile-modal');

        if (!trigger) {
            return;
        }

        event.preventDefault();

        document.body.classList.remove('offcanvas-menu');

        const profileModalElement = document.getElementById('profileModal');

        if (profileModalElement && window.bootstrap) {
            const profileModal = new bootstrap.Modal(profileModalElement);
            profileModal.show();
        }
    });
</script>
@endpush

@push('scripts')
<style>
    .user-dropdown-wrap {
        position: relative;
    }

    .user-dropdown-button {
        width: 42px;
        height: 42px;
        padding: 0;
    }

    .user-dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        min-width: 180px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        padding: 8px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.2s ease;
        z-index: 9999;
    }

    .user-dropdown-wrap:hover .user-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .user-dropdown-item {
        display: block;
        width: 100%;
        padding: 10px 16px;
        border: 0;
        background: transparent;
        color: #1f2937;
        text-align: left;
        font-size: 14px;
        text-decoration: none;
    }

    .user-dropdown-item:hover {
        background: #f3f4f6;
        color: #005555;
    }
</style>
@endpush