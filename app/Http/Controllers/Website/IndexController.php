<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
class IndexController extends Controller
{
    public function index(){
        return view('welcome');
    }
    public function about(){
        return view('website.pages.about');
    }
    public function contact(){
        return view('website.pages.contact');
    }
    public function faq(){
        return view('website.pages.faq');
    }
    public function Product(){
        return view('website.pages.product');
    }

    public function opportunity(){
        return view('website.pages.opportunity');
    }
    public function term(){
        return view('website.pages.t&c');
    }
    public function testimonials(){
        return view('website.pages.c_plan');
    }
}
