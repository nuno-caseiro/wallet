<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Resources\Category as CategoryResource;

class CategoryControllerAPI extends Controller
{
    public function index(Request $request){
        if($request->has('page')){
            return CategoryResource::collection(Category::paginate(5));
        }else{
            return CategoryResource::collection(Movement::all());
        }
    }

    public function show($id){
        return new CategoryResource(Category::find($id));
    }

    public function store(Request $request){
        //TODO validacoes e deve ser preciso fazer mais alguma coisa

        $category= new Category();
        $category->fill($request->all());
        $category->save();

        return response()->json(new CategoryResource($category),201);
    }

    public function update(Request $request, $id){
        //TODO validacoes
        $category= Category::findOrFail($id);
        $category->update($request->all());
        return new CategoryResource($category);
    }

    public function destroy($id){
        $movement= Category::findOrFail($id);
        $movement->delete();
        return response()->json(null,204);

    }
}
