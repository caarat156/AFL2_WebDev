<div class="col-lg-4 col-md-6"> 
    {{-- di layar besar ambil 4 kolom dari 12 klo md ambil 6 --}}
        <div class="review-card p-4 shadow-sm rounded-3 bg-light">
            {{-- bikin card yg padding 4, dll --}}
        <div class="d-flex align-items-center mb-3">
            {{-- layout fleksibel, sejajar vertiksl, margin bawah biar ga nempel text bawahnya --}}
            <div class="me-3"><i class="bi bi-person-circle fs-2 text-secondary"></i></div>
            {{-- icon user --}}
            <div>
            <h5 class="mb-0">{{ $review->name }}</h5>
            {{-- ambil data nama dari model review, ga ada margin bawah --}}
            <div class="text-warning">
                @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $review->rating) ★ @else ☆ @endif
                @endfor
            </div>
            {{-- loop buat bintang sesuai rating, text warning untuk warnanya --}}
            </div>
        </div>
        <p class="mb-0 text-muted">"{{ $review->comment }}"</p>
        </div>
    </div>
    