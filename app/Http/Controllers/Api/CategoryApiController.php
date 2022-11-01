<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Dotenv\Validator;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        return response()->json([
            'message'=>'success',compact('data')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatore = Validator($request->all(),[
            'name' => 'required|string|min:3|max:30',
            'active'=>'required|boolean',
            'image'=>'required|image|max:2048|mimes:png,jpg'
        ]);
        if(!$validatore->fails()){
            $category = new Category();
            $category->name = $request->get('name');
            $category->active = $request->get('active');
            $category->image = $request->get('image');
            $isSaved = $category->save();
            return response()->json(['message'=>$isSaved ? 'success':'Faild'
        ],$isSaved ? Response ::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json(
                ['message'=>$validatore->getMessageBag()->first()
        ],Response::HTTP_BAD_REQUEST);
        }
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
