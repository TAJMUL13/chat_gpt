<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Carbon;
use App\Models\History;
use Validator;

class ChatGptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        try {
            $validate = Validator::make($request->all(), 
            [
                'msg' => 'required',
                
            ]);

            // store user input
                History::create([
                    'user_id'=>$request->user()->id,
                    'msg'=> $request->msg,
                    'is_gpt_msg'=>0, // [0:No  1:yes]
                ]);
            $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                    ['role' => 'user', 'content' => $request->msg],
                ],
            ]);
            $gpt_response = $result->choices[0]->message->content;
            
            if(strlen($gpt_response)>10){
                // store chat-gpt response
                History::create([
                    'user_id'=>$request->user()->id,
                    'msg'=>$gpt_response,
                    'is_gpt_msg'=>1,// [0:No  1:yes]
                ]);
            }
            return response()->json($gpt_response,200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function old(Request $request)
    {


        try {
            $old_msg = History::where('user_id','=',$request->user()->id)->get();
            return response()->json($old_msg,200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }

    
    
}
