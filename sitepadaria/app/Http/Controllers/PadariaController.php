<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PadariaController extends Controller
{
    
    public function index() {
        
        $search = request('search');

        if($search){

            $products = Product::where([
                ['product', 'like', '%'.$search.'%']
            ])->get();

        }   else{

            $products = Product::all();

        }

       

        return view('welcome', ['products'=>$products,'search'=>$search]);
    }

    public function pagecontato() {
        return view('pagecontato');
    }

    public function cadastro() {
        return view('cadastro');
    }

    public function cadastroprodutos() {
        return view('cadastro.cadastroprodutos');
    }
    
    public function store(Request $request){
        $product = new Product;

        $product->product = $request->product;
        $product->description = $request->description;
        $product->qtd = $request->qtd;
        $product->valor = $request->valor;
        $product->codigo = $request->codigo;

        // Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {
            
            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/products'), $imageName);

            $product->image = $imageName;
        }

        $product->save();

        return redirect('cadastro/cadastroprodutos')->with('msg','Produto cadastrado com sucesso!');
    }

    public function show($id) {

        $product= Product::FindOrFail($id);

        return view('cadastro.show',['product'=>$product]);

    }

}
