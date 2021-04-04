<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        return view('role.index');
    }

    public function getData(Request $request){
        $keyword = $request['searchkey'];

        $Role = Role::with(['permissions'])
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? Role::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%'. $keyword . '%');
            })
            ->get();

        $RoleCounter = Role::when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%'. $keyword . '%');
        })
        ->count();
        $response = [
            'status' => true,
            'code' => '',
            'message' => '',
            'draw' => $request['draw'],
            'recordsTotal' => Role::count(),
            'recordsFiltered' => $RoleCounter,
            'data' => $Role,
        ];
        return $response;
    }

    public function create()
    {
        $data['permissions'] = Permission::orderBy('name', 'ASC')->pluck('name')->all();
            return view('role.create')->with($data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Hak Akses gagal ditambah'];
            $createRole = Role::create([
                'name'        => $request['name'],
                'description' => $request['description'],
                'guard_name'  => 'web',
            ]);

            $createPermissionToRole = $createRole->syncPermissions($request->permission);
            if($createPermissionToRole){
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Hak Akses berhasil ditambah'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'Ups, Terjadi kesalahan sistem'.$ex];
        }
        return $data;
    }

    public function edit($id)
    {
	    $data['role'] = Role::findById($id);
	    $data['permissions'] = Permission::orderBy('name', 'ASC')->pluck('name')->all();
	    $data['hasPermission'] = DB::table('role_has_permissions')
	        ->select('permissions.name')
	        ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
	        ->where('role_id', $id)->get()->pluck('name')->all();
	        return view('role.edit')->with($data);
    }
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Hak Akses gagal diubah'];
            $role              = Role::findById($id);
            $role->name        = $request->name;
            $role->description = $request->description;
            $role->save();

            $createPermissionToRole = $role->syncPermissions($request->permission);
            if($createPermissionToRole){
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Hak Akses berhasil diubah'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'Ups, Terjadi kesalahan sistem'.$ex];
        }
        return $data;
    }

    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Hak akses gagal dihapus'];
            
            $delete = Role::where('id', $id)->delete();
            if($delete){
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Hak akses berhasil dihapus'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'Ups, Terjadi kesalahan sistem'.$ex];
        }
        return $data;
    }
}
