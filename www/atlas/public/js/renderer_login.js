// public/js/renderer_login.js
document.addEventListener('DOMContentLoaded', function() {
    
    // === DEKLARASI ELEMEN ===
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const customAlert = document.getElementById('custom-alert');
    const alertCloseBtn = document.getElementById('alert-close-btn');

    // === FUNGSI NOTIFIKASI ===
    if (alertCloseBtn) {
        alertCloseBtn.addEventListener('click', () => {
            if (customAlert) customAlert.classList.add('hidden');
        });
    }

    // === UX TAMBAHAN (Enter di form) ===
    if (usernameInput && passwordInput) {
        usernameInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                passwordInput.focus();
            }
        });
    }

    const successToast = document.getElementById('success-toast');

    if (successToast) {
        // 1. Tampilkan popup (animasi fade-in + slide-in)
        setTimeout(() => {
            successToast.classList.remove('opacity-0');
            successToast.classList.remove('translate-x-10');
        }, 100); // Kasih jeda dikit biar animasi CSS-nya "kaget" & jalan

        // 2. Sembunyikan popup setelah 3 detik (animasi fade-out + slide-out)
        setTimeout(() => {
            successToast.classList.add('opacity-0');
            successToast.classList.add('translate-x-10');
        }, 3000); // Popup-nya nampil selama 3 detik

        // 3. (Opsional) Hapus elemennya dari HTML setelah animasinya selesai
        setTimeout(() => {
             if (successToast) {
                successToast.remove();
             }
        }, 3500); // 3 detik nampil + 0.5 detik animasi hilang
    }
});