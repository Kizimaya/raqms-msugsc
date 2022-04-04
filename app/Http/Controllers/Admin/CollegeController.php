<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\College;

class CollegeController extends Controller
{
    
    public function index()
    { 
        $colleges = College::get();
        return view('backend.admin.college.list', compact('colleges'));
    }

    public function showForm()
    {
        $keyList = $this->keyList();
        return view('backend.admin.college.form', compact('keyList'));
    }
    
    public function create(Request $request)
    { 
        @date_default_timezone_set(session('app.timezone')); 
        $validator = Validator::make($request->all(), [
            'name'        => 'required|unique:college,name|max:50',
            'description' => 'max:255',
            'key'         => 'required|unique:college,key|max:1',
            'status'      => 'required',
        ])
        ->setAttributeNames(array(
           'name' => trans('app.name'),
           'description' => trans('app.description'),
           'key' => trans('app.key_for_keyboard_mode'),
           'status' => trans('app.status')
        ));

        if ($validator->fails()) {
            return redirect('admin/college/create')
                ->withErrors($validator)
                ->withInput();
        } else {

            $save = College::insert([
                'name'        => $request->name,
                'description' => $request->description,
                'key'         => $request->key,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => null,
                'status'      => $request->status
            ]);

            if ($save) {
                return back()->withInput()
                        ->with('message',trans('app.save_successfully'));
            } else {
                return back()->withInput()
                        ->with('exception', trans('app.please_try_again'));
            }

        }
    } 
 
    public function showEditForm($id = null)
    {
        $keyList = $this->keyList();
        $college = College::where('id', $id)->first();
        return view('backend.admin.college.edit', compact('college', 'keyList'));
    }


    public function update(Request $request)
    { 
        @date_default_timezone_set(session('app.timezone'));

        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:50|unique:college,name,'.$request->id,
            'description' => 'max:255',
            'key'         => 'required|max:1|unique:college,key,'.$request->id,
            'status'      => 'required',
        ])
        ->setAttributeNames(array(
           'name' => trans('app.name'),
           'description' => trans('app.description'),
            'key' => trans('app.key_for_keyboard_mode'),
           'status' => trans('app.status')
        ));

        if ($validator->fails()) {
            return redirect('admin/college/edit/'.$request->id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $update = College::where('id',$request->id)
                ->update([
                    'name'        => $request->name,
                    'description' => $request->description,
                    'key'         => $request->key,
                    'updated_at'  => date('Y-m-d H:i:s'),
                    'status'      => $request->status
                ]);

            if ($update) {
                return back()
                        ->with('message', trans('app.update_successfully'));
            } else {
                return back()
                        ->with('exception',trans('app.please_try_again'));
            }

        }
    }
 
    public function delete($id = null)
    {
        $delete = College::where('id', $id)->delete();
        return redirect('admin/college')->with('message', trans('app.delete_successfully'));
    } 
 
    public function keyList()
    {
        $chars = array_merge(range('1','9'), range('a','z'));
        $list = array();
        foreach($chars as $char)
        {
            if ($char != "v")
            $list[$char] = $char;
        }
        return $list;
    }
 
}
