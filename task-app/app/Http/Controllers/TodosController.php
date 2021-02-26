<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Auth;
use Session;


class TodosController extends Controller
{

      public function store(Request $request){
          $this->validate($request, [
              'todo' => 'required|min:5'
          ]);
          
      
    $todo = new Todo();
    $todo->user_id = Auth::user()->id;
    $todo->todo = $request->todo;
    $todo->save();

     Session::flash('success', 'Your task was saved successfully.');
     return redirect()->back();
}

public function edit($id){
    $todo = Todo::find($id);
    return view('edit')->with('todo', $todo);
}

  public function update(Request $request, $id){
    $this->validate($request, [
        'todo' => 'required|min:5'
    ]);
      $todo = Todo::find($id);
      
      if($todo->user_id != Auth::id()){
        return redirect()->route('home')->with('warning','unauthorized!!!');
      }

    $todo->save();
    return redirect()->route('home')->with('success','Todo updated.');
  }


      public function delete($id){
          $todo = Todo::find($id);
          $todo->delete();
          return redirect()->route('home')->with('success','Todo deleted.');
      }

}