const form = document.getElementById("complaintForm");
const confirmationDiv = document.getElementById("confirmation");

form.addEventListener("submit", function(event) {
    event.preventDefault(); // Mencegah pengiriman form default

    const imageInput = document.getElementById('image');
    if (imageInput.files.length === 0) {
        confirmationDiv.innerHTML = "<div class='error'>Harap unggah gambar sebelum mengirim laporan.</div>";
        confirmationDiv.style.display = "block";
        return; // Hentikan pengiriman jika gambar tidak diunggah
    }

    const formData = new FormData(form);

    fetch('submit_report.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Menampilkan respon dari server di konsol
        confirmationDiv.innerHTML = data; // Menampilkan pesan dari server di halaman
        confirmationDiv.style.display = "block"; // Pastikan pesan tampil di halaman

        // Reset form jika laporan berhasil dikirim
        if (data.includes("Laporan berhasil dikirim")) {
            form.reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        confirmationDiv.innerHTML = `<div class="error">Terjadi kesalahan: ${error.message}</div>`;
        confirmationDiv.style.display = "block";
    });

    // Sembunyikan pesan setelah 3 detik
    setTimeout(() => {
        confirmationDiv.style.display = "none";
    }, 3000);
});





