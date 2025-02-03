<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'sometimes|required|string|max:255', 
            'stock' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'status' => 400,
                'message' => 'validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $product = Product::create($request->only(['name', 'price', 'description', 'stock']));

        return response()->json([
            'success' => true,
            'status' => 201,
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $product
        ]);
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
        $product = Product::find($id);

        if (!$product) {
            return response()->json(
                [
                    'success' => false,
                    'status' => 404,
                    'messages' => 'Product not found'
                ],
                404
            );
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'succes' => false,
                'status' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $product->update($request->only(['name', 'description', 'price', 'stock']));

        return response()->json([
            'success' => true,
            'status' => 201,
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(
                [
                    'success' => false,
                    'status' => 404,
                    'message' => 'Product not found'
                ],
                404
            );
        }

        $product->delete();
        return response()->json(
            [
                'success' => true,
                'status' => 204,
                'message' => 'Product deleted successfully'
            ]
        );
    }
}
