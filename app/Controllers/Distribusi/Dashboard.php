<?php

namespace App\Controllers\Distribusi;

use App\Controllers\BaseController;
use App\Models\PengirimanModel;
use App\Models\SupirModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $siapKirim = $db->table('pengiriman')
            ->join('transaksi', 'transaksi.id = pengiriman.transaksi_id', 'left')
            ->where('transaksi.status_pembayaran', 'Lunas')
            ->where('status_pengiriman', 'Diproses')->countAllResults();

        $sedangKirim = $db->table('pengiriman')
            ->join('transaksi', 'transaksi.id = pengiriman.transaksi_id', 'left')
            ->where('transaksi.status_pembayaran', 'Lunas')
            ->where('status_pengiriman', 'Dikirim')->countAllResults();

        $telahDiterima = $db->table('pengiriman')
            ->join('transaksi', 'transaksi.id = pengiriman.transaksi_id', 'left')
            ->where('transaksi.status_pembayaran', 'Lunas')
            ->where('status_pengiriman', 'Selesai')->countAllResults();

        $recentDeliveries = $db->table('pengiriman')
            ->select('pengiriman.*, transaksi.recipient_name, transaksi.shipping_address, supir.nama as supir_nama, supir.nomor_kendaraan')
            ->join('transaksi', 'transaksi.id = pengiriman.transaksi_id', 'left')
            ->join('supir', 'supir.id = pengiriman.supir_id', 'left')
            ->where('transaksi.status_pembayaran', 'Lunas')
            ->where('status_pengiriman !=', 'Batal')
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        return view('dashboard/distribusi/index', [
            'title'            => 'Dashboard Distribusi',
            'siapKirim'        => $siapKirim,
            'sedangKirim'      => $sedangKirim,
            'telahDiterima'    => $telahDiterima,
            'recentDeliveries' => $recentDeliveries
        ]);
    }

    public function pengiriman()
    {
        $db = \Config\Database::connect();
        
        // Fetch deliveries that are waiting driver assignment or currently processed
        $deliveries = $db->table('pengiriman')
            ->select('pengiriman.*, transaksi.recipient_name, transaksi.shipping_address, supir.nama as supir_nama')
            ->join('transaksi', 'transaksi.id = pengiriman.transaksi_id', 'left')
            ->join('supir', 'supir.id = pengiriman.supir_id', 'left')
            ->where('transaksi.status_pembayaran', 'Lunas')
            ->where('status_pengiriman !=', 'Selesai')
            ->where('status_pengiriman !=', 'Batal')
            ->get()->getResultArray();

        foreach ($deliveries as &$del) {
            $del['details'] = $db->table('transaksi_detail')
                ->select('transaksi_detail.*, produk.nama as produk_nama, produk.satuan')
                ->join('produk', 'produk.id = transaksi_detail.produk_id', 'left')
                ->where('transaksi_id', $del['transaksi_id'])
                ->get()->getResultArray();
        }

        $supirModel = new SupirModel();
        $drivers = $supirModel->where('status', 'Aktif')->findAll();

        return view('dashboard/distribusi/pengiriman', [
            'title'      => 'Kelola Pengiriman',
            'deliveries' => $deliveries,
            'drivers'    => $drivers
        ]);
    }

    public function resi()
    {
        $db = \Config\Database::connect();
        
        // Fetch all deliveries for general tracking resi list
        $deliveries = $db->table('pengiriman')
            ->select('pengiriman.*, transaksi.recipient_name, transaksi.shipping_address, supir.nama as supir_nama, supir.nomor_kendaraan')
            ->join('transaksi', 'transaksi.id = pengiriman.transaksi_id', 'left')
            ->join('supir', 'supir.id = pengiriman.supir_id', 'left')
            ->where('transaksi.status_pembayaran', 'Lunas')
            ->where('status_pengiriman !=', 'Batal')
            ->get()->getResultArray();

        foreach ($deliveries as &$del) {
            $del['details'] = $db->table('transaksi_detail')
                ->select('transaksi_detail.*, produk.nama as produk_nama, produk.satuan')
                ->join('produk', 'produk.id = transaksi_detail.produk_id', 'left')
                ->where('transaksi_id', $del['transaksi_id'])
                ->get()->getResultArray();
        }

        return view('dashboard/distribusi/resi', [
            'title'      => 'Update Status Resi',
            'deliveries' => $deliveries
        ]);
    }

    // =========================================================================
    // SKELETON ACTIONS: Tempat teman-teman meletakkan logika CRUD logistik
    // =========================================================================

    public function updateLogistik($id)
    {
        $db = \Config\Database::connect();
        
        $metodeSelect = $this->request->getPost('metode_select');
        $status = $this->request->getPost('status_pengiriman');

        if ($metodeSelect === 'manual') {
            $data = [
                'metode_pengiriman' => 'manual',
                'supir_id'          => $this->request->getPost('supir_id') ?: null,
                'ekspedisi_nama'    => null,
                'nomor_resi'        => null,
                'status_pengiriman' => $status,
            ];
        } else {
            $data = [
                'metode_pengiriman' => 'ekspedisi',
                'supir_id'          => null,
                'ekspedisi_nama'    => $metodeSelect,
                'nomor_resi'        => $this->request->getPost('nomor_resi'),
                'status_pengiriman' => $status,
            ];
        }

        if ($status === 'Selesai') {
            $data['tanggal_diterima'] = date('Y-m-d');
        }
        if ($status === 'Sedang Dikirim') {
            $data['tanggal_kirim'] = date('Y-m-d');
        }

        $db->table('pengiriman')->where('id', $id)->update($data);

        return redirect()->to(base_url('distribusi/pengiriman'))->with('success', 'Status pengiriman berhasil diperbarui.');
    }

    public function updateResi($id)
    {
        $db = \Config\Database::connect();
        
        $resi = $this->request->getPost('nomor_resi');
        $status = $this->request->getPost('status_pengiriman');

        $data = [
            'nomor_resi'        => $resi,
            'status_pengiriman' => $status,
        ];

        if ($status === 'Selesai') {
            $data['tanggal_diterima'] = date('Y-m-d');
        }
        if ($status === 'Sedang Dikirim') {
            $data['tanggal_kirim'] = date('Y-m-d');
        }

        $db->table('pengiriman')->where('id', $id)->update($data);

        return redirect()->to(base_url('distribusi/resi'))->with('success', 'Status resi/pengiriman berhasil diperbarui.');
    }
}
