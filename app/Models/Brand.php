<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillabe = [
        'brand_name',
        'brand_image'
    ];

    // /// solves the issue for not updating the image and the text
    //// Call to a member function getClientOriginalExtension() on null -- text issue
    //// Add [brand_name] to fillable property to allow mass assignment on [App\Models\Brand]. - image issue
    protected $guarded = [];

    use HasFactory;
}
