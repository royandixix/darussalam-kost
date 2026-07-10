<div class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="widget">
                    <h3>Darussalam Kost</h3>
                    <address>
                        Platform pemesanan kamar kost berbasis website.
                    </address>

                    <ul class="list-unstyled links">
                        <li><a href="#">Makassar, Indonesia</a></li>
                        <li><a href="tel://081234567890">0812-3456-7890</a></li>
                        <li><a href="mailto:darussalamkost@gmail.com">darussalamkost@gmail.com</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="widget">
                    <h3>Menu</h3>

                    <ul class="list-unstyled float-start links">
                        <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('user.rooms.index') }}">Cari Kamar</a></li>
                        <li><a href="{{ route('user.bookings.index') }}">Sewa Saya</a></li>
                        <li><a href="{{ route('user.payments.index') }}">Pembayaran</a></li>
                    </ul>

                    <ul class="list-unstyled float-start links">
                        <li><a href="{{ route('user.maintenance.index') }}">Perbaikan</a></li>
                        <li><a href="{{ route('user.feedback.index') }}">Feedback</a></li>
                        <li><a href="{{ route('user.profile.index') }}">Profil</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="widget">
                    <h3>Layanan</h3>

                    <ul class="list-unstyled links">
                        <li><a href="{{ route('user.rooms.index') }}">Pemesanan Kamar</a></li>
                        <li><a href="{{ route('user.payments.index') }}">Upload Bukti Pembayaran</a></li>
                        <li><a href="{{ route('user.maintenance.index') }}">Laporan Kerusakan</a></li>
                        <li><a href="{{ route('user.feedback.index') }}">Feedback Penghuni</a></li>
                    </ul>

                    <ul class="list-unstyled social">
                        <li><a href="#"><span class="icon-instagram"></span></a></li>
                        <li><a href="#"><span class="icon-facebook"></span></a></li>
                        <li><a href="#"><span class="icon-whatsapp"></span></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <p>
                    Copyright &copy; {{ date('Y') }} Darussalam Kost. All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</div>