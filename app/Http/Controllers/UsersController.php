<?php

namespace App\Http\Controllers;

use App\Models\Pelanggans;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function indexUsers()
    {
        $users = Pelanggans::all();
        return response()->json(['users' => $users], 200);

    }

    
    public function storeUser(Request $request)
    {
        $user = new Pelanggans;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }


    public function showUser($id)
    {
        $user = Pelanggans::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found!');
        }

        return view('users.show', ['user' => $user]);
    }


    public function updateUser(Request $request, $id)
    {
        $user = Pelanggans::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return response()->json($user);
    }

    
    public function deleteUser($id)
    {
        $user = Pelanggans::find($id);
        $user->delete();
        return response()->json('User deleted successfully');
    }


    public function search(Request $request)
    {
        $search = $request->input('query');
        $users = Pelanggans::where('name', 'LIKE', "%$search%")->get();

        return response()->json([
            'users' => $users
        ]);
    }
}