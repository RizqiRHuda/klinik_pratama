<?php
namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.user-management');
    }

    public function getUser(Request $request)
    {
        if ($request->ajax()) {
            $user = User::select(['id', 'name', 'email', 'username', 'password', 'role']);

            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $disabled = $row->role === 'super_admin' ? 'disabled' : '';
                    return '<button class="btn btn-primary btn-sm edit" data-id="' . $row->id . '" ' . $disabled . '>Edit</button>
                        <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '" ' . $disabled . '>Hapus</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,user',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password), // Hash password
                'role'     => $request->role,
            ]);

            DB::commit();

            return response()->json(['success' => 'User berhasil ditambahkan!']);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request)
    {
        $id   = $request->id;
        $user = User::find($id);

        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'nullable|string',
            'username' => 'nullable|string',
            'password' => 'nullable|string|min:6',
            'role'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $data = [
                'name'     => $request->name,
                'username' => $request->username,
                'role'     => $request->role,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            DB::commit();
            return response()->json(['message' => 'User updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update user', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (! $user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }

}
