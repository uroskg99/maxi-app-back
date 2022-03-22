<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProducts() {
        $result = Product::all();

        return [
            'products' => $result
        ];
    }

    public function search(Request $request) {
        $query = Product::query();
        if($cat = $request->input('cat')){
            $query->where('category', $cat);
        }

        $perPage = 15;
        $page = $request->input('page', 1);
        $total = $query->count();

        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

        return [
            'products' => $result,
            'totalProducts' => $total,
            'lastPage' => ceil($total / $perPage)
        ];
    }
    
    public function getElementById($id) {
        $result = Product::where('_id', $id)->get();
        return [
            'product' => $result
        ];
    }

    public function searchv2(Request $request) {
        $query = Product::query();

        if($cat = $request->input('cat')){
            $categories = explode(':' ,$request->get('cat'));
            $query->whereIn('category', $categories);
        }

        $perPage = 15;
        $page = $request->input('page', 1);
        $total = $query->count();

        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

        return [
            'products' => $result,
            'totalProducts' => $total,
            'lastPage' => ceil($total / $perPage)
        ];
    }

    public function addNewProduct(Request $request) {
        $product = Product::where('name', $request['name'])->first();

        if($product) {
            $response['status'] = 0;
            $response['message'] = 'Product with the same name already exists';
            $response['code'] = 409;
        } else {
            $product = Product::create([
                'name' => $request->name,
                'category' => $request->category,
                'picture' => $request->picture,
                'price' => $request->price,
                'quantity' => $request->quantity
            ]);

            $response['status'] = 1;
            $response['message'] = 'Product added successfully';
            $response['code'] = 200;
        }

        return response()->json($response);
    }

    function deleteProduct(Request $request) {
        $data = Product::where('_id', $request->get('_id'))->first();
        if($data) {
            $data->delete();

            $response['status'] = 1;
            $response['message'] = 'Product deleted successfully';
            $response['code'] = 200;
    
            return response()->json($response);
        }
        else {
            $response['status'] = 0;
            $response['message'] = "Product didn't delete successfully";
            $response['code'] = 409;
    
            return response()->json($response);
        }
    }

    public function updateProduct(Request $request) {
        $result = Product::where('_id', $request->get('_id'))->first();

        $result->name = $request->get('name');
        $result->price = $request->get('price');
        $result->quantity = $request->get('quantity');
        $result->picture = $request->get('picture');
        $result->category = $request->get('category');

        $result->update();

        if($result) {
            $response['status'] = 1;
            $response['message'] = 'Product updated successfully';
            $response['code'] = 200;

            return response()->json($response);
        }
        else {
            $response['status'] = 0;
            $response['message'] = "Product didn't update successfully";
            $response['code'] = 409;
    
            return response()->json($response);
        }
    }
}
