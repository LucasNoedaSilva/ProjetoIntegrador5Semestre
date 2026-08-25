<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function create(){
        return view("Category.create"); } 
    
    public function store(Request $request){
     Category::create($request->all());
        return redirect('/category'); }
    
    public function index(){
        return view("Category.index", ["categories" => Category::all()]);}
    
    public function edit(Category $category){
        return view('Category.edit', ['category'=>$category]);}
    
    public function update(Request $request, Category $category){
        $category->update($request->all());
        return redirect('/category');}

    public function show(Category $category){
        return view('Category.show', ['category'=>$category]);}
    
    public function delete(Category $category){
        Gate::authorize('deletar-registros');
        $category->delete();
        return redirect('/category');}
}
