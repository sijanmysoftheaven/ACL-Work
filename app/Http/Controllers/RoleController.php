<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

use Hash;
use Illuminate\Support\Arr;
use DB;
    
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    //public $user_id = null;
    public function __construct()
    {
             $this->middleware('permission:GET::permission/roles', ['only' => ['index']]);
             $this->middleware('permission:GET::permission/roles/create', ['only' => ['create','store']]);
             $this->middleware('permission:GET::permission/roles/{role}', ['only' => ['show']]);
             $this->middleware('permission:GET::permission/roles/{role}/edit', ['only' => ['edit','update']]);
             $this->middleware('permission:DELETE::permission/roles/{role}', ['only' => ['destroy']]);

            //$this->middleware('permission:'.$role_show, ['only' => ['index','show']]);
            
    }   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;
        
        $roles = Role::orderBy('id','DESC')->paginate(5);
         return view('roles.index',compact('roles','arrayUser','arrayPermission','arrayProduct','arrayRole'))
         ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;

        $permission = Permission::get();
        return view('roles.create',compact('permission','arrayUser','arrayPermission','arrayProduct','arrayRole'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;

        $role = Role::find($id);
        
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('roles.show',compact('role','rolePermissions','arrayUser','arrayPermission','arrayProduct','arrayRole'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;
       
        $role = Role::find($id);
        $permission = Permission::get();
       
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('roles.edit',compact('role','permission','rolePermissions','arrayUser','arrayPermission','arrayProduct','arrayRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}

