<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\Category;
use Dotenv\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(SubCategory::class, 'sub_category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth('admin')->check()) {
            $subCategories = SubCategory::withCount('notes')->get();
        } else {
            // $subCategories = $request->user()->subCategories;
            //طريقة تانية اذا لم يكن هناك علاقة بين السب واليوزر
            //whereHas في داخلها العلاقة بين الكاتيجوري والسب
            $subCategories = SubCategory::withCount('notes')->whereHas('category', function ($query) use ($request) {
                $query->where('user_id', '=', $request->user()->id);
            })->get();
        }
        return response()->view('store.sub-categories.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('active', '=', true)->get();
        return response()->view('store.sub-categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatore = Validator($request->all(),[
            'name' => 'required|string|min:3|max:30',
            'active' => 'required|boolean',
            'category_id' => 'required|numeric|exists:categories,id',
        ]);
        if (!$validatore->fails()) {
            $subCategory = new SubCategory();
            $subCategory->name = $request->get('name');
            $subCategory->active = $request->get('active');
            // $subCategory->category_id = $request->input('category_id');
            // $isSaved = $request->user()->subCategories()->save($subCategory);
            //طريقة ثانية
            $subCategory->user_id = $request->user()->id;
            $category = Category::findOrFail($request->input('category_id'));
            $isSaved = $category->subCategories()->save($subCategory);
            return response()->json([
                'message' => $isSaved ? 'Saved Successfuly' : 'Failed to Save'
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
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubCategoryRequest  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}
