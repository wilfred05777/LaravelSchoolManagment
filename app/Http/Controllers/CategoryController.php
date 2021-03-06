<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function AllCat(){

        // Query builder Join Table
        // $categories = DB::table('categories')
        // ->join('users', 'categories.user_id', 'users.id')
        // ->select('categories.*','users.name')
        // ->latest()->paginate(5);


        //// Eloquent ORM - Read Data
        // $categories = Category::all();
        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);

        //// Query Builder Read Data
        // $categories = DB::table('categories')->latest()->paginate(5);
        return view('admin.category.index', compact('categories','trashCat'));
    }


    public function AddCat(Request $request){

        $validatedData = $request->validate(
            ['category_name' => 'required|unique:categories|max:255',
            ],
            // CUSTOM VALIDATION MESSAGE
            ['category_name.required' => 'Please Input Category Name']
    );

        // // Eloquent format - insert data
        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        // // Query Builder format - insert data
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success', 'Category Inserted Successfully');
    }

    public function Edit($id){
        // // using Eloquent to update
        // $categories = Category::find($id);

        // // using query builder to update
        $categories = DB::table('categories')->where('id', $id)->first();


        return view('admin.category.edit', compact('categories'));
    }

    public function Update(Request $request, $id){
    // // eloquent
        // $update = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id
        // ]);

    // Query Builder
    $data = array();
    $data['category_name'] = $request->category_name;
    $data['user_id'] =  Auth::user()->id;
    DB::table('categories')->where('id', $id)->update($data);

    return Redirect()->route('all.category')->with('success', 'Category Inserted Successfully');

    }


    public function SoftDelete($id){
        // eloquent
        $delete = Category::find($id)->delete();

        return Redirect()->back()->with('success', 'Category Soft Delete Succesfully');

    }

    public function Restore($id){
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restore Succesfully');
    }

    public function PermanentDelete($id){
        $delete = Category::onlyTrashed()->find($id)->forceDelete();

        return Redirect()->back()->with('success', 'Category Permanently Deleted Succesfully');
    }
}
