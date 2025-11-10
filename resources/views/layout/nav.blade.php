<nav class="navbar navbar-expand-lg navbar-light shadow-sm py-3" style="background-color: #f6efe8;">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('homeumum') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="60" class="me-2">
        </a>

        {{-- Toggle --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list" style="font-size: 1.5rem; color: #6b4e3d;"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-lg-4 gap-3 mt-3 mt-lg-0">

                {{-- Home --}}
                <li class="nav-item">
                    @if(Auth::check())
                        {{-- User login --}}
                        <a class="nav-link fw-semibold text-uppercase" href="{{ route('user.home') }}" style="color: #5a4634;">Home</a>
                    @else
                        {{-- Guest --}}
                        <a class="nav-link fw-semibold text-uppercase" href="{{ route('homeumum') }}" style="color: #5a4634;">Home</a>
                    @endif
                </li>

                {{-- Admin Menu --}}
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase" href="{{ route('admin.product') }}" style="color: #5a4634;">Admin Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase" href="{{ route('admin.store') }}" style="color: #5a4634;">Admin Store</a>
                    </li>

                {{-- User biasa --}}
                @elseif(Auth::check())
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="{{ route('user.product') }}" style="color: #5a4634;">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="{{ route('user.store') }}" style="color: #5a4634;">Offline Stores</a>
                </li>
                @endif

                {{-- About --}}
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="{{ route('about') }}" style="color: #5a4634;">About</a>
                </li>

                {{-- My Review (hanya untuk user login) --}}
                @auth
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase" href="{{ route('user.reviews.index') }}" style="color: #5a4634;">
                            My Review
                        </a>
                    </li>
                @endauth

                {{-- Search --}}
                <li class="nav-item position-relative">
                    <a class="nav-link text-secondary" href="#" id="searchToggle">
                        <i class="bi bi-search"></i>
                    </a>

                    @php
                        $searchRoute = Auth::check()
                                        ? (Auth::user()->role === 'admin' ? route('admin.product') : route('user.product'))
                                        : route('products.index');
                    @endphp

                    <form action="{{ $searchRoute }}" method="GET" 
                        class="position-absolute top-100 end-0 bg-white shadow p-2 rounded d-none" 
                        id="searchForm" style="width: 220px;">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Search product or category..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary mt-2 w-100">Search</button>
                    </form>
                </li>

                {{-- Cart --}}
                <li class="nav-item">
                    <a class="nav-link text-secondary" href="#">
                        <i class="bi bi-bag"></i>
                    </a>
                </li>

                {{-- User / Guest --}}
                <li class="nav-item dropdown">
                    @if(Auth::check())
                        <a class="nav-link text-secondary dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Admin Profile</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}">User Profile</a></li>
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
                        <a class="nav-link text-secondary dropdown-toggle" href="#" id="guestDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="guestDropdown">
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                        </ul>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
