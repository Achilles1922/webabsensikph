// Ambil elemen-elemen yang dibutuhkan
const menuIcon = document.getElementById('menu-icon');
const sidebar = document.getElementById('sidebar');
const content = document.getElementById('content');

// Ketika tombol menu diklik, toggle sidebar (menu)
menuIcon.addEventListener('click', () => {
    if (sidebar.style.left === '-220px' || sidebar.style.opacity === '0') {
        sidebar.style.left = '0'; // Menampilkan sidebar
        sidebar.style.opacity = '1'; // Menampilkan sidebar dengan transisi
        content.style.marginLeft = '220px'; // Geser konten untuk memberi ruang sidebar
    } else {
        sidebar.style.left = '-220px'; // Menyembunyikan sidebar
        sidebar.style.opacity = '0'; // Menyembunyikan sidebar dengan transisi
        content.style.marginLeft = '0'; // Kembalikan posisi konten
    }
});
