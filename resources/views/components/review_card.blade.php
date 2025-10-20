<div class="col-lg-4 col-md-6">
        <div class="review-card p-4 shadow-sm rounded-3 bg-light">
        <div class="d-flex align-items-center mb-3">
            <div class="me-3"><i class="bi bi-person-circle fs-2 text-secondary"></i></div>
            <div>
            <h5 class="mb-0">{{ $review->name }}</h5>
            <div class="text-warning">
                @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $review->rating) ★ @else ☆ @endif
                @endfor
            </div>
            </div>
        </div>
        <p class="mb-0 text-muted">"{{ $review->comment }}"</p>
        </div>
    </div>
    