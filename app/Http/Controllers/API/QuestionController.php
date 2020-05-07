<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Section;

class QuestionController extends ResponseController
{
    public function show($id) {
        $questions = Section::find($id)->questions;
        if($questions){
            return $this->sendResponse($questions);

        } else{
            return $this->sendError("ressource not found",404);
        }
    }
}
