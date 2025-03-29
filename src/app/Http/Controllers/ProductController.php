<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::all();
        $perPage = 6;
        $page = Paginator::resolveCurrentPage('page');
        $pageData = $products->slice(($page-1) * $perPage, $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];

        $products = new LengthAwarePaginator($pageData, $products->count(), $perPage, $page, $options);

        return view('list', compact('products'));
    }

    public function search(Request $request)
    {
        $query = Product::query();

        $sort = $request->input('sort');
        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $sort_label = '';
        if ($sort === 'high_price') {
            $query->orderBy('price', 'desc');
            $sort_label = '高い順に表示';
        } elseif ($sort === 'low_price') {
            $query->orderBy('price', 'asc');
            $sort_label = '低い順に表示';
        }

        $products = $query->paginate(6)->appends($request->all());

        $seasons = Season::all();
        
        return view('list', compact('products', 'sort_label', 'seasons'));
    }

    public function getRegister()
    {
        $seasons = Season::all();

        return view('register', compact('seasons'));
    }

    public function upload(ProductRequest $request)
    {
        $path = $request->file('product_image')->store('public/fruits-img');
        $fileName = basename($path);
        $imageUrl = 'fruits-img/' . $fileName;

        $product = Product::create([
            'name' => $request->product_name,
            'price' => $request->product_price,
            'image' => $imageUrl,
            'description' => $request->product_description,
        ]);

        $product->seasons()->sync($request->product_season);

        return redirect('/products');
    }

    public function getDetail($productId)
    {
        $product = Product::find($productId);
        $seasons = Season::all();

        return view('detail', compact('product', 'seasons'));
    }

    public function update(ProductRequest $request, $productId)
    {
        $product = Product::find($productId);

        $updateData = [
            'name' => $request->product_name,
            'price' => $request->product_price,
            'description' => $request->product_description
        ];

        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('public/fruits-img');
            $fileName = basename($path);
            $updateData['image'] = 'fruits-img/' . $fileName;
        }

        $product->update($updateData);

        $product->seasons()->sync($request->product_season);

        return redirect('/products');
    }

    public function delete($productId)
    {
        $product = Product::find($productId);

        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }

        $product->delete();

        return redirect('/products');
    }
}