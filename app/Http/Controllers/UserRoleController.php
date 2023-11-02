<?php
namespace App\Http\Controllers;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        $userRoles = UserRole::with('user', 'role')->get();
        return response()->json($userRoles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $userRole = UserRole::create([
            'user_id' => $request->user_id,
            'role_id' => $request->role_id,
        ]);

        return response()->json($userRole, 201);
    }

    public function update(Request $request, UserRole $userRole)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $userRole->update([
            'user_id' => $request->user_id,
            'role_id' => $request->role_id,
        ]);

        return response()->json(['message' => 'User role updated successfully']);
    }

    public function destroy(UserRole $userRole)
    {
        $userRole->delete();

        return response()->json(['message' => 'User role deleted successfully']);
    }
}
