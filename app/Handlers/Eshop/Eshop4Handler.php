<?php

namespace App\Handlers\Eshop;

use App\Interfaces\EshopHandlerInterface;
use App\Services\EshopService;

class Eshop4Handler implements EshopHandlerInterface
{
    private $eshopService;
    private $eshop;

    public function __construct(eshopService $eshopService)
    {
        $this->eshopService = $eshopService;

        /**
         * Variable parameters for current eshop. Please modify to your needs.
         */
        $this->eshop = [
            'name'  => 'Bezmena eshop',
            'url'   => 'https://bezmena-eshop.sk',
            'feed'  =>  public_path(). '/feeds/eshop_bezmena.xml'
        ];

    }

    public function getData(): Array
    {
        $eshop_feed = file_get_contents( $this->eshop['feed'] );

        if ( !file_exists( $this->eshop['feed'] ) ) {
            throw new \Exception( 'Súbor neexistuje: '. $this->eshop['feed'] );
        }

        $result_data = $this->parsheDataFromFeed( $eshop_feed );

        return array_merge(['items' => $result_data], $this->eshop);
    }

    public function parsheDataFromFeed( $eshop_feed ): Array
    {
        $data_feed = json_decode(
            json_encode(
                simplexml_load_string(
                    $eshop_feed
                )
            ), true);

        return $data_feed['product'];
    }

}
