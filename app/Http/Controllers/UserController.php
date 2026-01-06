<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'sometimes|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
        ]);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|string',
        ]);

        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('password')) $user->password = Hash::make($request->password);
        if ($request->has('role')) $user->role = $request->role;

        $user->save();

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
    public function profile(Request $request)
{
    return response()->json($request->user());
}

public function updateProfile(Request $request)
{
    $user = $request->user();

    $request->validate([
        'name' => ['sometimes', 'string', 'max:255'],
        'email' => [
            'sometimes',
            'email',
            Rule::unique('users', 'email')->ignore($user->id),
        ],
        'password' => ['sometimes', 'string', 'min:6', 'confirmed'],
        // password_confirmation is required only when password is sent
    ]);

    if ($request->filled('name')) $user->name = $request->name;
    if ($request->filled('email')) $user->email = $request->email;
    if ($request->filled('password')) $user->password = Hash::make($request->password);

    $user->save();

    return response()->json([
        'message' => 'Profile updated',
        'user' => $user,
    ]);
}

public function deleteAccount(Request $request)
{
    $user = $request->user();

    // Optional: require password for safety (recommended)
    $request->validate([
        'password' => ['required', 'string'],
    ]);

    if (!Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Password is incorrect'], 403);
    }

    // If you have relations, you can delete/cleanup here if needed
    // Example: $user->problems()->delete();

    $user->delete();

    return response()->json(['message' => 'Account deleted']);
}

}


