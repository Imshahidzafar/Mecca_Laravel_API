<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Event_post;
use App\Models\Tag;
use App\Models\Event_tag;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use DB;

use Artisan;
use Session;

class AdminController extends Controller{
    public $successStatus = 200;
    public $errorStatus = 401;

    // -------------- CACHE PAGE ------------- //
    public function clear_cache(Request $request){
        $exitCode = Artisan::call('route:clear');
        $exitCode = Artisan::call('config:cache');
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('view:clear');

        Session::flash('success', 'Cache Cleared!'); 
        return redirect('admin/dashboard');
    }
    // -------------- CACHE PAGE ------------- //
    
    // -------------- LOGIN PAGE ------------- //
    public function index(Request $request){
        if ($request->session()->has('id')) {
            return redirect('admin/dashboard');
        } else{
            return view('admin.login');
        }
    }
    // -------------- LOGIN PAGE ------------- //

    // -------------- LOGIN AUTHENTICATION ------------- //
    public function login(Request $request){
        $validateData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $postData = $request->all();
        $ifExists = DB::table('users_system')->where('email', $postData['email'])->where('password', $postData['password'])->first();
        if (!empty($ifExists)) {
            $request->session()->put([
                'id' => $ifExists->users_system_id,
                'users_system_roles_id'=>$ifExists->users_system_roles_id,
                'user_image' => $ifExists->user_image,
                'fname' => $ifExists->first_name,
                'lname' => '',
                'email' => $ifExists->email,
            ]);
            Session::flash('success', ' Logged in successfully.'); 
            return redirect('admin/dashboard');
        } else {
            Session::flash('error', 'Invalid Email/Password'); 
            return redirect()->back();
        }
    }
    // -------------- LOGIN AUTHENTICATION ------------- //

    // -------------- LOGOUT ------------- //
    public function logout(Request $request){
        $request->session()->flush();
        return redirect('admin/');
    }
    // -------------- LOGOUT ------------- //

    // ------------- DASHBOARD -------------- //
    public function dashboard(){
        if(session()->has('id')){
            $total_users_customers     = number_format(DB::table('users_customers')->count());
            $system_currency    = DB::table('system_settings')->select('description')->where('type', 'system_currency')->get()->first();
            
            return view('admin.dashboard', compact('total_users_customers'));
        } else {
            return redirect('admin/');
        }
    }
    // ------------- DASHBOARD -------------- //

