<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model->orderBy('id','desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required|min:3|string',
            'iconImage' => 'required'
        ]);
        return $this->model->create($request->all());
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
        $this->validate($request, [
            'categoryName' => 'required|min:3|string',
        ]);
        return $this->model->where('id', $id)->update([
            'categoryName' => $request->categoryName
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->model->destroy($id);
    }
    public function imageUpload(Request $request){
        $this->validate($request, [
            'iconImage' => 'required|mimes:jpg,png,jpeg'
        ]);
        $picName = time(). '.' . $request->iconImage->extension();
        $request->iconImage->move(public_path('uploads/category'), $picName);
        return $picName;
    }
    public function delete_image(Request $request) {
        $filename = $request->imageName;
        $this->deleteFileFromServer($filename);
        return 'done';
    }

    public function deleteFileFromServer($filename){

        $filePatch = public_path() . '/uploads/category/'.$filename;
        if (file_exists($filePatch)){
            @unlink($filePatch);
        };

    }
}
