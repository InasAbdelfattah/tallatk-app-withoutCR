<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Device;
use App\Notification;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use LaravelFCM\Message\Topics;


class NotificationController extends Controller {

    public function getIndex(){
        if (!Gate::allows('contact_manage')) {
            return abort(401);
        }
      
        // $data = Device::join('users','devices.user_id','users.id')->select('devices.*','users.id as user_id', 'users.name as username')->get();
        // return view('admin.notifs.all', compact('data'));
        
        $notifs = Notification::where('notif_type','control_panel')->orderBy('id','desc')->get();
        return view('admin.notifs.notifs', compact('notifs'));
    }
    
    public function show($id){
        if (!Gate::allows('content_manage')) {
            return abort(401);
        }
        $data = Notification::find($id);
        return view('admin.notifs.details',compact('data'));
    }
    
    public function delete(Request $request){
        if (!Gate::allows('content_manage')) {
            return abort(401);
        }

        $model = Notification::findOrFail($request->id);

        
        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'data' => $model->id
            ]);
        }
    }

    public function getNotif() {

        if (!Gate::allows('contact_manage')) {
            return abort(401);
        }

        $data = Device::join('users','devices.user_id','users.id')->select('devices.*','users.id as user_id', 'users.name as username')->get();

        $users = Device::all();

        return view('admin.notifs.index', compact('data' , 'users'));
    }

    public function send(Request $request) {

        if (!Gate::allows('contact_manage')) {
            return abort(401);
        }
        
        $rules = [
            'msg' => 'required',
            'device_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->route('new-notif')->withErrors($validator)->withInput();
        }

        if($request->device_id == 'single'){
            //case:push notif to one device
            $token = $request->device_id;
            $type = 'single';

        }elseif($request->device_id == 'providers'){
            
            $notificationBuilder = new PayloadNotificationBuilder('طلتك');
            $notificationBuilder->setBody($request->msg)
            				    ->setSound('default');
            $notificationBuilder->setClickAction("FCM_PLUGIN_ACTIVITY");
            
            $notification = $notificationBuilder->build();
            
            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData([
            	'message' => $request->msg ,
            	'title'=>'اشعار من لوحة التحكم',
            	'type' => 'control_panel'
            ]);
            
            $data = $dataBuilder->build();
            
            $topic = new Topics();
            $topic->topic('provider')->andTopic(function($condition) {
            
            	$condition->topic('provider')->orTopic('provider');
            
            });

            $topicResponse = FCM::sendToTopic($topic, null, $notification, $data);
            
            $topicResponse->isSuccess();
            $topicResponse->shouldRetry();
            $topicResponse->error();
            
            //case:you push notif to providers
            $users = User::where('is_provider',1)->pluck('id')->toArray();
            $token = [];
            if(count($users) > 0){
                $token = Device::whereIn('user_id',$users)->pluck('device')->toArray();
            }
            if(count($token) == 0){
                $token = '';
            }
            $type = 'providers';
        }elseif($request->device_id == 'users'){
            
            $notificationBuilder = new PayloadNotificationBuilder('طلتك');
            $notificationBuilder->setBody($request->msg)
            				    ->setSound('default');
            $notificationBuilder->setClickAction("FCM_PLUGIN_ACTIVITY");
            
            $notification = $notificationBuilder->build();
            
            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData([
            	'message' => $request->msg ,
            	'title'=>'اشعار من  ادارة التطبيق',
            	'type' => 'control_panel'
            ]);
            
            $data = $dataBuilder->build();
            
            $topic = new Topics();
            $topic->topic('user')->andTopic(function($condition) {
            
            	$condition->topic('user')->orTopic('user');
            
            });

            $topicResponse = FCM::sendToTopic($topic, null, $notification, $data);
            
            $topicResponse->isSuccess();
            $topicResponse->shouldRetry();
            $topicResponse->error();
            
            //case:you push notif to providers
            $users = User::where('is_provider',0)->pluck('id')->toArray();
            $token = [];
            if(count($users) > 0){
                $token = Device::whereIn('user_id',$users)->pluck('device')->toArray();
            }
            if(count($token) == 0){
                $token = '';
            }
            $type = 'users';
        }else{
            
            $notificationBuilder = new PayloadNotificationBuilder('طلتك');
            $notificationBuilder->setBody($request->msg)
            				    ->setSound('default');
            $notificationBuilder->setClickAction("FCM_PLUGIN_ACTIVITY");
            
            $notification = $notificationBuilder->build();
            
            $topic = new Topics();
            $topic->topic('general')->andTopic(function($condition) {
            
            	$condition->topic('general')->orTopic('general');
            
            });

            $topicResponse = FCM::sendToTopic($topic, null, $notification, null);
            
            $topicResponse->isSuccess();
            $topicResponse->shouldRetry();
            $topicResponse->error();
            
            //case:you push notif to all user
            $token = Device::where('device','!=','')->pluck('device')->toArray();
            if(count($token) == 0){
                $token = '';
            }
            $type = 'all';
            //dd($token);
        }
        
    
        if($token != ''){


            $notif = new Notification();
            $notif->msg = $request->msg;
            $notif->title = $request->title;
            $notif->image = '';
            $tokens = [];
            if($type == 'all'){
                foreach($token as $user_token){
                    $user_id = Device::where('device',$user_token)->first();
                    if($user_id){
                        $user = User::find($user_id->user_id);
                        if($user){
                            array_push($tokens,$user->id);
                        }  
                    }
                }
                $notif->to_user = json_encode($tokens);
            }elseif($type == 'providers'){
                
                
                //dd($token);
                foreach($token as $user_token){
                    $user_id = Device::where('device',$user_token)->first();
                    if($user_id){
                        $user = User::find($user_id->user_id);
                        if($user){
                            array_push($tokens,$user->id);
                        }
                    }
                }
                $notif->to_user = json_encode($tokens);
            }elseif($type == 'users'){
                foreach($token as $user_token){
                    $user_id = Device::where('device',$user_token)->first();
                    if($user_id){
                        $user = User::find($user_id->user_id);
                        if($user){
                            array_push($tokens,$user->id);
                        }
                    }
                }
                $notif->to_user = json_encode($tokens);
            }else{
                dd($type);
//                //$user = User::where('device_id',$token)->first();
                $user_id = Device::where('device',$request->device_id)->first();
                $notif->to_user = $user_id->user_id;
            }
            $notif->type = $type;
            $notif->notif_type = 'control_panel';
            $notif->save();
            return redirect()->route('notifs')->with('success', 'تم الارسال بنجاح');
        }else{
            return redirect()->route('new-notif')->with('fail', 'لم يتم الارسال');
        }
    }

}