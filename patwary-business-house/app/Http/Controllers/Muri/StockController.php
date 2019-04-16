<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Stock;

class StockController extends HomeController {

    public function index() {
        //check_user_access('supplier');
        $dataset = Product::all();
        $category = new Category();
        $product = new Product();
        $stock = new Stock();
        return view('Admin.stocks.index', compact('dataset','category', 'product', 'stock'));
    }

    // Ajax Functions
    public function search(Request $r) {
        $item_count = $r->input('item_count');
        $category = $r->category;
        $product = $r->product;
        $search = $r->input('search');
        $query = Product::query();
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
        $query->orderBy('category_id', 'DESC');
        $query->limit($item_count);
        $dataset = $query->get();
        $category = new Category();
        $product = new Product();
        $stock = new Stock();
        return view('Admin.stocks._list', compact('dataset','category','product','stock'));
    }

}
