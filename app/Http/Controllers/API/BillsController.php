<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



class BillsController extends Controller
{

    public function index()
    {
        $bills=Bill::all();
        return response()->json([
            'status'=>200,
            'bills'=>$bills,
        ]);
    }

    public function indexGroupBy(Request $request)
    {

        $time_start = $request->input('time_start');
        $time_end = $request->input('time_end');
 
           
        $sql = " SELECT DATE(created_at) AS time_date, SUM(total_price) AS quantity_activity
        FROM bills 
        WHERE status= 2  AND  ( DATE(created_at) >= $time_start AND  DATE(created_at) <= $time_end)
        GROUP BY DATE(created_at)";
     

        $bills = DB::select($sql);
     
        
        // $bills=Bill::select()->;
        return response()->json([
            'status'=>200,
            'bills'=>$bills,
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
   

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        } else {

            $id_user= $request->input('id_user');
            $product_list=$request->input('product_list');
            
            $bill = new Bill();
            $bill->id_user = $request->input('id_user');
            $bill->full_name = $request->input('full_name');
            $bill->andress = $request->input('andress');
            $bill->phone_number = $request->input('mobile_phone');
            // $bill->payment_methods = $request->input('payment_methods');
            $bill->total_price = $request->input('total_price') ;
          
            $bill->save();

      
            $queryidBill= 'SELECT id  FROM `bills` WHERE `id_user` = '.$id_user.' ORDER BY id DESC LIMIT 1';

            // $sql = "SELECT TOP 3 * FROM activities ORDER BY point";
            $id_bill_array= DB::select($queryidBill);
            $id_bill=$id_bill_array[0]->id;


       
            if(!empty($id_bill))
            {
               
              
                foreach($product_list as $key => $value) {

                    $total_price=$value['price'] * $value['quantity'] ;

                    $queryCTDH = 'INSERT INTO `bills_detail` (`id_bill`, `id_product`,`quantity`,`total_price`) VALUE ('.$id_bill.','.$value['idProduct'].','.$value['quantity'].', '.$total_price.')';

                    DB::insert($queryCTDH);

                    // $resultCTDH= mysqli_query($conn, $queryCTDH);
        
                    // $querySoLuong = 'SELECT SoLuong  FROM `sanpham` WHERE `MaSP` = '.$value['maSP'].' ';
                    // $resultSoLuong = mysqli_query($conn, $querySoLuong);
         
                    // while ($row = mysqli_fetch_assoc($resultSoLuong)){
                    //     $SoLuong=$row;
                    // }
        
                    // $SoLuongUpdate=$SoLuong['SoLuong'] - $value['soluong'];
                    // $queryUpdateSoLuong ='UPDATE `sanpham`  SET `SoLuong`='.$SoLuongUpdate.'  WHERE `MaSP` = '.$value['maSP'].' ';
                }
                return response()->json([
                    'status' => 200,
                    'message' =>"Đặt Hàng Thành Công",
                ]);
              
            
            }
        }
    }

    public function getBillsDetail($id)
    {
        $billDetails=BillDetail::where('id_bill',$id)->get();
        return response()->json([
            'status'=>200,
            'billDetails'=>$billDetails,
        ]);
    }
    public function getBillsAllDetail()
    {
        $sql = " SELECT bills_detail.id_product,products.img01,products.name,products.slug, SUM(total_price * quantity) AS price_total , SUM(quantity) AS quantity
        FROM bills_detail ,products
        WHERE bills_detail.id_product = products.id 
        GROUP BY bills_detail.id_product, products.slug, products.name,products.img01 ";
     

        $billDetails = DB::select($sql);
     
        return response()->json([
            'status'=>200,
            'billDetails'=>$billDetails,
        ]);
    }

    public function getBillsUser()
    {

        if(auth('sanctum')->check())
        {
            $id_user=auth('sanctum')->user()->id;
            $billsUser=Bill::where('id_user',$id_user)->get();

              return response()->json([
                  'status'=>200,
                  'billsUser'=>$billsUser,
              ]);
        }
       
    }

    public function getBill($id)

    {
        $bill = Bill::find($id);
        if ($bill) {
            return response()->json([
                'status' => 200,
                'bill' => $bill,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No User Id Found',
            ]);
        }
    }
    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
    

        ]);
        if ($validator->fails()) {   
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),

            ]);
          
        } else {
            $id= $request->input('id_bill');
            $bill = Bill::find($id);
            if($bill)
            {            
                $bill->status = $request->input('status') ; 
    
                $bill->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Thành Công',
                ]);
            }
          
        }
    }

}