<?php

 
    function clearSession(){
        
        if (Request()->session()->has('success')) {
            Request()->session()->forget('success');
            return true;
        }
        return 'false';
    }
    
    function company($id)
    {
        return \App\Company::where('user_id' , $id)->first();
        //return $this->belongsTo(Company::class);
    }

    function day($key){
        $days_arr = ['Sat'=>'السبت' , 'Sun'=>'الأحد' , 'Mon'=>'الإثنين' ,'Tue'=>'الثلاثاء' , 'Wed'=>'الأربعاء' , 'Thu'=>'الخميس' , 'Fri'=>'الجمعة'] ;
         return $days_arr[$key];
    }
    
    function dayEn($key){
        $days_arr = ['Sat'=>'saturday' , 'Sun'=>'sunday' , 'Mon'=>'monday' ,'Tue'=>'tuesday' , 'Wed'=>'wednesday' , 'Thu'=>'thursday' , 'Fri'=>'friday'] ;
         return $days_arr[$key];
    }

    function user($id){
        return App\User::find($id);
    }

    function type($id){
        return App\Category::find($id);
    }

    function countInvited($user_id){
        //$net = 0 ;
        $invitations =  App\UserInvitation::where('invited_by',$user_id)->count();

        $last_discount = App\UserDiscount::where('user_id',$user_id)->orderBy('id','desc')->first();
        
        $last_invitations = App\UserDiscount::where('user_id',$user_id)->where('is_reset',1)->sum('registered_users_no');
        
        $net = $invitations - $last_invitations ;
        
        if($last_discount){
            if($last_discount->is_reset == 1):
                
                $invitation = App\UserInvitation::where('invited_by',$user_id)->where('created_at','>=',$last_discount->created_at)->count();

                $net = $invitation;
                //dd($net);
            else:
                $net = $invitations  - $last_invitations ;
            endif;
        }
        
        return $net ;
    }

    function countLastDiscounts($user_id){
        return App\UserDiscount::where('user_id',$user_id)->count();
    }

    function validateRules($errors, $rules) {

       $error_arr = [];

       foreach ($rules as $key => $value) {

           if( $errors->get($key) ) {

               array_push($error_arr, array($key => $errors->first($key)));
           }
       }

       return $error_arr;
    }

    function uploadImage($request, $name, $path = null, $width = null, $height = null)
    {
        if ($request->hasFile($name)):
            // Get File name from POST Form
            $image = $request->file($name);

            // Custom file name with adding Timestamp
            $filename = time() . '.' . str_random(20) . $image->getClientOriginalName();

            // Directory Path Save Images
            $path = public_path($path . $filename);

            // Upload images to Target folder By INTERVENTION/IMAGE
            $img = Image::make($image);

            // RESIZE IMAGE TO CREATE THUMBNAILS
            if (isset($width) || isset($height))
                $img->resize($width, $height, function ($ratio) {
                    $ratio->aspectRatio();
                });
            $img->save($path);

            // RETURN path to save in images tables DATABASE
            return $filename;
        endif;
    }

    function save64Img($base64_img, $path) {
        $image_data = base64_decode($base64_img);
        $source = imagecreatefromstring($image_data);
        $angle = 0;
        $rotate = imagerotate($source, $angle, 0); // if want to rotate the image
        $imageName = time() . str_random(20) . '.png';
        $path = $path . $imageName;
        $imageSave = imagejpeg($rotate, $path, 100);
        return $imageName;
    }


    function uploading($inputRequest, $folderNam, $resize = []) {

        $imageName = time().'.'.$inputRequest->getClientOriginalExtension();

        if(! empty($resize)) {

            foreach($resize as $dimensions) {

                $destinationPath = public_path( $folderNam . '_' . $dimensions);

                $img = Image::make($inputRequest->getRealPath());

                $dimension = explode('x', $dimensions);

                $img->resize($dimension[0], $dimension[1], function ($constraint) {
                    $constraint->aspectRatio();

                });

                //$img->insert('public/web/images/logo-sm.png', 'bottom-right');

                $img->save($destinationPath. DIRECTORY_SEPARATOR .$imageName);
            }
        }

        $destinationPath = public_path('/' . $folderNam);
        $inputRequest->move($destinationPath, $imageName);

        return $imageName ? $imageName : FALSE ;

    }
    
    function sendSingleNotification($title , $msg , $user_id ){

        $device = \App\Device::where('user_id',$user_id)->first();
        if($device):
            $token = $device->device;
        else:
            $token = '';
        endif;

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $notificationBuilder = new PayloadNotificationBuilder('طلتك');
        $notificationBuilder->setBody($msg)
            ->setSound('default');
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
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
            $notif = new Notification();
            $notif->msg = $msg;
            $notif->title = $title;
            $notif->image = '';
            $notif->to_user = $user_id;
            $notif->type = 'single';
            $notif->save();
            
            return true;
        }
        return false;
    }
    
    
    function filter_mobile_number($mob_num) {

        $first_3_val = substr($mob_num, 0, 3);
        $sixth_val = substr($mob_num, 0, 6);
        $first_val = substr($mob_num, 0, 1);
        $mob_number = 0;
        $val = 0;
        if ($sixth_val == "009665") {
            $val = NULL;
            $mob_number = substr($mob_num, 2, 12);
        } elseif ($first_3_val == "+96") {
            $val = "966";
            $mob_number = substr($mob_num, 4);
        } elseif ($first_3_val == "966") {
            $val = NULL;
            $mob_number = $mob_num;
        } elseif ($first_val == "5") {
            $val = "966";
            $mob_number = $mob_num;
        } elseif ($first_3_val == "009") {
            $val = "9";
            $mob_number = substr($mob_num, 4);
        } elseif ($first_val == "0") {
            $val = "966";
            $mob_number = substr($mob_num, 1, 9);
        } else {
            $val = "966";
            $mob_number = $mob_num;
        }
    
        $real_mob_number = $val . $mob_number;
        return $real_mob_number;
    }
    
    function sendActivationCode($message, $recepientNumber)
    {
            $getdata = http_build_query(
            $fields = array(
                // "Username" => "tallatk",
                // "Password" => "tallatk2018",
                "Username" => "s12-Alshqardy",
                "Password" => "Alshqardy@2018",
                "Message" => $message,
                "RecepientNumber" =>  $recepientNumber,
                "ReplacementList" => "",
                "SendDateTime" => "0",
                "EnableDR" => False,
                //"Tagname" => "tallatk",
                "Tagname" => "Alshqardy",
                "VariableList" => "0"
            ));

        $opts = array('http' =>
            array(
                'method' => 'GET',
                'header' => 'Content-type: application/x-www-form-urlencoded',

            )
        );

        $context = stream_context_create($opts);

        $results = file_get_contents('http://api.yamamah.com/SendSMSV2?' . $getdata, false, $context);
        
        return $results;
    }


?>