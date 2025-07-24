<?php
include 'includes/header.php';

$artikel = [
    [
        'id' => 1,
        'judul' => 'Mengenal Danau Toba',
        'kategori' => 'wisata',
        'konten' => 'Danau Toba adalah danau vulkanik terbesar di Asia Tenggara. Terletak di Provinsi Sumatera Utara, danau ini memiliki panjang sekitar 100 kilometer dan lebar 30 kilometer. Di tengahnya terdapat Pulau Samosir yang menjadi tujuan wisata populer. Keindahan alam, budaya lokal, dan keramahan masyarakat menjadikan Danau Toba destinasi favorit.',
    ],
    [
        'id' => 2,
        'judul' => 'Tradisi Masyarakat Batak',
        'kategori' => 'budaya',
        'konten' => 'Suku Batak memiliki banyak tradisi unik seperti mangulosi, yaitu pemberian ulos sebagai lambang kasih sayang, restu, dan kehormatan. Tradisi ini biasanya dilakukan pada acara pernikahan, kelahiran, dan kematian. Selain itu, Batak juga memiliki seni musik gondang, tarian tor-tor, serta sistem marga yang kuat sebagai identitas kekerabatan.',
    ]
];

// Ambil ID dari query string
$id = $_GET['id'] ?? null;

// Cari artikel berdasarkan ID
$artikel_terpilih = null;
foreach ($artikel as $a) {
    if ($a['id'] == $id) {
        $artikel_terpilih = $a;
        break;
    }
}
?>

<div class="container my-5">
    <?php if ($artikel_terpilih): ?>
        <h2><?= $artikel_terpilih['judul'] ?></h2>
        <p><em>Kategori: <?= $artikel_terpilih['kategori'] ?></em></p>
        <p><?= nl2br($artikel_terpilih['konten']) ?></p>
        <a href="artikel.php" class="btn btn-secondary mt-3">Kembali ke Daftar Artikel</a>
    <?php else: ?>
        <div class="alert alert-danger">
            Artikel tidak ditemukan.
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
