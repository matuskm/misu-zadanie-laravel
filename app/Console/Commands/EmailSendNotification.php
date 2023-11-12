<?php

namespace App\Console\Commands;

use App\Mail\Notification;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailSendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email about the lowest price.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('The command "email:send-notification" has been launched.');

        $lowest_price = ProductPrice::with('product.eshop')->lowestPriceChanged()->first();

        if ( isset($lowest_price) ){

            Mail::to( config('custom.notification_email') )->send( new Notification( $lowest_price->toArray() ) );

            ProductPrice::query()->update([
                'changed_price' => false
            ]);

            Log::info('Send to: '. config('custom.notification_email'));
        }

        Log::info('The command "email:send-notification" has been successfully completed.');

        return 0;
    }
}
