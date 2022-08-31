<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductFile;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SecondSubCategory;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //
    public function store_category_data(Request $request){
        logger($request->all());
        // dd($request->all());
        if(!empty($request->photo))
        {
            $file = $request->file('photo');
            $name=uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path() . '/files', $name);
            $getData = $this->getCateData($request,$name);
        }
        else
        {
            $getData = $this->getCateData($request,null);
        }
        Category::create($getData);
        $category = Category::all();
        return response()->json([
            'category' => $category
        ]);
    }
    public function get_category_data()
    {
        $category = Category::all();
        return response()->json([
            'category' => $category
        ]);
    }
    public function store_subcategory_data(Request $request)
    {

        $getSubCategory = $this->getSubCateData($request);
        SubCategory::create($getSubCategory);
        $subcategory = SubCategory::all();
        $result_subcategory = Category::select('categories.category_name','sub_categories.*')
        ->join('sub_categories','categories.id','sub_categories.category_id')
        // ->where('categories.category_id',$request->id)
        ->get();
        logger($result_subcategory);
        return response()->json([
            'subcategory' => $result_subcategory,

        ]);
    }
    public function get_subcategory_data()
    {
        $result_subcategory = Category::select('categories.category_name','sub_categories.*')
        ->join('sub_categories','categories.id','sub_categories.category_id')
        // ->where('categories.category_id',$request->id)
        ->get();
        logger($result_subcategory);
        return response()->json([
            'subcategory' => $result_subcategory,

        ]);
    }
    public function store_second_subcategory_data(Request $request)
    {
        $getSecond = $this->getSecondSub($request);
        SecondSubCategory::create($getSecond);
        $second_sub = SecondSubCategory::select('categories.category_name','sub_categories.subcategory_name','second_sub_categories.*')
        ->join('sub_categories','sub_categories.id','second_sub_categories.subcategory_id')
        ->join('categories','categories.id','sub_categories.category_id')
        ->where('sub_categories.id',$request->subcategory_id)
        ->get();
        logger($second_sub);
        return response()->json([
            'second_sub' => $second_sub,
        ]);
    }
    public function get_second_subcategory_data(Request $request)
    {
        $second_sub = SecondSubCategory::select('categories.category_name','sub_categories.subcategory_name','second_sub_categories.*')
        ->join('sub_categories','sub_categories.id','second_sub_categories.subcategory_id')
        ->join('categories','categories.id','sub_categories.category_id')
        ->where('sub_categories.id',$request->subcate_id)
        ->get();
        logger($second_sub);
        return response()->json([
            'second_sub' => $second_sub,
        ]);
    }
    public function store_product_data(Request $request)
    {
        logger($request->pic);
        // logger($request->all());

        $getData = $this->getProductData($request);
        // logger($getData);
        $product = Product::create($getData);
        $set_photo = $product::find($product->id);
        foreach($request->pic as $photo)
        {
            logger($photo);
            if($photo != null)
            {
                logger($photo);
                $file = $photo;
                    $name=uniqid().'_'.$file->getClientOriginalName();
                    $file->move(public_path() . '/files', $name);


                ProductFile::create([
                    'product_id'=>$product->id,
                    'photo' => $name,
                ]);
            }

        }
        return response()->json(['product_id'=>$product->id],200);
    }
    public function get_subcategory_product_data(Request $request)
    {
        $subcategory = SubCategory::where('category_id',$request->cate_id)->get();
        return response()->json([
            'subcategory' => $subcategory,
        ]);
    }
    public function get_sec_subcategory_product_data(Request $request)
    {
        $sec = SecondSubCategory::where('subcategory_id',$request->subcate_id)->get();
        return response()->json([
            'secsubcategory' => $sec,
        ]);
    }
    public function store_each_item_data(Request $request)
    {
            // logger($request->all());
            // logger("what");
           logger(count($request->itemcode));
            for($i=0;$i<count($request->itemcode);$i++)
            {
                $file = $request->itemimage[$i];
                $name=uniqid().'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/files', $name);

                    Item::create([
                        'product_id' => $request->product_id,
                        'item_code' => $request->itemcode[$i],
                        'item_name' =>  $request->itemname[$i],
                        'color' =>  $request->itemcolor[$i],
                        'size' =>  $request->itemsize[$i],
                        'price' =>  $request->itemprice[$i],
                        'photo' => $name
                    ]);
            }
            logger("OK");
            // foreach($arr as $data)
            // {
            //     if(!empty($data->item_image))
            //     {
            //         $file = $request->file('item_image');
            //         $name=uniqid().'_'.$file->getClientOriginalName();
            //         $file->move(public_path() . '/files', $name);
            //     }
            //     Item::create([
            //         'product_id' => $request->product_id,
            //         'item_code' => $data->item_code,
            //         'item_name' =>  $data->item_name,
            //         'color' =>  $data->item_color,
            //         'size' =>  $data->item_size,
            //         'price' =>  $data->item_price,
            //         'photo' => $name
            //     ]);
            // }
            return response()->json("success");
    }
    private function getSecondSub($request)
    {
        return [
            'subcategory_id' => $request->subcategory_id,
            'second_name' => $request->name,
        ];
    }
    private function getSubCateData($request)
    {

        return [

            'subcategory_code' => $request->code,
            'subcategory_name' => $request->name,
            'category_id' => $request->category_id
        ];
    }
    private function getCateData($request,$name)
    {

        return [

            'category_code' => $request->code,
            'category_name' => $request->name,
            'photo' => $name
        ];
    }
    private function getProductData($request)
    {

        return [
            'product_code' => $request->code,
            'product_name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'sub_category_id' =>$request->sub_cate_id,
            'sec_sub_category_id' => $request->sec_sub_cate_id,
            'video_link' => $request->link,
            'long_description' => $request->long
        ];
    }
}
