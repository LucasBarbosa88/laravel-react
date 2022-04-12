<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::select('id','name','description')->get();

        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        if($request->validate($rules)){
            try{
                Task::create($request->post());
    
                return response()->json([
                    'message'=>'Task created successfully!!'
                ]);
            }catch(\Exception $e){
                Log::error($e->getMessage());
                return response()->json([
                    'message'=>'Something goes wrong while creating a task!!'
                ],500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return response()->json([
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        if($request->validate($rules)){
            try{
                $task->fill($request->post())->update();
                $task->save();
    
                return response()->json([
                    'message'=>'Task updated successfully!!'
                ]);
    
            }catch(\Exception $e){
                Log::error($e->getMessage());
                return response()->json([
                    'message'=>'Something goes wrong while updating a task!!'
                ],500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response()->json([
                'message'=>'Task deleted successfully!!'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while deleting a task!!'
            ]);
        }
    }
}
