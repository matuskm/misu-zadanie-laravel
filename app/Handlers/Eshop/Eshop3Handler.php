<?php

namespace App\Handlers\Eshop;

use App\Interfaces\EshopHandlerInterface;

class Eshop3Handler implements EshopHandlerInterface
{
    private $eshop;

    public function __construct()
    {       
        /**
         * Variable parameters for current eshop. Please modify to your needs.
         */
        $this->eshop = [
            'name'  => 'NoName eshop',
            'url'   => 'https://noname-eshop.sk',
            'feed'  =>  public_path(). '/feeds/eshop_noname.json'
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
        $data_feed = json_decode( $eshop_feed, true );

        return $data_feed['products'];
    }

}
