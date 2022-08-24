<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function search(Request $request)
    {
        $search = $request->get('search');
        $role = (int)$request->get('role');
        $query = User::query()
            ->where('name', 'like', '%' . $search . '%');
        if ($role != -1) {
            $query->where('role', $role);
        }
        $users = $query->OrderBy('created_at', 'desc')->get();
        return response()->json($users, 200);
    }

    public function store(UserRequest $request)
    {
        $user = new User();
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $new_name = date('YmdHi') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin\assets\img'), $new_name);
            // $path = 'admin/assets/img/' . $new_name;
            $user->avatar = $new_name;
        }
        $user->name = $request->input('name');
        $user->password = $request->input('password');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->save();
        return response()->json([
            'message' => 'Thêm mới thành công!',
            'user' => $user,
        ], 200);
    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'email' => 'required',
            'name' => 'required',
            'role' => 'required',
        ]);
        $user = User::find($request->input('id'));
        if ($user) {
            if ($request->file('avatar')) {
                if ($user->avatar != 'default-avatar.png') {
                    $link = '\\' . $user->avatar;
                    unlink(public_path('admin\assets\img' . $link . ''));
                }
                $image = $request->file('avatar');
                $new_name = date('YmdHi') . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('admin\assets\img'), $new_name);
                // $path = 'admin/assets/img/' . $new_name;
                $user->avatar = $new_name;
            }
            $user->name = $request->input('name');
            if(!empty($request->input('password'))) {
                $user->password = $request->input('password');
            }
            $user->email = $request->input('email');
            $user->role = $request->input('role');
            $user->save();
            return response()->json([
                'user' => $user,
                'message' => 'Sửa thành công!',
            ], 200);
        }
        return response()->json([
            'error' => 'ID Không hợp lệ!',
        ], 400);
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $user = User::find($request->input('id'));
        Post::query()->where('author_id',$request->get('id'))->delete();
        if ($user) {
            if ($user->avatar != 'default-avatar.png') {
                $link = '\\' . $user->avatar;
                unlink(public_path('admin\assets\img' . $link . ''));
            }
            $user->delete();
            return response()->json([
                'message' => 'Xoá thành công!',
            ], 200);
        }
        return response()->json([
            'error' => 'ID Không hợp lệ!',
        ], 404);
        
    }
}
