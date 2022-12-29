<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\infoshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class InfoShopController extends Controller
{
    public function getInfoShop()
    {
     
        $infoshop = infoshop::find(1);
        // $infoshop =  DB::table('infoshop')->limit(1)->get();; 
        if ($infoshop) {
            return response()->json([
                'status' => 200,
                'infoshop' => $infoshop,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Info Id Found',
            ]);
        }
    }
    public function update(Request $request)
    {
        
            $infoshop = infoshop::find(1);
 
            if ($infoshop) {
                $infoshop->mobile_phone = $request->input('mobile_phone');
                $infoshop->andress = $request->input('andress');
                $infoshop->header_sale = $request->input('header_sale');
                $infoshop->coppyright = $request->input('coppyright');
                $infoshop->email = $request->input('email');

                $infoshop->link_fb = $request->input('link_fb');
                $infoshop->link_gg_plus = $request->input('link_gg_plus');
                $infoshop->link_pinterest = $request->input('link_pinterest');
                $infoshop->link_instagram = $request->input('link_instagram');

                if ($request->hasFile('logo')) {
                    $path = $infoshop->logo;
                    if(File::exists($path))
                    {
                        File::delete($path);
                    }
                    $file = $request->file('logo');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() + 1 . '.' . $extension;
                    $file->move('uploads/logo/', $filename);
                    $infoshop->logo = 'uploads/logo/' . $filename;
                }
 
                $infoshop->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Đã Được Cập Nhật',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Category ID Found',
                ]);
            }
        
    }
}