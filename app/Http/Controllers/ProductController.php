<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return Inertia::render('Products/Index', [
            'products' => Product::orderByTitle()
                ->get()
                ->transform(fn ($product) => [
                    'id' => $product->id,
                    'title' => $product->title,
                    'description' => $product->description,
                    'price' => $product->price,
                    'image' => asset('images/' . ($product->image ?? env('NO_IMAGE_AVAILABLE_PATH', 'no_image.png'))),
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Form', ['action' => 'Create']);
    }

    public function store(Request $request)
    {
        Product::create($request->all());

        return to_route('products.index', [], 303);
    }

    public function edit(Product $product)
    {
        return Inertia::render('Products/Form', [
            'product' => [
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description,
                'price' => (float) $product->price,
                'image' => $product->image ? asset('images/' . $product->image) : null,
            ],
            'action' => 'Edit',
        ]);
    }

    public function update(Product $product, Request $request)
    {
        $product->update($request->all());

        return to_route('products.index', [], 303);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return to_route('products.index', [], 303);
    }
}
