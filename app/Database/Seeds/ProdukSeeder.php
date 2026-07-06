<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Induk Pisang Cavendish
            [
                'id'                => 'sungrow-cavendish',
                'parent_id'         => null,
                'unit_bisnis_id'    => 'sungrow',
                'nama'              => 'Pisang Cavendish Segar',
                'harga'             => 22000,
                'satuan'            => 'Sisir',
                'stok'              => 0,
                'image_path'        => 'assets/images/produk/pisang.jpg',
                'deskripsi_singkat' => 'Pisang Cavendish segar langsung dari Perkebunan Sungrow Bogor.',
                'deskripsi_lengkap' => 'Pisang Cavendish berkualitas unggul yang dirawat dengan teknologi pertanian modern dan pupuk organik sirkular. Memiliki rasa manis yang khas, tekstur yang lembut, dan kulit berwarna kuning cerah.',
                'spesifikasi'       => json_encode([
                    'kandungan' => 'Vitamin C, Kalium, Serat Alami',
                    'kawasan'   => 'Kec. Cisarua, Bogor',
                    'berat'     => '1.2 - 1.5 Kg per sisir'
                ])
            ],
            // Varian Grade A
            [
                'id'                => 'sungrow-cavendish-a',
                'parent_id'         => 'sungrow-cavendish',
                'unit_bisnis_id'    => 'sungrow',
                'nama'              => 'Pisang Cavendish Grade A (Premium)',
                'harga'             => 35000,
                'satuan'            => 'Sisir',
                'stok'              => 80,
                'image_path'        => 'assets/images/produk/pisang.jpg',
                'deskripsi_singkat' => 'Pisang Cavendish Grade A Premium dengan kemulusan kulit >95%.',
                'deskripsi_lengkap' => 'Pisang Cavendish Grade A berkualitas ekspor, memiliki ukuran sisir yang besar dan mulus sempurna tanpa cacat fisik.',
                'spesifikasi'       => json_encode([
                    'kandungan' => 'Vitamin C, Kalium, Serat Alami',
                    'kawasan'   => 'Kec. Cisarua, Bogor',
                    'berat'     => '1.4 - 1.6 Kg per sisir'
                ])
            ],
            // Varian Grade B
            [
                'id'                => 'sungrow-cavendish-b',
                'parent_id'         => 'sungrow-cavendish',
                'unit_bisnis_id'    => 'sungrow',
                'nama'              => 'Pisang Cavendish Grade B (Standar)',
                'harga'             => 28000,
                'satuan'            => 'Sisir',
                'stok'              => 120,
                'image_path'        => 'assets/images/produk/pisang.jpg',
                'deskripsi_singkat' => 'Pisang Cavendish Grade B Standar dengan kemulusan kulit 80-95%.',
                'deskripsi_lengkap' => 'Pisang Cavendish Grade B dengan rasa yang sama manisnya namun dengan ukuran sedang dan noda kulit alami yang wajar.',
                'spesifikasi'       => json_encode([
                    'kandungan' => 'Vitamin C, Kalium, Serat Alami',
                    'kawasan'   => 'Kec. Cisarua, Bogor',
                    'berat'     => '1.1 - 1.3 Kg per sisir'
                ])
            ],
            // Ayam Kampung
            [
                'id'                => 'chicken-kampung',
                'parent_id'         => null,
                'unit_bisnis_id'    => 'chicken',
                'nama'              => 'Ayam Kampung Utuh (1kg)',
                'harga'             => 85000,
                'satuan'            => 'Ekor',
                'stok'              => 150,
                'image_path'        => 'assets/images/produk/ayam.jpg',
                'deskripsi_singkat' => 'Daging ayam kampung segar, dipelihara dengan pakan organik mandiri.',
                'deskripsi_lengkap' => 'Daging ayam kampung segar berkualitas tinggi. Dipelihara secara higienis dengan pakan alami bernutrisi tinggi menghasilkan daging yang padat, gurih, dan rendah lemak.',
                'spesifikasi'       => json_encode([
                    'kandungan' => 'Protein Tinggi, Rendah Kolesterol',
                    'kawasan'   => 'Kec. Caringin, Bogor',
                    'berat'     => '1.0 - 1.2 Kg per ekor'
                ])
            ],
            // Telur Kampung
            [
                'id'                => 'chicken-eggs',
                'parent_id'         => null,
                'unit_bisnis_id'    => 'chicken',
                'nama'              => 'Telur Kampung Organik (Isi 10)',
                'harga'             => 32000,
                'satuan'            => 'Pack',
                'stok'              => 45,
                'image_path'        => 'assets/images/produk/ayam.jpg',
                'deskripsi_singkat' => 'Telur omega-3 organik berkualitas, cangkang tebal dan kuning pekat.',
                'deskripsi_lengkap' => 'Telur ayam kampung organik hasil peternakan mandiri. Kaya akan nutrisi omega-3, protein, dan vitamin untuk kebutuhan harian keluarga Anda.',
                'spesifikasi'       => json_encode([
                    'kandungan' => 'Kaya Omega-3, Protein Tinggi',
                    'kawasan'   => 'Kec. Caringin, Bogor',
                    'isi'       => '10 Butir per pack'
                ])
            ],
            // Ikan Patin
            [
                'id'                => 'patin-segar',
                'parent_id'         => null,
                'unit_bisnis_id'    => 'patin',
                'nama'              => 'Ikan Patin Air Tawar Segar (1kg)',
                'harga'             => 38000,
                'satuan'            => 'Kg',
                'stok'              => 240,
                'image_path'        => 'assets/images/produk/ikan.png',
                'deskripsi_singkat' => 'Ikan patin segar hidup, dipelihara di kolam air jernih bebas bau lumpur.',
                'deskripsi_lengkap' => 'Ikan patin air tawar segar hasil budidaya ramah lingkungan. Daging tebal, lembut, gurih, dan kaya akan lemak sehat (omega-3). Dijamin segar sampai di tangan Anda.',
                'spesifikasi'       => json_encode([
                    'kandungan' => 'Omega-3, Protein, Mineral',
                    'kawasan'   => 'Kec. Kemang, Bogor',
                    'isi'       => '3 - 4 Ekor per Kg'
                ])
            ],
            // Pupuk Kompos
            [
                'id'                => 'waste-fertilizer',
                'parent_id'         => null,
                'unit_bisnis_id'    => 'waste',
                'nama'              => 'Pupuk Kompos Organik Premium (5kg)',
                'harga'             => 15000,
                'satuan'            => 'Pack',
                'stok'              => 300,
                'image_path'        => 'assets/images/produk/limbah.png',
                'deskripsi_singkat' => 'Pupuk kompos organik hasil sirkular ekonomi, kaya unsur hara.',
                'deskripsi_lengkap' => 'Pupuk organik kualitas premium hasil pemrosesan limbah organik perkebunan dan pasar tradisional. Sangat baik untuk menggemburkan tanah dan menyuburkan segala jenis tanaman hias, sayur, maupun buah.',
                'spesifikasi'       => json_encode([
                    'kandungan' => 'Nitrogen (N), Fosfor (P), Kalium (K) Alami',
                    'kawasan'   => 'Kec. Parung, Bogor',
                    'berat'     => '5 Kg per pack'
                ])
            ]
        ];

        foreach ($data as $row) {
            $this->db->table('produk')->replace($row);
        }
    }
}
