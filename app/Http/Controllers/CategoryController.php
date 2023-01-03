<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Validator;


class CategoryController extends Controller
{

 public function allcat()
    {
        $cat = Category::all();
        if($cat->isEmpty()){
        return response()->json([
            'success' => true,
            'message' => 'Category Not Found Done.',
            // 'data' => $Items

        ], 404);        
        }
        return response()->json([
            'success' => true,
            'message' => 'Category Fetch Successfully Done.',
            'data' => $cat

        ], 200);
        
    }

public function store(Request $request)
    {
   
        $input = $request->all();
        $validator = Validator::make($input, [
          
            'category'=>'required|string',
            'category_min_quantity' => 'required|string',
            'category_max_quantity' => 'required|string',
    ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ]);
        }  

            $cat = new Category();
            $cat->category=$request->category;
            $cat->category_min_quantity=$request->category_min_quantity;
            $cat->category_max_quantity=$request->category_max_quantity;
            $cat->save();

        return response()->json([
            'success' => true,
            'message' => 'Category Details Added Successfully.',            
        ], 200);

         }

    public function show_single_category(Request $request , $id)
    {
         $cat = Category::where('id',$id)->get();
      // $ids = $request->input('ids', []); // via injected instance of Request
      // $items1 = items::whereIn('id', explode(',', $id))->get();
      // $items1 = items::whereIn('id', explode(',', $id->$request->get()));
        
        if ($cat->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'Category Details Not Found'
            ], 404);
        }

        return response()->json([
                'success' => true,
                'message' => 'Category Details Found',
                'Category' => $cat
            ], 200);

      
    }
      
     public function update_category(Request $request , $id)
    {
          $cat = new Category();
            $cat = Category::find($id);
            
            if(!$cat->isEmpty()){

            $cat->category=$request->category;
            $cat->category_min_quantity=$request->category_min_quantity;
            $cat->category_max_quantity=$request->category_max_quantity;
            $cat->save();
            
            
            
            return response()->json([
            'success' => true,
            'message' => 'Category Details Updated Successfully.'
        ], 200);

            }
             return response()->json([
            'success' => true,
            'message' => 'Category Details Not Found .'
        ], 404);
            
         } 



        public function destroy_cat($id)
          {
        $delete_cat = Category::find($id);
    
        $delete_cat->delete();
 
        return response()->json([
            'success' => true,
            'message' => 'Category Remove Successfully Done.'
        ], 200);
    

}
}