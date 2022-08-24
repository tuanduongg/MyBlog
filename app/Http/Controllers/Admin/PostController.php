<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $model;
    public function __construct()
    {
        $this->model = new Post();
    }
    public function index(Request $request)
    {
        $search = $request->get('q');
        $posts = $this->model::query()
            ->select([
                'posts.tittle',
                'posts.id',
                'posts.tags',
                'posts.category_id',
                'posts.created_at',
                'users.name',
                'categories.ct_name',
            ])
            ->leftJoin('users', 'posts.author_id', '=', 'users.id')
            ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
            ->where('posts.tittle', 'like', '%' . $search . '%')
            ->OrderBy('created_at', 'DESC')
            ->paginate(12);
        $posts->appends([
            'q' => $search,
        ]);
        $request->session()->flash('q', $search);
        return view('admin.post.index', [
            'posts' => $posts,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->getAllCategories();
        return view('admin.post.create', [
            'categories' => $categories,
        ]);
    }

    public function getAllCategories()
    {
        $categories = Category::query()
            ->OrderBy('created_at', 'DESC')
            ->get(['ct_name', 'id']);
        return $categories;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tittle' => 'bail|required',
            'content' => 'required',
            'slug' => 'required|unique:posts',
            'tags' => 'required',
            'category_id' => 'required',
            'thumbnail' => 'required',
        ]);
        $post = new Post();
        $image = $request->file('thumbnail');
        $new_name = date('YmdHi') . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('public\uploads\posts'), $new_name);
        $post->thumbnail = $new_name;
        $post->tittle = $request->input('tittle');
        $post->content = $request->input('content');
        $post->slug = $request->input('slug');
        $post->tags = $request->input('tags');
        $post->category_id = $request->input('category_id');
        $post->author_id = auth()->user()->id;
        $post->save();
        return redirect()->back()
            ->with('success', 'Tạo Bài Đăng Thành Công.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->model::query()
                ->findOrFail($id);

        $categories = $this->getAllCategories();
        return view('admin.post.edit', [
            'categories' => $categories,
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tittle' => 'required',
            'content' => 'required',
            'slug' => 'required',
            'tags' => 'required',
            'category_id' => 'required',
        ]);
        $post = $this->model::query()->findOrFail($id);
        if ($request->hasFile('thumbnail')) {
            if($post->thumbnail != 'thumbnail.jpg') {
                $link = '\\' . $post->thumbnail;
                unlink(public_path('public\uploads\posts' . $link . ''));
            }
            $image = $request->file('thumbnail');
            $new_name = date('YmdHi') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('public\uploads\posts'), $new_name);
            $post->thumbnail = $new_name;
        }
        $post->tittle = $request->input('tittle');
        $post->content = $request->input('content');
        $post->slug = $request->input('slug');
        $post->tags = $request->input('tags');
        $post->category_id = $request->input('category_id');
        // $post->author_id = auth()->user()->id;
        $post->save();
        return redirect()->back()
            ->with('success', 'Sửa Bài Đăng Thành Công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $post = $this->model::query()->findOrFail($id);
        if($post->thumbnail != 'thumbnail.jpg') {
            $link = '\\' . $post->thumbnail;
            unlink(public_path('public\uploads\posts' . $link . ''));
        }
        $post->delete();
        return response()->json(['success', 'Xoá Bài Đăng Thành Công !'],200);
    }


    public function FindTags(Request $request)
    {
        $tag = $request->get('q');
        $tags = Post::query()

            ->where('tags', 'like', '%' . $tag . '%')
            ->pluck('tags');

        return response()->json($tags);
    }


    public function UpLoadPhotoCkEditor(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move('public/uploads/ckeditor', $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/uploads/ckeditor/' . $fileName);
            $msg = 'Tải ảnh thành công!';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum,'$url','$msg');</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
    public function filebrowser(Request $request)
    {
        $paths = glob(public_path('public/uploads/ckeditor/*'));
        $fileNames = array();
        foreach ($paths as $path) {
            array_push($fileNames, basename($path));
        }
        $data = array(
            'fileNames' => $fileNames
        );
        return view('admin.file_browser')->with($data);
    }
}
