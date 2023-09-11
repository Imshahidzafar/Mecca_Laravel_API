<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\{Book,Author,Category,Bookmark,BookView};

class ApiController extends Controller{
  /* SEND NOTIFICATIONS */
  public function send_notification($data){
    DB::table('notifications')->insert($data);
  }
  /* SEND NOTIFICATIONS */

  /* DECODE IMAGE */
  public function decode_image($img , $path_url, $prefix, $random, $postfix){                                   
    $data = base64_decode($img);
    $file_name = $prefix.$random.$postfix.'.jpeg';
    $file = $path_url.$file_name;
    $success = file_put_contents($file, $data);
    return $file_name; 
  }
  /* DECODE IMAGE */

  /* CACLULATE DISTANCE */
  public function calculate_distance($lon1 , $lat1, $lon2 , $lat2, $unit = 'M'){
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else if ($unit == "M") {
      return $miles;
    } else {
      return '1.2 Miles'; 
    }
  }
  /* CACLULATE DISTANCE */

  /* USERS CUSTOMERS DETAILS */
  public function users_customers_profile(Request $req){
    if (isset($req->users_customers_id)) {
      $user = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->first();
      if ($user) {
        $userDetail=DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->first();
        if (isset($userDetail) && $userDetail != null) {
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $userDetail;
        } else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "User do not exist.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Email does not exits.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
  }
  /* USERS CUSTOMERS DETAILS */

  /* LOGIN USERS CUSTOMERS */
  public function users_customers_login(Request $req){
    if (isset($req->email) && isset($req->password)) {
      $email = DB::table('users_customers')->where('email', $req->email)->first();
      if ($email) {
        $data=DB::table('users_customers')->where('email', $req->email)->first();
        $password=$data->password;
        $id = $data->users_customers_id;
        if (md5($req->password) == $password) {
          if($data->status == 'Active'){
            if($req->one_signal_id){
              $update=DB::table('users_customers')->where('email', $req->email)->update(['one_signal_id'=>$req->one_signal_id]);
            }

            $userDetail=DB::table('users_customers')->where('users_customers_id', $id)->first();
            if (isset($userDetail) && $userDetail != null) {
              $response["code"] = 200;
              $response["status"] = "success";
              $response["data"] = $userDetail;
            } else{
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = "User do not exist.";
            }
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Your account is in ".$data->status." status. Please contact admin.";
          }
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Password do not match.";
        }
      }else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Email does not exits.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
  }
  /* LOGIN USERS CUSTOMERS */

  /* SIGNUP USERS CUSTOMERS */
  public function users_customers_signup(Request $req){
    if (isset($req->first_name) && isset($req->last_name) && isset($req->email) && isset($req->password)) {
      $email = DB::table('users_customers')->where('email', $req->email)->first();

      if(!$email) {
        if(isset($req->one_signal_id)){
        	$saveData['one_signal_id']        = $req->one_signal_id;
        }

        $saveData['first_name']            = $req->first_name;
        $saveData['last_name']            = $req->last_name;
        $saveData['email']                = $req->email;
        $saveData['password']             = md5($req->password);
        $saveData['notifications']        = 'Yes';

        if(isset($req->profile_pic)){
          $profile_pic = $req->profile_pic;
          $prefix = time();
          $img_name = $prefix . '.jpeg';
          $image_path = public_path('uploads/users_customers/') . $img_name;

          file_put_contents($image_path, base64_decode($profile_pic));
          $saveData['profile_pic'] = 'uploads/users_customers/'. $img_name;
        }

        if(isset($req->account_type)){
	        $saveData['account_type']     = $req->account_type;
	      }

        $saveData['social_acc_type']      = 'None';
        $saveData['google_access_token']  = '';

        $saveData['verified_badge']       = 'No';
        $saveData['date_expiry']       	  = $req->date_expiry;
        $saveData['date_added']           = date('Y-m-d H:i:s');

        $users_customers_id   = DB::table('users_customers')->insertGetId($saveData);
        $users_customers      = DB::table('users_customers')->where('users_customers_id', $users_customers_id)->first();

        $response["code"]     = 200;   
        $response["status"]   = "success";
        $response["data"]     = $users_customers;
      } else {
        $response["code"]     = 401;
        $response["status"]   = "error";
        $response["message"]  = "Email already exists.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }
    
    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /* SIGNUP USERS CUSTOMERS */

  /* UPDATE PROFILE */
  public function update_profile(Request $req){
    if(isset($req->users_customers_id) && isset($req->first_name) && isset($req->last_name) && isset($req->phone) && isset($req->notifications)) {
      $updateData['users_customers_id'] = $req->users_customers_id;
      $saveData['users_customers_type']           = $req->users_customers_type;

      if($req->users_customers_type == 'Company'){
        $saveData['company_name']           = $req->company_name;
      }

      $updateData['first_name']         = $req->first_name;
      $updateData['last_name']         = $req->last_name;
      $updateData['phone']              = $req->phone;
      $updateData['notifications']      = $req->notifications;

      if(isset($req->profile_pic)){
        $profile_pic = $req->profile_pic;
        $prefix = time();
        $img_name = $prefix . '.jpeg';
        $image_path = public_path('uploads/users_customers/') . $img_name;

        file_put_contents($image_path, base64_decode($profile_pic));
        $updateData['profile_pic'] = 'uploads/users_customers/'. $img_name;
      }

      if(isset($req->proof_document)){
        $proof_document = $req->proof_document;
        $prefix = time();
        $img_name = $prefix . '.jpeg';
        $image_path = public_path('uploads/users_documents/') . $img_name;

        file_put_contents($image_path, base64_decode($proof_document));
        $updateData['proof_document'] = 'uploads/users_documents/'. $img_name;
      }

      if(isset($req->valid_document)){
        $valid_document = $req->valid_document;
        $prefix = time();
        $img_name = $prefix . '.jpeg';
        $image_path = public_path('uploads/users_documents/') . $img_name;

        file_put_contents($image_path, base64_decode($valid_document));
        $updateData['valid_document'] = 'uploads/users_documents/'. $img_name;
      }

      DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->update($updateData);
      $updatedData = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->get();
 
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $updatedData;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* UPDATE PROFILE */

  /* FORGETPASSWORD API */
  public function forgot_password(Request $req){
    if (isset($req)) {
      $email=DB::table('users_customers')->where('email', $req->email)->get()->count();
      if ($email>0) {
        $data = DB::table('users_customers')->where('email', $req->email)->first();
        $id = $data->users_customers_id;
        $onlyEmail = $req->email;
        $otp = rand(1000,9999);
        $details = [
            "title"=>"Email Verification Code",
            "data"=>$data,
            "body"=> $otp
        ];
        $otpSended= Mail::to($onlyEmail)->send(new SendMail($details));
        $otpData=array(
         'verify_code'=>$otp
        );
        $UserotpUpdate=DB::table('users_customers')->where('users_customers_id', $id)->update($otpData);

        $details = array('otp' => $otp, 'message' => 'OTP sent in the email.');
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $details;
      }else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Email does not exists.";
      }
    }else{
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "Please enter email address.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* FORGETPASSWORD API */

  /* MODIFY PASSWORD */
  public function modify_password(Request $req){
    if (isset($req->email) && isset($req->otp) && isset($req->password) && isset($req->confirm_password)) {
      $forgetOtp = DB::table('users_customers')->select('verify_code')->where('email', $req->email)->get();
      $otpforgetdb = $forgetOtp[0]->verify_code;
      if ($otpforgetdb == $req->otp) {
        if ($req->confirm_password == $req->password) {
          $otpData=array(
           'verify_code'=>'',
           'password' => md5($req->password)
          );
          
          $UserotpUpdate =DB::table('users_customers')->where('email', $req->email)->update($otpData);
          $users_customers = DB::table('users_customers')->where('email', $req->email)->get();
          
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $users_customers;
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Password and confirm password do not match.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Otp do not match.";
      }
    }else{
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /* MODIFY PASSWORD */

  /* CHANGE PASSWORD */
  public function change_password(Request $req){
    if (isset($req->email) && isset($req->old_password) && isset($req->password) && isset($req->confirm_password)) {
      $old_password = DB::table('users_customers')->select('password')->where('email', $req->email)->first();
      $old_passwordDB = $old_password->password;
      if ($old_passwordDB == md5($req->old_password)) {
        if ($req->confirm_password == $req->password) {
          $otpData=array('password' => md5($req->password));          
          $UserotpUpdate =DB::table('users_customers')->where('email', $req->email)->update($otpData);
          $users_customers = DB::table('users_customers')->where('email', $req->email)->first();
          
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $users_customers;
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Password and confirm password do not match.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Old password is not correct.";
      }
    }else{
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /* CHANGE PASSWORD */

  /* DELETE ACCOUNT API */
  public function delete_account(Request $req){
    if (isset($req->user_email) && isset($req->delete_reason) && isset($req->comments)) {
      $users_customers = DB::table('users_customers')->where('email', $req->user_email)->get()->count();
      if ($users_customers>0) {
        $users_customers_delete = DB::table('users_customers_delete')->where('email', $req->user_email)->get()->count();
        if ($users_customers_delete == 0) { 
          $data = array(
            'email'=>$req->user_email,
            'delete_reason'=> $req->delete_reason,
            'comments'=> $req->comments,
            'date_added'=>date('Y-m-d H:i:s'),
            'status'=>'Pending'
          );
          $users_customers_id   = DB::table('users_customers_delete')->insertGetId($data);

          $response["code"] = 200;
          $response["status"] = "success";
          $response["message"] = "Delete account request recieved successfully.";
        }else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Delete account request already sent. Please wait out team will get back to you in 24 hours.";
        }
      }else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Email does not exists.";
      }
    }else{
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* DELETE ACCOUNT API */

  /* GET SYSTEM SETTINGS */
  public function system_settings(){
    $fetch_data   =  DB::table('system_settings')->get();
    
    if (!empty($fetch_data)) {
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $fetch_data;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "no data found.";
    }
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* GET SYSTEM SETTINGS */

  /* MESSAGES PERMISSION */
  public function messages_permission(Request $req){
    if(isset($req->users_customers_id) && isset($req->messages)) {
      $updateData['messages']      = $req->messages;

      DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->update($updateData);
      $updatedData = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->get();
 
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $updatedData;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* MESSAGES PERMISSION */

  /* NOTIFICATION PERMISSION */
  public function notification_permission(Request $req){
    if(isset($req->users_customers_id) && isset($req->notifications)) {
      $updateData['notifications']      = $req->notifications;

      DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->update($updateData);
      $updatedData = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->get();
 
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $updatedData;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* NOTIFICATION PERMISSION */

  /* NOTIFICATIONS API */
  public function notifications(Request $req){
    if (isset($req->users_customers_id)) {
      $notifications  = DB::table('notifications')->where('receivers_id', $req->users_customers_id)->get();
      $data=[];
      foreach($notifications as $notification){
        $notification->notification_sender= DB::table('users_customers')->where('users_customers_id', $notification->senders_id)->select("first_name","last_name","profile_pic")->first();
        $data[]=$notification;
      }

      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $data;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* NOTIFICATIONS API */

  /* UNREAD NOTIFICATIONS API */
  public function notifications_unread(Request $req){
    if (isset($req->users_customers_id)) {
      $notifications  = DB::table('notifications')->where('receivers_id', $req->users_customers_id)->where('notifications.status', 'Unread')->get();

      $data = array("status"=>'Read');
      $updateProfile=DB::table('notifications')->where('receivers_id', $req->users_customers_id)->where('status', 'Unread')->update($data);

      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $notifications;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* UNREAD NOTIFICATIONS API */

  /*** CHAT HEADS ADMIN ***/
  public function getAllChatLive(Request $req){  
      if (isset($req->users_customers_id)){
        $final_chat_array = array();
        $chat_list = DB::table('chat_list_live')->where('sender_id', $req->users_customers_id)->get();

        foreach($chat_list as $key => $chat){
          $chat_array = array();
          $chat_array['sender_id'] = $chat->sender_id;
          $chat_array['receiver_id'] = $chat->receiver_id;

          $receiver_data = DB::table('users_system')->where('users_system_id',$chat->receiver_id)->get();
          $chat_array['first_name'] = $receiver_data[0]->first_name;
          $chat_array['user_image'] = $receiver_data[0]->user_image;
            
          $chat_message = DB::table('chat_messages_live')
            ->where([['sender_id', $req->appUserId],['receiver_id', $chat->receiver_id]])
            ->orWhere([['sender_id', $chat->receiver_id], ['receiver_id', $req->appUserId]])
            ->get()->last();
          if (!empty($chat_message)) {
            $date_request = Helper::get_day_difference($chat_message->send_date);
            $chat_array['date'] = $date_request;
            $chat_array['last_message'] = $chat_message;
          } else {
            $date_request = Helper::get_day_difference($chat->date_request);
            $chat_array['date'] = $date_request;
            $chat_array['last_message'] = 'No Message sent or recieved.';
          }

          $final_chat_array[] = $chat_array;
        }

        if (!empty($final_chat_array)) {
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $final_chat_array;
        } else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "No chat found.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Enter All Fields.";
      }

      return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /*** CHAT HEADS ***/

  /*** CHAT MESSAGES ***/
  public function user_chat_live(Request $req){
      if (isset($req->requestType)) {
        $request_type = $req->requestType;
        switch ($request_type) {
          case "startChat":
            if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
              $check_request = DB::table('chat_list_live')->where([ ['sender_id', $req->users_customers_id], ['receiver_id', $req->other_users_customers_id]])->orWhere([ ['sender_id', $req->other_users_customers_id], ['receiver_id', $req->users_customers_id]])->count();
              if($check_request > 0){
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = 'chat already started';    
              } else {
                $data_save = array(
                    'sender_id'=> $req->users_customers_id,
                    'receiver_id'=> $req->other_users_customers_id,
                    'date_request'=> date('Y-m-d'),
                    'created_at' => Carbon::now()
                );
                $requestSend = DB::table('chat_list_live')->insert($data_save);
                
                if($requestSend){
                    $response["code"] = 200;
                    $response["status"] = "success";
                    $response["message"] = 'Chat Started!';
                  } else {
                    $response["code"] = 404;
                    $response["status"] = "error";
                    $response["message"] = 'Error in starting chat';
                  }
              }
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = 'All fields are required';      
            }
          break;   
          
          case "sendMessage":
            if(isset($req->users_customers_id) && isset($req->other_users_customers_id) && isset($req->content) && isset($req->messageType) && isset($req->sender_type)){
              $message_details = array(
                'sender_type'=> $req->sender_type,
                'sender_id'=> $req->users_customers_id,
                'receiver_id'=> $req->other_users_customers_id,
                'message'=>  json_encode($req->content) ,
                'message_type'=> $req->messageType,
                'send_date'=> date('Y-m-d'),
                'send_time'=> date('H:i:s'),
                'created_at'=> date('Y-m-d H:i:s'),
                'status'=> 'Unread'
              );

              $insertedId = DB::table('chat_messages_live')->insertGetId($message_details);
              if($insertedId){

                //NEW MESSAGE Notifications
                $dataInsert=array(
                  'bookings_id'=>0,
                  'senders_id'=>$req->users_customers_id,
                  'receivers_id'=>$req->other_users_customers_id,
                  'message'=> 'sent a message.',
                  'date_added'=>date('Y-m-d H:i:s'),
                  'date_modified'=>date('Y-m-d H:i:s'),
                  'status'=>'Unread'
                );
                $this->send_notification($dataInsert);
                //NEW MESSAGE Notifications

                $messageDetails =  DB::table('chat_messages_live')->where('chat_messages_live_id', $insertedId)->first();
                $messageDetails->message = json_decode($messageDetails->message);
                if($messageDetails->message_type == 'attachment'){
                  $messageDetails->message = config('base_urls.chat_attachments_base_url').$messageDetails->message;
                }

                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = 'Message sent successfully.';  
              } else {
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = 'Oops! Something went wrong.';  
              }
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = 'All fields are required';  
            }
          break;
                                         
          case "getMessages":
            if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
              $chat_array =array();
              $day_array =array();
              $result = DB::table('chat_messages_live')->where([
                ['sender_id',$req->other_users_customers_id],    
                ['receiver_id', $req->users_customers_id]
              ])->update(array('status' => 'Read'));  
              
              $all_chat = DB::table('chat_messages_live')->where([
                  ['sender_id',$req->users_customers_id],
                  ['receiver_id',$req->other_users_customers_id],
              ])->orWhere([
                  ['sender_id',$req->other_users_customers_id],
                  ['receiver_id',$req->users_customers_id],
              ])->orderBy('chat_messages_live_id','ASC')->get();

              if(sizeof($all_chat) > 0){
                foreach($all_chat as $key => $chat){

                  $get_data['sender_type'] = $chat->sender_type;

                  $chat->message = json_decode($chat->message);
                  $day = Helper::get_day_difference($chat->send_date);

                  if (in_array($day, $day_array, TRUE)){
                    $get_data['date']= '';
                  } else {
                    array_push($day_array, $day);
                    $get_data['date']= $day;
                  } 
                  
                  $get_data['time'] =  date('h:i A',strtotime($chat->send_time));
                  $get_data['msgType'] = $chat->message_type;

                  if($chat->message_type=='attachment'){
                    $attachment = config('base_urls.chat_attachments_base_url') . $chat->message;
                    $get_data['message'] = $attachment;
                  } else {
                    $get_data['message'] = $chat->message;
                  }

                  if($chat->sender_type == 'Admin'){
                    $receiver_data = DB::table('users_system')->where('users_system_id',$req->other_users_customers_id)->get();
                    $get_data['users_data'] = $receiver_data[0];
                  } else {
                    $sender_data = DB::table('users_customers')->where('users_customers_id',$req->users_customers_id)->get();
                    $get_data['users_data'] = $sender_data[0];
                  }
                  array_push($chat_array, $get_data);
                  
                  if(!empty($chat_array)){
                    $result =  DB::table('chat_messages_live')->where([
                      ['sender_id',$req->other_users_customers_id],
                      ['receiver_id',$req->users_customers_id]
                    ])->update(array('status'=>'Read'));
                  }
                }
                
                if($chat_array){
                  $response["code"] = 200;
                  $response["status"] = "success";
                  $response["data"] = $chat_array; 
                } else {
                  $response["code"] = 404;
                  $response["status"] = "error";
                  $response["message"] = 'Error in chat array'; 
                }
              } else {
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = 'no chat history'; 
              }                       
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = 'All fields are needed'; 
            }
          break;

          case "updateMessages":
            if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
              $user_id = $req->users_customers_id;
              $other_user_id  = $req->other_users_customers_id;
              $chat_array =array();
              $all_chat =  DB::table('chat_messages_live')->where([
                    ['sender_id', $other_user_id],
                    ['receiver_id',$user_id],
                    ['status','Unread']
              ])->orderBy('chat_messages_live_id', 'ASC')->get();
              
              if(sizeof($all_chat) > 0){
                foreach($all_chat as $chat){
                  $get_data['chat_messages_live_id'] = $chat->chat_messages_live_id;
                  $get_data['sender_type'] = $chat->sender_type;

                  $chat->message = json_decode($chat->message);                
                  $get_data['time'] =  date('h:i A',strtotime($chat->send_date));
                  $get_data['msgType'] = $chat->message_type;
                  if($chat->message_type =='attachment'){
                    $image = config('base_urls.chat_attachments_base_url') . $chat->message;
                    $get_data['message'] = $image;
                  } else { 
                    $get_data['message'] = $chat->message;
                  } 

                  if($chat->sender_type == 'Admin'){
                    $receiver_data = DB::table('users_system')->where('users_system_id',$other_user_id)->get();
                    $get_data['users_data'] = $receiver_data[0];
                  } else {
                    $sender_data = DB::table('appUsers')->where('appUserId',$other_user_id)->get();
                    $get_data['users_data'] = $sender_data[0];
                  }   

                  if(!empty($chat_array)){
                    $result =  DB::table('chat_messages_live')->where([
                      ['sender_id',$other_user_id],
                      ['receiver_id',$user_id]
                      ])->update(array('status'=>'Read'));
                  }
                  array_push($chat_array, $get_data);
                             
                  $chat_length   =  DB::table('chat_messages_live')->where([
                    ['sender_id', $user_id],
                    ['receiver_id',$other_user_id]
                    ])->orderBy('chat_messages_live_id','ASC')->count();

                  if($chat_array){
                    $finalDataset = array(
                        "chat_length" => $chat_length,
                        "unread_messages" => $chat_array,
                    );

                    $response["code"] = 200;
                    $response["status"] = "success";
                    $response["data"] = $finalDataset; 
                  } else {
                    $response["code"] = 404;
                    $response["status"] = "error";
                    $response["message"] = "Un Updated Chat Not Found!"; 
                  }
                }
              } else {
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "No New Message Found!"; 
              }
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = "All fields are required!"; 
            }
          break;    
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Request type not found"; 
      }

      return response()
       ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
       ->header('Content-Type', 'application/json');
    }
    /*** CHAT MESSAGES ***/

    /* GET ADMIN LIST */
    public function get_admin_list(Request $req){
      $admin_list = DB::table('users_system')->where('status', 'Active')->get();
      if ($admin_list) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $admin_list;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No active admin found.";
      }
      
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
  }
  /* GET ADMIN LIST */

  /*** CHAT HEADS ***/
  public function getAllChat(Request $req){  
    if (isset($req->users_customers_id)){
      $final_chat_array = array();
      $chat_list = DB::table('chat_list')->where('sender_id', $req->users_customers_id)->get();

      foreach($chat_list as $key => $chat){
        $chat_array = array();
        $chat_array['sender_id'] = $chat->sender_id;
        $chat_array['receiver_id'] = $chat->receiver_id;

        $receiver_data = DB::table('users_customers')->where('users_customers_id',$chat->receiver_id)->get()->first();
        $chat_array['receiver_data'] = $receiver_data;
          
        $chat_message = DB::table('chat_messages')->where('sender_id', $req->users_customers_id)->where('sender_id', $req->users_customers_id)->get();
        if (!empty($chat_message[0])) {
          $date_request = Helper::get_day_difference($chat_message[0]->send_date);
          $chat_array['date'] = $date_request;
          $chat_array['last_message'] = $chat_message[0]->message;
        } else {
          $date_request = Helper::get_day_difference($chat->date_request);
          $chat_array['date'] = $date_request;
          $chat_array['last_message'] = 'No Message sent or recieved.';
        }

        $final_chat_array[] = $chat_array;
      }

      if (!empty($final_chat_array)) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $final_chat_array;
      } else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "chat unavailable.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "Enter All Fields.";
    }

    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
  }
  /*** CHAT HEADS ***/

  /*** CHAT MESSAGES ***/
  public function user_chat(Request $req){
    if (isset($req->requestType)) {
      $request_type = $req->requestType;
      switch ($request_type) {
        case "startChat":
          if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
            $check_request = DB::table('chat_list')->where([ ['sender_id', $req->users_customers_id], ['receiver_id', $req->other_users_customers_id]])->orWhere([ ['sender_id', $req->other_users_customers_id], ['receiver_id', $req->users_customers_id]])->count();
            if($check_request > 0){
              $response["code"] = 200;
              $response["status"] = "success";
              $response["message"] = 'chat already started';    
            } else {
              $data_save = array(
                  'sender_id'=> $req->users_customers_id,
                  'receiver_id'=> $req->other_users_customers_id,
                  'date_request'=> date('Y-m-d'),
                  'created_at' => Carbon::now()
              );
              $requestSend = DB::table('chat_list')->insert($data_save);
              
              if($requestSend){
                  $response["code"] = 200;
                  $response["status"] = "success";
                  $response["message"] = 'chat started';
                } else {
                  $response["code"] = 404;
                  $response["status"] = "error";
                  $response["message"] = 'Error in starting chat';
                }
            }
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = 'All fields are required';      
          }
        break;   
        
        case "sendMessage":
          if(isset($req->users_customers_id) && isset($req->other_users_customers_id) && isset($req->content) && isset($req->messageType)){
            $message_details = array(
              'sender_id'=> $req->users_customers_id,
              'receiver_id'=> $req->other_users_customers_id,
              'sender_type'=> $req->sender_type,
              'message'=>  json_encode($req->content) ,
              'message_type'=> $req->messageType,
              'send_date'=> date('Y-m-d'),
              'send_time'=> date('H:i:s'),
              'created_at'=> date('Y-m-d H:i:s'),
              'status'=> 'Unread'
            );

            $insertedId = DB::table('chat_messages')->insertGetId($message_details);
            if($insertedId){
              //NEW MESSAGE Notifications
              $dataInsert=array(
                'bookings_id'=>0,
                'senders_id'=>$req->users_customers_id,
                'receivers_id'=>$req->other_users_customers_id,
                'message'=> 'A new message has been recieved.',
                'date_added'=>date('Y-m-d H:i:s'),
                'date_modified'=>date('Y-m-d H:i:s')
              );
              $this->send_notification($dataInsert);
              //NEW MESSAGE Notifications

              $messageDetails =  DB::table('chat_messages')->where('chat_message_id', $insertedId)->first();
              $messageDetails->message = json_decode($messageDetails->message);
              if($messageDetails->message_type == 'attachment'){
                $messageDetails->message = config('base_urls.chat_attachments_base_url').$messageDetails->message;
              }

              $response["code"] = 200;
              $response["status"] = "success";
              $response["message"] = 'Message sent successfully.';  
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = 'Oops! Something went wrong.';  
            }
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = 'All fields are required';  
          }
        break;
                                       
        case "getMessages":
          if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
            $chat_array =array();
            $day_array =array();
            $result = DB::table('chat_messages')->where([['sender_id',$req->other_users_customers_id], ['receiver_id', $req->users_customers_id]])->update(array('status' => 'Read'));  
            
            $all_chat = DB::table('chat_messages')->where([['sender_id',$req->users_customers_id],['receiver_id',$req->other_users_customers_id]])->orWhere([['sender_id',$req->other_users_customers_id], ['receiver_id',$req->users_customers_id]])->orderBy('chat_message_id','ASC')->get();

            if(sizeof($all_chat) > 0){
              foreach($all_chat as $key => $chat){
                $get_data['sender_type'] = $chat->sender_type;

                $chat->message = json_decode($chat->message);
                $day = Helper::get_day_difference($chat->send_date);

                if (in_array($day, $day_array, TRUE)){
                  $get_data['date']= '';
                } else {
                  array_push($day_array, $day);
                  $get_data['date']= $day;
                } 
                
                $get_data['time'] =  date('h:i A',strtotime($chat->send_time));
                $get_data['msgType'] = $chat->message_type;

                if($chat->message_type=='attachment'){
                  $attachment = config('base_urls.chat_attachments_base_url') . $chat->message;
                  $get_data['message'] = $attachment;
                } else {
                  $get_data['message'] = $chat->message;
                }

                $sender_data = DB::table('users_customers')->where('users_customers_id',$req->users_customers_id)->get();
                $get_data['users_data'] = $sender_data[0];
              
                array_push($chat_array, $get_data);
                
                if(!empty($chat_array)){
                  $result =  DB::table('chat_messages')->where([
                    ['sender_id',$req->other_users_customers_id],
                    ['receiver_id',$req->users_customers_id]
                  ])->update(array('status'=>'Read'));
                }
              }

              if($chat_array){
                $response["code"] = 200;
                $response["status"] = "success";
                $response["data"] = $chat_array; 
              } else {
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = 'Error in chat array'; 
              }
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = 'no chat history'; 
            }                       
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = 'All fields are needed'; 
          }
        break;

        case "updateMessages":
          if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
            $user_id = $req->users_customers_id;
            $other_user_id  = $req->other_users_customers_id;
            $chat_array =array();
  
            $all_chat =  DB::table('chat_messages')
              ->where([['sender_id', $other_user_id], ['receiver_id',$user_id],['status','Unread']])
              ->orderBy('chat_message_id', 'ASC')->get();
            
            if(sizeof($all_chat) > 0){
              foreach($all_chat as $chat){
                $get_data['chat_message_id'] = $chat->chat_message_id;
                $get_data['sender_type'] = $chat->sender_type;

                $chat->message = json_decode($chat->message);                
                $get_data['time'] =  date('h:i A',strtotime($chat->send_date));
                $get_data['msgType'] = $chat->message_type;
                if($chat->message_type =='attachment'){
                  $image = config('base_urls.chat_attachments_base_url') . $chat->message;
                  $get_data['message'] = $image;
                } else { 
                  $get_data['message'] = $chat->message;
                } 

                $sender_data = DB::table('users_customers')->where('users_customers_id',$req->other_users_customers_id)->get();
                $get_data['users_data'] = $sender_data[0];
                array_push($chat_array, $get_data);
              }
               
              if(!empty($chat_array)){
                $result =  DB::table('chat_messages')->where([
                  ['sender_id',$other_user_id],
                  ['receiver_id',$user_id]
                  ])->update(array('status'=>'Read'));
              }
                         
              $chat_length   =  DB::table('chat_messages')->where([
                ['sender_id', $user_id],
                ['receiver_id',$other_user_id]
                ])->orWhere([
                    ['sender_id', $other_user_id],
                ['receiver_id',$user_id]
              ])->orderBy('chat_messages_id','ASC')->count();
            
              $finalDataset = array(
                  "chat_length" => $chat_length,
                  "unread_messages" => $chat_array,
              );

              $response["code"] = 200;
              $response["status"] = "success";
              $response["data"] = $finalDataset; 
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = "no chat found"; 
            }
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "All fields are needed"; 
          }
        break;    
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "Request type not Found"; 
    }

    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /*** CHAT MESSAGES ***/

  /* EMAIL EXIST API */
  public function email_exist(Request $req){
    if (isset($req->email)) {
      $email=DB::table('users_customers')->where('email', $req->email)->first();
      if ($email) {
        $response["code"] = 200;
        $response["status"] = "error";
        $response["message"]  ="Email already exists.";
      }else{
        $response["code"] = 404;
        $response["status"] = "success";
        $response["message"] = "Email does not exists.";
      }
    }else{ 
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "Please enter email address.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* EMAIL EXIST API */
 
  /* GET CATEGORES */
  public function categories(){
    $fetch_data   =  DB::table('categories')->get();
    if (count($fetch_data)>0) {
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $fetch_data;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "no data found.";
    }
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* GET CATEGORES */

  /* GET BOOKS */
  public function books(){
    $fetch_data   =  DB::table('books')->where('status','Active')->get();
    $books=[];
    foreach ($fetch_data as $key => $data) {
      $data->category=DB::table('categories')->where(['categories_id'=>$data->categories_id,'status'=>'Active'])->first();
      $data->author=DB::table('authors')->where(['authors_id'=>$data->authors_id,'status'=>'Active'])->first();
      $books[]=$data;
    }
    if (count($books)>0) {
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $books;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "no data found.";
    }
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* GET BOOKS */

    /* ALL BOOKMARKED BOOKS*/
    public function all_bookmarked_books(Request $req){
      if (isset($req->users_customers_id)) {
        $user=DB::table('users_customers')->where(['users_customers_id'=>$req->users_customers_id,'status'=>'Active'])->first();
        if($user) {
            $fetch_data = DB::table('books')->where('status','Active')->get();
            $get_data=[];
              foreach ($fetch_data as $key => $data) {
                $data->category = Category::where(['categories_id'=>$data->categories_id, 'status'=>'Active'])->first();
                $data->author = Author::where(['authors_id'=>$data->authors_id, 'status'=>'Active'])->first();
                $bookmarked = Bookmark::where(['users_customers_id'=>$req->users_customers_id, 'books_id'=>$data->books_id, 'status'=>'Active'])->first();
                if($bookmarked){
                  $data->bookmarked = 'Yes';
                  $get_data[]=$data;
                } 
              }
            
            if (count($get_data)>0) {
              $response["code"] = 200;
              $response["status"] = "success";
              $response["data"] = $get_data;
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = "no data found.";
            }
          }else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "User does not exists.";
          }
        }else{ 
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "All fields are needed.";
        }
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /* ALL BOOKMARKED BOOKS*/
  
     /* ADD BOOK BOOKMARK*/
     public function add_book_bookmark(Request $req){
      if (isset($req->users_customers_id) && isset($req->books_id)) {
        $user=DB::table('users_customers')->where(['users_customers_id'=>$req->users_customers_id,'status'=>'Active'])->first();
        if($user) {
          $book=DB::table('books')->where(['books_id'=>$req->books_id,'status'=>'Active'])->first();
          if($book) {
            $already_bookedMark=Bookmark::where(['users_customers_id' => $req->users_customers_id,'books_id' => $req->books_id,'status'=>'Active'])->first();
            if(!$already_bookedMark) {
              $bookmark_book=Bookmark::where(['users_customers_id' => $req->users_customers_id,'books_id' => $req->books_id,'status'=>'Deleted'])->first();
              if($bookmark_book) {
                $update_book = Bookmark::where(
                  ['users_customers_id' => $req->users_customers_id,'books_id' => $req->books_id])->update(['status' => "Active"]);
                $updated_book = Bookmark::where(
                  ['users_customers_id' => $req->users_customers_id,'books_id' => $req->books_id])->first();
                $response["code"] = 200;
                $response["status"] = "success";
                $response["data"] = $updated_book;
              }else{
                $bookmark_book = Bookmark::firstOrCreate(
                  ['users_customers_id' => $req->users_customers_id,'books_id' => $req->books_id],
                  ['users_customers_id' => $req->users_customers_id,'books_id' => $req->books_id]);
      
                $response["code"] = 200;
                $response["status"] = "success";
                $response["data"] = $bookmark_book;
              }
            }else{
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = "Book is already bookmarked.";
            }
          }else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Book does not exists.";
          }
        }else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "User does not exists.";
        }
      }else{ 
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "All fields are needed.";
      }
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /* ADD BOOK BOOKMARK*/
  
    /* REMOVE BOOK BOOKMARK*/
    public function remove_book_bookmark(Request $req){
      if (isset($req->users_customers_id) && isset($req->books_id)) {
        $user=DB::table('users_customers')->where(['users_customers_id'=>$req->users_customers_id,'status'=>'Active'])->first();
        if ($user) {
          $book=DB::table('books')->where(['books_id'=>$req->books_id,'status'=>'Active'])->first();
          if ($book) {
            $remove_book = Bookmark::where(
              ['users_customers_id' => $req->users_customers_id,'books_id' => $req->books_id])->update(['status' => "Deleted"]);
              if($remove_book){
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Remove Successfully";
              }else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Data not updated.";
              }
          }else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Book does not exists.";
          }
        }else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "User does not exists.";
        }
      }else{ 
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "All fields are needed.";
      }
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /* REMOVE BOOK BOOKMARK*/
  
    /*BOOK VIEW*/
    public function book_view(Request $req){
      if(isset($req->users_customers_id) && isset($req->books_id)) {
        $user=DB::table('users_customers')->where(['users_customers_id'=>$req->users_customers_id,'status'=>'Active'])->first();
          if ($user){
            $book=DB::table('books')->where(['books_id'=>$req->books_id,'status'=>'Active'])->first();
            if ($book) {
            DB::beginTransaction();
            try {
              $userid = ['users_customers_id'=>$req->users_customers_id,'books_id'=>$req->books_id]; 
                                  
                    $viewed=BookView::firstOrCreate($userid,[
                        'users_customers_id'=>$req->users_customers_id,
                        'books_id'=>$req->books_id,
                    ]);
  
                    if($viewed){
                  DB::commit();
                      $changedStatus=BookView::where($userid)->first();
                      $response["code"] = 200;
                      $response["status"] = "success";
                      $response["data"] = $changedStatus;
                     }
            } catch (\Exception $ex) {
                DB::rollback();
                $response["code"] = 404;
                $response["status"] = "error";
                $response['message'] = $ex->getMessage();
            }
          }else{  
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Book does not exists.";
          }    
        }else{  
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "User does not exists.";
        }
      }else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "All fields is required.";
      }
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /*BOOK VIEW*/
  
    /* POPULAR BOOKS */
    public function popular_books(Request $req){
      if (isset($req->users_customers_id)) {
        $user=DB::table('users_customers')->where(['users_customers_id'=>$req->users_customers_id,'status'=>'Active'])->first();
        if($user) {
          $books= DB::table('books')->where("status","Active")->get();
          $views=BookView::all();
          $array=[];
          
          foreach ($books as $key => $book) {
            foreach ($views as $key => $view) {
              // books views like
              $book->category = Category::where(['categories_id'=>$book->categories_id, 'status'=>'Active'])->first();
              $book->author = Author::where(['authors_id'=>$book->authors_id, 'status'=>'Active'])->first();
              $bookmarked = Bookmark::where(['users_customers_id'=>$req->users_customers_id, 'books_id'=>$book->books_id, 'status'=>'Active'])->first();
                if($bookmarked){
                  $book->bookmarked = 'Yes';
                } else {
                  $book->bookmarked = 'No';
                }
              // books views like
      
              // books views count
              $book->view_count=0;
              if($view->books_id == $book->books_id){
                $book->view_count+=1;
              }
              // books views count
            }
            $array[]=$book;
          }
          $get_data = collect($array)->sortByDesc('view_count')->values()->all();
          if (count($get_data)>0) {
            $response["code"] = 200;
            $response["status"] = "success";
            $response["data"] = $get_data;
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "no data found.";
          }
        }else{  
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "User does not exists.";
        }  
      }else{ 
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "All fields are needed.";
      }  
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /* POPULAR BOOKS*/
    
    /* SEARCH BOOK*/
    public function search_book(Request $req){
      if(isset($req->search_query )) {
        $searchQuery=$req->search_query;
        $fetch_data = Book::query()
                      ->whereHas('author', function ($query) use ($searchQuery) {
                          $query->where('name', 'like', '%' . $searchQuery . '%');
                      })
                      ->orWhereHas('category', function ($query) use ($searchQuery) {
                          $query->where('name', 'like', '%' . $searchQuery . '%');
                      })
                      ->orWhere('title', 'like', '%' . $searchQuery . '%')
                      ->where('status','Active')
                      ->get();

          $get_data=[];
            foreach ($fetch_data as $key => $data) {
              $data->category = Category::where(['categories_id'=>$data->categories_id, 'status'=>'Active'])->first();
                $data->author = Author::where(['authors_id'=>$data->authors_id, 'status'=>'Active'])->first();
              $bookmarked = Bookmark::where(['users_customers_id'=>$req->users_customers_id, 'books_id'=>$data->books_id, 'status'=>'Active'])->first();
              if($bookmarked){
                $data->bookmarked = 'Yes';
              } else {
                $data->bookmarked = 'No';
              }
              $get_data[]=$data;
            }
          
          if (count($get_data)>0) {
            $response["code"] = 200;
            $response["status"] = "success";
            $response["data"] = $get_data;
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Data not found.";
        }
      }else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "searchQuery field is required.";
      }
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /* SEARCH BOOK*/
    
    /*BOOK DOWNLOAD*/
    public function book_download(Request $req){
      if (isset($req->users_customers_id) && isset($req->books_id)) {
          $book=DB::table('books')->where(['books_id'=>$req->books_id,'status'=>'Active'])->first();
          if($book) {
              DB::beginTransaction();
              try {
    
                $old_download=$book->downloads;
                $new_download=$old_download+1;
                $update_download=Book::where(['books_id'=>$req->books_id])->update(['downloads'=>$new_download]);
                if ($update_download) {
                $updated_book=Book::where(['books_id'=>$req->books_id,'status'=>'Active'])->first();
                  DB::commit();
                      $response["code"] = 200;
                      $response["status"] = "success";
                      $response["data"] = $updated_book;
                }
              } catch (\Exception $ex) {
                DB::rollback();
                $response["code"] = 404;
                $response["status"] = "error";
                $response['message'] = $ex->getMessage();
              }
          }else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Book does not exists.";
          }
      }else{ 
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "All fields are needed.";
      }
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /*BOOK DOWNLOAD*/

    /* SEARCH BOOK BY AUTHOR*/
    public function search_book_by_author(Request $req){
      if(isset($req->search_query )) {
        $searchQuery=$req->search_query;
        $fetch_data = Book::whereHas('author', function ($query) use ($searchQuery) {
                          $query->where('name', 'like', '%' . $searchQuery . '%');
                      })
                      ->where('status','Active')
                      ->get();

          $get_data=[];
            foreach ($fetch_data as $key => $data) {
              $data->category = Category::where(['categories_id'=>$data->categories_id, 'status'=>'Active'])->first();
                $data->author = Author::where(['authors_id'=>$data->authors_id, 'status'=>'Active'])->first();
              $bookmarked = Bookmark::where(['users_customers_id'=>$req->users_customers_id, 'books_id'=>$data->books_id, 'status'=>'Active'])->first();
              if($bookmarked){
                $data->bookmarked = 'Yes';
              } else {
                $data->bookmarked = 'No';
              }
              $get_data[]=$data;
            }
          
          if (count($get_data)>0) {
            $response["code"] = 200;
            $response["status"] = "success";
            $response["data"] = $get_data;
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Data not found.";
        }
      }else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "searchQuery field is required.";
      }
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /* SEARCH BOOK BY AUTHOR*/

    /* SEARCH BOOK BY BOOKNAME*/
    public function search_book_by_bookname(Request $req){
      if(isset($req->search_query )) {
        $searchQuery=$req->search_query;
        $fetch_data = Book::where('title', 'like', '%' . $searchQuery . '%')->where('status','Active')->get();

          $get_data=[];
            foreach ($fetch_data as $key => $data) {
               $data->categories = Category::where(['categories_id'=>$data->categories_id, 'status'=>'Active'])->first();
               $data->authores = Author::where(['authors_id'=>$data->authors_id, 'status'=>'Active'])->first();
              $bookmarked = Bookmark::where(['users_customers_id'=>$req->users_customers_id, 'books_id'=>$data->books_id, 'status'=>'Active'])->first();
              if($bookmarked){
                $data->bookmarked = 'Yes';
              } else {
                $data->bookmarked = 'No';
              }
              $get_data[]=$data;
            }
          
          if (count($get_data)>0) {
            $response["code"] = 200;
            $response["status"] = "success";
            $response["data"] = $get_data;
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Data not found.";
        }
      }else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "searchQuery field is required.";
      }
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /* SEARCH BOOK BY BOOKNAME*/

     /* RELATED BOOKS*/
     public function related_books(Request $req){
      if (isset($req->users_customers_id) && isset($req->books_id)) {
        $user=DB::table('users_customers')->where(['users_customers_id'=>$req->users_customers_id,'status'=>'Active'])->first();
        if($user) {
          $book=DB::table('books')->where(['books_id'=>$req->books_id,'status'=>'Active'])->first();
          if($book) {
            $fetch_data = Book::where("categories_id",$book->categories_id)
            ->orWhere("authors_id",$book->authors_id)
            ->where('status','Active')
            ->where("books_id",'!=',$req->books_id)
            ->get();

            $get_data=[];
            foreach ($fetch_data as $key => $data) {
              if($data->books_id!=$req->books_id){
               
                $data->category = Category::where(['categories_id'=>$data->categories_id, 'status'=>'Active'])->first();
                  $data->author = Author::where(['authors_id'=>$data->authors_id, 'status'=>'Active'])->first();
                $bookmarked = Bookmark::where(['users_customers_id'=>$req->users_customers_id, 'books_id'=>$data->books_id, 'status'=>'Active'])->first();
                if($bookmarked){
                  $data->bookmarked = 'Yes';
                } else {
                  $data->bookmarked = 'No';
                }
                
                $get_data[]=$data;
              }

            }

            if (count($get_data)>0) {
            $response["code"] = 200;
            $response["status"] = "success";
            $response["data"] = $get_data;
            } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Data not found.";
            }
          }else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Book does not exists.";
          }
        }else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "User does not exists.";
        }
      }else{ 
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "All fields are needed.";
      }
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /* RELATED BOOKS*/
} 