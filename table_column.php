<?php 

    $table_columns_mapping = [
        'pengguna' => [
            'nama_depan', 'nama_belakang', 'email', 'password', 'dibuat', 'diperbarui'
        ], 
        'produk' => [
            'nama_produk', 'deskripsi', 'gambar', 'stok', 'oleh', 'dibuat', 'diperbarui', 'harga'
        ],
        'transaksi' => [
            'produk_id', 'qty', 'total_harga', 'waktu_transaksi', 'dibuat', 'diperbarui', 'oleh'
        ]
    ];
?>