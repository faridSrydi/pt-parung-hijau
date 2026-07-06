<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\SupirModel;
use App\Models\ProdukModel;
use App\Models\UnitBisnisModel;
use App\Models\PanenModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $totalUsers = $db->table('users')->countAllResults();
        $totalUnits = $db->table('unit_bisnis')->countAllResults();
        $totalProducts = $db->table('produk')->where('parent_id', null)->countAllResults();
        $totalOmset = $db->table('transaksi')->where('status_pembayaran', 'Lunas')->selectSum('total_harga')->get()->getRow()->total_harga ?? 0;

        $units = $db->table('unit_bisnis')->limit(5)->get()->getResultArray();
        $products = $db->table('produk')
            ->select('produk.*, unit_bisnis.nama as unit_nama')
            ->join('unit_bisnis', 'unit_bisnis.id = produk.unit_bisnis_id', 'left')
            ->where('parent_id', null)
            ->limit(5)->get()->getResultArray();

        // Fetch users and their roles
        $usersRaw = $db->table('users')->limit(5)->get()->getResultArray();
        $users = [];
        $usersProvider = auth()->getProvider();
        foreach ($usersRaw as $uRaw) {
            $userEntity = $usersProvider->findById($uRaw['id']);
            $groups = $userEntity ? $userEntity->getGroups() : [];
            $role = !empty($groups) ? $groups[0] : 'pelanggan';
            $email = $db->table('auth_identities')
                ->where('user_id', $uRaw['id'])
                ->where('type', 'email_password')
                ->get()->getRow()->secret ?? '';
                
            $users[] = [
                'id' => $uRaw['id'],
                'username' => $uRaw['username'],
                'email' => $email,
                'role' => $role,
            ];
        }

        $transactions = $db->table('transaksi')
            ->select('transaksi.*, users.username as pelanggan_nama')
            ->join('users', 'users.id = transaksi.pelanggan_id', 'left')
            ->orderBy('tanggal_transaksi', 'DESC')
            ->limit(5)->get()->getResultArray();

        return view('dashboard/admin', [
            'title'         => 'Dashboard Admin',
            'totalUsers'    => $totalUsers,
            'totalUnits'    => $totalUnits,
            'totalProducts' => $totalProducts,
            'totalOmset'    => $totalOmset,
            'units'         => $units,
            'products'      => $products,
            'users'         => $users,
            'transactions'  => $transactions,
        ]);
    }

    public function kelolaAkun()
    {
        $db = \Config\Database::connect();
        $usersRaw = $db->table('users')->get()->getResultArray();
        
        $users = [];
        $usersProvider = auth()->getProvider();
        foreach ($usersRaw as $uRaw) {
            $userEntity = $usersProvider->findById($uRaw['id']);
            $groups = $userEntity ? $userEntity->getGroups() : [];
            $role = !empty($groups) ? $groups[0] : 'pelanggan';
            $email = $db->table('auth_identities')
                ->where('user_id', $uRaw['id'])
                ->where('type', 'email_password')
                ->get()->getRow()->secret ?? '';
            
            $users[] = [
                'id' => $uRaw['id'],
                'username' => $uRaw['username'],
                'email' => $email,
                'role' => $role,
                'status' => 'aktif',
            ];
        }

        return view('dashboard/admin/kelola_akun', [
            'title' => 'Kelola Akun',
            'users' => $users,
        ]);
    }

    public function tambahAkun()
    {
        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role') ?: 'pelanggan';

        $usersProvider = auth()->getProvider();
        $user = new \CodeIgniter\Shield\Entities\User([
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ]);

        if ($usersProvider->save($user)) {
            $newUserId = $usersProvider->getInsertID();
            $userEntity = $usersProvider->findById($newUserId);
            $userEntity->addGroup($role);

            // Create Profile Record
            $db = \Config\Database::connect();
            $db->table('user_profiles')->insert([
                'user_id'   => $newUserId,
                'full_name' => $username,
            ]);

            return redirect()->to(base_url('admin/kelola-akun'))->with('success', 'Akun ' . esc($username) . ' berhasil ditambahkan.');
        }

        return redirect()->to(base_url('admin/kelola-akun'))->with('error', 'Gagal menambahkan akun.');
    }

    public function editAkun($id)
    {
        $usersProvider = auth()->getProvider();
        $user = $usersProvider->findById($id);

        if ($user) {
            $username = $this->request->getPost('username');
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $role     = $this->request->getPost('role');

            $user->fill([
                'username' => $username,
            ]);

            if (!empty($password)) {
                $user->password = $password;
            }

            if ($usersProvider->save($user)) {
                // Update email in identities directly
                $db = \Config\Database::connect();
                $db->table('auth_identities')
                   ->where('user_id', $id)
                   ->where('type', 'email_password')
                   ->update(['secret' => $email]);

                // Update Group / Role
                $user->syncGroups($role);

                // Update Profile name
                $db->table('user_profiles')->where('user_id', $id)->update([
                    'full_name' => $username,
                ]);

                return redirect()->to(base_url('admin/kelola-akun'))->with('success', 'Akun berhasil diperbarui.');
            }
        }

        return redirect()->to(base_url('admin/kelola-akun'))->with('error', 'Gagal memperbarui akun.');
    }

    public function hapusAkun($id)
    {
        $usersProvider = auth()->getProvider();
        if ($usersProvider->delete($id, true)) {
            $db = \Config\Database::connect();
            $db->table('user_profiles')->where('user_id', $id)->delete();
            return redirect()->to(base_url('admin/kelola-akun'))->with('success', 'Akun berhasil dihapus.');
        }
        return redirect()->to(base_url('admin/kelola-akun'))->with('error', 'Gagal menghapus akun.');
    }

    public function kelolaUnit()
    {
        $unitModel = new UnitBisnisModel();
        $units = $unitModel->findAll();

        return view('dashboard/admin/kelola_unit', [
            'title' => 'Kelola Unit Bisnis',
            'units' => $units,
        ]);
    }

    public function tambahUnit()
    {
        $nama = $this->request->getPost('nama');
        $id = url_title(strtolower($nama));

        $dokumentasi = [];
        $fotoSampul = 'assets/images/kategori/pisang.jpg';
        if ($file = $this->request->getFile('foto_sampul')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $sampulName = $file->getRandomName();
                $file->move('uploads/unit', $sampulName);
                $fotoSampul = 'uploads/unit/' . $sampulName;
            }
        }

        $galleryOrder = json_decode($this->request->getPost('gallery_order') ?? '[]', true);
        $uploadedFiles = $this->request->getFileMultiple('gallery') ?: [];
        $newFileIdx = 0;
        
        if (!empty($galleryOrder)) {
            foreach ($galleryOrder as $entry) {
                if ($entry['type'] === 'new' && isset($uploadedFiles[$newFileIdx])) {
                    $img = $uploadedFiles[$newFileIdx];
                    $newFileIdx++;
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('uploads/unit', $newName);
                        $dokumentasi[] = 'uploads/unit/' . $newName;
                    }
                }
            }
        } else {
            foreach ($uploadedFiles as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move('uploads/unit', $newName);
                    $dokumentasi[] = 'uploads/unit/' . $newName;
                }
            }
        }

        $unitModel = new UnitBisnisModel();
        $unitModel->insert([
            'id'          => $id,
            'nama'        => $nama,
            'tagline'     => $this->request->getPost('tagline'),
            'wilayah'     => $this->request->getPost('wilayah'),
            'komoditas'   => $this->request->getPost('komoditas'),
            'kapasitas'   => $this->request->getPost('kapasitas'),
            'alamat'      => $this->request->getPost('alamat'),
            'phone'       => $this->request->getPost('phone'),
            'jam'         => $this->request->getPost('hari') . ', ' . $this->request->getPost('jam_buka') . ' – ' . $this->request->getPost('jam_tutup') . ' WIB',
            'maps'        => $this->request->getPost('maps'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'foto_sampul' => $fotoSampul,
            'dokumentasi' => json_encode($dokumentasi),
        ]);

        return redirect()->to(base_url('admin/kelola-unit'))->with('success', 'Unit bisnis ' . esc($nama) . ' berhasil ditambahkan.');
    }

    public function editUnit($id)
    {
        $unitModel = new UnitBisnisModel();
        
        $data = [
            'nama'        => $this->request->getPost('nama'),
            'tagline'     => $this->request->getPost('tagline'),
            'wilayah'     => $this->request->getPost('wilayah'),
            'komoditas'   => $this->request->getPost('komoditas'),
            'kapasitas'   => $this->request->getPost('kapasitas'),
            'alamat'      => $this->request->getPost('alamat'),
            'phone'       => $this->request->getPost('phone'),
            'jam'         => $this->request->getPost('hari') . ', ' . $this->request->getPost('jam_buka') . ' – ' . $this->request->getPost('jam_tutup') . ' WIB',
            'maps'        => $this->request->getPost('maps'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
        ];

        if ($file = $this->request->getFile('foto_sampul')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $sampulName = $file->getRandomName();
                $file->move('uploads/unit', $sampulName);
                $data['foto_sampul'] = 'uploads/unit/' . $sampulName;
            }
        }
        
        $galleryOrder = json_decode($this->request->getPost('gallery_order') ?? '[]', true);
        $uploadedFiles = $this->request->getFileMultiple('gallery') ?: [];
        
        if (!empty($galleryOrder)) {
            $finalGallery = [];
            $newFileIdx = 0;
            foreach ($galleryOrder as $entry) {
                if (($entry['type'] ?? '') === 'existing' && !empty($entry['path'])) {
                    $finalGallery[] = $entry['path'];
                } elseif (($entry['type'] ?? '') === 'new' && isset($uploadedFiles[$newFileIdx])) {
                    $img = $uploadedFiles[$newFileIdx];
                    $newFileIdx++;
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('uploads/unit', $newName);
                        $finalGallery[] = 'uploads/unit/' . $newName;
                    }
                }
            }
            $data['dokumentasi'] = json_encode($finalGallery);
        } elseif (!empty($uploadedFiles)) {
            $dokumentasi = [];
            foreach ($uploadedFiles as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move('uploads/unit', $newName);
                    $dokumentasi[] = 'uploads/unit/' . $newName;
                }
            }
            if (!empty($dokumentasi)) {
                $existing = $unitModel->find($id);
                $oldDocs = json_decode($existing['dokumentasi'] ?? '[]', true) ?: [];
                $data['dokumentasi'] = json_encode(array_merge($oldDocs, $dokumentasi));
            }
        }

        $unitModel->update($id, $data);

        return redirect()->to(base_url('admin/kelola-unit'))->with('success', 'Unit bisnis berhasil diperbarui.');
    }

    public function hapusUnit($id)
    {
        $unitModel = new UnitBisnisModel();
        $unitModel->delete($id);
        return redirect()->to(base_url('admin/kelola-unit'))->with('success', 'Unit bisnis berhasil dihapus.');
    }

    public function kelolaProduk()
    {
        $produkModel = new ProdukModel();
        $products = $produkModel->findAll();

        $unitModel = new UnitBisnisModel();
        $units = $unitModel->findAll();

        return view('dashboard/admin/kelola_produk', [
            'title'    => 'Kelola Produk',
            'products' => $products,
            'units'    => $units,
        ]);
    }

    public function tambahProduk()
    {
        $nama = $this->request->getPost('nama');
        $id = url_title(strtolower($nama));

        $fotoProduk = 'assets/images/produk/pisang.jpg';
        $galleryProduk = [];
        
        if ($file = $this->request->getFile('foto_produk')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $fotoName = $file->getRandomName();
                $file->move('uploads/produk', $fotoName);
                $fotoProduk = 'uploads/produk/' . $fotoName;
            }
        }
        
        // Process gallery using gallery_order JSON
        $galleryOrder = json_decode($this->request->getPost('gallery_order') ?? '[]', true);
        $uploadedFiles = $this->request->getFileMultiple('gallery_produk') ?: [];
        $newFileIdx = 0;
        
        if (!empty($galleryOrder)) {
            foreach ($galleryOrder as $entry) {
                if ($entry['type'] === 'new' && isset($uploadedFiles[$newFileIdx])) {
                    $img = $uploadedFiles[$newFileIdx];
                    $newFileIdx++;
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('uploads/produk', $newName);
                        $galleryProduk[] = 'uploads/produk/' . $newName;
                    }
                }
            }
        } else {
            // Fallback: no gallery_order, process files sequentially
            foreach ($uploadedFiles as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move('uploads/produk', $newName);
                    $galleryProduk[] = 'uploads/produk/' . $newName;
                }
            }
        }

        $produkModel = new ProdukModel();
        $produkModel->insert([
            'id'                => $id,
            'parent_id'         => $this->request->getPost('parent_id') ?: null,
            'unit_bisnis_id'    => $this->request->getPost('unit_bisnis_id'),
            'nama'              => $nama,
            'harga'             => $this->request->getPost('harga'),
            'satuan'            => $this->request->getPost('satuan'),
            'stok'              => $this->request->getPost('stok') ?: 0,
            'deskripsi_singkat' => $this->request->getPost('deskripsi_singkat'),
            'deskripsi_lengkap' => $this->request->getPost('deskripsi_lengkap'),
            'image_path'        => $fotoProduk,
            'gallery'           => json_encode($galleryProduk),
        ]);

        return redirect()->to(base_url('admin/kelola-produk'))->with('success', 'Produk ' . esc($nama) . ' berhasil ditambahkan.');
    }

    public function editProduk($id)
    {
        $produkModel = new ProdukModel();
        
        $data = [
            'parent_id'         => $this->request->getPost('parent_id') ?: null,
            'unit_bisnis_id'    => $this->request->getPost('unit_bisnis_id'),
            'nama'              => $this->request->getPost('nama'),
            'harga'             => $this->request->getPost('harga'),
            'satuan'            => $this->request->getPost('satuan'),
            'stok'              => $this->request->getPost('stok'),
            'deskripsi_singkat' => $this->request->getPost('deskripsi_singkat'),
            'deskripsi_lengkap' => $this->request->getPost('deskripsi_lengkap'),
        ];
        
        if ($file = $this->request->getFile('foto_produk')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $fotoName = $file->getRandomName();
                $file->move('uploads/produk', $fotoName);
                $data['image_path'] = 'uploads/produk/' . $fotoName;
            }
        }
        
        // Process gallery using gallery_order JSON
        $galleryOrder = json_decode($this->request->getPost('gallery_order') ?? '[]', true);
        $uploadedFiles = $this->request->getFileMultiple('gallery_produk') ?: [];
        
        if (!empty($galleryOrder)) {
            $finalGallery = [];
            $newFileIdx = 0;
            
            foreach ($galleryOrder as $entry) {
                if (($entry['type'] ?? '') === 'existing' && !empty($entry['path'])) {
                    $finalGallery[] = $entry['path'];
                } elseif (($entry['type'] ?? '') === 'new' && isset($uploadedFiles[$newFileIdx])) {
                    $img = $uploadedFiles[$newFileIdx];
                    $newFileIdx++;
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('uploads/produk', $newName);
                        $finalGallery[] = 'uploads/produk/' . $newName;
                    }
                }
            }
            
            $data['gallery'] = json_encode($finalGallery);
        } elseif (!empty($uploadedFiles)) {
            // Fallback: no gallery_order but files were uploaded (append to existing)
            $galleryProduk = [];
            foreach ($uploadedFiles as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move('uploads/produk', $newName);
                    $galleryProduk[] = 'uploads/produk/' . $newName;
                }
            }
            if (!empty($galleryProduk)) {
                $existing = $produkModel->find($id);
                $oldDocs = json_decode($existing['gallery'] ?? '[]', true) ?: [];
                $data['gallery'] = json_encode(array_merge($oldDocs, $galleryProduk));
            }
        }

        $produkModel->update($id, $data);

        return redirect()->to(base_url('admin/kelola-produk'))->with('success', 'Produk berhasil diperbarui.');
    }

    public function hapusProduk($id)
    {
        $produkModel = new ProdukModel();
        $produkModel->delete($id);
        return redirect()->to(base_url('admin/kelola-produk'))->with('success', 'Produk berhasil dihapus.');
    }

    public function lihatTransaksi()
    {
        $db = \Config\Database::connect();
        $transactions = $db->table('transaksi')
            ->select('transaksi.*, users.username as pelanggan_nama, pengiriman.status_pengiriman as logistik_status')
            ->join('users', 'users.id = transaksi.pelanggan_id', 'left')
            ->join('pengiriman', 'pengiriman.transaksi_id = transaksi.id', 'left')
            ->orderBy('tanggal_transaksi', 'DESC')
            ->get()->getResultArray();

        foreach ($transactions as &$tx) {
            $tx['details'] = $db->table('transaksi_detail')
                ->select('transaksi_detail.*, produk.nama as produk_nama, produk.satuan')
                ->join('produk', 'produk.id = transaksi_detail.produk_id', 'left')
                ->where('transaksi_id', $tx['id'])
                ->get()->getResultArray();
        }

        return view('dashboard/admin/lihat_transaksi', [
            'title'        => 'Lihat Transaksi',
            'transactions' => $transactions,
        ]);
    }

    public function verifikasiTransaksi($id)
    {
        $db = \Config\Database::connect();
        
        // Fetch transaction details
        $tx = $db->table('transaksi')->where('id', $id)->get()->getRowArray();
        
        if ($tx && $tx['status_pembayaran'] !== 'Lunas') {
            // Update transaction status
            $db->table('transaksi')->where('id', $id)->update([
                'status_pembayaran' => 'Lunas'
            ]);

            // Deduct stock now that payment is confirmed
            $details = $db->table('transaksi_detail')->where('transaksi_id', $id)->get()->getResultArray();
            foreach ($details as $item) {
                $prod = $db->table('produk')->where('id', $item['produk_id'])->get()->getRowArray();
                if ($prod) {
                    $db->table('produk')
                        ->where('id', $item['produk_id'])
                        ->update(['stok' => max(0, $prod['stok'] - $item['qty'])]);
                }
            }
        }

        $existingShipment = $db->table('pengiriman')->where('transaksi_id', $id)->get()->getRowArray();

        // Calculate recommendations
        $totalQty = $db->table('transaksi_detail')->where('transaksi_id', $id)->selectSum('qty')->get()->getRow()->qty ?? 0;
        $method = ($totalQty >= 50) ? 'manual' : 'ekspedisi';
        $courier = ($method === 'ekspedisi') ? 'JNE' : '';

        if ($tx) {
            if ($existingShipment) {
                // Reset shipment status to active waiting scheduling
                $db->table('pengiriman')->where('transaksi_id', $id)->update([
                    'metode_pengiriman' => $method,
                    'ekspedisi_nama'    => $courier,
                    'status_pengiriman' => 'Menunggu Penjadwalan',
                    'supir_id'          => null,
                    'nomor_resi'        => null,
                    'tanggal_kirim'     => null,
                    'tanggal_diterima'  => null,
                    'estimasi_tiba'     => date('Y-m-d', strtotime('+3 days')),
                ]);
            } else {
                $db->table('pengiriman')->insert([
                    'transaksi_id'      => $id,
                    'metode_pengiriman' => $method,
                    'ekspedisi_nama'    => $courier,
                    'status_pengiriman' => 'Menunggu Penjadwalan',
                    'tanggal_kirim'     => null,
                    'estimasi_tiba'     => date('Y-m-d', strtotime('+3 days')),
                ]);
            }
        }

        return redirect()->to(base_url('admin/lihat-transaksi'))->with('success', 'Pembayaran transaksi #' . esc($id) . ' berhasil diverifikasi (Lunas).');
    }

    public function batalTransaksi($id)
    {
        $db = \Config\Database::connect();
        
        $tx = $db->table('transaksi')->where('id', $id)->get()->getRowArray();
        $oldStatus = $tx ? $tx['status_pembayaran'] : '';

        $db->table('transaksi')->where('id', $id)->update([
            'status_pembayaran' => 'Batal'
        ]);

        // Set shipment status to Batal as well
        $db->table('pengiriman')->where('transaksi_id', $id)->update([
            'status_pengiriman' => 'Batal'
        ]);

        // If it was Lunas, we must restore/refund the stock
        if ($oldStatus === 'Lunas') {
            $details = $db->table('transaksi_detail')->where('transaksi_id', $id)->get()->getResultArray();
            foreach ($details as $item) {
                $prod = $db->table('produk')->where('id', $item['produk_id'])->get()->getRowArray();
                if ($prod) {
                    $db->table('produk')
                        ->where('id', $item['produk_id'])
                        ->update(['stok' => $prod['stok'] + $item['qty']]);
                }
            }
        }

        return redirect()->to(base_url('admin/lihat-transaksi'))->with('success', 'Transaksi #' . esc($id) . ' berhasil dibatalkan.');
    }

    public function laporanEkspor()
    {
        $db = \Config\Database::connect();
        
        // Sum total paid transactions
        $totalSales = $db->table('transaksi')
            ->where('status_pembayaran', 'Lunas')
            ->selectSum('total_harga')
            ->get()->getRow()->total_harga ?? 0;

        $totalOrders = $db->table('transaksi')
            ->where('status_pembayaran', 'Lunas')
            ->countAllResults();

        // Sum total harvest volume
        $totalHarvest = $db->table('panen')
            ->selectSum('volume')
            ->get()->getRow()->volume ?? 0;

        $totalTani = $db->table('unit_bisnis')->countAllResults();

        // Sum total shipments
        $totalShipments = $db->table('pengiriman')
            ->where('status_pengiriman', 'Selesai')
            ->countAllResults();
            
        $activeShipments = $db->table('pengiriman')
            ->where('status_pengiriman', 'Sedang Dikirim')
            ->countAllResults();
            
        // Fetch all unit bisnis dynamically from database
        $unitBisnisList = $db->table('unit_bisnis')->get()->getResultArray();
        
        $salesData = [];
        $harvestData = [];
        $salesData30 = [];
        $harvestData30 = [];
        $salesData1Y = [];
        $harvestData1Y = [];
        $salesDataToday = [];
        $harvestDataToday = [];

        foreach ($unitBisnisList as $ub) {
            $ubId = $ub['id'];
            $salesData[$ubId] = [0, 0, 0, 0, 0, 0];
            $harvestData[$ubId] = [0, 0, 0, 0, 0, 0];
            
            $salesData30[$ubId] = [0, 0, 0, 0];
            $harvestData30[$ubId] = [0, 0, 0, 0];
            
            $salesData1Y[$ubId] = [0, 0, 0, 0];
            $harvestData1Y[$ubId] = [0, 0, 0, 0];
            
            $salesDataToday[$ubId] = [0, 0, 0, 0, 0, 0, 0, 0];
            $harvestDataToday[$ubId] = [0, 0, 0, 0, 0, 0, 0, 0];
        }

        // Generate last 6 months labels and map index
        $chartLabels = [];
        $monthsMapping = []; // Format 'Y-m' => index (0 to 5)
        for ($i = 5; $i >= 0; $i--) {
            $monthTime = strtotime("-$i months");
            $ym = date('Y-m', $monthTime);
            $monthsMapping[$ym] = 5 - $i;
            $chartLabels[] = date('M', $monthTime);
        }

        // Query real sales from database
        $salesQuery = $db->table('transaksi_detail')
            ->select('produk.unit_bisnis_id, transaksi_detail.subtotal, transaksi.tanggal_transaksi')
            ->join('transaksi', 'transaksi.id = transaksi_detail.transaksi_id')
            ->join('produk', 'produk.id = transaksi_detail.produk_id')
            ->where('transaksi.status_pembayaran', 'Lunas')
            ->get()->getResultArray();

        // Query real harvests from database
        $harvestQuery = $db->table('panen')
            ->select('produk.unit_bisnis_id, panen.volume, panen.tanggal_panen')
            ->join('produk', 'produk.id = panen.produk_id')
            ->get()->getResultArray();

        // 30 Days helper calculation
        $thirtyDaysAgo = strtotime('-30 days');
        // Current Year helper calculation
        $currentYear = date('Y');
        // Today helper calculation
        $todayDateOnly = date('Y-m-d');

        // Populate Sales data
        foreach ($salesQuery as $sq) {
            $ym = date('Y-m', strtotime($sq['tanggal_transaksi']));
            $ubId = $sq['unit_bisnis_id'];
            
            // 6 Months
            if (isset($monthsMapping[$ym]) && isset($salesData[$ubId])) {
                $salesData[$ubId][$monthsMapping[$ym]] += (int)$sq['subtotal'];
            }
            
            // 30 Days
            $txTime = strtotime($sq['tanggal_transaksi']);
            if ($txTime >= $thirtyDaysAgo && isset($salesData30[$ubId])) {
                $daysDiff = floor((time() - $txTime) / 86400);
                if ($daysDiff <= 7) $wIdx = 3;
                elseif ($daysDiff <= 14) $wIdx = 2;
                elseif ($daysDiff <= 21) $wIdx = 1;
                else $wIdx = 0;
                $salesData30[$ubId][$wIdx] += (int)$sq['subtotal'];
            }
            
            // 1 Year
            if (date('Y', $txTime) === $currentYear && isset($salesData1Y[$ubId])) {
                $monthNum = (int)date('n', $txTime);
                $qIdx = floor(($monthNum - 1) / 3);
                $salesData1Y[$ubId][$qIdx] += (int)$sq['subtotal'];
            }
            
            // Today
            if (date('Y-m-d', $txTime) === $todayDateOnly && isset($salesDataToday[$ubId])) {
                $hour = (int)date('H', $txTime);
                if ($hour < 8) $hIdx = 0;
                elseif ($hour >= 22) $hIdx = 7;
                else $hIdx = (int)floor(($hour - 8) / 2);
                $salesDataToday[$ubId][$hIdx] += (int)$sq['subtotal'];
            }
        }

        // Populate Harvest data
        foreach ($harvestQuery as $hq) {
            $ym = date('Y-m', strtotime($hq['tanggal_panen']));
            $ubId = $hq['unit_bisnis_id'];
            
            // 6 Months
            if (isset($monthsMapping[$ym]) && isset($harvestData[$ubId])) {
                $harvestData[$ubId][$monthsMapping[$ym]] += (int)$hq['volume'];
            }
            
            // 30 Days
            $panenTime = strtotime($hq['tanggal_panen']);
            if ($panenTime >= $thirtyDaysAgo && isset($harvestData30[$ubId])) {
                $daysDiff = floor((time() - $panenTime) / 86400);
                if ($daysDiff <= 7) $wIdx = 3;
                elseif ($daysDiff <= 14) $wIdx = 2;
                elseif ($daysDiff <= 21) $wIdx = 1;
                else $wIdx = 0;
                $harvestData30[$ubId][$wIdx] += (int)$hq['volume'];
            }
            
            // 1 Year
            if (date('Y', $panenTime) === $currentYear && isset($harvestData1Y[$ubId])) {
                $monthNum = (int)date('n', $panenTime);
                $qIdx = floor(($monthNum - 1) / 3);
                $harvestData1Y[$ubId][$qIdx] += (int)$hq['volume'];
            }
            
            // Today
            if (date('Y-m-d', $panenTime) === $todayDateOnly && isset($harvestDataToday[$ubId])) {
                $harvestDataToday[$ubId][1] += (int)$hq['volume'];
            }
        }

        // Helper to calculate Pie Data
        $calculatePie = function($dataSets) use ($unitBisnisList) {
            $total = 0;
            foreach ($unitBisnisList as $ub) {
                $total += array_sum($dataSets[$ub['id']] ?? []);
            }
            $pie = [];
            foreach ($unitBisnisList as $ub) {
                if ($total > 0) {
                    $pie[] = round((array_sum($dataSets[$ub['id']] ?? []) / $total) * 100);
                } else {
                    $pie[] = round(100 / count($unitBisnisList));
                }
            }
            return $pie;
        };

        $pieData = $calculatePie($salesData);
        $pieData30 = $calculatePie($salesData30);
        $pieData1Y = $calculatePie($salesData1Y);
        $pieDataToday = $calculatePie($salesDataToday);

        // Map simplified array for javascript rendering
        $simplifiedUnitBisnis = array_map(function($ub) {
            return ['id' => $ub['id'], 'nama' => $ub['nama']];
        }, $unitBisnisList);

        return view('dashboard/admin/laporan_ekspor', [
            'title'           => 'Laporan & Ekspor',
            'totalSales'      => $totalSales,
            'totalOrders'     => $totalOrders,
            'totalHarvest'    => $totalHarvest,
            'totalTani'       => $totalTani,
            'totalShipments'  => $totalShipments,
            'activeShipments' => $activeShipments,
            'chartLabels'     => json_encode($chartLabels),
            'salesData'       => json_encode($salesData),
            'harvestData'     => json_encode($harvestData),
            'pieData'         => json_encode($pieData),
            
            // 30 Days
            'salesData30'     => json_encode($salesData30),
            'harvestData30'   => json_encode($harvestData30),
            'pieData30'       => json_encode($pieData30),
            
            // 1 Year
            'salesData1Y'     => json_encode($salesData1Y),
            'harvestData1Y'   => json_encode($harvestData1Y),
            'pieData1Y'       => json_encode($pieData1Y),

            // Today
            'salesDataToday'   => json_encode($salesDataToday),
            'harvestDataToday' => json_encode($harvestDataToday),
            'pieDataToday'     => json_encode($pieDataToday),

            // Unit Bisnis Meta
            'unitBisnisList'   => json_encode($simplifiedUnitBisnis),
        ]);
    }

    public function kelolaSupir()
    {
        $supirModel = new SupirModel();
        $drivers = $supirModel->findAll();

        return view('dashboard/admin/kelola_supir', [
            'title'   => 'Kelola Supir & Armada',
            'drivers' => $drivers,
        ]);
    }

    public function tambahSupir()
    {
        $nama = $this->request->getPost('nama');
        $telepon = $this->request->getPost('telepon');
        $armada = $this->request->getPost('armada');
        $plat = $this->request->getPost('plat');

        $supirModel = new SupirModel();
        $supirModel->insert([
            'nama'             => $nama,
            'telepon'          => $telepon,
            'nomor_kendaraan'  => $plat . ' (' . $armada . ')',
            'status'           => 'Aktif'
        ]);

        return redirect()->to(base_url('admin/kelola-supir'))->with('success', 'Supir ' . esc($nama) . ' berhasil ditambahkan.');
    }

    public function editSupir($id)
    {
        $nama = $this->request->getPost('nama');
        $telepon = $this->request->getPost('telepon');
        $armada = $this->request->getPost('armada');
        $plat = $this->request->getPost('plat');

        $supirModel = new SupirModel();
        $supirModel->update($id, [
            'nama'             => $nama,
            'telepon'          => $telepon,
            'nomor_kendaraan'  => $plat . ' (' . $armada . ')',
        ]);

        return redirect()->to(base_url('admin/kelola-supir'))->with('success', 'Data supir berhasil diperbarui.');
    }

    public function hapusSupir($id)
    {
        $supirModel = new SupirModel();
        $supirModel->delete($id);
        return redirect()->to(base_url('admin/kelola-supir'))->with('success', 'Supir berhasil dihapus.');
    }

    public function ekspor()
    {
        $jenis = $this->request->getGet('jenis_laporan'); // penjualan, produksi, distribusi, stok
        $mulai = $this->request->getGet('tanggal_mulai');
        $selesai = $this->request->getGet('tanggal_selesai');
        $format = $this->request->getGet('format'); // pdf, excel

        $db = \Config\Database::connect();
        
        $data = [];
        $title = '';
        
        if ($jenis === 'penjualan') {
            $title = 'Laporan Penjualan (Omset)';
            $data = $db->table('transaksi')
                ->select('transaksi.*, users.username as pelanggan_nama')
                ->join('users', 'users.id = transaksi.pelanggan_id', 'left')
                ->where('tanggal_transaksi >=', $mulai . ' 00:00:00')
                ->where('tanggal_transaksi <=', $selesai . ' 23:59:59')
                ->where('status_pembayaran', 'Lunas')
                ->orderBy('tanggal_transaksi', 'DESC')
                ->get()->getResultArray();
        } elseif ($jenis === 'produksi') {
            $title = 'Laporan Hasil Panen (Produksi)';
            $data = $db->table('panen')
                ->select('panen.*, produk.nama as produk_nama, users.username as petugas_nama')
                ->join('produk', 'produk.id = panen.produk_id', 'left')
                ->join('users', 'users.id = panen.user_id', 'left')
                ->where('tanggal_panen >=', $mulai)
                ->where('tanggal_panen <=', $selesai)
                ->orderBy('tanggal_panen', 'DESC')
                ->get()->getResultArray();
        } elseif ($jenis === 'distribusi') {
            $title = 'Laporan Pengiriman (Logistik)';
            $data = $db->table('pengiriman')
                ->select('pengiriman.*, transaksi.recipient_name, transaksi.shipping_address, supir.nama as supir_nama, supir.nomor_kendaraan')
                ->join('transaksi', 'transaksi.id = pengiriman.transaksi_id', 'left')
                ->join('supir', 'supir.id = pengiriman.supir_id', 'left')
                ->where('tanggal_transaksi >=', $mulai . ' 00:00:00')
                ->where('tanggal_transaksi <=', $selesai . ' 23:59:59')
                ->orderBy('tanggal_transaksi', 'DESC')
                ->get()->getResultArray();
        } elseif ($jenis === 'stok') {
            $title = 'Laporan Stok Inventaris';
            $data = $db->table('produk')
                ->select('produk.*, unit_bisnis.nama as unit_nama')
                ->join('unit_bisnis', 'unit_bisnis.id = produk.unit_bisnis_id', 'left')
                ->orderBy('stok', 'ASC')
                ->get()->getResultArray();
        }

        // 1. FORMAT EXCEL (HTML spreadsheet format for styling)
        if ($format === 'excel') {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . str_replace(' ', '_', $title) . '_' . date('Ymd') . '.xls"');
            
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta charset="UTF-8">';
            echo '<style>
                table { border-collapse: collapse; font-family: Calibri, sans-serif; font-size: 11pt; }
                th { background-color: #0c8a5f; color: #ffffff; font-weight: bold; border: 1px solid #005a36; padding: 10px; text-align: left; }
                td { border: 1px solid #dddddd; padding: 8px; text-align: left; }
                .title-row { font-size: 16pt; font-weight: bold; color: #0c8a5f; }
                .meta-row { font-size: 10pt; color: #555555; }
                .total-row { font-weight: bold; background-color: #e8f5e9; border-top: 2px solid #0c8a5f; }
                .bg-low { color: #d32f2f; font-weight: bold; background-color: #ffebee; }
            </style></head>';
            echo '<body>';
            
            // Title block
            echo '<table>';
            echo '<tr><td colspan="7" class="title-row">' . esc($title) . '</td></tr>';
            echo '<tr><td colspan="7" class="meta-row">PT Parung Hijau Perkasa</td></tr>';
            if ($jenis !== 'stok') {
                echo '<tr><td colspan="7" class="meta-row">Periode: ' . esc($mulai) . ' s/d ' . esc($selesai) . '</td></tr>';
            }
            echo '<tr><td colspan="7" class="meta-row">Dicetak Pada: ' . date('d M Y H:i') . '</td></tr>';
            echo '<tr><td colspan="7"></td></tr>'; // Empty spacing row
            echo '</table>';

            echo '<table>';
            if ($jenis === 'penjualan') {
                echo '<thead><tr>';
                echo '<th>ID Transaksi</th><th>Tanggal</th><th>Pelanggan</th><th>Penerima</th><th>Alamat</th><th>Metode Bayar</th><th>Total Harga</th>';
                echo '</tr></thead><tbody>';
                $totalSales = 0;
                foreach ($data as $row) {
                    $totalSales += $row['total_harga'];
                    echo '<tr>';
                    echo '<td>#' . esc($row['id']) . '</td>';
                    echo '<td>' . esc($row['tanggal_transaksi']) . '</td>';
                    echo '<td>' . esc($row['pelanggan_nama'] ?? 'Pelanggan') . '</td>';
                    echo '<td>' . esc($row['recipient_name']) . '</td>';
                    echo '<td>' . esc($row['shipping_address']) . '</td>';
                    echo '<td style="text-transform: capitalize;">' . esc($row['metode_pembayaran']) . '</td>';
                    echo '<td>Rp ' . number_format($row['total_harga'], 0, ',', '.') . '</td>';
                    echo '</tr>';
                }
                echo '<tr class="total-row">';
                echo '<td colspan="6" style="text-align: right; font-weight: bold;">Total Pendapatan (Omset):</td>';
                echo '<td style="font-weight: bold; background-color: #e8f5e9;">Rp ' . number_format($totalSales, 0, ',', '.') . '</td>';
                echo '</tr>';
            } elseif ($jenis === 'produksi') {
                echo '<thead><tr>';
                echo '<th>ID Panen</th><th>Tanggal Panen</th><th>Produk</th><th>Petugas</th><th>Kualitas</th><th>Volume</th><th>Satuan</th>';
                echo '</tr></thead><tbody>';
                $totalVol = 0;
                foreach ($data as $row) {
                    $totalVol += $row['volume'];
                    echo '<tr>';
                    echo '<td>#PAN-' . esc($row['id']) . '</td>';
                    echo '<td>' . esc($row['tanggal_panen']) . '</td>';
                    echo '<td>' . esc($row['produk_nama']) . '</td>';
                    echo '<td>' . esc($row['petugas_nama']) . '</td>';
                    echo '<td style="text-transform: capitalize;">' . str_replace('_', ' ', esc($row['kualitas'])) . '</td>';
                    echo '<td>' . number_format($row['volume'], 0, ',', '.') . '</td>';
                    echo '<td>' . esc($row['satuan']) . '</td>';
                    echo '</tr>';
                }
                echo '<tr class="total-row">';
                echo '<td colspan="5" style="text-align: right; font-weight: bold;">Total Volume Panen:</td>';
                echo '<td style="font-weight: bold; background-color: #e8f5e9;">' . number_format($totalVol, 0, ',', '.') . '</td>';
                echo '<td>Unit</td>';
                echo '</tr>';
            } elseif ($jenis === 'distribusi') {
                echo '<thead><tr>';
                echo '<th>ID Pengiriman</th><th>ID Transaksi</th><th>Metode</th><th>Kurir / Supir / Resi</th><th>Penerima</th><th>Alamat</th><th>Status</th>';
                echo '</tr></thead><tbody>';
                foreach ($data as $row) {
                    $kurir = $row['metode_pengiriman'] === 'manual' ? ($row['supir_nama'] . ' (' . $row['nomor_kendaraan'] . ')') : ($row['ekspedisi_nama'] . ' (Resi: ' . $row['nomor_resi'] . ')');
                    echo '<tr>';
                    echo '<td>#DEL-' . esc($row['id']) . '</td>';
                    echo '<td>#' . esc($row['transaksi_id']) . '</td>';
                    echo '<td style="text-transform: capitalize;">' . esc($row['metode_pengiriman']) . '</td>';
                    echo '<td>' . esc($kurir) . '</td>';
                    echo '<td>' . esc($row['recipient_name']) . '</td>';
                    echo '<td>' . esc($row['shipping_address']) . '</td>';
                    echo '<td>' . esc($row['status_pengiriman']) . '</td>';
                    echo '</tr>';
                }
            } elseif ($jenis === 'stok') {
                echo '<thead><tr>';
                echo '<th>ID Produk</th><th>Nama Produk</th><th>Unit Bisnis</th><th>Harga</th><th>Satuan</th><th>Stok</th>';
                echo '</tr></thead><tbody>';
                foreach ($data as $row) {
                    $isLow = $row['stok'] <= 10;
                    echo '<tr>';
                    echo '<td>#' . esc($row['id']) . '</td>';
                    echo '<td>' . esc($row['nama']) . '</td>';
                    echo '<td style="text-transform: capitalize;">' . esc($row['unit_nama']) . '</td>';
                    echo '<td>Rp ' . number_format($row['harga'], 0, ',', '.') . '</td>';
                    echo '<td>' . esc($row['satuan']) . '</td>';
                    echo '<td class="' . ($isLow ? 'bg-low' : '') . '">' . esc($row['stok']) . '</td>';
                    echo '</tr>';
                }
            }
            echo '</tbody></table>';
            echo '</body></html>';
            exit;
        }

        // 2. FORMAT PDF (Print-Friendly HTML Page)
        return view('dashboard/admin/ekspor_pdf', [
            'title'   => $title,
            'jenis'   => $jenis,
            'mulai'   => $mulai,
            'selesai' => $selesai,
            'data'    => $data
        ]);
    }
}
