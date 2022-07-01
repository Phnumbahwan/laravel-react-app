<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->role == '1') {
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required' 
            ]);
            return Product::create($request->all());
        }else {
            return [
                'message' => 'You need to be admin to enable action.'
            ];
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     return Product::find($id);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(auth()->user()->role == '1') {
            $product = Product::find($id);
            if(!empty($product)) {
                $product->update($request->all());
                return $product;
            }else {
                return [
                    'message' => 'Empty Product.'
                ];
            }
        }else {
            return [
                'message' => 'You need to be admin to enable action.'
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->role == '1') {
            return Product::destroy($id);
        }else {
            return [
                'message' => 'You need to be admin to enable action.'
            ];
        }
    }

    /**
     * Search for a product
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Product::where('name', 'like','%'.$name.'%')->get();
    }
}
