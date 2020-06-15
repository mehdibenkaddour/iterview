<?php

namespace App\Http\Controllers\Admin;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $topics = Topic::orderBy('id')->paginate(10);
        return View('admin.topics.index');
    }

    /**
     * This method is for ajax only
     */
    public function ajaxTopics() {
        return Datatables::of(Topic::query())

        // add actions collumn
        ->addColumn('actions', function (Topic $topic) {
            $url=route('sections.index');
            return '
            <div class="dropdown">
                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                <button
                data-id="' . $topic->id . '"
                class="edit dropdown-item">Modifier</button>
                <button
                data-id="' . $topic->id .'"
                class="delete dropdown-item">Supprimer</button>
                <a class="dropdown-item" href="' . $url .'?topic_id=' . $topic->id .'">Les élements</a>
                </div>
            </div>';
        })

        ->addColumn('topic', function (Topic $topic) {
            return '
            <div class="media align-items-center">
                <a href="#" class="avatar rounded-circle mr-3">
                    <img alt="Image placeholder" src="/uploads/topics/' . $topic->image . '">
                </a>
                <div class="media-body">
                  <span class="name mb-0 text-sm" id="TopicLabel">' . $topic->label . '</span>
                </div>
            </div>
            ';
        })
        
        // to interpret html and not considering it as text
        ->rawColumns(['actions', 'topic'])

        ->toJson();
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

        if($request->hasfile('image')) {
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time() . '.' . $extension;
            $file->move('uploads/topics/',$filename);
            $topic->image=$filename;

        } else {
            return $request;
            $topic->image="default_image";
        }
        
        $topic->save();

        // flash the session
        $request->session()->flash('status', 'Topic has been added with success');

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
