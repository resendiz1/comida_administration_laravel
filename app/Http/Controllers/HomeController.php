<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ['tortas', 'desayunos', 'comida', 'postres', 'antojitos'];
        $productsByCategory = [];

        foreach ($categories as $category) {
            $productsByCategory[$category] = Product::with('images')
                ->where('category', $category)
                ->where('visible', true)
                ->get();
        }

        return view('home', compact('productsByCategory', 'categories'));
    }
}
