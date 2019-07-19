<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;

class HomeController extends Controller
{
   public function index()
   {
   		$categories = Category::all();
   		return view('frontend.pages.content', compact('categories'));
   }
}
