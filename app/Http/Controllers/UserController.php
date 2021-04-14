<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Illuminate\Support\Facades\Storage;
use Images;
use Documents;



class UserController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $elements=User::join('perfiles', 'perfiles.id', '=', 'usuarios.fk_perfil')
        ->orderBy('usuarios.id', 'DESC')->get();
        foreach ($elements as $key => $value) {
            if($value->image_presentation_id){
                $value->imageUrl=Images::getUrl($value->image_id); 
            }
        }
        return response()->json($elements);
    }
    public function getAllElements() {
        $elements=User::all()->where("active", 1);
        return response()->json($elements);
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
       
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'fk_rol' => 'required',
            'active' => 'required'
        ]);

        $element=new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'fk_rol' => $validatedData['fk_rol'],
            'active' => $validatedData['active']
        ]);
        $element->save();

        if ($request->hasFile('image')) {
            $image_id=Images::save($request->image,"users");
            $element->image_id=$image_id;
            $element->save();
        }
        return response()->json($element);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){ 
       
        $element=User::find($request->id);
        if($element->image_id){
            $element->imageUrl=Images::getUrl($element->image_id); 
        }
        return $element;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'fk_rol' => 'required',
            'active' => 'required'
        ]);

        $element=User::find($validatedData['id']);
        $element->name = $validatedData['name'];
        $element->email = $validatedData['email'];
        $element->password = $validatedData['password'];
        $element->fk_rol = $validatedData['fk_rol'];
        $element->active= $validatedData['active'];

        if ($request->hasFile('image')) {
            //$this->deleteImage($request->id);
            $image_id=Images::save($request->image,"users");
            $element->image_id=$image_id;
        }

        $element->save();
       
        return response()->json($element);
    }
    
    public function updateActive(Request $request){
        $element=User::find($request->id);
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
        $element=User::find($id);

        if($element->delete())
            return true;
        else
            return false;    
    }

    
}
