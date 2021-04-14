<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use DB;

class MenuController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $menusList=[];
        $routeList=[];
        $menus = Menu::where('menus.active', 1)
        ->select('menus.*')
        ->get();

        foreach ($menus as $key => $value) {
            //$menuObject["id"] = $value->id;
            $menuObject["title"] = $value->title;
            $menuObject["name"] = $value->name;
            $menuObject["is_heading"] = $value->is_heading;
            $menuObject["is_active"] = $value->is_active;
            $menuObject["class_name"] = $value->class_name;
            $menuObject["is_icon_class"] = $value->is_icon_class;
            $menuObject["icon"] = $value->icon;
        
            if( $value->route != ''){
                $menuObject["link"] = $this->setRoute($value->route);
            }else{
                //$menuRoute["name"] = '';
                $menuObject["link"] = '';
                //$menuRoute["name"];
                //$menuRoute = null;
            }
            $menuObject["no_children"] = $this->menuHasChildren($value->id, $request->rol);
            if($menuObject["no_children"] >= 1 ){
               $menuObject["children"] = $this->getMenuChildren($value->id, $request->rol);
            }
            array_push($menusList, $menuObject);
            $menuObject = null;
        }
        return response()->json($menusList);
    }
    public function getAllElements() {
       $elements = Menu::select('menus.*')
       ->get();
        return response()->json($elements);
    }

    public function getMenuChildren($idParent, $idRol){
        
        $submenusList=[];
        
        $routeList=[];
        $submenus = Menu::where('menus.fk_parent', $idParent)
        ->where('menus.active', 1)
        ->select('menus.*')
        ->get();
        foreach ($submenus as $key => $value) {
           if($value->id>0){
                //$menuObject["parent"] = $idParent;
                //$menuObject["id"] = $value->id;
                $menuObject["title"] = $value->title;
                $menuObject["name"] = $value->name;
                $menuObject["is_active"] = $value->is_active;
                $menuObject["class_name"] = $value->class_name;
                $menuObject["is_icon_class"] = $value->is_icon_class;
                $menuObject["icon"] = $value->icon;
            
                if( $value->route != ''){
                    $menuObject["link"] = $this->setRoute($value->route);
                    
                }else{
                    $menuObject["link"] = "";
                    //$menuRoute["name"] = '';
                    //$menuObject["link"] = $menuRoute["name"];
                    //$menuRoute = null;
                }
                $menuObject["no_children"] = $this->menuHasChildren($value->id, $idRol);
                if($menuObject["no_children"] >= 1 ){
                    $menuObject["children"] = $this->getMenuChildren($value->id, $idRol);
                }
                array_push($submenusList, $menuObject);
                $menuObject = null;
           }     
        }
        return $submenusList;
    }

    public function  menuHasChildren($idParent, $idRol){
        $chilldren = Menu::where('menus.fk_parent', $idParent)
        ->where('menus.active', 1)
        ->select(DB::raw('count(menus.id) as parent_count'))
        ->first();
        return $chilldren->parent_count;
        if($chilldren->parent_count >0){
            return true;
        }else{
            return false;
        }
    }

    public function setRoute($route){
        $link_data = [ 'name' => $route ];
        return $link_data;
    }
        
        
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
        $element=new Menu([
            'name' => $request->name,
            'title' => $request->title,
            'fk_parent' => $request->fk_parent,
            'is_heading' => $request->is_heading,
            'is_active' => $request->is_active,
            'route' => $request->route,
            'class_name' => $request->class_name,
            'is_icon_class' => $request->is_icon_class,
            'icon' => $request->icon,
            'active' => $request->active
        ]);
        $element->save();
        return response()->json($element);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){ 
        $element=Menu::find($request->id);
        
        $element->parentOptions = $this->getOptions();
        return $element;
    }

    public function getOptions(){
        $arrayMenu=[];
        $parentOptions=[];
        $arrayMenu = Menu::where('menus.active', 1)->get();
        foreach ($arrayMenu as $key => $value) {
            $menuObject=([
                'value' => $value->id,
                'text' => $value->id.' - '.$value->title
            ]);
            array_push($parentOptions, $menuObject);
        }
        return $parentOptions;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $element=Menu::find($request->id);
        $element->name=$request->name;
        $element->title=$request->title;
        $element->fk_parent=$request->fk_parent;
        $element->is_heading=$request->is_heading;
        $element->is_active=$request->is_active;
        $element->route=$request->route;
        $element->class_name=$request->class_name;
        $element->is_icon_class=$request->is_icon_class;
        $element->icon=$request->icon;
        $element->active=$request->active;
        $element->save();
        return response()->json($element);
    }
    
    public function updateActive(Request $request){
        $element=Menu::find($request->id);
        $element->active=$request->active;
        $element->save();
        return response()->json($element);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
         if($this->deleteSingle($request->id)){
            return response()->json(['msg'=>'Departamento con ID '.$request->id.' eliminado.']);
        }
        else{
            return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
        }
    }
    public function destroyMultiple(Request $request){
        //return response()->json([$request->elementData, $request->api],200);
        foreach ($request->elementData as $key => $value) {
            $status=$this->deleteSingle($value);
            if(!$status)
                break;
        }
        if ($status) {
            return response()->json(['msg'=>'Departamentos eliminados.']);
        }
        else{
            return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
        }
    }

    private function deleteSingle($id){
        $element=Menu::find($id);

        if($element->delete())
            return true;
        else
            return false;    
    }
}
