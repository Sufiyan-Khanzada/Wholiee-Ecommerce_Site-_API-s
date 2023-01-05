<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Validator;


class ProductsController extends Controller
{
    //
     public function allproducts()
    {
        $pro = Products::all();
        if($pro->isEmpty()){
        return response()->json([
            'success' => true,
            'message' => 'Products Not Found Done.',
            // 'data' => $Items

        ], 404);        
        }
        return response()->json([
            'success' => true,
            'message' => 'Products Fetch Successfully Done.',
            'data' => $pro

        ], 200);
        
    }


    public function store(Request $request)
    {
   
        $input = $request->all();
        $validator = Validator::make($input, [
          
            'Product_name'=>'required|string',
            'Product_Category' => 'required|string|exists:Categories,category',
            'Product_Description' => 'required|string',
            'Product_Per_Price'=>'required|string',
            'Product_Available_Qty' => 'required|string',
            'user_id' => 'required|string|exists:users,id',
            'Product_Image' => 'required',
            'Product_status'=> 'string|nullable',
            

    ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ]);
        }  

        $images=$request->file('Product_Image');
        $imageName="";
         $imagepath="https://wholiee.code7labs.com/storage/app/public/uploads/products";


         if($images!=''){


            $newname=rand().'.'.$images->getClientOriginalExtension();
            $images->move('storage/app/public/uploads/pages',$newname);
            $imageName=$imageName.$newname;

            $full_image=$imagepath."/".$imageName;

            $pro = new Products();
            $pro->Product_name=$request->Product_name;
            $pro->Product_Category=$request->Product_Category;
            $pro->Product_Description=$request->Product_Description;

            $pro->Product_Per_Price=$request->Product_Per_Price;
            $pro->Product_Available_Qty=$request->Product_Available_Qty;
            $pro->Product_Description=$request->Product_Description;

            $pro->user_id=$request->user_id;
            $pro->Product_Status="Pending";
            $pro->Product_Description=$request->Product_Description;
             $pro->Product_Image=$input['Product_Image']=$full_image; 
            $pro->save();

        return response()->json([
            'success' => true,
            'message' => 'Products Details Added Successfully.',            
        ], 200);

         }
         else{

            $pro = new Products();

            $pro->Product_name=$request->Product_name;
            $pro->Product_Category=$request->Product_Category;
            $pro->Product_Description=$request->Product_Description;

            $pro->Product_Per_Price=$request->Product_Per_Price;
            $pro->Product_Available_Qty=$request->Product_Available_Qty;
            $pro->Product_Description=$request->Product_Description;

            $pro->user_id=$request->user_id;
            $pro->Product_Status="Pending";
            $pro->Product_Description=$request->Product_Description;
             $pro->Product_Image=$input['Product_Image']=$full_image; 

            $pro->save();

        return response()->json([
            'success' => true,
            'message' => 'Products Details Added Successfully.',            
        ], 200);


         }




}




    public function update_products(Request $request , $id)
    {

        $pro = new Products();
          $pro = Products::find($id);
            
         $images=$request->file('Product_Image');
        $imageName="";
         $imagepath="https://wholiee.code7labs.com/storage/app/public/uploads/products";


         if($images!=''){


            $newname=rand().'.'.$images->getClientOriginalExtension();
            $images->move('storage/app/public/uploads/pages',$newname);
            $imageName=$imageName.$newname;

            $full_image=$imagepath."/".$imageName;  
            $pro->Product_name=$request->Product_name;
            $pro->Product_Category=$request->Product_Category;
            $pro->Product_Description=$request->Product_Description;

            $pro->Product_Per_Price=$request->Product_Per_Price;
            $pro->Product_Available_Qty=$request->Product_Available_Qty;
            $pro->Product_Description=$request->Product_Description;

            $pro->user_id=$request->user_id;
            $pro->Product_Status=$request->Product_Status;
            $pro->Product_Description=$request->Product_Description;
              $pro->Product_Image=$input['Product_Image']=$full_image; 
            $pro->save();
            
            
            
            return response()->json([
            'success' => true,
            'message' => 'Category Details Updated Successfully.'
        ], 200);

            
         } 
     
     else{

            $pro->Product_name=$request->Product_name;
            $pro->Product_Category=$request->Product_Category;
            $pro->Product_Description=$request->Product_Description;

            $pro->Product_Per_Price=$request->Product_Per_Price;
            $pro->Product_Available_Qty=$request->Product_Available_Qty;
            $pro->Product_Description=$request->Product_Description;

           // $pro->user_id=$request->user_id;
            $pro->Product_Status=$request->Product_Status;
            $pro->Product_Description=$request->Product_Description;
          ///   $pro->Product_Image=$input['Product_Image']=$full_image; 

            $pro->save();

        return response()->json([
            'success' => true,
            'message' => 'Products Details Added Successfully.',            
        ], 200);

     }


}
    public function show_single_product(Request $request , $id)
    {
         $pro = Products::where('id',$id)->get();
      // $ids = $request->input('ids', []); // via injected instance of Request
      // $items1 = items::whereIn('id', explode(',', $id))->get();
      // $items1 = items::whereIn('id', explode(',', $id->$request->get()));
        
        if ($pro->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'Products Details Not Found'
            ], 404);
        }

        return response()->json([
                'success' => true,
                'message' => 'Products Details Found',
                'Category' => $pro
            ], 200);

      
    }




 public function destroy_product($id)
          {
        $delete_pro = Products::find($id);
    
        $delete_pro->delete();
 
        return response()->json([
            'success' => true,
            'message' => 'Product Remove Successfully Done.'
        ], 200);
    

}

}
