<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Testimonial;
use DB;
use Illuminate\Support\Facades\Storage;
use Images;
use Documents;


class TestimonialController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $elements=Testimonial::orderBy('id', 'DESC')->get();
        foreach ($elements as $key => $value) {
            if($value->image_id){
                $value->imageUrl=Images::getUrl($value->image_id); 
            }
        }
        return response()->json($elements);
    }
    public function getAllElements() {
        $elements=Testimonial::all()->where("active", 1);
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
            'level_depth' => 'required',
            'stars' => 'required',
            'testimonial' => 'required',
            'active' => 'required'
        ]);

        $element=new Testimonial([
            'name' => $validatedData['name'],
            'companyName' => $request['companyName'],
            'level_depth' => $validatedData['level_depth'],
            'stars' => $validatedData['stars'],
            'testimonial' => $validatedData['testimonial'],
            'active' => $validatedData['active']
        ]);
        $element->save();
       
        if ($request->hasFile('image')) {
            $image_id=Images::save($request->image,"testimonial");
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
        $element=Testimonial::find($request->id);
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
            'level_depth' => 'required',
            'stars' => 'required',
            'testimonial' => 'required',
            'active' => 'required'
        ]);

        $element=Testimonial::find($validatedData['id']);
        $element->name = $validatedData['name'];
        $element->companyName= $request['companyName'];
        $element->level_depth=$validatedData['level_depth'];
        $element->stars= $validatedData['stars'];
        $element->testimonial= $validatedData['testimonial'];
        $element->active= $validatedData['active'];
       

        if ($request->hasFile('image')) {
            //$this->deleteImage($request->id);
            $image_id=Images::save($request->image,"testimonial");
            $element->image_id=$image_id;
        }
        $element->save();
       
        return response()->json($element);
    }
    
    public function updateActive(Request $request){
        $element=Testimonial::find($request->id);
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
        $element=Testimonial::find($id);

        if($element->delete())
            return true;
        else
            return false;    
    }

    
}
