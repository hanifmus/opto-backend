<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'firstName' => 'required|string',
                'lastName' => 'required|string',
                'username' => 'required|string|unique:user,username',
                'email' => 'required|email|unique:user,email',
                'password' => 'required|string|min:6',
                'role' => 'required|string',
                'phone' => 'nullable|string',
                'status' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Generate next staffid
            $latestUser = User::orderBy('staffid', 'desc')->first();
            $nextId = 'stf001';
            
            if ($latestUser) {
                $lastNum = (int)substr($latestUser->staffid, 3);
                $nextNum = $lastNum + 1;
                $nextId = 'stf' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
            }

            $validated['staffid'] = $nextId;

            // Handle image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $validated['img'] = 'images/' . $filename;
            } else {
                $validated['img'] = '';
            }

            $user = User::create($validated);
            return $user;
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'firstName' => 'string',
            'lastName' => 'string',
            'username' => 'string|unique:user,username,' . $id . ',staffid',
            'email' => 'email|unique:user,email,' . $id . ',staffid',
            'password' => 'nullable|string|min:6',
            'role' => 'string',
            'phone' => 'nullable|string',
            'status' => 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->img && file_exists(public_path($user->img))) {
                unlink(public_path($user->img));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validated['img'] = 'images/' . $filename;
        }

        $user->update($validated);
        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Delete image if exists
        if ($user->img && file_exists(public_path($user->img))) {
            unlink(public_path($user->img));
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function login(Request $request)
    {
        try {
            // Get input from JSON body or form data
            $input = $request->all();
            
            // If Content-Type is application/json, parse it directly
            if ($request->isJson()) {
                $input = array_merge($input, $request->json()->all());
            }

            $validator = Validator::make($input, [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            $email = $input['email'];
            $password = $input['password'];

            $user = User::where('email', $email)->first();
            if (! $user) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $passwordMatches = false;
            try {
                $passwordMatches = Hash::check($password, $user->password);
            } catch (\Throwable $ex) {
                // Fallback for non-bcrypt/plain passwords in legacy data: compare directly
                $passwordMatches = ($user->password === $password);
            }

            if (! $passwordMatches) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // store minimal user info in session
            $sessionUser = [
                'staffid' => $user->staffid,
                'firstName' => $user->firstName,
                'lastName' => $user->lastName,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'img' => $user->img,
            ];
            session(['user' => $sessionUser]);

            return response()->json(['user' => $sessionUser, 'role' => $user->role]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function me(Request $request)
    {
        $user = session('user');
        if ($user) {
            return response()->json(['user' => $user]);
        }
        return response()->json(['user' => null], 200);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return response()->json(['message' => 'Logged out']);
    }
}
