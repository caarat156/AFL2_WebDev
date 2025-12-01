@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div>
@endif

{{-- ni adalah Blade component kecil di Laravel, 
biasanya digunakan untuk menampilkan status pesan (success message) seperti “Password reset link sent” atau “Profile updated”. --}}