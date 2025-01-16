

// Fungsi untuk menampilkan waktu
function updateTime() {
    const now = new Date();
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    // Format waktu menjadi dd-mm-yyyy HH:MM:SS
    const formattedTime = `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;

    // Menampilkan waktu pada elemen dengan id "current-time"
    document.getElementById('current-time').textContent = formattedTime;
}

// Memperbarui waktu setiap detik
setInterval(updateTime, 1000); // 1000ms = 1 detik

// Panggil fungsi pertama kali ketika halaman dimuat
updateTime();
