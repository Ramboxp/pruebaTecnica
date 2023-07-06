<?php

namespace App\Http\Controllers\API;

use App\Race;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Throwable;

class RaceController extends Controller
{
     public function index()
    {
        try {
            $race = Race::all();
            return response()->json(['success' => true,'data'=>$race]);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:race,name,except,id'
            ]);

            if ($validator->fails()) {
                // Validation fail
                $errors = $validator->errors();
                return response()->json($errors);
            } else {
                //New race
                $race = new Race;
                $race->name = $request->name;

                //Save
                $race->save();
            }
            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $race = Race::where('id', $id)
                ->first();
            return response()->json(['success' => true, 'data' => $race]);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    public function update(Request $request, $id)
    {
        $race = Race::findOrFail($id);

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:race,name,except,id'
            ]);

            if ($validator->fails()) {
                // Validation fail
                $errors = $validator->errors();
                return response()->json($errors);
            } else {
                //Update race
                $race->name = $request->name;

                //Salvando la instancia
                $race->save();
            }
            return response()->json(['success' => true,'data'=>$race]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $race = Race::findOrFail($id);
            $race->delete();
            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
