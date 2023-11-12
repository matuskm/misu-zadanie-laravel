<?php

namespace App\Services;

use App\Models\Eshop;
use App\Models\Product;
use App\Models\ProductPrice;

class ProductService
{
    private $price_change_percentage;

    public function __construct()
    {
        $this->price_change_percentage = (int) config('custom.price_change_percentage');
    }

    private function checkChangedPrice(float $db_price, float $feed_price, int $price_id)
    {
        try {

            //check price_id exists
            ProductPrice::findOrFail($price_id);

            $price_diff = $db_price - $feed_price;
            $percentage = intval( ($price_diff / $db_price) * 100 );
            $percentage_diff = ($percentage > 0) ? $percentage : 0;

            if ($percentage_diff >= $this->price_change_percentage) {

                ProductPrice::where('id', $price_id)->update([
                    'old_price'         => $db_price,
                    'new_price'         => $feed_price,
                    'percentage_diff'   => $percentage_diff,
                    'changed_price'     => true
                ]);

            } else {

                ProductPrice::where('id', $price_id)->update([
                    'old_price'         => $db_price,
                    'new_price'         => $feed_price,
                    'percentage_diff'   => $percentage_diff,
                    'changed_price'     => false
                ]);

            }

        } catch (\Exception $e) {

            abort( 400, $e->getMessage() );

        }
    }

    public function saveProductToDb(array $data)
    {
        $eshop_id = $data['eshop_id'];

        foreach ($data['items'] as $item) {

            $product = Product::with('price')
                ->where([
                    'ean'       => $item['ean'],
                    'eshop_id'  => $eshop_id
                ])
                ->first();

            if ( isset($product->id) ){

                Product::where('id', $product->id)
                    ->update([
                        'eshop_id'  => $eshop_id,
                        'name'      => $item['name'],
                        'ean'       => $item['ean'],
                ]);

                $this->checkChangedPrice( $product->price->new_price, $item['price'], $product->price->id );

            } else {

                $product_create = Product::create([
                    'eshop_id'  => $eshop_id,
                    'name'      => $item['name'],
                    'ean'       => $item['ean'],
                ]);

                $product_price = ProductPrice::create([
                    'product_id'        => $product_create->id,
                    'old_price'         => $item['price'],
                    'new_price'         => $item['price'],
                    'percentage_diff'   => 0,
                    'changed_price'     => false
                ]);

                Product::where( 'id', $product_create->id )->update([
                    'product_price_id' => $product_price->id
                ]);
            }

        }
    }
}
