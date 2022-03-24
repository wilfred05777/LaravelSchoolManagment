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
}
