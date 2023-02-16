<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\Product\Interfaces\ProductInterface;
use App\Http\Controllers\ApiResponseController as BaseController;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    public $product;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function __construct(ProductInterface $product) {
        $this->product = $product;
    }
    public function show()
    {
        $products =  $this->product->getAllProducts();
        return response()->json([
            'products' => $products
        ]);
    }
    public function store(Request $request)
    {
        // validate and store data
        logger($request->all());
        $validator = Validator::make($request->all(), [
            'photo' => 'required',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'category_id' => 'required | not_in:0'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $data = $request->all();

        if($image = $request->file('photo')) {
            $name = time(). '.' .$image->getClientOriginalName();
            $image->move(public_path() . '/assets/images/products/', $name);
            $data['photo'] = $name;
        }

        $this->product->createProduct($data);

        return response()->json([
            'msg' => 'success'
        ]);

    }
    public function edit($id)
    {
        $product = $this->product->editProduct($id);
        return response()->json([
            'data' => $product
        ]);
    }
    public function update(Request $request, $id)
    {
        // validate and store data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        //image upload

        $data = $request->all();

        if($image = $request->file('photo')) {
            $name = time(). '.' .$image->getClientOriginalName();
            $image->move(public_path('/assets/images/products/'), $name);
            $data['photo'] = "$name";
        }

        $this->product->updateProduct($id, $data);

        return response()->json([
            'msg' => 'success'
        ]);

    }
    public function delete($id)
    {
        $this->product->deleteProduct($id);

        return response()->json([
            'msg' => 'success'
        ]);
    }

}
