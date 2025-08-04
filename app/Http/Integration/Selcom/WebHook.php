<?php

namespace App\Http\Integration\Selcom;

use App\Http\Controllers\TraController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebHook{

    public function valuationPayment(Request $request)
    {

       
        $rq_data=$request->getContent();
        
        Log::info($request->getContent());
        $data= json_decode($rq_data,true);

        $order = DB::table('orders')->where('id',$data['order_id']);

        if($data['payment_status'] == 'COMPLETED'){

            //send receipt to TRA. 

            // get order 
            // fetch valuation id related to order
            // get tra details
            // generate and store link 
            
             $tra_qr_link=app(TraController::class)->processOfflineReceipt($data['phone'],$data['order_id']);

            //  return $tra_qr_link;
            //  update order 

            TraController::recordLog("Successful payment","success","Successful payment from thamani website via selcom",$data);
           
                $order->update([
                    'status' => 'completed',
                    'amount' => $data['amount'],
                    'callback' => $data,
                    'tra_qr_link' => $tra_qr_link,
                    'updated_at' => \Carbon\Carbon::now(),
                    ]);

            // create payment record
            if(!$order){
                return back()->with('msg','fail to update order');

            }

             DB::table('payments')
                ->insert([
                    'status' => $data['payment_status'],
                    'method' => $data['channel'],
                    'order_id' => $data['order_id'],
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon:: now(),

                ]);

            $valuation= $order->select('orders.valuation_id')->first();

        }else{
            
                $order->update([
                    'status' => 'canceled',
                    'callback' => $data,
                    'updated_at' => \Carbon\Carbon::now(),
                ]);

               Log::info("payment canceled",$data);     
        }
        

        
    }
}


?>