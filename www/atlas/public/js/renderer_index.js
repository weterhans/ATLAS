// public/js/renderer_index.js

document.addEventListener('DOMContentLoaded', function() {
    
    // --- HANYA LOGIKA UNTUK ANIMASI UI ---

    // 1. Logika Buka/Tutup Sidebar
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mainContent = document.getElementById('main-content');
    const sidebarOpenMobile = document.getElementById('sidebar-open-mobile');

    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed'); // Untuk state
            sidebar.classList.toggle('w-64');      // Lebar penuh
            sidebar.classList.toggle('w-20');      // Lebar ciut
            mainContent.classList.toggle('md:ml-64'); // Margin konten penuh
            mainContent.classList.toggle('md:ml-20'); // Margin konten ciut
        });
    }
    
    // 2. Logika Buka/Tutup Sidebar (Versi Mobile)
    if (sidebarOpenMobile && sidebar) {
        sidebarOpenMobile.addEventListener('click', (event) => {
             event.stopPropagation();
             sidebar.classList.remove('-translate-x-full'); // Tampilkan sidebar mobile
        });
    }

    // 3. Logika Dropdown Profil (Kanan Atas)
    const profileButton = document.getElementById('profile-button');
    const profileMenu = document.getElementById('profile-menu');

    if (profileButton && profileMenu) {
        profileButton.addEventListener('click', (event) => {
            event.stopPropagation(); 
            profileMenu.classList.toggle('hidden');
        });
    }

    // Menutup dropdown/sidebar jika klik di luar area
    document.addEventListener('click', (e) => {
        if (profileMenu && !profileMenu.classList.contains('hidden') && !profileButton.contains(e.target)) {
            profileMenu.classList.add('hidden');
        }
        
        if (sidebar && !sidebar.classList.contains('-translate-x-full') && !sidebar.contains(e.target) && !sidebarOpenMobile.contains(e.target)) {
            sidebar.classList.add('-translate-x-full');
        }
    });

    // --- SEMUA LOGIKA NAVIGASI (data-target) & AMBIL DATA (window.api) DIHAPUS ---
    // --- KARENA SUDAH DI-HANDLE LARAVEL & BLADE ---
});