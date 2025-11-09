import './bootstrap';

document.addEventListener("DOMContentLoaded", function() {
    const toggle = document.getElementById("searchToggle");
    const form = document.getElementById("searchForm");

    if (toggle && form) { // biar aman di halaman lain juga
        // klik ikon = munculkan/sembunyikan form
        toggle.addEventListener("click", function(e) {
            e.preventDefault();
            form.classList.toggle("d-none");
        });

        // klik di luar form = sembunyikan form
        document.addEventListener("click", function(e) {
            if (!form.contains(e.target) && !toggle.contains(e.target)) {
                form.classList.add("d-none");
            }
        });
    }
});
