<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Category;

class IngredientController extends Controller
{
    public function create(){
        $categorys = Category::all(); 
        return view("Ingredient.create", compact('categorys'));} 

    public function store(Request $request){
        Ingredient::create($request->all());
        return redirect('/ingredient');}

    public function index(){
        return view("Ingredient.index", ["ingredients" => Ingredient::all()]);} 
    
    public function edit(Ingredient $ingredient){
        $categorys = Category::all();
        return view ("Ingredient.edit", ["ingredient"=>$ingredient],compact('categorys'));}
    
    public function update(Request $request, Ingredient $ingredient){
        $ingredient->update($request->all());
        return redirect('/ingredient');}    

     public function show(Ingredient $ingredient){
        return view('Ingredient.show', ['ingredient'=>$ingredient]);}
    
    public function delete(Ingredient $ingredient){
        $ingredient->delete();
        return redirect('/ingredient');}
}
