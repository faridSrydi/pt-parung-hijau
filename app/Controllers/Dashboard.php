<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $totalPenjualan = $db->table('transaksi')->where('status_pembayaran', 'Lunas')->selectSum('total_harga')->get()->getRow()->total_harga ?? 0;
        $totalUsers = $db->table('users')->countAllResults();
        $totalStock = $db->table('produk')->selectSum('stok')->get()->getRow()->stok ?? 0;
        $totalTransactions = $db->table('transaksi')->countAllResults();

        $recentTransactions = $db->table('transaksi')
            ->select('transaksi.*, users.username')
            ->join('users', 'users.id = transaksi.pelanggan_id', 'left')
            ->orderBy('tanggal_transaksi', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        return view('dashboard/index', [
            'title'              => 'Dashboard Overview',
            'totalPenjualan'     => $totalPenjualan,
            'totalUsers'          => $totalUsers,
            'totalStock'         => $totalStock,
            'totalTransactions'  => $totalTransactions,
            'recentTransactions' => $recentTransactions
        ]);
    }
}
