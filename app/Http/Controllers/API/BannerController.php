<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = banner::all();
        return response()->json([
            'status' => 200,
            'banners' => $banners,
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'img' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        } else {
            $banner = new banner();
            if ($request->hasFile('img')) {
              
                $file = $request->file('img');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/banner/', $filename);
                $banner->img = 'uploads/banner/' . $filename;
            }

            $banner->save();
            return response()->json([
                'status' => 200,
                'message' => 'Banner Đã Được Thêm Mới',
            ]);
        }
    }
    public function edit($id)
    {
        $banner = banner::find($id);
        if ($banner) {
            return response()->json([
                'status' => 200,
                'banner' => $banner,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Banner Id Found',
            ]);
        }
    }
    public function update(Request $request,$id)
    {
        
            $banner = banner::find($id);
            if ($banner) {
      
                if ($request->hasFile('img')) {
                    $path = $banner->img;
                    if(File::exists($path))
                    {
                        File::delete($path);
    
                    }
                    $file = $request->file('img');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() + 1 . '.' . $extension;
                    $file->move('uploads/banner/', $filename);
                    $banner->img = 'uploads/banner/' . $filename;
                }
 
                $banner->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Banner Đã Được Cập Nhật',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Category ID Found',
                ]);
            }
        
    }
    public function destroy($id)
    {
        $banner = banner::find($id);
        if($banner)
        {
            $banner->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Banner Đã Được Xóa Thành Công!',
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No category Id Found',
            ]);
        }
       
    }
}