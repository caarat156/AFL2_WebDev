@extends('layout.mainlayout')

@section('title', 'Workshop Registration - ' . $workshop->title)

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <!-- Workshop Summary Card -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if($workshop->image)
                                <img src="{{ asset($workshop->image) }}" 
                                    alt="{{ $workshop->title }}" 
                                    class="img-fluid rounded" 
                                    style="object-fit: cover; height: 150px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                    style="height: 150px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h4>{{ $workshop->title }}</h4>
                            <p class="text-muted mb-1">
                                <i class="bi bi-calendar-event"></i>
                                {{ \Carbon\Carbon::parse($workshop->date)->format('d M Y') }} | 
                                {{ $workshop->time }}
                            </p>
                            <p class="text-muted mb-1">
                                <i class="bi bi-geo-alt"></i>
                                {{ $workshop->location }}
                            </p>
                            <p class="text-success fw-bold">
                                Harga: Rp {{ number_format($workshop->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Mohon periksa kembali data yang diisi.
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Registration Form -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>Form Pendaftaran Workshop
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('workshops.storeRegistration', $workshop) }}" method="POST">
                        @csrf

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                class="form-control @error('full_name') is-invalid @enderror" 
                                id="full_name" 
                                name="full_name"
                                value="{{ old('full_name') }}"
                                placeholder="Masukkan nama lengkap Anda"
                                required>
                            @error('full_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email Anda"
                                required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                Nomor Telepon <span class="text-danger">*</span>
                            </label>
                            <input type="tel" 
                                class="form-control @error('phone') is-invalid @enderror" 
                                id="phone" 
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Contoh: 08123456789"
                                required>
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Participant Count -->
                        <div class="mb-3">
                            <label for="participant_count" class="form-label">
                                Jumlah Peserta <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                class="form-control @error('participant_count') is-invalid @enderror" 
                                id="participant_count" 
                                name="participant_count"
                                value="{{ old('participant_count', 1) }}"
                                min="1"
                                placeholder="Jumlah peserta yang akan mendaftar"
                                required>
                            <small class="text-muted d-block mt-1">
                                Kapasitas tersedia: {{ $workshop->capacity }} orang
                            </small>
                            @error('participant_count')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total Price -->
                        <div class="mb-4 p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total Harga:</span>
                                <span class="text-success fw-bold fs-5" id="total_price">
                                    Rp {{ number_format($workshop->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Harga per peserta: Rp {{ number_format($workshop->price, 0, ',', '.') }}
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="bi bi-check-circle me-2"></i>Daftar Sekarang
                            </button>
                            <a href="{{ route('workshops.show', $workshop) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="alert alert-info mt-4" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Catatan:</strong> Setelah mengisi form ini, Anda akan diarahkan untuk melakukan pembayaran untuk menyelesaikan pendaftaran workshop.
            </div>
        </div>
    </div>
</div>

<script>
    // Hitung total harga berdasarkan jumlah peserta
    const pricePerParticipant = {{ $workshop->price }};
    const participantInput = document.getElementById('participant_count');
    const totalPriceDisplay = document.getElementById('total_price');

    if (participantInput) {
        participantInput.addEventListener('change', function() {
            const count = parseInt(this.value) || 1;
            const totalPrice = pricePerParticipant * count;
            totalPriceDisplay.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        });
    }
</script>
@endsection
