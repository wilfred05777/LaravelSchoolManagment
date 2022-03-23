<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // $img_ext = strtolower($brand_image->guessExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

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
            'created_at' => Carbon::now()]);
            return Redirect()->back()->with('success', 'Brand Updated Successfully!');

        // if($brand_image){
        //     $name_gen = hexdec(uniqid());
        //     $img_ext = strtolower($brand_image->getClientOriginalExtension());
        //     $img_name = $name_gen.'.'.$img_ext;
        //     $up_location = 'image/brand/';
        //     $last_img = $up_location.$img_name;
        //     $brand_image->move($up_location,$img_name);

        //     unlink($old_image);
        //     Brand::find($id)->update([
        //         'brand_name'  => $request->brand_name,
        //         'brand_image' => $last_img,
        //         'created_at' => Carbon::now()
        // ]);
        // return Redirect()->back()->with('success', 'Brand Updated Successfully!');
        // }else{
        //     Brand::find($id)->update([
        //         'brand_name'  => $request->brand_name,
        //         'created_at' => Carbon::now()
        // ]);
        // return Redirect()->back()->with('success', 'Brand Updated Successfully!');
        // }


    }


    public function Delete($id){

        $image = Brand::find($id);
        $old_image = $image->brand_image;

        unlink($old_image);

        Brand::find($id)->delete();
        return Redirect()->back()->with('success', 'Brand Deleted Successfully!');
    }
}
