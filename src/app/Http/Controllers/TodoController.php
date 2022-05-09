<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Psy\debug;

class TodoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(
            Todo::all()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(
            Todo::findOrFail($id)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $todo = Todo::create([
            'user_id' => $request->input('user_id'),
            'task' => $request->input('task'),
            'detail' => $request->input('detail'),
            'label' => $request->input('label'),
            'status' => $request->input('status'),
            'limited_at' => $request->input('limited_at'),
        ]);

        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'task' => 'required',
            'status' => 'required|integer',
//            'limited_at' => 'required|date_format:Y-m-d H:i:s|after:5 hours',
        ];

        $message = [
            'user_id.required' => 'ユーザーIDを入力してください',
            'task.required' => 'タスクを入力してください',
            'status.between' => 'ステータスを入力してください',
            'status.integer' => 'ステータスを数字で入力してください',
            'limited_at.required' => '期限を入力してください'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => '入力値が異なります'
                ]
            );
        }

        $todo = Todo::findOrFail($id);

        Todo::where('id', $id)->update([
            'user_id' => $todo->user_id,
            'task' => $request->input('task'),
            'detail' => $request->input('detail'),
            'label' => $request->input('label'),
            'status' => $request->input('status'),
            'limited_at' => $request->input('limited_at'),
        ]);

        return response()->json(
            Todo::findOrFail($id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Todo::findOrFail($id)->delete();

        return response()->json();
    }
}
