<?php

namespace App\Http\Controllers\Admin;

use App\Models\Topic;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics=Topic::all();
        return View('admin.questions.index')->with('topics',$topics);
    }
    /**
     * This method is for ajax only
     */
    public function ajaxQuestions() {
        return Datatables::of(Question::query())

        // add actions collumn
        ->addColumn('actions', function (Question $question) {
            return '
            <button
                data-id="' . $question->id . '"
                class="btn btn-success btn-sm edit">Edit</button>
            <button
                data-id="' . $question->id .'"
                class="btn btn-danger btn-sm delete">Delete</button>';
        })

        ->addColumn('question', function (Question $question) {
            return '
            <div class="media align-items-center">
                <div class="media-body">
                  <span class="name mb-0 text-sm" id="sectionLabel">' . $question->content . '</span>
                </div>
            </div>
            ';
        })

        ->addColumn('type', function (Question $question) {
            return '
            <div class="media align-items-center">
                <div class="media-body">
                  <span class="name mb-0 text-sm" id="sectionLabel">' . $question->type . '</span>
                </div>
            </div>
            ';
        })

        ->addColumn('topic', function(Question $question) {
            return $question->section->topic->label;
        })
        ->addColumn('section', function(Question $question) {
            return $question->section->label;
        })
        
        // to interpret html and not considering it as text
        ->rawColumns(['actions', 'type','question'])

        ->toJson();
    }
    /*
     this method for geting section of topics used in dynamic dropdown menu 
    */
    public function getSections($id){
        $sections= Section::where("topic_id",$id)->pluck("label","id");
        return json_encode($sections);
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
            'content' => ['required', 'string'],
            'topic'=>['required'],
            'section'=>['required'],
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $question = new Question();

        $question->content=$request->input('content');
        $question->section_id=$request->input('section');
        $question->type=$request->input('type');
        $question->code=$request->input('code');
        $question->save();

        $correctAnswer=new Answer();

        $correctAnswer->content=$request->input('correct_answer');
        $correctAnswer->correct=true;
        $correctAnswer->question_id=$question->id;
        $correctAnswer->save();

        $answers=$request->input('wrong_answers');
        foreach($answers as $answer){
            $wrongAnswer=new Answer();
            $wrongAnswer->content=$answer;
            $wrongAnswer->correct=false;
            $wrongAnswer->question_id=$question->id;
            $wrongAnswer->save();
        }

        return response()->json(['alert' => 'Section has been Added with success']);
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
