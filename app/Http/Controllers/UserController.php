<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('branch')->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        $roles = ['owner', 'manager', 'supervisor', 'cashier', 'warehouse'];
        return view('users.create', compact('branches', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in(['owner', 'manager', 'supervisor', 'cashier', 'warehouse'])],
            'phone' => 'nullable|string|max:30',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->only(['branch_id', 'name', 'email', 'role', 'phone', 'is_active']);
        $data['branch_id'] = $request->role === 'owner' ? null : $request->branch_id;
        $data['password'] = Hash::make($request->password);

        User::create($data);
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return redirect()->route('users.edit', $user);
    }

    public function edit(User $user)
    {
        $branches = Branch::orderBy('name')->get();
        $roles = ['owner', 'manager', 'supervisor', 'cashier', 'warehouse'];
        return view('users.edit', compact('user', 'branches', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => ['required', Rule::in(['owner', 'manager', 'supervisor', 'cashier', 'warehouse'])],
            'phone' => 'nullable|string|max:30',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->only(['branch_id', 'name', 'email', 'role', 'phone', 'is_active']);
        $data['branch_id'] = $request->role === 'owner' ? null : $request->branch_id;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Akun yang sedang login tidak boleh dihapus.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
