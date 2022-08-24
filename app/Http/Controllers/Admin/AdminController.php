<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    

    public function DashBoard() {
        $totalPost = Post::query()->count('id');
        $totalUser = User::query()->count('id');
        $totalCategory = Category::query()->count('id');
        $users = User::query()
        ->where('id','<>',auth()->user()->id)
        ->get(['avatar','id','name']);
        return view('admin.dashboard.index',[
            'totalPost' => $totalPost,
            'totalUser' => $totalUser,
            'totalCategory' => $totalCategory,
            'users' => $users,
        ]);
    }
    public function getDataChart($tableName) {
        //SELECT MONTH(users.created_at) as month,COUNT(users.id) as total FROM users
        // WHERE YEAR(users.created_at) = YEAR(NOW())
        // GROUP BY MONTH(users.created_at);
        // $model;
        switch ($tableName) {
            case 'User':
                $model = new User();
                break;
            
            case 'Post':
                $model = new Post();
                break;
            
            case 'Category':
                $model = new Category();
                break;
            
            default:
                break;
        }
        $data = $model::query()
        ->select(DB::raw('MONTH(created_at) as month,COUNT(id) as total'))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw('MONTH(created_at)')) 
        ->get();

        $arrResult = [];
        for ($i = 1 ; $i <= date('m') ; $i++) { 
            $arrResult['T'.$i] = 0;
        }
        foreach ($data as $value) {
            $arrResult['T'.$value->month] = (int)$value->total;
        }
        return response()->json($arrResult,200);
    }
    
    public function Users() {
        $users = User::query()
            ->OrderBy('created_at', 'desc')
            ->get();
        return view('admin.user.index', [
            'users' => $users,
        ]);
    }

    public function Profile() {
        $id = auth()->user()->id;
        $user = User::query()
                ->where('id',$id)
                ->first();
        return view('admin.profile.index',[
            'user' => $user
        ]);
    }
}
