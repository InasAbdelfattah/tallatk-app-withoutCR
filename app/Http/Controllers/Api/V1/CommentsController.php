<?php

namespace App\Http\Controllers\Api\V1;

use App\Comment;
use App\Company;
use App\Events\NotifyAdminJoinApp;
use App\Events\NotifyUsers;
use App\Notifications\CommentsNotification;
use App\User;
use App\Abuse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;


use App\Notification;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class CommentsController extends Controller
{
    public $public_path_user;
    
    public function __construct()
    {
        $this->public_path_user = 'files/users/';
        app()->setlocale(request('lang'));
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Comment Create New Comment.
     */
    public function saveComment(Request $request)
    {
        if($request->lang):
        \App::setLocale($request->lang);
        endif;

        $rules = [
            'centerId' => 'integer|required',
            'comment' => 'required|string|min:2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }

        $company = Company::whereId($request->centerId)->first();

        $user = User::byToken($request->api_token);
        //$user = Auth::user();
        if ($request->comment) {
            $comment = new Comment;
            $comment->comment = $request->comment;
            if ($request->parent_id)
                $comment->parent_id = $request->parent_id;
            else
                $comment->parent_id = 0;

            $comment->user_id = $user->id;

            if ($company->comments()->save($comment)) {

//                $message = "لديك تعليق جديد على المنشأة $company->name";
//                event(new NotifyUsers($user, $company, $message, 0));
                $query = Comment::with('user')
                    ->where('id', $comment->id)->first();

                $query->user->photo = $query->user->image ? request()->root() . '/' . $this->public_path_user . $query->user->image : null;

                // if(app()->getlocale() == 'ar'):
                //     $msg = 'نص التعليق هو :'.$request->comment;
                // else:
                //     $msg = 'the comment is :'.$request->comment;
                // endif;
                
                // if(app()->getlocale() == 'ar'):
                //     $title = 'تم اضافة تعليق من '.$user->name;
                // else:
                //     $title = 'new Comment from'.$user->name;
                // endif;
                
                $title = $user->name;
                $msg = $request->comment;
            
                $this->sendSingleNotification($title , $msg , $company->user_id ,'comment' , $company->id);    

                return response()->json([
                    'status' => true,
                    'data' => $query
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }


//    private function getUsersAreFavoriteCompany($id, $userId)
////    {
////
//        // get company
//        $company = Company::whereId($id)->first();
//        $userFavorites = $company->favorites->filter(function ($q) use ($userId) {
//            return $q->id != $userId;
//        })->values();
//
//        return $userFavorites;
//    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Update comment.
     */

    public function updateComment(Request $request)
    {
        if($request->lang):
            \App::setLocale($request->lang);
        endif;

        $rules = [
            'commentId' => 'integer|required',
            'comment' => 'required|string|min:2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }


        $comment = Comment::whereId($request->commentId)->first();

        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'commentnotfound',
                'data' => []
            ]);
        }


        if ($comment->user && $comment->user->api_token == $request->api_token) {
            if ($request->comment) {
                $comment->comment = $request->comment;
                if ($comment->save()) {
                    
                    $query = Comment::with('user')
                    ->where('id', $comment->id)->first();

                    $query->user->photo = $query->user->image ? request()->root() . '/' . $this->public_path_user . $query->user->image : null;
                
                    return response()->json([
                        'status' => true,
                        'message' => 'commentupdated',
                        'data' => $query
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'commentnotupdated',
                        'data' => []
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => false,
                'message' => 'commentnotupdated',
                'data' => []
            ]);
        }

    }


    public function commentList(Request $request)
    {
        $rules = [
            'centerId' => 'integer|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }
        /**
         * Set Default Value For Skip Count To Avoid Error In Service.
         * @ Default Value 15...
         */
        if (isset($request->pageSize)):
            $pageSize = $request->pageSize;
        else:
            $pageSize = 5;
        endif;
        /**
         * SkipCount is Number will Skip From Array
         */
        $skipCount = $request->get('skipCount',0);
        $itemId = $request->itemId;

        $currentPage = $request->get('page', 1); // Default to 1

        $query = Comment::where('commentable_id', $request->centerId)->where('is_suspend',0)
            ->orderBy('created_at', 'desc')
            ->select();
        
        

        /**
         * @ If item Id Exists skipping by it.
         */
        if ($itemId) {
            $query->where('id', '<=', $itemId);
        }

        if (isset($request->filterby) && $request->filterby == 'date') {
            $query->orderBy('created_at', 'desc');
        }
        /**
         * @@ Skip Result Based on SkipCount Number And Pagesize.
         */
        $query->skip($skipCount);
        $query->take($pageSize);

        /**
         * @ Get All Data Array
         */

        $comments = $query->get();
        
        $comments->map(function ($q) {
            $q->user->photo = $q->user->image ? request()->root() . '/' . $this->public_path_user . $q->user->image : null;
        });

        /**
         * Return Data Array
         */

        return response()->json([
            'status' => true,
            'data' => $comments
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Comment Delete.
     */
    public function deleteComment(Request $request)
    {
        $rules = [
            'commentId' => 'integer|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }

        $comment = Comment::whereId($request->commentId)->first();
        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'commentnotfound',
                'data' => []
            ]);
        }

        if ($comment->user && $comment->user->api_token == $request->api_token) {

            if ($comment->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'commentdeleted',
                    'data' => []
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'commentnotdeleted',
                    'data' => []
                ]);
            }
        }
    }

    public function abuseComment(Request $request){
        // `user_id`, `company_id`, `abuseable_id`, `text`, `text`, `is_adopt`,
        
        $company = Company::find($request->center_id);
        if(!$company){
            return response()->json([
                'status' => false,
                'message' => 'companyNotFound',
                'data' => []
            ]);
        }
        
        // if($company->user_id  != $request->user_id){
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'unavailableToAbuseComment',
        //         'data' => []
        //     ]);
        // }
        $newModel = new Abuse();
        $newModel->user_id = $request->user_id ;
        $newModel->company_id = $request->center_id ;
        $newModel->abuseable_id = $request->comment_id ;
        $newModel->abuseable_type = 'App\Comment' ;
        $newModel->text = $request->text ? $request->text : '' ;
        $newModel->is_adopt = 0 ;
        $newModel->save();
        
        return response()->json([
            'status' => true,
            'message' => 'commentabused',
            'data' => []
        ]);
    }
    
    
    
    private function sendSingleNotification($title , $msg , $user_id ,$notif_type , $target_id){

        //$device = \App\Device::where('user_id',$user_id)->orderBy('id','Desc')->first();
        $device = \App\Device::where('user_id',$user_id)->pluck('device')->toArray();
        if($device):
            $token = $device;
            
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
        $dataBuilder->addData(['message' => $msg , 'title'=>$title ,'type' =>$notif_type , 'centerId' =>$target_id]);
        
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        $notif = new Notification();
        $notif->msg = $msg;
        $notif->title = $title;
        $notif->image = '';
        $notif->to_user = $user_id;
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
            
            return true;
        }
        
        return false;
    }
    
    
   

}
