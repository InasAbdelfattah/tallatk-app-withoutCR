<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Validator;

use UploadImage;


class CategoriesController extends Controller
{

    /**
     * @var Category
     */

    public $public_path;

    public function __construct()
    {
        $this->public_path = 'files/categories/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        /**
         * Get all Categories
         */
        $categories = Category::get();

        ## SHOW CATEGORIES LIST VIEW WITH SEND CATEGORIES DATA.
        return view('admin.categories.index')
            ->with(compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }
        
        $rules = [
            'name_ar' => 'required|min:3|max:50',
            'name_en' => 'required|min:3|max:50',
            'description_ar' => 'required|min:3|max:1000',
            'description_en' => 'required|min:3|max:1000',
            'target_gender' => 'required',
            'is_active' => 'required',
            'image' => 'required|image'
          
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

           // return redirect()->back()->withErrors($validator)->withInput();

            $valErrors = $validator->messages();
            return redirect()->back()->withInput()
                ->withErrors($valErrors);
        }

        $category = new Category;
        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->description_ar = $request->description_ar;
        $category->description_en = $request->description_en;
        $category->target_gender = $request->target_gender;
        $category->is_active = $request->is_active;
        $category->parent_id = ($request->parent != null) ?: 0;

        /**
         * @ Store Image With Image Intervention.
         */

        if ($request->hasFile('image')):
            $category->image = $request->root() . '/' . $this->public_path . UploadImage::uploadImage($request, 'image', $this->public_path);
        endif;

        if ($category->save()) {
            session()->flash('success', 'لقد تم إضافة نوع الخدمة بنجاح' . $category->name);
            return redirect(route('categories.index'));
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $category = Category::findOrFail($id);
        return view('admin.categories.edit')->with(compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $category = Category::findOrFail($id);
        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->description_ar = $request->description_ar;
        $category->description_en = $request->description_en;
        $category->target_gender = $request->target_gender;
        $category->is_active = $request->is_active;
        $category->parent_id = ($request->parent != null) ?: 0;

        /**
         * @ Store Image With Image Intervention.
         */

        if ($request->hasFile('image')):
            $category->image = $request->root() . '/' . $this->public_path . UploadImage::uploadImage($request, 'image', $this->public_path);
        endif;


//        if ($category->save()) {
//            return response()->json([
//                'status' => true,
//                'message' => 'لقد تم إضافة نوع المنشأة بنجاح' . $category->name,
//                'data' => $category
//            ]);
//        }


        if ($category->save()) {
            session()->flash('success', 'لقد تم تعديل نوع الخدمة بنجاح' . $category->name);

            return redirect(route('categories.index'));
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Custom Functions
     */


    function filter(Request $request)
    {

        $name = $request->keyName;

        $page = $request->pageSize;

        ## GET ALL CATEGORIES PARENTS
        $query = Category::select();

        if ($name != '') {
            $query->where('name_ar', 'like', "%$name%")->orWhere('name_en', 'like', "%$name%");
        }

        $categories = $query->paginate(($page) ?: 10);

        if ($name != '') {
            $categories->setPath('categories?name_ar=' . $name);
        } else {
            $categories->setPath('categories');
        }


        if ($request->ajax()) {
            return view('admin.categories.load', ['categories' => $categories])->render();
        }
        ## SHOW CATEGORIES LIST VIEW WITH SEND CATEGORIES DATA.
        return view('admin.categories.index')
            ->with(compact('categories'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function groupDelete(Request $request)
    {

        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $ids = $request->ids;
        foreach ($ids as $id) {

            $model = Category::findOrFail($id);
            
            if ($model->companies->count() > 0) {
                return response()->json([
                    'status' => false,
                    'message' => "عفواً, لا يمكنك حذف النوع ($model->name) نظراً لوجود مراكز ملتحقة بهذا النوع"
                ]);
            }
            
            if ($model->services->count() > 0) {
                return response()->json([
                    'status' => false,
                    'message' => "عفواً, لا يمكنك حذف النوع ($model->name) نظراً لوجود خدمات بها"
                ]);
            }

            $model->delete();
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id
            ]
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if (!Gate::allows('setting_manage')) {
            return abort(401);
        }

        $model = Category::findOrFail($request->id);

        // if ($model->companies->count() > 0) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => "عفواً, لا يمكنك حذف النوع ($model->name) نظراً لوجود مراكز ملتحقة بهذا النوع"
        //     ]);
        // }
        
        if ($model->services->count() > 0) {
            
            return response()->json([
                'status' => false,
                'message' => "عفواً, لا يمكنك حذف النوع ($model->name_ar) نظراً لوجود خدمات بها"
            ]);
        }
        

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'data' => $model->id
            ]);
        }
    }
}
