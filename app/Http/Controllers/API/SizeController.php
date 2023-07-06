<?php

namespace App\Http\Controllers\API;

use App\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Throwable;

class SizeController extends Controller
{
    public function index()
    {
        try {
            $size = Size::all();
            return response()->json(['success' => true,'data'=>$size]);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:size,name,except,id'
            ]);

            if ($validator->fails()) {
                // Validation fail
                $errors = $validator->errors();
                return response()->json($errors);
            } else {
                //New size
                $size = new Size;
                $size->name = $request->name;
                $size->scale = $request->scale;

                //Save
                $size->save();
            }
            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $size = Size::where('id', $id)
                ->first();
            return response()->json(['success' => true, 'data' => $size]);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:size,name,except,id'
            ]);

            if ($validator->fails()) {
                // Validation fail
                $errors = $validator->errors();
                return response()->json($errors);
            } else {
                //Update size
                $size->name = $request->name;
                $size->scale = $request->scale;

                //Salvando la instancia
                $size->save();
            }
            return response()->json(['success' => true,'data'=>$size]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $size = Size::findOrFail($id);
            $size->delete();
            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
