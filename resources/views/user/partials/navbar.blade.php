<nav class="navbar navbar-expand-lg navbar-light sticky-top" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container">

        <a class="navbar-brand" href="{{ route('user.dashboard') }}">
            <a class="navbar-brand " href="{{ route('user.dashboard') }}">
                Darussalam Kost
            </a>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.rooms.index') }}">
                        Kamar
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.bookings.index') }}">
                        Booking
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.payments.index') }}">
                        Pembayaran
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.maintenance.index') }}">
                        Pemeliharaan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.feedback.index') }}">
                        Feedback
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.profile.index') }}">
                        Profil
                    </a>
                </li>

            </ul>

            <div class="d-flex ms-lg-4">
                <form action="{{ route('user.logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-warning">
                        Logout
                    </button>
                </form>
            </div>

        </div>

    </div>
</nav>
