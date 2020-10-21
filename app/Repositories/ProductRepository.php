<?php

namespace App\Repositories;

use App\Product;
use App\Category;

class ProductRepository
{
    public function all()
    {
        $category = Category::all();
        $product;
        if (request()->input('filter')) {
            switch (request()->input('filter')) {
                case 'all':
                    $product = Product::all();
                break;
                case 'duplicate':
                    $product = $this->duplicateProduct();
                break;
                default:
                    $product = Product::all();
                break;
            }
        } else {
            $product = Product::all();
        }
        return array('product' => $product, 'category' => $category, 'filter' => request()->input('filter') ?? 'all');
    }

    public function create()
    {
        return Product::create([
            'name' => request()->input('name'),
            'qty' => request()->input('qty'),
            'price' => request()->input('price'),
            'category' => request()->input('category'),
            'image_uri' => $this->moveFile(),
        ]);
    }

    public function moveFile()
    {
        $imageName = request()->input('image_uri');
        if (request()->hasfile('image_uri')) {
            $file = request()->file($imageName)['image_uri'];
            $filename = time().'-'.$file->getClientOriginalName();
            $file->move('uploads/', $filename);
            return $filename;
        }
        return null;
    }
    
    public function update($product)
    {
        return $product->update([
            'id' => $product->id,
            'name' => request()->input('name'),
            'qty' => request()->input('qty'),
            'price' => request()->input('price'),
            'category' => request()->input('category'),
            'image_uri' => $this->moveFile() ?? $product->image_uri,
        ]);
    }

    public function duplicateProduct()
    {
        $product = Product::groupBy('name')
                        ->havingRaw('COUNT(*) > 1')
                        ->get();
        return $product;
    }
}
