<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use App\Models\Question;
use Egulias\EmailValidator\Warning\QuotedString;

class HomeController extends Controller
{
    public function index(){


        return view('home');
    }

    public function get_form_structure(){

        $question  = Question::with('answer')->get();

    
        
        return response()->json( $question);

    }
}