    // ------------- MANAGE CUSTOMERS -------------- //
    public function users_customers(Request $request){
        if ($request->session()->has('id')) {
            if(empty($request->get('filter'))){
                $users = DB::table('users_customers')->orderBy('users_customers_id', 'DESC')->get();
            } else {
                $users = DB::table('users_customers')->where('status', $request->get('filter'))->orderBy('users_customers_id', 'DESC')->get();
            }

            $filter = $request->get('filter');
            return view('admin.users_customers', compact('users', 'filter'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE CUSTOMERS -------------- //

    // ------------- MANAGE CUSTOMERS VIEW -------------- //
    public function users_customers_view($id){
        if (session()->has('id')) {
            $users_data         = DB::table('users_customers')->where('users_customers_id', $id)->get();
            return view('admin.users_customers_view', compact('users_data'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE CUSTOMERS VIEW -------------- //

    // ------------- UPDATE CUSTOMERS -------------- //
    public function users_customers_update(Request $req){
        $update_array['status'] = $req->status;      
        if($req->status == 'Active'){
            $update_array['verified_badge'] = 'Yes';
        }  
        $updated = DB::table('users_customers')->where('users_customers_id', $req->id)->update($update_array);
        if ($updated) {
            Session::flash('success', ' Data Updated successfully'); 
            return back()->with('success', 'Data Updated successfully');
        } else {
            Session::flash('error', ' Oops! something went wrong'); 
            return back()->with('errors', 'Oops! something went wrong');
        }
    }
    // ------------- UPDATE CUSTOMERS -------------- //

    // ------------- DELETE CUSTOMERS -------------- //
    public function users_customers_delete(Request $req){
        if(session()->has('id')){
            if(!empty($req->id)){
                $checkdata = DB::table('users_customers')->where('users_customers_id', $req->id)->where('status', '!=','Deleted')->get();

                if(count($checkdata) != 0){
                    $del=DB::table('users_customers')->where('users_customers_id', '=', $req->id)->update(array( 'status' => 'Deleted'));
                    if($del){
                        Session::flash('success', ' Data Deleted successfully'); 
                        return redirect('admin/users_customers');
                    } else {
                        Session::flash('error', ' Oops! something went wrong'); 
                        return redirect('admin/users_customers');
                    }
                } else {
                    Session::flash('error', ' This record is already deleted in status'); 
                    return redirect('admin/users_customers');
                }
            } else {
                Session::flash('error', ' No Data Found'); 
                return redirect('admin/users_customers');
            }
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- DELETE CUSTOMERS -------------- //

    /*** SUPPORT ***/
    public function support(){
        if (!session()->has('id')) {
          return redirect('admin/admin');
        } else {
          return view('admin.support');
        }
    }
    /*** SUPPORT ***/    

    // ------------- ACCOUNT SETTINGS -------------- //
    public function account_settings(){
        if(session()->has('id')){
            $page_name = 'account_settings';
            $fetch_data = DB::table('users_system')->where('users_system_id',session('id'))->get();
            return view('admin.account_settings',compact('fetch_data','page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- ACCOUNT SETTINGS -------------- //

    // ------------- UPDATE ACCOUNT SETTINGS -------------- //
    public function account_settings_update(Request $req,$id){
        $insert=array();
        $insert['first_name'] = $req->first_name;
        $insert['email'] = $req->email;
        $insert['password'] = $req->password;
        
        $insert['city'] = $req->city;
        $insert['address'] = $req->address;
        $insert['mobile'] = $req->mobile;

        if ($req->hasfile('image')) {
            $file = $req->file('image');
            if ($file->isValid()) {
                $ext = $file->extension();
                $path = public_path('uploads/users_system/');
                $prefix = 'user-' . md5(time());
                $img_name = $prefix . '.' . $ext;
                if ($file->move($path, $img_name)) {
                    $insert['user_image'] = 'uploads/users_system/' . $img_name;
                }
            }
        }

        $a = DB::table('users_system')->where('users_system_id','=',$id)->update($insert);
        if ($a) {
            Session::flash('success', ' Profile Updated successfully'); 
            return redirect('admin/account_settings');
        } else {
            Session::flash('error', ' oops! something went wrong'); 
            return redirect('admin/account_settings');
        }
    }
    // ------------- UPDATE ACCOUNT SETTINGS -------------- //

    // ------------- MANAGE SYSTEM SETTINGS -------------- //
    public function system_settings(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'system_settings';
            $system_settings = DB::table('system_settings')->get();
            return view('admin.system_settings', compact('system_settings','page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE SYSTEM ROLES EDIT -------------- //

    // ------------- MANAGE SYSTEM USERS ROLES DATA -------------- //
    public function system_settings_edit(Request $req){
        $page_name  = $req->page_name;

        if(isset($req->invite_text)){
            $data['description']          = $req->invite_text;
            DB::table('system_settings')->where('type', 'invite_text')->update($data);
        } 

        if(isset($req->admin_share)){
            $data['description']          = $req->admin_share;
            DB::table('system_settings')->where('type', 'admin_share')->update($data);
        } 

        if(isset($req->email)){
            $data['description']          = $req->email;
            DB::table('system_settings')->where('type', 'email')->update($data);
        } 

        if(isset($req->phone)){
            $data['description']          = $req->phone;
            DB::table('system_settings')->where('type', 'phone')->update($data);
        } 

        if(isset($req->system_name)){
            $data['description']          = $req->system_name;
            DB::table('system_settings')->where('type', 'system_name')->update($data);
        } 

        if(isset($req->address)){
            $data['description']          = $req->address;
            DB::table('system_settings')->where('type', 'address')->update($data);
        } 

        if(isset($req->system_currency)){
            $data['description']          = $req->system_currency;
            DB::table('system_settings')->where('type', 'system_currency')->update($data);
        } 

        if(isset($req->social_login)){
            $data['description']          = $req->social_login;
            DB::table('system_settings')->where('type', 'social_login')->update($data);
        } 

        if(isset($req->about_text)){
            $data['description']          = $req->about_text;
            DB::table('system_settings')->where('type', 'about_text')->update($data);
        }

        if(isset($req->terms_text)){
            $data['description']          = $req->terms_text;
            DB::table('system_settings')->where('type', 'terms_text')->update($data);
        }

        if(isset($req->privacy_text)){
            $data['description']          = $req->privacy_text;
            DB::table('system_settings')->where('type', 'privacy_text')->update($data);
        }

        if (isset($req->image)) {
            $image              = $req->file('image');
            $image1_name        = $image->getClientOriginalName();
            $destinationPath    = public_path().'/uploads/system_image' ;
            $image_n            = $image1_name;
            $uploaded           = $image->move($destinationPath, $image1_name);
            
            $data['description'] = $image_n;
            DB::table('system_settings')->where('type', 'system_image')->update($data);
        }   

        session()->flash('success', 'System settings updated successfully!');
        return redirect('admin/'.$page_name);
    }
    // ------------- MANAGE SYSTEM USERS ROLES DATA -------------- //

    // ------------- MANAGE SYSTEM USERS -------------- //
    public function users_system(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system';
            $users= db::table('users_system')->orderBy('users_system_id', 'DESC')->get();
            return view('admin.users_system', compact('users', 'page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE SYSTEM USERS -------------- //

    // ------------- UPDATE SYSTEM USERS -------------- //
    public function users_system_update(Request $req){
        $update_array['status'] = $req->status;        
        $updated = DB::table('users_system')->where('users_system_id', $req->id)->update($update_array);
        if ($updated) {
            Session::flash('success', ' Data Updated successfully'); 
            return redirect('admin/users_system');
        } else {
            Session::flash('error', ' Oops! something went wrong'); 
            return back()->with('errors', 'Oops! something went wrong');
        }
    }
    // ------------- UPDATE SYSTEM USERS -------------- //

    // ------------- DELETE SYSTEM USERS -------------- //
    public function users_system_delete(Request $req){
        if(session()->has('id')){
            if(!empty($req->id)){
                $checkdata = DB::table('users_system')->where('users_system_id', $req->id)->get();

                if(count($checkdata) != 0){
                    $del = DB::table('users_system')->where('users_system_id', $req->id)->delete();
                    if($del){
                        Session::flash('success', ' Data Deleted successfully'); 
                        return redirect('admin/users_system');
                    } else {
                        Session::flash('error', ' Oops! something went wrong'); 
                        return redirect('admin/users_system');
                    }
                } else {
                    Session::flash('error', ' This record is already deleted in status'); 
                    return redirect('admin/users_system');
                }
            } else {
                Session::flash('error', ' No Data Found'); 
                return redirect('admin/users_system');
            }
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- DELETE SYSTEM USERS -------------- //

    // ------------- MANAGE SYSTEM USERS ADD -------------- //
    public function users_system_add(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system';
            $roles = DB::table('users_system_roles')->orderBy('users_system_roles_id', 'DESC')->get();
            return view('admin.users_system_add', compact('roles', 'page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE SYSTEM USERS ADD -------------- //

    // ------------- MANAGE SYSTEM USERS ADD DATA -------------- //
    public function users_system_add_data(Request $req){
        $save_data['users_system_roles_id']     = $req->users_system_roles_id;
        $save_data['first_name']                = $req->first_name;
        $save_data['email']                     = $req->email;
        $save_data['password']                  = $req->password;
        $save_data['mobile']                    = $req->mobile;
        $save_data['city']                      = $req->city;
        $save_data['address']                   = $req->address;
        $save_data['status']                    = $req->status;
        
        if (isset($req->image)) {
            $image = $req->file('image');
            $image1_name = $image->getClientOriginalName();
            $destinationPath = public_path().'/uploads/users_system';
            $image_n=  "uploads/users_system/".$image1_name;
            $image->move($destinationPath, $image1_name);
            
            $save_data['user_image'] = $image_n;
        }   
        $users_system_id = DB::table('users_system')->insertGetId($save_data);

        if($users_system_id > 0){ 
            session()->flash('success', 'User added successfully!');
            return redirect('admin/users_system');
        } else {
            session()->flash('error', 'Oops! Somrthing went wrong. Please try again.');
            return redirect()->back();
        }
    }
    // ------------- MANAGE SYSTEM USERS ADD DATA -------------- //

    // ------------- MANAGE SYSTEM USERS EDIT -------------- //
    public function users_system_edit(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system';
            $roles = DB::table('users_system_roles')->orderBy('users_system_roles_id', 'DESC')->get();
            $users_system = DB::table('users_system')->where('users_system_id', $request->id)->get()->first();
            return view('admin.users_system_edit', compact('roles', 'users_system', 'page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE SYSTEM USERS EDIT -------------- //

    // ------------- MANAGE SYSTEM USERS EDIT DATA -------------- //
    public function users_system_edit_data(Request $req){
        $update_data['users_system_roles_id']     = $req->users_system_roles_id;
        $update_data['first_name']                = $req->first_name;
        $update_data['email']                     = $req->email;
        $update_data['password']                  = $req->password;
        $update_data['mobile']                    = $req->mobile;
        $update_data['city']                      = $req->city;
        $update_data['address']                   = $req->address;
        $update_data['status']                    = $req->status;
        
        if (isset($req->image)) {
            $image = $req->file('image');
            $image1_name = $image->getClientOriginalName();
            $destinationPath = public_path().'/uploads/users_system' ;
            $image_n=  "uploads/users_system/".$image1_name;
            $image->move($destinationPath, $image1_name);
            
            $update_data['user_image'] = $image_n;
        }   
        $updated = DB::table('users_system')->where('users_system_id', $req->users_system_id)->update($update_data);

        if($updated > 0){ 
            session()->flash('success', 'User updated successfully!');
            return redirect('admin/users_system');
        } else {
            session()->flash('error', 'Oops! Somrthing went wrong. Please try again.');
            return redirect()->back();
        }
    }
    // ------------- MANAGE SYSTEM USERS EDIT DATA -------------- //

    // ------------- MANAGE SYSTEM ROLES -------------- //
    public function users_system_roles(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system_roles';
            $users_system_roles = db::table('users_system_roles')->orderBy('users_system_roles_id', 'DESC')->get();
            return view('admin.users_system_roles', compact('users_system_roles','page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE SYSTEM ROLES -------------- //

    // ------------- MANAGE SYSTEM ROLES ADD -------------- //
    public function users_system_roles_add(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system_roles';
            return view('admin.users_system_roles_add', compact('page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE SYSTEM ROLES ADD -------------- //

    // ------------- MANAGE SYSTEM ROLES ADD DATA -------------- //
    public function users_system_roles_add_data(Request $req){
        $data['dashboard']           = $req->dashboard;
        $data['users_customers']     = $req->users_customers;
        $data['users_system']        = $req->users_system;
        $data['users_system_roles']  = $req->users_system_roles;
        $data['system_settings']     = $req->system_settings;
        $data['account_settings']    = $req->account_settings;
        
        $users_system_id = DB::table('users_system_roles')->insertGetId($data);

        if($users_system_id > 0){ 
            session()->flash('success', 'Role added successfully!');
            return redirect('admin/users_system_roles');
        } else {
            session()->flash('error', 'Oops! Somrthing went wrong. Please try again.');
            return redirect()->back();
        }
    }
    // ------------- MANAGE SYSTEM ROLES ADD DATA -------------- //

    // ------------- MANAGE SYSTEM ROLES EDIT -------------- //
    public function users_system_roles_edit(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system_roles';
            $users_system_roles = DB::table('users_system_roles')->where('users_system_roles_id', $request->id)->get()->first();
            return view('admin.users_system_roles_edit', compact('users_system_roles', 'page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE SYSTEM ROLES EDIT -------------- //

    // ------------- MANAGE SYSTEM USERS ROLES DATA -------------- //
    public function users_system_roles_edit_data(Request $req){
        $data['name']                = $req->name;
        $data['status']              = $req->status;
        
        $data['dashboard']           = $req->dashboard;
        $data['users_customers']     = $req->users_customers;
        $data['users_system']        = $req->users_system;
        $data['users_system_roles']  = $req->users_system_roles;
        $data['system_settings']     = $req->system_settings;
        $data['account_settings']    = $req->account_settings;

        $updated = DB::table('users_system_roles')->where('users_system_roles_id', $req->users_system_roles_id)->update($data);

        if($updated > 0){ 
            session()->flash('success', 'Role updated successfully!');
            return redirect('admin/users_system_roles');
        } else {
            session()->flash('error', 'Oops! Somrthing went wrong. Please try again.');
            return redirect()->back();
        }
    }
    // ------------- MANAGE SYSTEM USERS ROLES DATA -------------- //

    // ------------- DELETE SYSTEM USERS ROLES -------------- //
    public function users_system_roles_delete(Request $req){
        if(session()->has('id')){
            if(!empty($req->id)){
                $checkdata = DB::table('users_system')->where('users_system_roles_id', $req->id)->get();

                if(count($checkdata) == 0){
                    $del = DB::table('users_system_roles')->where('users_system_roles_id', $req->id)->delete();
                    if($del){
                        Session::flash('success', ' Data Deleted successfully'); 
                        return redirect('admin/users_system_roles');
                    } else {
                        Session::flash('error', ' Oops! something went wrong'); 
                        return redirect('admin/users_system_roles');
                    }
                } else {
                    Session::flash('error', ' This role is assigned to some users. Delete the users first.'); 
                    return redirect('admin/users_system_roles');
                }
            } else {
                Session::flash('error', ' No Data Found'); 
                return redirect('admin/users_system_roles');
            }
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- DELETE SYSTEM USERS ROLES -------------- //

    // ------------- MANAGE SYSTEM  ABOUT US -------------- //
    public function system_about_us(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'system_about_us';
            $system_settings = DB::table('system_settings')->get();
            return view('admin.system_about_us', compact('system_settings','page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE SYSTEM ABOUT US -------------- //

    // ------------- MANAGE SYSTEM TERMS -------------- //
    public function system_terms(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'system_terms';
            $system_settings = DB::table('system_settings')->get();
            return view('admin.system_terms', compact('system_settings','page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE SYSTEM TERMS -------------- //

    // ------------- MANAGE SYSTEM PRIVACY -------------- //
    public function system_privacy(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'system_privacy';
            $system_settings = DB::table('system_settings')->get();
            return view('admin.system_privacy', compact('system_settings','page_name'));
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE SYSTEM PRIVACY -------------- //

     // ------------- MANAGE CATEGORY -------------- //
     public function categories_fetch(Request $request){
        if (session()->has('id')) {
            if(empty($request->get('filter'))){
                $categories = DB::table('categories')->orderBy('categories_id', 'DESC')->get();
            } else {
                $categories = DB::table('categories')->where('status', $request->get('filter'))->orderBy('categories_id', 'DESC')->get();
            }

            $filter = $request->get('filter');
            return response()->json([
                'categories'=>$categories,
                'filter'=>$filter,
            ]);
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE CATEGORY -------------- //

    // ------------- MANAGE CATEGORY PAGE -------------- //
    public function categories(){
        if (session()->has('id')) {
            return view('admin.categories');
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE CATEGORY PAGE -------------- //

    // ------------- UPDATE CATEGORY -------------- //
    public function category_update(Request $req){
        $update_array['status'] = $req->status; 
        $updated = DB::table('categories')->where('categories_id', $req->categories_id)->update($update_array);
            if ($updated) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Data Updated successfully";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- UPDATE CATEGORY -------------- //

    // ------------- DELETE CATEGORY -------------- //
    public function category_delete(Request $req){
            if($req->categories_id){
                $checkdata = DB::table('categories')->where('categories_id', $req->categories_id)->where('status', '!=','Deleted')->first();

                if($checkdata){
                    $del=DB::table('categories')->where('categories_id', '=', $req->categories_id)->update(array( 'status' => 'Deleted'));
                    if($del){
                        $response["code"] = 200;
                        $response["status"] = "success";
                        $response["message"] = "Data Deleted successfully";
                    } else{
                        $response["code"] = 404;
                        $response["status"] = "error";
                        $response["message"] = "Oops! Something went wrong.";
                    }
                } else{
                    $response["code"] = 404;
                    $response["status"] = "error";
                    $response["message"] = "This record is already deleted in status.";
                }
            } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "No Data Found.";
            }
            return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- DELETE CATEGORY -------------- //


    // ------------- MANAGE ADD CATEGORY -------------- //
    public function category_add_data(Request $req){

        if (isset($req->name)) {
            $save_data['name']     = $req->name;
          
            $categories_id = DB::table('categories')->insertGetId($save_data);
            if ($categories_id) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Connect Categoies Added";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
        } else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = 'All fields are required';
        }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- MANAGE ADD CATEGORY -------------- //

    // ------------- MANAGE CATEGORY -------------- //
    public function category_edit($id){
        if (session()->has('id')) {
            $page_name = 'category_edit';
            $category = DB::table('categories')->where('categories_id', $id)->first();
            if ($category) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["data"] = $category;
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Data not found.";
            }
        } else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Oops! Something went wrong.";
        }
        return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- MANAGE CATEGORY -------------- //

     // ------------- MANAGE CATEGORY DATA -------------- //
     public function category_edit_data(Request $req){
        if (isset($req->name) && isset($req->categories_id)) {
            $update_data['name']     = $req->name;

            $updated = DB::table('categories')->where('categories_id', $req->categories_id)->update($update_data);
            if ($updated) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Signature updated successfully!";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
        } else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = 'All fields are required';
        }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
       
    }
    // ------------- MANAGE CATEGORY DATA -------------- //

    // ------------- MANAGE AUTHOR -------------- //
    public function authors_fetch(Request $request){
        if (session()->has('id')) {
            if(empty($request->get('filter'))){
                $authors = DB::table('authors')->orderBy('authors_id', 'DESC')->get();
            } else {
                $authors = DB::table('authors')->where('status', $request->get('filter'))->orderBy('authors_id', 'DESC')->get();
            }

            $filter = $request->get('filter');
            return response()->json([
                'authors'=>$authors,
                'filter'=>$filter,
            ]);
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE AUTHOR -------------- //

    // ------------- MANAGE AUTHOR PAGE -------------- //
    public function authors(){
        if (session()->has('id')) {
            return view('admin.authors');
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE AUTHOR PAGE -------------- //

    // ------------- UPDATE AUTHOR -------------- //
    public function author_update(Request $req){
        $update_array['status'] = $req->status; 
        $updated = DB::table('authors')->where('authors_id', $req->authors_id)->update($update_array);
            if ($updated) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Data Updated successfully";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- UPDATE AUTHOR -------------- //

    // ------------- DELETE AUTHOR -------------- //
    public function author_delete(Request $req){
            if($req->authors_id){
                $checkdata = DB::table('authors')->where('authors_id', $req->authors_id)->where('status', '!=','Deleted')->first();

                if($checkdata){
                    $del=DB::table('authors')->where('authors_id', '=', $req->authors_id)->update(array( 'status' => 'Deleted'));
                    if($del){
                        $response["code"] = 200;
                        $response["status"] = "success";
                        $response["message"] = "Data Deleted successfully";
                    } else{
                        $response["code"] = 404;
                        $response["status"] = "error";
                        $response["message"] = "Oops! Something went wrong.";
                    }
                } else{
                    $response["code"] = 404;
                    $response["status"] = "error";
                    $response["message"] = "This record is already deleted in status.";
                }
            } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "No Data Found.";
            }
            return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- DELETE AUTHOR -------------- //


    // ------------- MANAGE ADD AUTHOR -------------- //
    public function author_add_data(Request $req){
        if (isset($req->name)) {
            $save_data['name']     = $req->name;
            if(isset($req->description)){
                $save_data['description']     = $req->description;
            }
            if(isset($req->image)){ 
                $image = $req->image;
                $prefix = time();
                $img_name = $prefix.'.jpeg';
                $image_path = public_path('uploads/author/').$img_name;
      
                file_put_contents($image_path, base64_decode($image));
                $save_data['image'] = 'uploads/author/'.$img_name;
              }
          
            $authors_id = DB::table('authors')->insertGetId($save_data);
            if ($authors_id) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Author Added";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
        } else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = 'All fields are required';
        }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- MANAGE ADD AUTHOR -------------- //

    // ------------- MANAGE AUTHOR -------------- //
    public function author_edit($id){
        if (session()->has('id')) {
            $page_name = 'author_edit';
            $data = DB::table('authors')->where('authors_id', $id)->first();
            if ($data) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["data"] = $data;
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Data not found.";
            }
        } else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Oops! Something went wrong.";
        }
        return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- MANAGE AUTHOR -------------- //

     // ------------- MANAGE AUTHOR DATA -------------- //
     public function author_edit_data(Request $req){
        if (isset($req->name)) {
            $update_data['name']     = $req->name;
            if(isset($req->description)){
                $update_data['description']     = $req->description;
            }
            if(isset($req->image)){ 
                $image = $req->image;
                $prefix = time();
                $img_name = $prefix.'.jpeg';
                $image_path = public_path('uploads/author/').$img_name;
      
                file_put_contents($image_path, base64_decode($image));
                $update_data['image'] = 'uploads/author/'.$img_name;
              }

            $updated = DB::table('authors')->where('authors_id', $req->authors_id)->update($update_data);
            if ($updated) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Author updated successfully!";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
        } else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = 'All fields are required';
        }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
       
    }
    // ------------- MANAGE AUTHOR DATA -------------- //

    // ------------- MANAGE BOOK -------------- //
    public function books_fetch(Request $request){
        if (session()->has('id')) {
            $books=[];
            if(empty($request->get('filter'))){
                $fetch_data = DB::table('books')->orderBy('books_id', 'DESC')->get();
            } else {
                $fetch_data = DB::table('books')->where('status', $request->get('filter'))->orderBy('books_id', 'DESC')->get();
            }
            foreach ($fetch_data as $key => $data) {
                $data->category=DB::table('categories')->where(['categories_id'=>$data->categories_id,'status'=>'Active'])->first();
                $data->author=DB::table('authors')->where(['authors_id'=>$data->authors_id,'status'=>'Active'])->first();
                $books[]=$data;
            }
            $filter = $request->get('filter');
            return response()->json([
                'books'=>$books,
                'filter'=>$filter,
            ]);
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE BOOK -------------- //

    // ------------- MANAGE BOOK PAGE -------------- //
    public function books(){
        if (session()->has('id')) {
            return view('admin.books');
        } else {
            return redirect('admin/admin');
        }
    }
    // ------------- MANAGE BOOK PAGE -------------- //

    // ------------- UPDATE BOOK -------------- //
    public function book_update(Request $req){
        $update_array['status'] = $req->status; 
        $updated = DB::table('books')->where('books_id', $req->books_id)->update($update_array);
            if ($updated) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Data Updated successfully";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- UPDATE BOOK -------------- //

    // ------------- DELETE BOOK -------------- //
    public function book_delete(Request $req){
            if($req->books_id){
                $checkdata = DB::table('books')->where('books_id', $req->books_id)->where('status', '!=','Deleted')->first();

                if($checkdata){
                    $del=DB::table('books')->where('books_id', '=', $req->books_id)->update(array( 'status' => 'Deleted'));
                    if($del){
                        $response["code"] = 200;
                        $response["status"] = "success";
                        $response["message"] = "Data Deleted successfully";
                    } else{
                        $response["code"] = 404;
                        $response["status"] = "error";
                        $response["message"] = "Oops! Something went wrong.";
                    }
                } else{
                    $response["code"] = 404;
                    $response["status"] = "error";
                    $response["message"] = "This record is already deleted in status.";
                }
            } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "No Data Found.";
            }
            return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- DELETE BOOK -------------- //


    // ------------- MANAGE ADD BOOK -------------- //
    public function book_add_data(Request $req){
        if (isset($req->title) && isset($req->book)  && isset($req->categories_id) && isset($req->authors_id) && isset($req->pages)) {
            $save_data['title']     = $req->title;
            $save_data['authors_id']     = $req->authors_id;
            $save_data['categories_id']     = $req->categories_id;
            $save_data['pages']     = $req->pages;
            if(isset($req->book)){ 
                $book = $req->book;
                if ($book->isValid()) {
                    $book_name = time().".".$book->extension();
                    $book_path = public_path('uploads/book/');
                    if($book->move($book_path, $book_name)){
                        $save_data['book_url'] = 'uploads/book/'.$book_name;
                    }
                }
              }
            if(isset($req->cover)){ 
                $cover = $req->cover;
                if ($cover->isValid()) {
                    $cover_name = time().".".$cover->extension();
                    $cover_path = public_path('uploads/cover/');
                    if($cover->move($cover_path, $cover_name)){
                        $save_data['cover'] = 'uploads/cover/'.$cover_name;
                    }
                }
              }
          
            $books_id = DB::table('books')->insertGetId($save_data);
            if ($books_id) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Book Added";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
        } else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = 'All fields are required';
        }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- MANAGE ADD BOOK -------------- //

    // ------------- MANAGE BOOK -------------- //
    public function book_edit($id){
        if (session()->has('id')) {
            $page_name = 'book_edit';
            $data = DB::table('books')->where('books_id', $id)->first();
            if ($data) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["data"] = $data;
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Data not found.";
            }
        } else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Oops! Something went wrong.";
        }
        return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- MANAGE BOOK -------------- //

     // ------------- MANAGE BOOK DATA -------------- //
     public function book_edit_data(Request $req){
        if (isset($req->title) && isset($req->categories_id) && isset($req->authors_id) && isset($req->pages)) {
            $update_data['title']     = $req->title;
            $update_data['authors_id']     = $req->authors_id;
            $update_data['pages']         = $req->pages;
            $update_data['categories_id']     = $req->categories_id;
            if(isset($req->book)){ 
                $book = $req->book;
                if ($book->isValid()) {
                    $book_name = time().".".$book->extension();
                    $book_path = public_path('uploads/book/');
                    if($book->move($book_path, $book_name)){
                        $update_data['book_url'] = 'uploads/book/'.$book_name;
                    }
                }
              }
            if(isset($req->cover)){ 
                $cover = $req->cover;
                if ($cover->isValid()) {
                    $cover_name = time().".".$cover->extension();
                    $cover_path = public_path('uploads/cover/');
                    if($cover->move($cover_path, $cover_name)){
                        $update_data['cover'] = 'uploads/cover/'.$cover_name;
                    }
                }
              }

            $updated = DB::table('books')->where('books_id', $req->books_id)->update($update_data);
            if ($updated) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Book updated successfully!";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
        } else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = 'All fields are required';
        }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
       
    }
    // ------------- MANAGE BOOK DATA -------------- //
}