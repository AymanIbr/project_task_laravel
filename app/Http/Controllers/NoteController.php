<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Note::class, 'note');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth('admin')->check()) {
            $notes = Note::with('subCategory')->get();
            return response()->view('store.notes.index', ['notes' => $notes]);
        } else {
            //طريقة اولى
            // $notes = $request->user('user')->notes;
            $notes = $request->user()->notes()->with('subCategory')->get();
            // طريقة ثانية
            // $notes = auth('user')->user()->notes;
            //طريقة ثالثة
            // $notes = Note::where('user_id','=',auth('user')->id())->get();
            return response()->view('store.notes.index', ['notes' => $notes]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return response()->view('store.notes.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatore = Validator($request->all(), [
            'title' => 'required|string|min:3',
            'sub_category_id' => 'required|numeric|exists:sub_categories,id',
            'info' => 'required|string|min:3',
            'done' => 'required|boolean'
        ]);
        if (!$validatore->fails()) {
            $note = new Note();
            $note->title = $request->input('title');
            $note->sub_category_id = $request->input('sub_category_id');
            $note->info = $request->input('info');
            $note->done = $request->input('done');
            // $note->user_id = $request->user()->id;
            // $isSaved = $note->save();
            //طريقة ثانية
            $isSaved = auth('user')->user()->notes()->save($note);
            return response()->json([
                'message' => $isSaved ? 'Saved successfully' : 'Save failed'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validatore->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        return response()->view('store.notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {

        $validatore = Validator($request->all(), [
            'title' => 'required|string|min:3',
            'info' => 'required|string|min:3',
            'done' => 'required|boolean'
        ]);
        if (!$validatore->fails()) {
            // $note->title = $request->input('title');
            // $note->info = $request->input('info');
            // $note->done = $request->input('done');
            // $isSaved = $note->save();
            //طريقة أخرى
            $isSaved = $note->update($request->all());
            return response()->json([
                'message' => $isSaved ? 'Update successfully' : 'Update failed'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validatore->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $isDeleted = $note->delete();
        if($isDeleted){
            return response()->json(['title'=>'Success','text'=>'Note Deleted Successfully','icon'=>'success'],Response::HTTP_OK);
        }else{
            return response()->json(['title'=>'Failed','text'=>'Note Deleted Failed','icon'=>'error'],Response::HTTP_BAD_REQUEST);
        }    }
}
