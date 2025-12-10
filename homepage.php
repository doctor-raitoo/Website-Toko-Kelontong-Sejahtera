<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
    <style>
        .header {
            width: 100%;
            background: darkblue;
            padding: 10px 2px;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            opacity: 80%;
        }

        .header .homepageContainer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .header a {
            font-size: 18px;
            color: white;
            padding: 5px 15px;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s ease;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(3px);
        }

        .header a:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .bannerHeader h1 {
            font-size: 80px;
            color: blue;
            line-height: 100%;
            font-family: "Montserrat";
            font-style: italic;
        }

        .bannerHeader p {
            font-size: 40px;
            margin-top: 10px;
            color: white;
            line-height: 100%;
            font-family: "Montserrat";
        }

        .bannerTagline {
            margin-top: 20px;
            font-size: 20px;   
            color: white;
        }

        .bannerTagline b {
            color: blue;
            font-style: italic;
            font-family: "Montserrat"
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="homepageContainer">
            <a href="login.php"><i class="fa fa-user"></i> Login</a>
        </div>
    </div>
    <div class="banner">
        <div class="homepageContainer">
            <div class="bannerHeader">
                <h1>STOKS</h1>
                <p>Sistem Informasi Toko Kelontong Sejahtera</p>
            </div>
            <p class="bannerTagline">
                <b>STOKS </b>adalah solusi berbasis web yang kami rancang untuk membantu mengelola toko kelontong secara lebih efektif dan efisien. Melalui sistem ini, proses pencatatan transaksi penjualan, pengelolaan stok barang, hingga pelaporan keuangan dapat dilakukan dengan lebih cepat, akurat, dan terorganisir. Dengan antarmuka yang sederhana serta fitur yang lengkap dapat mendukung pemilik toko dalam meningkatkan pelayanan, meminimalisir kesalahan pencatatan, dan mengoptimalkan operasional toko secara keseluruhan.
            </p>
        </div>
    </div>
    <div class="homepageContainer">
    <div class="homepageFeatures">
        <div class="homepageFeature">
            <span class="featureIcon"><i class="fa fa-line-chart"></i></span>
            <h3 class="featureTitle">Laporan Keuangan</h3>
            <p class="featureDesc">Fitur ini menyediakan rangkuman lengkap mengenai kondisi keuangan toko dalam periode tertentu. Pemilik dapat melihat total pemasukan, pengeluaran, serta keuntungan yang diperoleh. Data ditampilkan secara jelas dalam bentuk tabel maupun grafik, sehingga memudahkan analisis dan pengambilan keputusan bisnis. Laporan dapat diunduh atau dicetak untuk kebutuhan administrasi</p>
        </div>
        <div class="homepageFeature">
            <span class="featureIcon"><i class="fa fa-cubes"></i></span>
            <h3 class="featureTitle">Manajemen Barang</h3>
            <p class="featureDesc">Fitur ini berfungsi untuk mengelola seluruh data barang di toko. Pemilik dapat menambah, memperbarui, atau menghapus barang dengan mudah. Setiap barang ditampilkan beserta informasi penting seperti nama, kategori, harga, dan jumlah yang tersedia. Sistem ini membantu toko menjaga ketertiban data produk serta meminimalkan kesalahan dalam pencatatan persediaan.</p>
        </div>
        <div class="homepageFeature">
            <span class="featureIcon"><i class="fa fa-exchange"></i></span>
            <h3 class="featureTitle">Pencatatan Transaksi</h3>
            <p class="featureDesc">Fitur ini memungkinkan pencatatan transaksi penjualan secara cepat dan akurat. Setiap transaksi yang terjadi akan tersimpan secara otomatis ke dalam sistem, lengkap dengan rincian barang, harga, jumlah, dan waktu transaksi. Dengan pencatatan yang terstruktur, pemilik dapat memonitor aktivitas penjualan secara real-time dan memastikan seluruh transaksi tercatat tanpa terlewat.</p>
        </div>
    </div>
    </div>
        <div class="homepageAbout">
        <div class="homepageContainer">
            <div class="homepageAboutContainer">
                <div class="about">
            <h3>Tentang Toko Kelontong Sejahtera</h3>
            <p>
                Toko Kelontong Sejahtera merupakan sebuah usaha kecil menengah yang bergerak di bidang perdagangan kebutuhan pokok atau sembako. Toko Kelontong Sejahtera termasuk kedalam kategori toko grosir dan eceran, dengan aktivitas utama menyediakan berbagai barang kebutuhan sehari-hari seperti beras, minyak goreng, gula, telur, tepung, dan barang pokok lainnya.
            </p>
        </div>
        <div class="image">
            <img src="image/gambar1.jpg" alt="">
        </div>
    </div>
</div>
</div>
<div class="footer">
    <div class="homepageContainer">
        <a href="">Contact Us</a>
        <a href="">Location</a>
    </div>
</div>
</body>
</html>