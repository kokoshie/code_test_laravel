<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\Category\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\File;

class CategoryRepository implements CategoryInterface {

    public function getAllCategories()
    {
        return Category::all();
    }

    public function getSingleCategory($id)
    {


        // return  Product::find($id);

        //return Product::with('comments')->get();

        //return Product::with('comments')->find($id);
    }

    public function createCategory(array $data)
    {

        Category::create([
            'photo' => $data['photo'],
            'name' => $data['name'],
        ]);

        // $category = new Category();
        // $category->photo = $data['photo'];
        // $category->name = $data['name'];


        // $category->save();

    }

    public function editCategory($id)
    {
        return Category::find($id);
    }

    public function updateCategory($id, array $data)
    {
        if(isset($data['photo']))
        {
            $delete = Category::find($id);
            $name = public_path() . '/assets/images/categories/'. $delete->photo;
            File::delete($name);
            Category::find($id)->update([
                'photo' => $data['photo'],
                'name' => $data['name'],
            ]);
        }
        else
        {
            Category::find($id)->update([
                'name' => $data['name'],
            ]);
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $name = public_path() . '/assets/images/categories/'. $category->photo;
        File::delete($name);
        $category->delete();
    }

}



?>
