<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['products'] = Product::latest()->get();
        $data['invoices']= Invoice::latest()->get();
        return view('product.index', $data);
    }

    public function getProducts()
    {
        $products = Product::with('variants')->get();
        return response()->json($products);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['product_varients'] = ProductVariant::latest()->get();
        return view('product.create', $data);
    }


    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|max:255',
            'unit' => 'required',
            'price' => 'required|array',
            'price.*' => 'required|numeric',
            'description' => 'required|array',
            'description.*' => 'required|string',
        ]);

        // Create a new product
        $product = new Product();
        $product->name = $request->name;
        $product->unit = $request->unit;

        // Save the product
        if ($product->save()) {

            foreach ($request->price as $index => $price) {
                $variant = new ProductVariant();
                $variant->product_id = $product->id;
                $variant->price = $price;
                $variant->description = $request->description[$index];
                $variant->save();
            }
        }

        // Redirect to the product index with success message
        return redirect()->route('product.index')->with('success', 'Product was created');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
