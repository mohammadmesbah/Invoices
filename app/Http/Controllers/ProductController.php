<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:المنتجات'], ['only' => ['index']]);
        $this->middleware(['permission:اضافة منتج'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:تعديل منتج'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:حذف منتج'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections= Section::all();
        $products= Product::all();
        return view('products.products',compact('products','sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        Product::create([
            'name'=>$request->input('name'),
            'description'=>$request->input('description'),
            'section_id'=>$request->input('section_id')
        ]);
        session()->flash('Add',"تم إضافة المنتج بنجاح");
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, ProductRequest $request)
    {
        $sec_id= Section::where('name',$req->section_name)->first()->id;
        $product= Product::findorFail($req->id);
        $product->update([
            'name'=>$request->input('name'),
            'description'=>$request->input('description'),
            'section_id'=>$sec_id
        ]);
        session()->flash('Edit',"تم تعديل المنتج بنجاح");
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $product= Product::findorFail($request->id);
        $product->delete();
        session()->flash('delete','تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
