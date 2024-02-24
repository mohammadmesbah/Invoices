<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections= Section::all();
        return view('sections.section',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input= $request->all();
        $exist= Section::where('name',$input['section_name'])->exists();
        if($exist){
            session()->flash('Error','خطأ القسم مسجل بالقعل');
            return redirect('/sections');
        }else{
            /* $validated = $request->validate([
                'name' => 'required|unique:sections|max:255',
                'description' => 'required',
            ],
            [
                'name.required'=>"يجب إدخال الاسم",
                'name.unique'=>"تم إدخال هذا القسم من قبل",
                'description.required'=>"يجب إدخال الوصف",
            ]
        ); */
            Section::create([
                'name'=>$request->section_name,
                'description'=> $request->section_description,
                'created_by'=> Auth::user()->name,
            ]);
            session()->flash('Add','تمت الإضافة بنجاح');
            return redirect('/sections');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id= $request->id;
        $this->validate($request,[
            'name' => 'required|unique:sections,name|max:255'.$id,
            'description' => 'required',
            ],
            [
                'name.required'=>"يجب إدخال الاسم",
                'name.unique'=>"هذا القسم موجود بالفعل",
                'description.required'=>"يجب إدخال الوصف",
        ]);
        $section= Section::find($id);
        $section->update([
            'name'=>$request->name,
            'description'=>$request->description
        ]);
        session()->flash('Edit','تم تعديل القسم بنجاح');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Section::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
