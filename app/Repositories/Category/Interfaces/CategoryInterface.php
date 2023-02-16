<?php

namespace App\Repositories\Category\Interfaces;

use Illuminate\Support\Collection;

interface CategoryInterface {

    public function getAllCategories();

    public function getSingleCategory($id);

    public function createCategory(array $data);

    public function editCategory($id);

    public function updateCategory($id, array $data);

    public function deleteCategory($id);
}




?>
