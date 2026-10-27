<?php

namespace App\Controllers\Seller;

use App\Controllers\BaseController;
use App\Models\HsnMasterModel;

class HsnLookup extends BaseController
{
    public function search()
    {
        // Require an authenticated seller.
        if (! session()->get('seller_id')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Please log in as a seller.',
                    'results' => [],
                ]);
        }

        $term = trim((string) $this->request->getGet('q'));

        if (mb_strlen($term) < 3) {
            return $this->response->setJSON([
                'status'  => true,
                'results' => [],
            ]);
        }

        $model = new HsnMasterModel();

        $results = $model
            ->select('id, hsn_code, description')
            ->where('is_active', 1)
            ->groupStart()
                ->like('hsn_code', $term, 'after')
                ->orLike('description', $term)
            ->groupEnd()
            ->orderBy('hsn_code', 'ASC')
            ->limit(10)
            ->find();

        return $this->response->setJSON([
            'status'  => true,
            'results' => $results,
        ]);
    }
}