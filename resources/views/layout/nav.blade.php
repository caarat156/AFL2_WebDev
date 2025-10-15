<nav class="navbar navbar-expand-lg navbar-light shadow-sm py-3" style="background-color: #f6efe8;">
    <div class="container">
        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="45" class="me-2">
        </a>

        <!-- TOGGLER (mobile) -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list" style="font-size: 1.5rem; color: #6b4e3d;"></i>
        </button>

        <!-- MENU ITEMS -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-lg-4 gap-3 mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="#" style="color: #5a4634;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="#" style="color: #5a4634;">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="#" style="color: #5a4634;">Stores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="#" style="color: #5a4634;">About</a>
                </li>

                <!-- ICONS -->
                <li class="nav-item"><a class="nav-link text-secondary" href="#"><i class="bi bi-search"></i></a></li>
                <li class="nav-item"><a class="nav-link text-secondary" href="#"><i class="bi bi-bag"></i></a></li>
                <li class="nav-item"><a class="nav-link text-secondary" href="#"><i class="bi bi-person"></i></a></li>
            </ul>
        </div>
    </div>
</nav>
