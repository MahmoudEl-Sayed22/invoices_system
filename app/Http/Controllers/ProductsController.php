<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Sections::all();
        $products = products::all();
        return view('products.products',compact('sections','products'));
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
    public function store(Request $request)
    {
        $validationData = $request->validate([
            'Product_name' => 'required|unique:products|max:255',
            'description' => 'required',
        ],[
            'Product_name.required' => 'يرجى ادخال اسم المنتج',
            'Product_name.unique' => 'اسم المنتج مكرر مسبقا',
            'description.required' => 'يرجى ادخال الوصف الخاص بالمنتج'
        ]);
        $input = $request->all();
        $b_exists = products::where('product_name','=', $input['Product_name'])->exists();
        if($b_exists){
            session()->flash('Error','خطأ القسم غير صحيح');
            return redirect('/products');
        }else{
            products::create([
                'product_name'=>$request->Product_name,
                'description'=>$request->description,
                 'section_id'=>$request->section_id,
                // 'created_by'=>(Auth::user()->name),
            ]);
            session()->flash('Add','تم اضافة المنتج بنجاح');
            return redirect('/products');
    // return $request;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;

       $Products = Products::findOrFail($request->id);

       $Products->update([
       'product_name' => $request->product_name,
       'description' => $request->description,
       'section_id' => $id,
       ]);

       session()->flash('Edit','تم تعديل المنتج بنجاح');
       return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
        $product=products::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاج');
        return redirect('/products');
    }
}
