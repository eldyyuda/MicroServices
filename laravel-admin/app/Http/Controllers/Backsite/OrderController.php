<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderItemResource;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::paginate(10);
        // $orderItems=OrderItem::all();
        // dd($order);

        return OrderResource::collection($order);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new OrderResource(Order::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function export()
    {
        $headers=[
            "Content-type"=>"text/csv",
            "Content-Disposition"=>"attachment;filename=orders.csv",
            "Pragma"=>"no-cache",
            "Cache-Control"=>"must-revalidate, post-check=0, pre-check=0",
            "Expires"=>"0"
        ];
        $callback=function(){
            $orders=Order::all();
            $file=fopen('php:output','w');

            fputcsv($file,['ID','Name','Email','Product Title','Price','Quantity']);

            foreach ($orders as $key => $order) {
                fputcsv($file,[$order->id,$order->name,$order->email,'','','']);
                foreach ($order->orderItems as $key => $orderItem) {
                    fputcsv($file,['','','',$orderItem->product_title,$orderItem->price,$orderItem->quantity]);
                }
            }
            fclose($file);
        };
        return \Response::stream($callback,200,$headers);
        
    }
}
