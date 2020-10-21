<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Str;
use \Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $category = Category::all();
        return view('category', compact('category', $category));
    }

    public function create()
    {
        try{
            $category = Category::create($this->validateReqAndModify());
            return redirect($category->path());
        } catch(QueryException $ex) {
            return redirect('/category')->withErrors('slug', $ex->getMessage());
        }
    }

    public function update(Category $category)
    {
        try{
            $category->update($this->validateReqAndModify());
            return redirect($category->path());
        } catch(QueryException $ex) {
            return redirect('/category')->withErrors('slug', $ex->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect($category->path());
    }

    /**
     * return @mixed
     */
    protected function validateReqAndModify()
    {
        $data = request()->validate([
            'name' => 'required'
        ]);
        $data['slug'] = Str::slug($data['name']);   // ? Not sure about handling this ?
        return $data;
    }
}
