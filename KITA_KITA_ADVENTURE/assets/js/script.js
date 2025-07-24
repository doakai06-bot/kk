document.addEventListener("DOMContentLoaded", function () {
    const paketSelect = document.getElementById("paket_wisata");
    const penginapanCheckbox = document.getElementById("penginapan");
    const transportasiCheckbox = document.getElementById("transportasi");
    const makananCheckbox = document.getElementById("makanan");
    const waktuInput = document.getElementById("waktu_pelaksanaan");
    const pesertaInput = document.getElementById("jumlah_peserta");
    const hargaPaketInput = document.getElementById("harga_paket");
    const tagihanInput = document.getElementById("jumlah_tagihan");

    const harga = {
        "Danau Toba": {
            penginapan: 1000000,
            transportasi: 1200000,
            makanan: 500000
        },
        "Bukit Lawang": {
            penginapan: 800000,
            transportasi: 1000000,
            makanan: 400000
        },
        "Berastagi": {
            penginapan: 900000,
            transportasi: 1100000,
            makanan: 450000
        }
    };

    function updateHarga() {
        const paket = paketSelect.value;
        const layanan = harga[paket];
        const penginapan = penginapanCheckbox.checked ? layanan.penginapan : 0;
        const transportasi = transportasiCheckbox.checked ? layanan.transportasi : 0;
        const makanan = makananCheckbox.checked ? layanan.makanan : 0;

        const waktu = parseInt(waktuInput.value) || 0;
        const peserta = parseInt(pesertaInput.value) || 0;

        const hargaPaket = penginapan + transportasi + makanan;
        const jumlahTagihan = hargaPaket * waktu * peserta;

        hargaPaketInput.value = hargaPaket.toLocaleString("id-ID");
        tagihanInput.value = jumlahTagihan.toLocaleString("id-ID");
    }

    paketSelect.addEventListener("change", updateHarga);
    penginapanCheckbox.addEventListener("change", updateHarga);
    transportasiCheckbox.addEventListener("change", updateHarga);
    makananCheckbox.addEventListener("change", updateHarga);
    waktuInput.addEventListener("input", updateHarga);
    pesertaInput.addEventListener("input", updateHarga);

    // Inisialisasi hitung pertama kali
    updateHarga();
});
