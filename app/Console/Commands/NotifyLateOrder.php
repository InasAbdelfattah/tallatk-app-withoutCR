<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use Order ;
use Setting ;

use App\Notification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

use Carbon\Carbon;

class NotifyLateOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NotifyLateOrder:NotifyOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify user for late order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //DB::table('orders')->delete(225);
        // DB::table('orders')
        //     ->where('id', 222)
        //     ->update(['status' => 7]);


     //   \Log::info("Date:". date('Y-m-d'));
        
        
        $totalOrders = DB::table('orders')->where('status', 0)->get();
        
        
        $time = DB::table('settings')->where('key', 'waiting_time')->first();
        if($time):
            $waiting_time = $time->body;
        else:
            $waiting_time = 0;
        endif;
        //$totalOrders = Order::where('status', 0)->orderBy('id','desc')->get();
        
        //$waiting_time = (int)Setting::getBody('waiting_time');
        
        $totalOrders->map(function ($q) use ($waiting_time) {
            
            $now = date("Y-m-d H:i:s");
            $end2 =  date("Y-m-d H:i:s", strtotime($q->created_at . '+'.$waiting_time.' minutes'));
            $q->diff = strtotime($end2) - strtotime($now);
            
            if($q->status == 0 && $q->diff <= 0){
                // $order = Order::find($q->id);
                // $order->status = 4; 
                // $order->save();
                
                DB::table('orders')->where('id', $q->id)->update(['status' => 4]);
                $order = DB::table('orders')->where('id', $q->id)->first();
                $title = '';
                $message = 'لقد انتهى الوقت المحدد للرد من مزود الخدمة على الطلب '.$q->id .'يمكنك الشكوى الان' ;
                
                
                
                $this->sendSingleNotification($title , $message , $order->user_id ,'late_order' ,$order->id);
            }
         });
    }
    
     private function sendSingleNotification($title , $msg , $user_id ,$notif_type , $target){

        $device =  DB::table('devices')->where('user_id',$user_id)->orderBy('id','Desc')->first();
        
        //$device = \App\Device::where('user_id',$user_id)->pluck('device')->toArray();
        
        if($device):
            $token = $device->device;
        else:
            $token = '';
        endif;

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($msg)
            ->setSound('default');
        $notificationBuilder->setClickAction("FCM_PLUGIN_ACTIVITY");
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['message' => $msg , 'title'=>$title ,'type' =>$notif_type]);
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        $notif = new \App\Notification();
        $notif->msg = $msg;
        $notif->title = $title;
        $notif->image = '';
        $notif->to_user = $user_id;
        $notif->target_id = $target;
        $notif->type = 'single';
        $notif->notif_type = $notif_type;
        $notif->save();
        
        if($token != ''){
            $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
            $downstreamResponse->numberSuccess();
            $downstreamResponse->numberFailure();
            $downstreamResponse->numberModification();
            //return Array - you must remove all this tokens in your database
            $downstreamResponse->tokensToDelete();
            //return Array (key : oldToken, value : new token - you must change the token in your database )
            $downstreamResponse->tokensToModify();
            //return Array - you should try to resend the message to the tokens in the array
            $downstreamResponse->tokensToRetry();
            // return Array (key:token, value:errror) - in production you should remove from your database the tokens
            
            return $token;
        }
        
        return false;
    }

}