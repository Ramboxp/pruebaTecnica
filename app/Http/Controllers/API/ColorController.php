<?php

namespace App\Http\Controllers\API;

use App\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ColorController extends Controller
{
    public function index()
    {
        try {
            $colors = Color::all();
            return response()->json(['success' => true,'data'=>$colors]);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:color,name,except,id'
            ]);

            if ($validator->fails()) {
                // Validation fail
                $errors = $validator->errors();
                return response()->json($errors);
            } else {
                //New color
                $color = new Color;
                $color->name = $request->name;

                //Save
                $color->save();
            }
            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $color = Color::where('id', $id)
                ->first();
            return response()->json(['success' => true, 'data' => $color]);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:color,name,except,id'
            ]);

            if ($validator->fails()) {
                // Validation fail
                $errors = $validator->errors();
                return response()->json($errors);
            } else {
                //Update color
                $color->name = $request->name;

                //Salvando la instancia
                $color->save();
            }
            return response()->json(['success' => true,'data'=>$color]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $color = Color::findOrFail($id);
            $color->delete();
            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
