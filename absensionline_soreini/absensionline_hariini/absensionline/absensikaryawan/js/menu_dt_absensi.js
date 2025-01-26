// Ambil elemen menu
const menuIcon = document.getElementById('menu-icon');
const sidebar = document.querySelector('.sidebar');

// Awalnya sembunyikan sidebar
sidebar.style.display = 'none';

// Tampilkan atau sembunyikan sidebar saat ikon diklik
menuIcon.addEventListener('click', () => {
    if (sidebar.style.display === 'none' || sidebar.style.display === '') {
        sidebar.style.display = 'block'; // Tampilkan sidebar
    } else {
        sidebar.style.display = 'none'; // Sembunyikan sidebar
    }
});
