<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Section;
use App\Models\Enroll;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class EnrollController extends ResponseController
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $enroll=new Enroll();
        $topic=Topic::where('code','=',$request->code_access)->first();
        $user=Enroll::where('user_id','=',$request->user()->id);
        if($user){
            return $this->sendResponse([
                'message' => 'you already enroll this module',
            ]);
        }else{
            if($topic){
                if($topic->enable){
                    $enroll->user_id=$request->user()->id;
                    $enroll->topic_id=$topic->id;
                    $enroll->save();
                    return $this->sendResponse([
                        'message' => 'you have been successfully enroll the module',
                    ]);
                }else{
                    return $this->sendError("MODULE_DISABLED", 403);
                }
            }else{
                return $this->sendError("INVALID_CODE", 404);
            }

        }
        
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
}
