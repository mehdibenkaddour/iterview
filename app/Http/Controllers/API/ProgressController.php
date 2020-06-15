<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Progress;
use App\User;

class ProgressController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $progress= new Progress();
        $progress->user_id=$request->user_id;
        $progress->section_id=$request->section_id;
        $progress->score=$request->score;
        $progress->time=$request->time;
        $progress->mode=$request->mode;
        $progress->save();
        return $this->sendResponse([
            'message' => 'ressource has been successful stored',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function progress(Request $request){
        $user = $request->user();
        $result = [];
        $arrayOfSection=Progress::select('section_id')->where('user_id',$user->id)->distinct('section_id')->get()->toArray();
        foreach($arrayOfSection as $section_id){
            foreach($section_id as $key=>$value){
                $object = new \stdClass;
                $object->section_id=$value;
                $object->progress=Progress::select('score','created_at','time','mode')->where('section_id',$value)->get();
            }
            $result[]=$object;
        }
        return $this->sendResponse($result);
    }
}
