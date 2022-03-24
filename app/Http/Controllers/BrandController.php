<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Multipics;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Image;

class BrandController extends Controller
{
    //

    public function AllBrand(){

        $brands = Brand::latest()->paginate(5);

        return view('admin.brand.index', compact('brands'));
    }

    public function StoreBrand(Request $request){
        $validatedData =  $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes: jpg,jpeg,png',
        ],
        [
            'brand_name.required'=> 'Please Input Brand Name',
            'brand_image.max'=> 'Brand longer than 4 Character',

        ]);

        $brand_image = $request->file('brand_image');

        ////// without Image Intervention Package
        // $name_gen = hexdec(uniqid());
        // $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // // $img_ext = strtolower($brand_image->guessExtension());
        // $img_name = $name_gen.'.'.$img_ext;
        // $up_location = 'image/brand/';
        // $last_img = $up_location.$img_name;
        // $brand_image->move($up_location,$img_name);


        //// Using Image Intervention Package
        $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300,200)->save('image/brand/'.$name_gen);

        $last_img = 'image/brand/'.$name_gen;

        Brand::insert([
            'brand_name'  => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Brand Inserted Successfully!');

    }

    public function Edit($id){
        $brands = Brand::find($id);
        return view('admin.brand.edit', compact('brands'));
    }


    public function Update(Request $request, $id){
        $validatedData =  $request->validate([
            'brand_name' => 'required|min:4',
        ],
        [
            'brand_name.required'=> 'Please Input Brand Name',
            'brand_image.max'=> 'Brand longer than 4 Character',
        ]);

        $old_image = $request->old_image;
        // $brand_image = $request->file('brand_image');
        $brand_image = $request->file('brand_image');


        if($brand_image){
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;
            $up_location = 'image/brand/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);

            unlink($old_image);
            Brand::find($id)->update([
                'brand_name'  => $request->brand_name,
                'brand_image' => $last_img,
                'created_at' => Carbon::now()
        ]);
        return Redirect()->back()->with('success', 'Brand Image Updated Successfully!');
        }else{
            Brand::find($id)->update([
                'brand_name'  => $request->brand_name,
                'created_at' => Carbon::now()
        ]);
        return Redirect()->back()->with('success', 'Brand Name Updated Successfully!');
        }

        // $name_gen = hexdec(uniqid());
        // $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // $img_name = $name_gen.'.'.$img_ext;
        // $up_location = 'image/brand/';
        // $last_img = $up_location.$img_name;
        // $brand_image->move($up_location,$img_name);

        // unlink($old_image);
        // Brand::find($id)->update([
        //     'brand_name'  => $request->brand_name,
        //     'brand_image' => $last_img,
        //     'created_at' => Carbon::now()]);
        //     return Redirect()->back()->with('success', 'Brand Updated Successfully!');




    }


    public function Delete($id){

        $image = Brand::find($id);
        $old_image = $image->brand_image;

        unlink($old_image);

        Brand::find($id)->delete();
        return Redirect()->back()->with('success', 'Brand Deleted Successfully!');
    }


    //// This is for multi Image All Methods
    public function Multipic(){
        $image = Multipics::all();
        return view('admin.multipic.index', compact('image'));
    }

    public function StoreImage(Request $request){

        $image = $request->file('image');



        foreach($image as $multi_image){
            $name_gen = hexdec(uniqid()).'.'.$multi_image->getClientOriginalExtension();
            Image::make($multi_image)->resize(300,300)->save('image/multi/'.$name_gen);

            $last_img = 'image/multi/'.$name_gen;

            Multipics::insert([
                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);
         } // end of foreach

        return Redirect()->back()->with('Success', 'Multi Image Inserted Successfully!');



    }

    public function StoreImg(Request $request){
        $image  = $request->file('name');

        // $name_gen = hexdec(uniqid())

        foreach ($image as $multi_img){
            $name_gen = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension();
            Image::make($multi_img)->resize(300,300)->save('image/multi/'.$name_gen);

            $last_img = 'image/multi'.$name_gen;

            Multipics::insert([
                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);
        }


        return Redirect()->back()->with('Success', 'Multi Image Inserted Successfully');
    }
}
