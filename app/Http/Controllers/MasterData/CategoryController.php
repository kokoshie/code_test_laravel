<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\Category\Interfaces\CategoryInterface;
use App\Http\Controllers\ApiResponseController as BaseController;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    public $category;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

    }
    public function __construct(CategoryInterface $category) {
        $this->category = $category;
    }
    public function show()
    {
        $categories =  $this->category->getAllCategories();
        return response()->json([
            'categories' => $categories
        ]);
    }
    public function store(Request $request)
    {
        // validate and store data
        $validator = Validator::make($request->all(), [
            'photo' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $data = $request->all();

        if($image = $request->file('photo')) {
            $name = time(). '.' .$image->getClientOriginalName();
            $image->move(public_path() . '/assets/images/categories/', $name);
            $data['photo'] = $name;
        }

        $this->category->createCategory($data);

        return response()->json([
            'msg' => 'success'
        ]);

    }
    public function edit($id)
    {
        $category = $this->category->editCategory($id);
        return response()->json([
            'data' => $category
        ]);
    }
    public function update(Request $request, $id)
    {
        // validate and store data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        //image upload

        $data = $request->all();

        if($image = $request->file('photo')) {
            $name = time(). '.' .$image->getClientOriginalName();
            $image->move(public_path('/assets/images/categories/'), $name);
            $data['photo'] = "$name";
        }

        $this->category->updateCategory($id, $data);

        return response()->json([
            'msg' => 'success'
        ]);

    }
    public function delete($id)
    {
        $this->category->deleteCategory($id);

        return response()->json([
            'msg' => 'success'
        ]);
    }


}
