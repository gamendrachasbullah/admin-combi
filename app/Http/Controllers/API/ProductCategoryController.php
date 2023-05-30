<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('$name');
        $show_product = $request->input('show_product');

        if ($id)
        {
            $product = ProductCategory::with(['category','galleries'])->find($id);

            if ($product){
                return ResponseFormatter::success(
                    $product,
                    'Data kategori berhasil diambil'
                );
            }
            else {
                return ResponseFormatter::error(
                    null,
                    'Data kategori tidak ada',
                    404
                );
            }
        }

        $category = ProductCategory::query();

        if ($name){
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product){
            $category-> with('products');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data kategori berhasil diambil'
        );

    }
}
