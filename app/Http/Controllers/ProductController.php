<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProducts() {
        return Product::all();
    }

    public function search(Request $request){
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
}
