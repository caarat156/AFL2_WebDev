<nav class="navbar navbar-expand-lg navbar-light shadow-sm py-3" style="background-color: #f6efe8;">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="60" class="me-2">
        </a>

        {{-- Navbar toggle for mobile --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list" style="font-size: 1.5rem; color: #6b4e3d;"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-lg-4 gap-3 mt-3 mt-lg-0">

                {{-- Menu utama --}}
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="/" style="color: #5a4634;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="/product" style="color: #5a4634;">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="/store" style="color: #5a4634;">Offline Stores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="/about" style="color: #5a4634;">About</a>
                </li>

                {{-- Search --}}
                <li class="nav-item position-relative">
                    <a class="nav-link text-secondary" href="#" id="searchToggle">
                        <i class="bi bi-search"></i>
                    </a>
                    <form action="{{ route('products.index') }}" method="GET" 
                          class="position-absolute top-100 end-0 bg-white shadow p-2 rounded d-none"
                          id="searchForm" style="width: 220px;">
                        <input type="text" name="search" class="form-control form-control-sm" 
                               placeholder="Search product or category..." 
                               value="{{ request('search') }}">
                    </form>
                </li>

                {{-- Cart --}}
                <li class="nav-item">
                    <a class="nav-link text-secondary" href="#"><i class="bi bi-bag"></i></a>
                </li>

                {{-- User (login / dashboard / logout) --}}
                <li class="nav-item dropdown">
                    @if(Auth::check())
                        {{-- Jika sudah login --}}
                        <a class="nav-link text-secondary dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="/admin/profileAdmin">Profile Admin</a></li>
                            @else
                                <li><a class="dropdown-item" href="/user/profile">Profile</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @else
                        {{-- Jika belum login --}}
                        <a href="{{ route('login') }}" class="nav-link text-secondary">
                            <i class="bi bi-person"></i>
                        </a>
                    @endif
                </li>

            </ul>
        </div>
    </div>
</nav>
