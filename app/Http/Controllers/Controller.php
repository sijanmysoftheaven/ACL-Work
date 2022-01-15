<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $arr = [];
  
    public function __construct()
    {
    	
    }
    public function call_middleware($routename)
    {
        $id = Auth::user()->id;
        $trim_routename = rtrim($routename,'s');

        $role = Role::join("model_has_roles","model_has_roles.role_id","=","roles.id")
            ->where("model_has_roles.model_id",$id)
            ->get();
        $role_id = null;
        foreach($role as $item)
        {
            $role_id =$item->id;
        }

        $this->arr['index']='';
        $this->arr['show']='';
        $this->arr['edit']='';
        $this->arr['create']='';
        $this->arr['delete']='';

        $permission = Role::where('id',$role_id)->with('permissions')->get();
        
        foreach ($permission as $key => $value) 
        {
            foreach($value->permissions as $item)
            {
                if(strpos($item->http_uri,$routename) !== false && strpos($item->http_uri,'GET') !== false && strpos($item->http_uri,'edit') !== false)
                {
                        $this->arr['edit'] = $item->http_uri;                           
                }
                if(strpos($item->http_uri,$routename) !== false && strpos($item->http_uri,'GET') !== false && strpos($item->http_uri,'create') !== false)
                {
                        $this->arr['create'] = $item->http_uri;                           
                }
                
                if(strpos($item->http_uri,$routename) !== false && strpos($item->http_uri,'DELETE') !== false)
                {
                        $this->arr['delete'] = $item->http_uri;
                }

                if(strpos($item->http_uri,$routename) !== false && strpos($item->http_uri,'GET') !== false && strpos($item->http_uri,'{'.$trim_routename.'}') !== false)
                {
                    if(strpos($item->http_uri,'edit') == false)
                    {   
                        $this->arr['show'] = $item->http_uri;
                    }   
                }
                if(strpos($item->http_uri,$routename) !== false && strpos($item->http_uri,'GET') !== false )
                {
                    
                     $this->arr['index'] = $item->http_uri;
                    
                }
            }       
        }
    } 
}
