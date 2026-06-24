<nav class="navbar navbar-expand-lg navbar-light sticky-top border-bottom bg-white">
    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}">
            Darussalam Kost
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">

            <ul class="navbar-nav ms-auto gap-2">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.rooms.index') }}">Kamar</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.bookings.index') }}">Booking</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.payments.index') }}">Pembayaran</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.maintenance.index') }}">Maintenance</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.feedback.index') }}">Feedback</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.profile.index') }}">Profil</a>
                </li>

            </ul>

            <form action="{{ route('user.logout') }}" method="POST" class="ms-lg-3">
                @csrf
                <button class="btn btn-dark btn-sm">
                    Logout
                </button>
            </form>

        </div>

    </div>
</nav>