<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
            $this->middleware('permission:GET::permission/users/create', ['only' => ['create','store']]);
            $this->middleware('permission:GET::permission/users', ['only' => ['index']]);
            $this->middleware('permission:GET::permission/users/{user}', ['only' => ['show']]);
            $this->middleware('permission:GET::permission/users/{user}/edit', ['only' => ['edit','update']]);
            $this->middleware('permission:DELETE::permission/users/{user}', ['only' => ['destroy']]);
    }
    
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

        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data','arrayUser','arrayPermission','arrayProduct','arrayRole'))
            ->with('i', ($request->input('page', 1)-1)*5);
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

        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles','arrayUser','arrayPermission','arrayProduct','arrayRole'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
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

        $user = User::find($id);
        return view('users.show',compact('user','arrayUser','arrayPermission','arrayProduct','arrayRole'));
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

        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole','arrayUser','arrayPermission','arrayProduct','arrayRole'));
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
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
        ->with('success','User deleted successfully');
    }
    public function profile(Request $request)
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;

        $id =Auth::user()->id;
        $user = User::find($id);
        return view('users.profile',compact('user','arrayUser','arrayPermission','arrayProduct','arrayRole'));
        
    }


}