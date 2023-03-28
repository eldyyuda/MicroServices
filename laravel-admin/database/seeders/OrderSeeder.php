<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use App\Models\OrderItem;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Order::class,30)->create()->each(function(Order $order
        // ){
        //     factory(OrderItem::class,random_int(1,5))->create(
        //         [
        //             'order_id'=>$order->id,
        //         ]
        //         );
        // }); 
        Order::factory()
        ->count(30)
        ->create()
        ->each(
            function(Order $order){
                OrderItem::factory(random_int(1,5))
                ->create(
                    [
                        'order_id'=>$order->id
                    ]
                    );
            }
        );
    }
}
