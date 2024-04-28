<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->whereNull('deleted_at')->paginate(10);

        return view('admin.user-access-management.index', [
            'users' => $users
        ]);
    }

    /**
     * Display the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return back()->with('error_message', 'User tidak ditemukan');
        }

        $roles = config('roles.roles');

        return view('admin.user-access-management.show', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = config('roles.roles');
        return view('admin.user-access-management.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a new resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = [
            'name' => 'required',
            'username' => 'required',
            'role' => 'required',
        ];

        $this->validate($request, $validations);

        if ($request->password != $request->password_confirmation) {
            return redirect()->back()->with('error_message', 'Password tidak cocok');
        }

        try {
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'User gagal ditambahkan');
        }

        return redirect()->back()->with('success_message', 'User berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find($request->user_id);
        if (empty($user)) {
            return redirect()->back()->with('error_message', 'User tidak ditemukan');
        }
        $validations = [
            'name' => 'required',
            'username' => 'required',
            'role' => 'required',
        ];

        $this->validate($request, $validations);

        if (!empty($request->password)) {
            if ($request->password != $request->password_confirmation) {
                return redirect()->back()->with('error_message', 'Password tidak cocok');
            }
        }

        try {
            $user->name = $request->name;
            $user->username = $request->username;
            $user->role = $request->role;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }

        return redirect()->back()->with('success_message', 'User berhasil diupdate');

    }

    /**
     * Delete the specified resource from storage.
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return redirect()->back()->with('error_message', 'User tidak ditemukan');
        }

        try {
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'User gagal dihapus');
        }

        return redirect()->back()->with('success_message', 'User berhasil dihapus');
    }
}
