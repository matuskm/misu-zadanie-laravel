<?php

namespace App\Http\Controllers;

use App\Models\ProductPrice;

class HomeController extends Controller
{

    public function index()
    {
        $data = ProductPrice::with('product.eshop')->paginate(10);
        $lowest_price = ProductPrice::with('product.eshop')->lowestPrice()->first();


        if ( !isset($data) || !isset($lowest_price) ) {
            abort(404);
        }

        return view('main', [
            'data'          => $data,
            'lowest_price'  => $lowest_price
        ]);
    }
}
