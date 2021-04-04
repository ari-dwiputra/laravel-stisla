<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }
    public function update(Request $request)
    {
        $user = User::find($request->id);
        $fileName = Str::random(20);
        $path = 'images/user/';
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Pengguna gagal diperbaharui'];
            if ($user->email != $request['email']) {
                if(User::where('email', $request['email'])->exists()){
                    return $data = ['status' => false, 'code' => 'EC002', 'message' => 'Email sudah digunakan'];
                }
            }
            if ( $user->username != $request['username']) {
                if(User::where('username', $request['username'])->exists()){
                    return $data = ['status' => false, 'code' => 'EC002', 'message' => 'Username sudah digunakan'];
                }
            }
            $validator = Validator::make($request->all(), [
                'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            ], [
                'photo' => 'File tidak boleh lebih dari 2MB, dengan format jpg, jpeg, png',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'File tidak boleh lebih dari 2MB, dengan format jpg, jpeg, png']);
            }
            
            $user              = User::find($request->id);
            $user->username    = $request['username'];
            $user->name        = $request->name;
            $user->email       = $request->email;
            if($request->file('photo') != null){
                $extension = $request->file('photo')->extension();
                $photoName = $fileName.'.'.$extension;
                Storage::disk('public')->putFileAs($path,$request->file('photo'), $fileName.".".$extension);
                $user->photo       = $photoName;
            }
            $user->save();

            if($user){
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Pengguna berhasil diperbaharui'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'Ups, Terjadi kesalahan sistem'.$ex];
        }
        return $data;
    }
    public function changePassword(Request $request)
    {
       try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Password gagal diperbaharui'];
            
            $update = User::where('id', $request['id'])->update([
                'password' => Hash::make($request['password']),
            ]);
            if($update){
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Password berhasil diperbaharui'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'Ups, Terjadi kesalahan sistem'.$ex];
        }
        return $data; 
    }
}
