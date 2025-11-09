
<nav class="navbar navbar-expand-lg navbar-light shadow-sm py-3" style="background-color: #f6efe8;">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="60" class="me-2">
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list" style="font-size: 1.5rem; color: #6b4e3d;"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-lg-4 gap-3 mt-3 mt-lg-0">
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
                    <a class="nav-link fw-semibold text-uppercase" href="about" style="color: #5a4634;">About</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link fw-semibold text-uppercase" href="/review" style="color: #5a4634;">Review</a>
                </li> --}}

                <li class="nav-item position-relative">
                    <a class="nav-link text-secondary" href="#" id="searchToggle">
                        <i class="bi bi-search"></i>
                    </a>
            
                        <!-- form search yang muncul saat diklik -->
                        <form action="{{ route('products.index') }}" method="GET" 
                                class="position-absolute top-100 end-0 bg-white shadow p-2 rounded d-none"
                                id="searchForm" style="width: 220px;">
                                <input type="text" name="search" class="form-control form-control-sm" 
                                    placeholder="Search product or category..." 
                                    value="{{ request('search') }}">
                        </form>
                    </li>
                    
                </li>
                
                <li class="nav-item"><a class="nav-link text-secondary" href="#"><i class="bi bi-bag"></i></a></li>
                <li class="nav-item"><a class="nav-link text-secondary" href="#"><i class="bi bi-person"></i></a></li>
            </ul>
        </div>
    </div>
</nav>
