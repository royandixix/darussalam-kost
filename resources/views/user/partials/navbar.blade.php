<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container d-flex align-items-center justify-content-between">

        <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}">
            Darussalam Kost
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.rooms.index') }}">
                        Cari Kamar
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.bookings.index') }}">
                        Sewa Saya
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.payments.index') }}">
                        Pembayaran
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.maintenance.index') }}">
                        Perbaikan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.feedback.index') }}">
                        Feedback
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.profile.index') }}" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="Profil">
                        <i class="bi bi-person-circle fs-5"></i>
                    </a>
                </li>

                <li class="nav-item ms-lg-3">
                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-dark btn-sm px-3">
                            Logout
                        </button>
                    </form>
                </li>

            </ul>

        </div>

    </div>
</nav>
