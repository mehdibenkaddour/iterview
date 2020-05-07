<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;

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
}
