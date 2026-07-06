<?php

namespace App\Controllers\Produksi;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\PanenModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // 1. Total Volume Panen Bulan Ini
        $currentMonth = date('m');
        $currentYear = date('Y');
        $totalHarvest = $db->table('panen')
            ->where('MONTH(tanggal_panen)', $currentMonth)
            ->where('YEAR(tanggal_panen)', $currentYear)
            ->selectSum('volume')
            ->get()->getRow()->volume ?? 0;
            
        // 2. Unit Bisnis Aktif
        $activeUnits = $db->table('unit_bisnis')->countAllResults();

        // 3. Persentase Grade A
        $totalLogs = $db->table('panen')->countAllResults();
        $gradeALogs = $db->table('panen')->where('kualitas', 'grade_a')->countAllResults();
        $gradeAPercentage = $totalLogs > 0 ? round(($gradeALogs / $totalLogs) * 100) : 0;

        // 4. Aktivitas Panen Terakhir (limit 5)
        $recentLogs = $db->table('panen')
            ->select('panen.*, produk.nama as produk_nama, produk.satuan, produk.unit_bisnis_id')
            ->join('produk', 'produk.id = panen.produk_id', 'left')
            ->orderBy('tanggal_panen', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        return view('dashboard/produksi/index', [
            'title'            => 'Dashboard Produksi',
            'totalHarvest'     => $totalHarvest,
            'activeUnits'      => $activeUnits,
            'gradeAPercentage' => $gradeAPercentage,
            'recentLogs'       => $recentLogs
        ]);
    }

    public function input()
    {
        $produkModel = new ProdukModel();
        // Get sellable child products
        $products = $produkModel->where('id !=', 'sungrow-cavendish')->findAll();

        return view('dashboard/produksi/input', [
            'title'    => 'Input Hasil Produksi',
            'products' => $products
        ]);
    }

    public function riwayat()
    {
        $db = \Config\Database::connect();
        
        // Fetch all harvest logs with product details
        $logs = $db->table('panen')
            ->select('panen.*, produk.nama as produk_nama, produk.unit_bisnis_id, produk.satuan')
            ->join('produk', 'produk.id = panen.produk_id', 'left')
            ->orderBy('tanggal_panen', 'DESC')
            ->get()->getResultArray();

        $produkModel = new ProdukModel();
        $products = $produkModel->where('id !=', 'sungrow-cavendish')->findAll();

        return view('dashboard/produksi/riwayat', [
            'title'    => 'Update & Riwayat Produksi',
            'logs'     => $logs,
            'products' => $products
        ]);
    }

    // =========================================================================
    // CRUD ACTIONS: Logika simpan, update, dan hapus panen dengan sinkronisasi stok
    // =========================================================================

    public function simpanPanen()
    {
        $panenModel = new PanenModel();
        $produkModel = new ProdukModel();

        // Ambil input
        $produkId = $this->request->getPost('produk_id');
        $volume = (int)$this->request->getPost('volume');
        $kualitas = $this->request->getPost('kualitas');
        $tanggal = $this->request->getPost('tanggal_panen');
        $catatan = $this->request->getPost('catatan');

        // Cari info produk untuk mengambil nama satuannya
        $produk = $produkModel->find($produkId);
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Simpan log panen baru
        $panenModel->insert([
            'produk_id'     => $produkId,
            'user_id'       => auth()->id() ?? 1, // Fallback ke user ID 1 jika offline
            'volume'        => $volume,
            'satuan'        => $produk['satuan'],
            'kualitas'      => $kualitas,
            'tanggal_panen' => $tanggal,
            'catatan'       => $catatan
        ]);

        // Tambahkan volume panen ke stok produk terkait
        $stokBaru = $produk['stok'] + $volume;
        $produkModel->update($produkId, ['stok' => $stokBaru]);

        return redirect()->to(base_url('produksi/riwayat'))->with('success', 'Data panen berhasil disimpan dan stok produk berhasil bertambah!');
    }

    public function updatePanen($id)
    {
        $panenModel = new PanenModel();
        $produkModel = new ProdukModel();

        $log = $panenModel->find($id);
        if (!$log) {
            return redirect()->to(base_url('produksi/riwayat'))->with('error', 'Data panen tidak ditemukan.');
        }

        // Ambil input baru
        $produkId = $this->request->getPost('produk_id');
        $volume = (int)$this->request->getPost('volume');
        $kualitas = $this->request->getPost('kualitas');
        $tanggal = $this->request->getPost('tanggal_panen');
        $catatan = $this->request->getPost('catatan');

        $produk = $produkModel->find($produkId);
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Kembalikan stok lama
        $oldProduk = $produkModel->find($log['produk_id']);
        if ($oldProduk) {
            $stokReverted = max(0, $oldProduk['stok'] - $log['volume']);
            $produkModel->update($log['produk_id'], ['stok' => $stokReverted]);
        }

        // Terapkan stok baru
        $stokBaru = $produk['stok'] + $volume;
        $produkModel->update($produkId, ['stok' => $stokBaru]);

        // Simpan update log panen
        $panenModel->update($id, [
            'produk_id'     => $produkId,
            'volume'        => $volume,
            'satuan'        => $produk['satuan'],
            'kualitas'      => $kualitas,
            'tanggal_panen' => $tanggal,
            'catatan'       => $catatan
        ]);

        return redirect()->to(base_url('produksi/riwayat'))->with('success', 'Data panen berhasil diperbarui dan stok produk disesuaikan!');
    }

    public function hapusPanen($id)
    {
        $panenModel = new PanenModel();
        $produkModel = new ProdukModel();

        $log = $panenModel->find($id);
        if (!$log) {
            return redirect()->to(base_url('produksi/riwayat'))->with('error', 'Data panen tidak ditemukan.');
        }

        // Kurangi stok produk terkait sebanyak volume panen yang dihapus
        $produk = $produkModel->find($log['produk_id']);
        if ($produk) {
            $stokBaru = max(0, $produk['stok'] - $log['volume']);
            $produkModel->update($log['produk_id'], ['stok' => $stokBaru]);
        }

        // Hapus log panen
        $panenModel->delete($id);

        return redirect()->to(base_url('produksi/riwayat'))->with('success', 'Log panen berhasil dihapus dan stok produk disesuaikan.');
    }
}
