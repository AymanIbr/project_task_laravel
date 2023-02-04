<?php

namespace App\Http\Controllers;

use App\Models\City;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(City::class , 'city');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        return response()->view('store.cities.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('store.cities.create');
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
            // 'active'=>'nullable|string|in:on',
            'image'=>'required|image|max:2048|mimes:png,jpg'
        ]);
        if(!$validatore->fails()){

         $city = new City();
         $city->name = $request->get('name');
         $city->active = $request->get('active');

         if($request->hasFile('image')){
            $ex = $request->file('image')->getClientOriginalExtension();
            $image_name = time().'_city.'.$ex;
            $request->file('image')->storePubliclyAs('images',$image_name,['disk'=>'public']);
            $city->image = 'images/'.$image_name;
         }
         $isSaved = $city->save();
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
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return response()->view('store.cities.edit',compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $validatore = Validator($request->all(),[
            'name'=>'required|string|min:3|max:30',
            'active'=>'required|boolean',
            'image'=>'nullable|image|max:2048|mimes:jpg,png',
        ]);
        if(!$validatore->fails()){
            $city->name = $request->get('name');
            $city->active = $request->get('active');

            if($request->hasFile('image')){
                Storage::delete($city->image);
                $ex = $request->file('image')->getClientOriginalExtension();
                    $image_name = time().'_category.'.$ex;
                    $request->file('image')->storePubliclyAs('images',$image_name,['disk'=>'public']);
                    $city->image = 'images/'. $image_name;
            }
            $isUpdate = $city->save();
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
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $isDeleted = $city->delete();
        if($isDeleted){
            // Storage::delete($city->image);
            return response()->json(['title'=>'Success','text'=>'City Deleted Successfully','icon'=>'success'],Response::HTTP_OK);
        }else{
            return response()->json(['title'=>'Failed','text'=>'City Deleted Failed','icon'=>'error'],Response::HTTP_BAD_REQUEST);
        }
    }
}
