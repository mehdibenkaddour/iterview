<?php

namespace App\Http\Controllers\Admin;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::orderBy('id')->paginate(10);
        return View('admin.topics.index')->with('topics',$topics);
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
        $validator = Validator::make($request->all(), [
            'label' => ['required', 'string', 'max:255'],
            'image' => ['required','image','mimes:jpeg,png,jpg,gif', 'max:2084'],
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $topic = new Topic();

        $topic->label=$request->input('label');
        if($request->hasfile('image')){
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time() . '.' . $extension;
            $file->move('uploads/topics/',$filename);
            $topic->image=$filename;
        }
        else{
            return $request;
            $topic->image="default_image";
        }
        $topic->save();
        return response()->json(['alert' => 'Topic has been added with success']);

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
        $topic = Topic::find($id);

        $validator = Validator::make($request->all(), [
            'label' => ['required', 'string', 'max:255'],
            'image' => ['required','image','mimes:jpeg,png,jpg,gif', 'max:2084'],
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $topic->label=$request->input('label');
        if($request->hasfile('image')){
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time() . '.' . $extension;
            $file->move('uploads/topics/',$filename);
            $topic->image=$filename;
        }
        else{
            return $request;
            $topic->image="default_image.png";
        }
        $topic->update();
        return response()->json(['alert' => 'Topic has been updated with success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic=Topic::findOrFail($id);

        $topic->delete();

        return redirect('topics');
    }
}
