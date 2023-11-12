<?php

namespace App\Interfaces;

interface EshopHandlerInterface
{
    public function getData(): Array;
    public function parsheDataFromFeed( $eshop_feed );
}
