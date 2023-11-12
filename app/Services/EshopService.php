<?php
namespace App\Services;

use App\Models\Eshop;

class EshopService
{
    protected $handlers;
    protected $productService;

    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
        $this->productService = new ProductService;
    }

    /**
     * Get data eshop
     */
    public function getDataFromAllEshops(): Array
    {
        $data_eshop = [];
        $eshops_class = [];
        $eshops = [];

        foreach ($this->handlers as $handler) {
            $handlerInstance = app($handler);
            $data_eshop[] = $handlerInstance->getData();
            $eshops_class[] = get_class($handlerInstance);
        }

        foreach ($data_eshop as $data) {
            $eshops[] = $data['name'];
            $this->parsheData( $data['items'], $data );
        }

        return [
            'data'          => $data_eshop,
            'eshops_class'  => $eshops_class,
            'eshops'        => $eshops
        ];
    }

    /**
     * Save data eshop to database
     * @return int ID
     */
    private function saveEshopDataToDb(array $eshop_data): Int
    {
        $eshop = Eshop::firstOrCreate(
            [
                'name'  => $eshop_data['eshop_name'],
                'url'   => $eshop_data['eshop_url']
            ],
            [
                'name'      => $eshop_data['eshop_name'],
                'url'       => $eshop_data['eshop_url'],
                'feed_url'  => $eshop_data['feed_url'],
            ]
        );

        return $eshop->id;
    }

    /**
     * Parse data from feed to array
     */
    private function parsheData($products, $eshop)
    {
        $eshop_data = [
            'eshop_name'    => $eshop['name'],
            'eshop_url'     => $eshop['url'],
            'feed_url'      => $eshop['feed'],
            'items'         => []
        ];

        foreach ($products as $product) {
            $eshop_data['items'][] = [
                'name'              => $product['name'],
                'description'       => $product['description'],
                'price'             => $product['price'],
                'ean'               => $product['ean'],
            ];
        }

        $new_eshop_id = $this->saveEshopDataToDb($eshop_data);
        $new_data = array_merge(['eshop_id' => $new_eshop_id], $eshop_data);

        $products = $this->productService->saveProductToDb( $new_data );

        return $eshop_data;
    }
}
