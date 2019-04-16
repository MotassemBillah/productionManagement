<?php

namespace App\Http\Controllers\Flour;

use App\Http\Controllers\HomeController;

use Illuminate\Http\Request;
use App\Models\Inv\Category;
use App\Models\Inv\Product;
use App\Models\Flour\Stock;

class StockController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $dataset = Product::where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $categories = Category::where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $products = Product::where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $stock = new Stock();
        return view('flour.stocks.index', compact('dataset','categories', 'products', 'stock'));
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = Product::query();
        $query->where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', FLOURMILL]]);
        if (!empty($category)) {
            $query->where('category_id', '=', $category);
        }
        if (!empty($product)) {
            $query->where('id', '=', $product);
        }
        if (!empty($search)) {
            $productarr = [];
            $products = Product::where('name', 'like', '%' . $search . '%')->get();
            foreach ($products as $pro) {
                $productarr[] = $pro->id;
            }
            $query->whereIn('id', $productarr);
        }
        $query->limit($item_count);
        $dataset = $query->get();
        $categories = Category::where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $products = Product::where([['type', 'Raw'], ['is_deleted', 0], ['business_type_id', FLOURMILL]])->get();
        $stock = new Stock();
        return view('flour.stocks._list', compact('dataset','categories','products','stock'));
    }

}
