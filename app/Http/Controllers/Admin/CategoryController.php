<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Category();
    }
    public function index(Request $request)
    {
        $search = $request->get('q');
        $categories = $this->model::query()
            ->where('categories.ct_name', 'like', '%' . $search . '%')
            ->OrderBy('created_at', 'DESC')
            ->get();
        // $categories->appends([
        //     'q' => $search,
        // ]);
        $request->session()->flash('q', $search);
        return view('admin.category.index', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'ct_name' => 'required|unique:categories',
            'slug' => 'required|unique:categories',
        ]);
        $category = new Category();
        $category->ct_name = $request->get('ct_name');
        $category->slug = $request->get('slug');
        $category->save();
        return response()->json([
            'category' => $category,
            'message' => "Thêm danh mục thành công!",
        ],200);
    }
    
    public function show($id) {
        $category = $this->model::query()->findOrFail($id);
        return response()->json([
            'category' => $category
        ],200);
    }

    public function update(Request $request,$id) {
        
        $request->validate([
            'ct_name' => 'required',
            'slug' => 'required',
        ]);
        $category = $this->model::query()->findOrFail($id);
        $category->ct_name = $request->get('ct_name');
        $category->slug = $request->get('slug');
        $category->save();
        return response()->json([
            'category' => $category,
            'message' => "Sửa danh mục thành công!",
        ],200);
    }
    public function destroy($id) {
        $category = $this->model::query()->findOrFail($id);
        Post::query()->where('category_id',$id)->delete();
        $category->delete();
        return response()->json([
            'message' => "Xoá danh mục thành công!",
        ],200);
    }
}
