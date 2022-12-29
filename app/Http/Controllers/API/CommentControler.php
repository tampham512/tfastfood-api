<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ReplyComment;
use Illuminate\Http\Request;

class CommentControler extends Controller
{
    public function store(Request $request)
    {
   
            if(auth('sanctum')->check())
            {
                $id_user=auth('sanctum')->user()->id;
                $comment =new Comment();
                $comment->id_user =  $id_user;
                $comment->id_product =$request->input('id_product');
                $comment->content =$request->input('content');
             
                $comment->save();
                return response()->json([
                'status'=>200,
                'message'=>'Đánh Giá Thành Công',]);
             }
             else{
                return response()->json([
                    'status'=>400,
                    'message'=>'Vui Lòng Đăng Nhập Để Bình Luận',]);
             }
         
        
        

        // 'id',
        // 'id_user',
        // 'id_product',
        // 'content',
          
    }
    public function storeReply(Request $request)
    {
   
            if(auth('sanctum')->check())
            {
                $id_user=auth('sanctum')->user()->id;
                $comment =new ReplyComment();
                $comment->id_user =  $id_user;
                $comment->id_comment =$request->input('id_comment');
                $comment->content =$request->input('content');
             
                $comment->save();
                return response()->json([
                'status'=>200,
                'message'=>'Đánh Giá Thành Công',]);

                // 'id',
                // 'id_user',
                // 'id_comment',
                // 'content',
             }
             else{
                return response()->json([
                    'status'=>400,
                    'message'=>'Vui Lòng Đăng Nhập Để Bình Luận',]);
             }
         
        
        

        // 'id',
        // 'id_user',
        // 'id_product',
        // 'content',
          
    }

    public function index()
    {
        $comments=Comment::all();
        return response()->json([
            'status'=>200,
            'comments'=>$comments,
        ]);
    }

    
}