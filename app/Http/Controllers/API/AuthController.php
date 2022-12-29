<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;





class AuthController extends Controller
    
{

    public function index()
    {
        $user=User::all();
        return response()->json([
            'status'=>200,
            'user'=>$user,
        ]);
    }
    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'username'=>'required|max:255|unique:users,username',
            'email'=>'required|email|max:255|unique:users,email',
            'password'=>'required|min:8',
            'confirm_password'=>'required|min:8|same:password',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }
        else{
            $user = User::create([
                'username'=>$request->username,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),

            ]);
  


            if($user->role_as==2) ///nhanvien
            {
                $token=$user->createToken($user->email.'_Admintoken',['server:admin'])->plainTextToken;
            }
            else if($user->role_as==1) //admin
            {
                $token=$user->createToken($user->email.'_Personneltoken',['server:personnel'])->plainTextToken;

            } 
            else{
                $token=$user->createToken($user->email.'_token',[''])->plainTextToken;
            }
           
            return response()->json([
                'status'=>200,
                'username'=>$user->username,
                'token'=>$token,
                'message'=>'Đăng Kí Thành Công!',
            ]);


        }

    }

    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'username'=>'required|max:255',
            'password'=>'required|min:8',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }
        else{
            $user = User::where('username', $request->username)->first();
            if(!$user)
            {
                $user = User::where('email', $request->username)->first();
            }
    
            if (!$user || !Hash::check($request->password, $user->password)){
                return response()->json([
                    'status'=>401, 
                    'message'=>"Thông Tin Không Hợp Lệ!"
                ]);
                
            }
            else{

                if($user->role_as==2) ///admin
                {
                    $token=$user->createToken($user->email.'_Admintoken',['server:admin'])->plainTextToken;
                }
                else if($user->role_as==1) //personnel
                {
                    $token=$user->createToken($user->email.'_Personneltoken',['server:personnel'])->plainTextToken;

                } 
                else{
                    $token=$user->createToken($user->email.'_token',[''])->plainTextToken;
                }
               
                return response()->json([
                    'status'=>200,
                    'username'=>$user->username,
                    'token'=>$token,
                    'message'=>'Đăng Nhập Thành Công!',
                ]);
            }

        }

    }

    public function logout(Request $request)
    {
      $request->user()->currentAccessToken()->delete();
      return response()->json([
          'status'=>200,
          "message"=>"Đăng Xuất Thành Công!"
      ]);
    }

    public function user()

    {
        if(auth('sanctum')->check())
        {
            $user=auth('sanctum')->user();
         
              return response()->json([
                  'status'=>200,
                  "user"=>$user
              ]);
        }
       
    
    }
   

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username_input'=>'required|max:255|unique:users,username',
            'email_input'=>'required|email|max:255|unique:users,email',
            'password_input'=>'required|min:8',
            'password_confirm'=>'required|min:8|same:password_input',
            'role_as' => 'required|numeric',       

        ]);
        if ($validator->fails()) {
            
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),

            ]);
          
        } else {
            $user = new User();
            $user->username = $request->input('username_input');
            $user->email = $request->input('email_input');
            $user->password = Hash::make($request->input('password_input'));
            $user->role_as = $request->input('role_as');
            $user->full_name = $request->input('full_name');
           
            $user->phone_number = $request->input('phone_number');
            $user->andress = $request->input('andress');
            $user->date_birth =$request->input('date_birth');
            $user->gender = $request->input('gender');
            $user->status = $request->input('status');   
            
       
            if ($request->hasFile('avata')) {          
                $file = $request->file('avata');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/userAvata/', $filename);
                $user->avata = 'uploads/userAvata/' . $filename;
            }
            $user->save();
            return response()->json([
                'status' => 200,
                'message' => 'Thêm Người Dùng Thành Công',
            ]);
        }
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'username'=>'required|max:255|',
            'email'=>'required|email|max:255|',
            'password'=>'required|min:8',
            'role_as' => 'required|numeric',       

        ]);
        if ($validator->fails()) {   
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),

            ]);
          
        } else {
            $user = User::find($id);
            if($user)
            {
                $user->username = $request->input('username');
                $user->email = $request->input('email');
                if($request->input('password') != $user->password)
                {
                    $user->password =Hash::make($request->input('password'));
                }
                $user->role_as = $request->input('role_as');
                $user->full_name = $request->input('full_name')=='null'? null:$request->input('full_name');
               
                $user->phone_number = $request->input('phone_number')=='null'? null:$request->input('phone_number');
                $user->andress = $request->input('andress')=='null'? null:$request->input('andress');
                $user->date_birth = $request->input('date_birth')=='null'? null:$request->input('date_birth');
                $user->gender = $request->input('gender');
                $user->status = $request->input('status');   
    
           
                if ($request->hasFile('avata')) {     
                    $path = $user->avata;
                    if(File::exists($path))
                    {
                        File::delete($path);
    
                    }
                    

                    $file = $request->file('avata');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/userAvata/', $filename);
                    $user->avata = 'uploads/userAvata/' . $filename;
                }
                $user->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Cập Nhập Người Dùng Thành Công!',
                ]);
            }
          
        }
    }

    public function updateUser(Request $request)
    {

        if(auth('sanctum')->check())
        {
            $id=auth('sanctum')->user()->id;
            $user = User::find($id);

            $user->full_name = $request->input('full_name')=='null'? null:$request->input('full_name');
           
            $user->phone_number = $request->input('mobile_phone')=='null'? null:$request->input('mobile_phone');
            $user->andress = $request->input('andress')=='null'? null:$request->input('andress');
            $user->date_birth = $request->input('date_birth')=='null'? null:$request->input('date_birth');
            $user->gender = $request->input('gender');

  

           $user->update();
           
            return response()->json([
                'status' => 200,
                'message' => 'Cập Nhật Thông Tin Thành Công!',
            ]);
        }     
    }

    public function resetPassword(Request $request)
    {
        if($request->input('password_new')!= $request->input('password_new_confirm'))
        {
            return response()->json([
                'status' => 400,
                'errors' => 'Mật Khẩu Xác Nhận Không Khớp!',
            ]);
        }
        else{
            if(auth('sanctum')->check())
            {
                
                $id=auth('sanctum')->user()->id;
                $user = User::find($id);
                if( Hash::check($request->password_old, $user->password))
                {
                    $user->password = Hash::make($request->input('password_new')) ;
                    $user->update();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Đổi Mật Khẩu Thành Công!',
                    ]);
                }
                else{
                    return response()->json([
                        'status' => 401,
                        'errors' => "Mật Khẩu Cũ Không Chính Xác!",
        
                    ]);
                }      
            }    
            
        }
    
           
        
    }

    public function edit($id)

    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No User Id Found',
            ]);
        }
    }

    public function destroy($id)
    {
        $user=User::find($id);
        if($user)
        {
            $user->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Đã Xóa Thành Công!',
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No User Id Found',
            ]);
        }
       
    }

}