import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Toggle search navbar
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('searchToggle');
    const form = document.getElementById('searchForm');

    if (toggle && form) {
        toggle.addEventListener('click', function(e){
            e.preventDefault(); // cegah reload
            form.classList.toggle('d-none'); // toggle hidden
            if(!form.classList.contains('d-none')) {
                form.querySelector('input[name="search"]').focus();
            }
        });
    }
});