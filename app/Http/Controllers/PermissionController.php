<?php
    
namespace App\Http\Controllers;
    
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
    
class PermissionController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     function __construct()
    {
        $this->middleware('permission:GET::permission/permissions/create', ['only' => ['create','store']]);
        $this->middleware('permission:GET::permission/permissions', ['only' => ['index']]);
        $this->middleware('permission:GET::permission/permissions/{permission}', ['only' => ['show']]);
        $this->middleware('permission:GET::permission/permissions/{permission}/edit', ['only' => ['edit','update']]);
        $this->middleware('permission:DELETE::permission/permissions/{permission}', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;

        $permissions = Permission::latest()->paginate(5);
        return view('permissions.index',compact('permissions','arrayUser','arrayPermission','arrayProduct','arrayRole'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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

        $routeAdmin = Route::getRoutes();
        
        return view('permissions.create',compact('routeAdmin','arrayUser','arrayPermission','arrayProduct','arrayRole'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
        ]);

        
        $dataInsert = [
            'name' => $request['name'],
            'slug' => $request['slug'],
            'http_uri' => implode('|', ($request['http_uri'] ?? [])),
        ];
    
        Permission::create($dataInsert);
    
        return redirect()->route('permissions.index')
                        ->with('success','Permission created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;

        return view('permissions.show',compact('permission','arrayUser','arrayPermission','arrayProduct','arrayRole'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;

        $routeAdmin = Route::getRoutes();
        return view('permissions.edit',compact('permission','routeAdmin','arrayUser','arrayPermission','arrayProduct','arrayRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
         request()->validate([
            'name' => 'required',
        ]);
          $dataInsert = [
            'name' => $request['name'],
            'slug' => $request['slug'],
            'http_uri' => implode('|', ($request['http_uri'] ?? [])),
        ];
    
        $permission->update($dataInsert);
    
        return redirect()->route('permissions.index')
        ->with('success','Permission updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
    
        return redirect()->route('permissions.index')
        ->with('success','Permission deleted successfully');
    }
}