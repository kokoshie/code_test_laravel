<?php

namespace App\Repositories\Seller;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Seller\Interfaces\SellerInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SellerRepository implements SellerInterface {

    public function getAllSellers()
    {
        $seller = [];
        $role_user = DB::table('role_user')->where('role_id',2)->get();
        foreach($role_user as $user_seller)
        {
            $user = User::find($user_seller->user_id);
            if($user != null)
            {
            array_push($seller,$user);
            }
        }
        return $seller;
    }

    public function getSingleSeller($id)
    {


        // return  Product::find($id);

        //return Product::with('comments')->get();

        //return Product::with('comments')->find($id);
    }

    public function createSeller(array $data)
    {

            $user = User::create([
            'photo' => $data['photo'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        $user->roles()->attach(2);
    }

    public function editSeller($id)
    {
        return User::find($id);
    }

    public function updateSeller($id, array $data)
    {
        if(isset($data['photo']))
        {
            $delete = User::find($id);
            $name = public_path() . '/assets/images/sellers/'. $delete->photo;
            File::delete($name);
            User::find($id)->update([
                'photo' => $data['photo'],
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
        }
        else
        {
            User::find($id)->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
        }
    }

    public function deleteSeller($id)
    {
        $seller = User::find($id);
        $name = public_path() . '/assets/images/sellers/'. $seller->photo;
        File::delete($name);
        $seller->delete();
    }

}



?>
