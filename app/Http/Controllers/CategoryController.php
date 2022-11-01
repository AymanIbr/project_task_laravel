<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Dotenv\Validator;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class , 'category');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(auth('admin')->check() || auth('user')->check()){
        //     $categories = Category::all();
        //     return response()->view('store.categories.index',compact('categories'));
        // }else{
        //     $categories = Category::where('active','=',true)->get();
        //     return response()->json([
        //         'status'=>true,
        //         'message'=>'success',
        //         'data'=>$categories
        //     ]);
        // }

        $categories = Category::all();
        return response()->view('store.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('store.categories.create');
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

            if($request->hasFile('image')){
                $ex = $request->file('image')->getClientOriginalExtension();
                $image_name = time().'_category.'.$ex;
                $request->file('image')->storePubliclyAs('images',$image_name,['disk'=>'public']);
                $category->image = 'images/'.$image_name;
            }
            $isSaved = $category->save();
            return response()->json([
                'message'=>$isSaved ? 'Saved Successfuly':'Failed to Save'
            ],$isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json([
                'message'=>$validatore->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return response()->view('store.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validatore = Validator($request->all(),[
            'name'=>'required|string|min:3|max:30',
            'active'=>'required|boolean',
            'image'=>'nullable|image|max:2048|mimes:jpg,png',
        ]);
        if(!$validatore->fails()){
            $category->name = $request->get('name');
            $category->active = $request->get('active');

            if($request->hasFile('image')){
                Storage::delete($category->image);
                $ex = $request->file('image')->getClientOriginalExtension();
                    $image_name = time().'_category.'.$ex;
                    $request->file('image')->storePubliclyAs('images',$image_name,['disk'=>'public']);
                    $category->image = 'images/'. $image_name;
            }
            $isUpdate = $category->save();
            return response()->json([
                'message'=>$isUpdate ? 'Updated Successfuly':'Failed to Update'
            ],$isUpdate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);

        }else{
            return response()->json([
                'message'=>$validatore->getMessageBag()->first()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $isDeleted = $category->delete();
        if($isDeleted){
            return response()->json(['title'=>'Success','text'=>'Category Deleted Successfully','icon'=>'success'],Response::HTTP_OK);
        }else{
            return response()->json(['title'=>'Failed','text'=>'Category Deleted Failed','icon'=>'error'],Response::HTTP_BAD_REQUEST);
        }
    }
}
