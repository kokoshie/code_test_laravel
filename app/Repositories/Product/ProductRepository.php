<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Product\Interfaces\ProductInterface;
use Illuminate\Support\Facades\File;

class ProductRepository implements ProductInterface {

    public function getAllProducts()
    {
        return Product::all();
    }

    public function getSingleProduct($id)
    {


        // return  Product::find($id);

        //return Product::with('comments')->get();

        //return Product::with('comments')->find($id);
    }

    public function createProduct(array $data)
    {
        $category = Category::find($data['category_id']);
        if($data['role'] == 'admin')
        {
            $seller_id = null;
            $seller_name = null;
        }
        elseif($data['role'] == 'seller')
        {
            $seller_id = $data['user_id'];
            $seller = User::find($data['user_id']);
            $seller_name = $seller->name;
        }
        Product::create([
            'photo' => $data['photo'],
            'name' => $data['name'],
            'seller_id' => $seller_id,
            'seller_name' => $seller_name,
            'price' => $data['price'],
            'category_id' => $data['category_id'],
            'category_name' => $category->name,
            'description' => $data['description'],
        ]);

    }

    public function editProduct($id)
    {
        return Product::find($id);
    }

    public function updateProduct($id, array $data)
    {
        $category = Category::find($data['category_id']);
        if(isset($data['photo']))
        {
            $delete = Product::find($id);
            $name = public_path() . '/assets/images/products/'. $delete->photo;
            File::delete($name);
            Product::find($id)->update([
                'photo' => $data['photo'],
                'name' => $data['name'],
                'price' => $data['price'],
                'category_id' => $data['category_id'],
                'category_name' => $category->name,
                'description' => $data['description'],
            ]);
        }
        else
        {
            Product::find($id)->update([
                'name' => $data['name'],
                'price' => $data['price'],
                'category_id' => $data['category_id'],
                'category_name' => $category->name,
                'description' => $data['description'],
            ]);
        }
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $name = public_path() . '/assets/images/products/'. $product->photo;
        File::delete($name);
        $product->delete();
    }

}



?>
