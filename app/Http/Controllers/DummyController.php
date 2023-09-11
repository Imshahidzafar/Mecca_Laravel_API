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
use App\Models\{dummytable1,dummytable2};
 
class DummyController extends Controller{
  
  public function savedata(Request $request){
    if (isset($request->cat_name)) {
        $data=[

          'cat_name' =>$request->cat_name,
          'date_added' =>Carbon::now(),
          'status' => 'Active',
    
        ];
  
        DB::beginTransaction();
        try {
          $stdata=dummytable1::create($data);
            DB::commit();
        } catch (\Throwable $e) {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] =$e->getMessage();  
        }
      if($stdata){
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $stdata;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "All fields are required.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  public function getData(){
  
   
    $data = dummytable1::all(); 

     if(count($data)>0){
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $data;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "No Data Found";
    }
    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
     
  }
  public function upd_data(Request $request){
      $data = dummytable1::find($request->id);
      if($data){

      $data['cat_name'] = $request->cat_name;
      $data->save();
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $data;
      }else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No Data Found";
      }
     return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
   }
  public function delete_cat(Request $request){
    $data = dummytable1::findOrFail($request->id);
    if($data){
      $data->delete();
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = "Data deleted successfully";
    }else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "No Data Found";
    }
    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
   }
   // Crud operation for the product Table
    public function insert_product_data(Request $request){
      if (isset($request->product_name) && isset($request->cat_id)) {
        $data=[
           'cat_id' =>$request->cat_id,
          'product_name' =>$request->product_name,
          'date_added' =>Carbon::now(),
          'status' => 'Active',
    
        ];
        DB::beginTransaction();
        try {
          $pddata = dummytable2::create($data);
            DB::commit();
            if($pddata){
              $response["code"] = 200;
              $response["status"] = "success";
              $response["data"] = $pddata;
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = "All fields are required.";
            }
        } catch (\Throwable $e) {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] =$e->getMessage();  
        }  
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "All fields are required.";
      }
      return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');

    }
    public function get_products(){
  
   
      $data = dummytable2::all(); 
  
       if(count($data)>0){
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $data;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No Data Found";
      }
      return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
       
    }
    public function upd_products(Request $request){
      $data = dummytable2::find($request->id);
      if($data){

      $data['product_name'] = $request->product_name;
      $data->save();
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $data;
      }else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No Data Found";
      }
     return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
   } public function delete_products(Request $request){
    $data = dummytable2::findOrFail($request->id);
    if($data){
      $data->delete();
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = "Data deleted successfully";
    }else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "No Data Found";
    }
    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
   }

  }