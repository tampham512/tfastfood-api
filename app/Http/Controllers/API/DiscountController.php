<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;



use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::all();
        return response()->json([
            'status' => 200,
            'discounts' => $discounts,
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'idDiscount' => 'required|unique:discounts',
            'value' => 'required',
            'unit' => 'required',
            'quatity' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        } else {
            $discount = new Discount();

  
            $discount->idDiscount = $request->input('idDiscount');
            $discount->value = $request->input('value');
            $discount->unit = $request->input('unit');
            $discount->time_start = $request->input('time_start');
            $discount->time_end = $request->input('time_end');
      
            $discount->quatity = $request->input('quatity');

            $discount->save();
            return response()->json([
                'status' => 200,
                'message' => 'Banner Đã Được Thêm Mới',
            ]);
        }
    }
    public function edit($id)
    {
        $discount = Discount::find($id);
        if ($discount) {
            return response()->json([
                'status' => 200,
                'discount' => $discount,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Discount Id Found',
            ]);
        }
    }
    public function update(Request $request,$id)
    {
        
            $discount = Discount::find($id);
            if ($discount) {
                $discount->idDiscount = $request->input('idDiscount');
                $discount->value = $request->input('value');
                $discount->unit = $request->input('unit');
                $discount->time_start = $request->input('time_start');
                $discount->time_end = $request->input('time_end');
                $discount->quatity = $request->input('quatity');
               
                $discount->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Mã Giảm Giá Đã Được Cập Nhật',
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
        $discount = Discount::find($id);
        if($discount)
        {
            $discount->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Mã Giảm Giá Đã Được Xóa Thành Công!',
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No discount Id Found',
            ]);
        }
       
    }
}