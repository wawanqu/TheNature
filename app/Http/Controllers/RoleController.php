<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('roles.index', compact('users'));
    }

    public function update(Request $request, User $user)
	{
    $request->validate([
        'role' => 'required|string|in:user,admin'
    ]);

    // Jangan izinkan update role untuk super_admin
    if ($user->role === 'super_admin') {
        return redirect()->route('roles.index')->with('error', 'Peran super_admin tidak dapat diubah.');
    }

    $user->role = $request->role;
    $user->save();

    return redirect()->route('roles.index')->with('success', 'Peran berhasil diperbarui!');
	}
}