<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
   
            if(auth('sanctum')->check())
            {
                $id_user=auth('sanctum')->user()->id;
                $review =new Review;
                $review->id_user =  $id_user;
                $review->id_product =$request->input('id_product');
                $review->content =$request->input('content');
                $review->rate_star =$request->input('rate_star');
                $review->save();
                return response()->json([
                'status'=>200,
                'message'=>'Đánh Giá Thành Công',

            ]);
        }
          
    }
}