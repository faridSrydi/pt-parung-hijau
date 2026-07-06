<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UnitBisnisSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'          => 'sungrow',
                'nama'        => 'Sungrow',
                'tagline'     => 'Perkebunan Pisang Cavendish',
                'wilayah'     => 'Kec. Cisarua, Bogor',
                'komoditas'   => 'Pisang Cavendish',
                'kapasitas'   => '1,200 Sisir',
                'alamat'      => 'Jl. Raya Puncak No. 423, Cisarua, Bogor, Jawa Barat 16750',
                'phone'       => '+62 251 8765 4321',
                'jam'         => 'Senin – Sabtu, 07.00 – 17.00 WIB',
                'maps'        => 'https://maps.google.com/?q=Cisarua+Bogor',
                'deskripsi'   => 'Sungrow adalah unit perkebunan pisang Cavendish unggulan dari PT Parung Hijau Perkasa yang berlokasi di wilayah subur Bogor. Menerapkan teknologi pertanian modern and praktik berkelanjutan, Sungrow berkomitmen untuk memastikan hasil panen yang optimal di setiap siklus tanam.',
                'foto_sampul' => 'assets/images/unitbisnis/sungrow/hero/pisang.jpg',
                'dokumentasi' => json_encode(['assets/images/unitbisnis/sungrow/galeri/s1.jpg', 'assets/images/unitbisnis/sungrow/galeri/s2.jpg'])
            ],
            [
                'id'          => 'chicken',
                'nama'        => 'Adiluhung Chicken',
                'tagline'     => 'Peternakan Unggas & Telur Organik',
                'wilayah'     => 'Kec. Caringin, Bogor',
                'komoditas'   => 'Ayam Kampung & Telur Organik',
                'kapasitas'   => '5,000 Ekor',
                'alamat'      => 'Jl. Raya Caringin No. 12, Caringin, Bogor',
                'phone'       => '+62 251 8765 1111',
                'jam'         => 'Setiap Hari, 08.00 – 17.00 WIB',
                'maps'        => 'https://maps.google.com/?q=Caringin+Bogor',
                'deskripsi'   => 'Adiluhung Chicken memfokuskan diri pada peternakan unggas kampung dengan pakan organik hasil olahan mandiri, menghasilkan daging berkualitas tinggi dan telur kaya nutrisi.',
                'foto_sampul' => 'assets/images/unitbisnis/chicken/hero/ayam.jpg',
                'dokumentasi' => json_encode(['assets/images/unitbisnis/chicken/hero/ayam.jpg'])
            ],
            [
                'id'          => 'patin',
                'nama'        => 'Adiluhung Patin',
                'tagline'     => 'Perikanan Air Tawar Berkelanjutan',
                'wilayah'     => 'Kec. Kemang, Bogor',
                'komoditas'   => 'Budidaya Patin Air Tawar',
                'kapasitas'   => '8,000 Kg',
                'alamat'      => 'Jl. Kemang Raya No. 9, Kemang, Bogor',
                'phone'       => '+62 251 8765 2222',
                'jam'         => 'Senin – Jumat, 08.00 – 16.00 WIB',
                'maps'        => 'https://maps.google.com/?q=Kemang+Bogor',
                'deskripsi'   => 'Adiluhung Patin mengelola kolam budidaya ikan patin segar air tawar menggunakan bioteknologi kolam ramah lingkungan untuk menjaga kualitas nutrisi ikan patin.',
                'foto_sampul' => 'assets/images/unitbisnis/patin/hero/ikan.png',
                'dokumentasi' => json_encode(['assets/images/unitbisnis/patin/hero/ikan.png'])
            ],
            [
                'id'          => 'waste',
                'nama'        => 'Waste Management',
                'tagline'     => 'Sirkular Ekonomi & Pengolahan Sampah Organik',
                'wilayah'     => 'Kec. Parung, Bogor',
                'komoditas'   => 'Pupuk Organik & Maggot BSF',
                'kapasitas'   => '10 Ton Kompos',
                'alamat'      => 'Jl. Raya Parung No. 99, Parung, Bogor',
                'phone'       => '+62 251 8765 3333',
                'jam'         => 'Senin – Sabtu, 07.30 – 16.30 WIB',
                'maps'        => 'https://maps.google.com/?q=Parung+Bogor',
                'deskripsi'   => 'Unit Waste Management memproses sampah organik dari pasar dan perkebunan menjadi produk bernilai tinggi seperti pupuk kompos organik premium dan pakan maggot BSF berprotein tinggi.',
                'foto_sampul' => 'assets/images/unitbisnis/wasted/limbah.png',
                'dokumentasi' => json_encode(['assets/images/unitbisnis/wasted/limbah.png'])
            ]
        ];

        foreach ($data as $row) {
            $this->db->table('unit_bisnis')->replace($row);
        }
    }
}
