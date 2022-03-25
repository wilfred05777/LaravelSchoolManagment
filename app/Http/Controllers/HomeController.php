<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Carbon;
use Image;
use Auth;

class HomeController extends Controller
{
    public function HomeSlider(){

        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }


    //// load slider create/store form
    public function AddSlider(){
        return view('admin.slider.create');
    }

    //// Create/Store Fields Sliders: Title , Description, Image
    public function StoreSlider(Request $request){
        // $validatedData =  $request->validate([
        //     'brand_name' => 'required|unique:brands|min:4',
        //     'brand_image' => 'required|mimes: jpg,jpeg,png',
        // ],
        // [
        //     'brand_name.required'=> 'Please Input Brand Name',
        //     'brand_image.max'=> 'Brand longer than 4 Character',

        // ]);

        $slider_image = $request->file('image');


        //// Using Image Intervention Package
        $name_gen = hexdec(uniqid()).'.'.$slider_image->getClientOriginalExtension();
        Image::make($slider_image)->resize(1920,1088)->save('image/slider/'.$name_gen);

        $last_img = 'image/slider/'.$name_gen;

        Slider::insert([
            'title'  => $request->title,
            'description'  => $request->description,
            'image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->route('home.slider')->with('success', 'Slider Inserted Successfully!');
    }

    public function DeleteSlider($id){

        $image = Slider::find($id);
        $old_image = $image->image;

        unlink($old_image);

        Slider::find($id)->delete();
        return Redirect()->back()->with('success', 'Delete Deleted Successfully!');
    }

    public function EditSlider($id){
        $sliders = Slider::find($id);
        return view('admin.slider.edit', compact('sliders'));
    }


    public function UpdateSlider(Request $request, $id){

        $old_image = $request->old_image;

        $image = $request->file('image');

        if($image){
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($image->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;
            $up_location = 'image/slider/';
            $last_img = $up_location.$img_name;
            $image->move($up_location,$img_name);

            unlink($old_image);
            Slider::find($id)->update([
                'title'  => $request->title,
                'description'  => $request->description,
                'image' => $last_img,
                'created_at' => Carbon::now()
        ]);
        return Redirect()->back()->with('success', 'Slider Image Updated Successfully!');
        }else{
            Slider::find($id)->update([
                'title'  => $request->title,
                'description'  => $request->description,
                'created_at' => Carbon::now()
        ]);
        return Redirect()->back()->with('success', 'Slider Title or Description Updated Successfully!');
        }
    }
}
