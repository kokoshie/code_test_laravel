<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Seller\Interfaces\SellerInterface;
use App\Http\Controllers\ApiResponseController as BaseController;
use Illuminate\Support\Facades\Validator;

class SellerController extends BaseController
{
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
    public function __construct(SellerInterface $seller) {
        $this->seller = $seller;
    }
    public function show()
    {
        $sellers =  $this->seller->getAllSellers();
        logger("seeellllllllllller");
        logger($sellers);
        return response()->json([
            'sellers' => $sellers
        ]);
    }
    public function store(Request $request)
    {
        // validate and store data
        $validator = Validator::make($request->all(), [
            'photo' => 'required',
            'name' => 'required',
            'email' => ['required', 'string', 'email','unique:users', 'max:50'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $data = $request->all();

        if($image = $request->file('photo')) {
            $name = time(). '.' .$image->getClientOriginalName();
            $image->move(public_path() . '/assets/images/sellers/', $name);
            $data['photo'] = $name;
        }

        $this->seller->createSeller($data);

        return response()->json([
            'msg' => 'success'
        ]);

    }
    public function edit($id)
    {
        $seller = $this->seller->editseller($id);
        return response()->json([
            'data' => $seller
        ]);
    }
    public function update(Request $request, $id)
    {
        // validate and store data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:50'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        //image upload

        $data = $request->all();

        if($image = $request->file('photo')) {
            $name = time(). '.' .$image->getClientOriginalName();
            $image->move(public_path('/assets/images/sellers/'), $name);
            $data['photo'] = "$name";
        }

        $this->seller->updateSeller($id, $data);

        return response()->json([
            'msg' => 'success'
        ]);

    }
    public function delete($id)
    {
        $this->seller->deleteSeller($id);

        return response()->json([
            'msg' => 'success'
        ]);
    }

}
