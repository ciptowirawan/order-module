<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index() {
        $admins = User::role('admin')->paginate(10);
        return view('manage.admin.index', compact('admins'));
    }

    public function create() {
        return view('manage.admin.create');
    }

    public function edit(string $id) {
        $data = User::find($id);

        return View('manage.admin.edit', compact('data'));
    }

    public function store(Request $request)  {
        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]); 
        
        // if there's error
        if (count($validator->errors()->toArray()) > 0) {
            $error_message = $validator->errors()->toArray();
            $error = ValidationException::withMessages($error_message);
            return Redirect::back()->withInput($request->input())->withErrors($validator);
        }

        $reguser = User::create([
            'full_name' => $request->full_name,
            'email' =>  $request->email,
            'password' => Hash::make($request->password)
        ]);
        
        $role = Role::where('name', 'admin')->first();
        $perm = $role->permissions;
        $reguser->syncRoles('admin');
        $reguser->syncPermissions($perm);       
    
        Auth::login($reguser);
    
        return redirect('/dashboard')->with('success', 'Kami telah mengirimkan tautan verifikasi ke Alamat Email anda. Silahkan cek email anda dan ikuti instruksinya untuk melanjutkan proses verifikasi email.');
    }

    public function update(string $id, Request $request) {
        $rules = [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:dns', 'max:255']            
        ];

        $validated = $request->validate($rules);

        User::where('id', $id)
            ->update([
                'full_name' => $validated['full_name'],
                'email' => $validated['email']
            ]);

        return redirect('/manage/admin')->with('success', 'Perubahan Berhasil Disimpan!');
    }
    
    public function destroy(string $id) {
        $count_role = User::role('admin')->get();

        if ($count_role->count() == 1) {

            return redirect('/manage/admin')->with('error', 'User ini adalah satu-satunya Admin yang terdaftar, mohon pastikan bahwa masih terdapat Admin lain sebelum melanjutkan aksi ini.');
        } else {

            User::destroy($id);

            return redirect('/manage/admin')->with('success', 'Admin Berhasil Dihapus!');
        }

    }
    
}
