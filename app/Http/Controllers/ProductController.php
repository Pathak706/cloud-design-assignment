<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Product;

class ProductController extends Controller
{
    private $productRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->middleware('auth');
    }

    public function index()
    {
        $product = $this->productRepository->all();
        return view('product')->with($product);
    }

    public function create()
    {
        $this->validateRequest();
        $product = $this->productRepository->create();
        return redirect('/product');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/product');
    }

    public function update(Product $product)
    {
        $this->validateRequest();
        $product = $this->productRepository->update($product);
        return redirect('/product');
    }

    /**
     * return mixed
     */
    public function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'category' => 'required'
        ]);
    }
}
