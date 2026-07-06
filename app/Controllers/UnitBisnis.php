<?php

namespace App\Controllers;

use App\Models\UnitBisnisModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class UnitBisnis extends BaseController
{
    public function detail($id)
    {
        $unitModel = new UnitBisnisModel();
        $unit = $unitModel->find($id);

        if (!$unit) {
            throw PageNotFoundException::forPageNotFound("Unit bisnis tidak ditemukan.");
        }

        return view('unit_bisnis/detail', [
            'title' => 'Unit Bisnis ' . esc($unit['nama']),
            'unit'  => $unit
        ]);
    }
}
