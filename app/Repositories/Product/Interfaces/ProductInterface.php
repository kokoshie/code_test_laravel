<?php

namespace App\Repositories\Product\Interfaces;

use Illuminate\Support\Collection;

interface ProductInterface {

    public function getAllProducts();

    public function getSingleProduct($id);

    public function createProduct(array $data);

    public function editProduct($id);

    public function updateProduct($id, array $data);

    public function deleteProduct($id);
}


?>
