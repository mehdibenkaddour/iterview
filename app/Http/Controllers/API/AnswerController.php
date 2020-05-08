<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Section;

class AnswerController extends ResponseController
{
    public function show($id) {
        $answers = Question::find($id)->answers;

        if($answers){
            return $this->sendResponse($answers);

        } else{
            return $this->sendError("ressource not found",404);
        }
    }

    public function answers($id) {
        $questions = Section::find($id)->questions;

        $answers = array();

        foreach($questions as $questions) {
            foreach($questions->answers as $answer) {
                array_push($answers, $answer);
            }
            
        }

        if($answers){
            return $this->sendResponse($answers);

        } else{
            return $this->sendError("ressource not found",404);
        }
    }
}
