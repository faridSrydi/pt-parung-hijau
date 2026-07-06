<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\AlamatPengirimanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = auth()->id();
        $db = \Config\Database::connect();

        // Get transactions
        $transactions = $db->table('transaksi')
            ->select('transaksi.*, pengiriman.status_pengiriman as logistik_status')
            ->join('pengiriman', 'pengiriman.transaksi_id = transaksi.id', 'left')
            ->where('pelanggan_id', $userId)
            ->orderBy('tanggal_transaksi', 'DESC')
            ->get()->getResultArray();

        // Get transaction details for inline display / parsing
        foreach ($transactions as &$tx) {
            $tx['details'] = $db->table('transaksi_detail')
                ->select('transaksi_detail.*, produk.nama as produk_nama, produk.image_path as image_path')
                ->join('produk', 'produk.id = transaksi_detail.produk_id', 'left')
                ->where('transaksi_id', $tx['id'])
                ->get()->getResultArray();
        }

        // Get addresses
        $alamatModel = new AlamatPengirimanModel();
        $addresses = $alamatModel->where('user_id', $userId)->orderBy('is_default', 'DESC')->findAll();

        return view('dashboard/pelanggan', [
            'title'        => 'Dashboard Pelanggan',
            'transactions' => $transactions,
            'addresses'    => $addresses
        ]);
    }

    public function simpanAlamat()
    {
        $alamatModel = new AlamatPengirimanModel();
        
        $data = [
            'user_id' => auth()->id(),
            'recipient_name' => $this->request->getPost('recipient_name'),
            'phone' => $this->request->getPost('phone'),
            'address_line' => $this->request->getPost('address_line'),
            'is_default' => $this->request->getPost('is_default') ? 1 : 0
        ];
        
        if ($data['is_default']) {
            $alamatModel->where('user_id', $data['user_id'])->set(['is_default' => 0])->update();
        }

        if ($alamatModel->insert($data) === false) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Gagal menyimpan ke database.', 
                'errors' => $alamatModel->errors()
            ]);
        }
        
        return $this->response->setJSON(['status' => 'success', 'message' => 'Alamat pengiriman baru berhasil disimpan!']);
    }

    public function updateAlamat($id)
    {
        $alamatModel = new AlamatPengirimanModel();
        // Pastikan alamat milik user yang login
        $alamat = $alamatModel->where('user_id', auth()->id())->find($id);
        if (!$alamat) return $this->response->setJSON(['status' => 'error', 'message' => 'Alamat tidak ditemukan.']);

        $data = [
            'recipient_name' => $this->request->getPost('recipient_name'),
            'phone' => $this->request->getPost('phone'),
            'address_line' => $this->request->getPost('address_line'),
            'is_default' => $this->request->getPost('is_default') ? 1 : 0
        ];
        
        if ($data['is_default']) {
            $alamatModel->where('user_id', auth()->id())->set(['is_default' => 0])->update();
        }

        $alamatModel->update($id, $data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Alamat berhasil diperbarui!']);
    }

    public function hapusAlamat($id)
    {
        $alamatModel = new AlamatPengirimanModel();
        $alamat = $alamatModel->where('user_id', auth()->id())->find($id);
        if (!$alamat) return $this->response->setJSON(['status' => 'error', 'message' => 'Alamat tidak ditemukan.']);

        $alamatModel->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Alamat berhasil dihapus!']);
    }

    public function kirimBukti($id)
    {
        $db = \Config\Database::connect();
        
        // Check if transaction belongs to this user
        $tx = $db->table('transaksi')
            ->where('id', $id)
            ->where('pelanggan_id', auth()->id())
            ->get()->getRowArray();
            
        if (!$tx) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Transaksi tidak ditemukan.']);
        }

        $file = $this->request->getFile('bukti_transfer');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Check mime type
            if (!in_array($file->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Format berkas harus JPG atau PNG.']);
            }
            
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/bukti/', $newName);
            
            $db->table('transaksi')->where('id', $id)->update([
                'bukti_transfer'    => $newName,
                'status_pembayaran' => 'Menunggu Verifikasi'
            ]);
            
            return $this->response->setJSON(['status' => 'success', 'message' => 'Bukti pembayaran berhasil dikirim!']);
        }
        
        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengunggah gambar bukti.']);
    }
}
