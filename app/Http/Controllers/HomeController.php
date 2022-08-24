<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCategoryApi;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    private $model;
    private $strQuery;
    public function __construct()
    {
        $this->model = new Post();
        $this->strQuery = $this->model::query()
            ->select([
                'posts.thumbnail',
                'posts.slug',
                'posts.tittle',
                'posts.tags',
                'posts.created_at',
                'users.name',
                'users.avatar',
            ])
            ->OrderBy('created_at', 'DESC');
    }
    public function index(Request $request)
    {
        $search = $request->get('q');
        $posts = $this->strQuery
            ->where('posts.tittle', 'like', '%' . $search . '%')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->paginate(8);
        $posts->appends([
            'q' => $search,
        ]);
        $request->session()->flash('q', $search);
        return view('client.home', [
            'posts' => $posts,

        ]);
        //         SELECT posts.thumbnail,posts.slug,posts.tittle,posts.created_at,users.name,users.avatar,(SELECT COUNT(comments.cmt_content)  FROM comments WHERE comments.post_id = posts.id  ) as total_cmt FROM `posts`
        // JOIN users on users.id = posts.author_id
        // WHERE posts.id = 2
    }

    public function GetSuggestPosts()
    {
        $posts = $this->model::query()
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->select(['posts.tittle', 'posts.created_at','posts.thumbnail'])
            ->take(3)
            ->inRandomOrder()
            ->get();
        return response()->json($posts, 200);
    }

    public function GetRelatedPosts($categoryId,$postId)
    {
        $posts = $this->strQuery
            ->where([
                ['category_id', '=', $categoryId],
                ['posts.id', '<>', $postId],
            ])
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->take(3)
            ->get();
        return $posts;
    }

    public function ShowPost($slug)
    {
        $post = $this->model::query()
            ->where('slug', $slug)
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->select([
                'posts.*',
                'users.name',
                'users.avatar'
            ])
            ->first();

        $category_name = Category::query()
            ->select(['ct_name', 'slug'])
            ->where('id', $post->category_id)
            ->first();

        $relatedPosts = $this->GetRelatedPosts($post->category_id,$post->id);

        return view('client.post', [
            'post' => $post,
            'category_name' => $category_name,
            'relatedPosts' => $relatedPosts,
        ]);
    }

    public function GetAllCategory(RequestCategoryApi $request)
    {
        //SELECT COUNT(posts.id) as total_post,categories.ct_name FROM `posts`
        // JOIN categories on category_id = categories.id
        // GROUP BY categories.ct_name
        $categories = $this->model::query()
            ->join('categories', 'category_id', '=', 'categories.id')
            ->groupBy(['categories.ct_name', 'categories.slug'])
            ->select([
                DB::raw('COUNT(posts.id) as total_post'),
                'categories.ct_name',
                'categories.slug',
            ])
            ->get();
        return response()->json($categories, 200);
    }


    public function ShowPostsCategory($slug)
    {
        try {

            $category = Category::query()
                ->select(['id', 'ct_name'])
                ->where('slug', $slug)
                ->first();
            // $categoryId = $category[0]->id;
            // $categoryName = $category[0]->name;
            $posts = $this->strQuery
                ->where('posts.category_id', $category->id)
                ->join('users', 'posts.author_id', '=', 'users.id')
                ->paginate(9);
            return view('client.category', [
                'posts' => $posts,
                'categoryName' => $category->ct_name,
            ]);
        } catch (\Throwable $th) {
            return redirect('/');
        }
    }

    public function ShowPostsTag($name)
    {
        try {
            $posts = $this->strQuery
                ->where('posts.tags', 'like', '%' . $name . '%')
                ->join('users', 'posts.author_id', '=', 'users.id')
                ->paginate(9);
            // ->toSql();
            return view('client.tag', [
                'posts' => $posts,
                'tagName' => $name,
            ]);
        } catch (\Throwable $th) {
            return redirect('/');
        }
    }
    public function GetAllTag(RequestCategoryApi $request)
    {
        $arrTemp = [];
        $tags =  $this->model::query()
            ->get('tags');
        foreach ($tags as $tag) {
            $tagName = $tag->tags;
            $arrTag =  explode(',', $tagName);
            foreach ($arrTag as $item) {
                if (!in_array($item, $arrTemp)) {
                    $arrTemp[] = $item;
                }
            }
        }
        // return $arrTemp;
        return response()->json($arrTemp, 200);
    }

    public function ShowContact()
    {
        return view('client.contact');
    }
}
