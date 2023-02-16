<?php

namespace App\Repositories\Seller\Interfaces;

use Illuminate\Support\Collection;

interface SellerInterface {

    public function getAllSellers();

    public function getSingleSeller($id);

    public function createSeller(array $data);

    public function editSeller($id);

    public function updateSeller($id, array $data);

    public function deleteSeller($id);
}


?>
