<?php

namespace App\Http\Controllers\API;

use App\Color;
use App\Dog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Race;
use App\Size;
use Illuminate\Support\Facades\Validator;
use Throwable;

class DogController extends Controller
{
    public function index()
    {
        try {
            $dogs = Dog::all();
            return response()->json(['success' => true, 'data' => $dogs]);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $raceID = Race::pluck('id')
                ->unique()
                ->toArray();

            $colorID = Color::pluck('id')
                ->unique()
                ->toArray();

            $sizeID = Size::pluck('id')
                ->unique()
                ->toArray();

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:dog,name,except,id',
                'age' => 'required|integer',
                'weight' => 'required',
                'race_id' =>  'required|in:' . implode(',', $raceID),
                'color_id' => 'required|in:' . implode(',', $colorID),
                'size_id' => 'required|in:' . implode(',', $sizeID),
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'

            ]);

            if ($validator->fails()) {
                // Validation fail
                $errors = $validator->errors();
                return response()->json($errors);
            } else {

                //New dog
                $dog = new Dog;
                $dog->name = $request->name;
                $dog->age = $request->age;
                $dog->weight = $request->weight;
                $dog->race_id = $request->race_id;
                $dog->color_id = $request->color_id;
                $dog->size_id = $request->size_id;

                if ($request->image != '') {
                    $imagen = $request->file('image');
                    $file_name =  time() . '_' . $imagen->getClientOriginalName();
                    $imagen->move(public_path('images'), $file_name);
                    $dog->image = $file_name;
                }

                //Save
                $dog->save();
            }
            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $dog = Dog::where('id', $id)
                ->first();
            return response()->json(['success' => true, 'data' => $dog]);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    public function update(Request $request, $id)
    {
        $dog = Dog::findOrFail($id);

        $raceID = Race::pluck('id')
            ->unique()
            ->toArray();

        $colorID = Color::pluck('id')
            ->unique()
            ->toArray();

        $sizeID = Size::pluck('id')
            ->unique()
            ->toArray();

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:dog,name,except,id',
                'age' => 'required|integer',
                'weight' => 'required',
                'race_id' =>  'required|in:' . implode(',', $raceID),
                'color_id' => 'required|in:' . implode(',', $colorID),
                'size_id' => 'required|in:' . implode(',', $sizeID),
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'

            ]);

            if ($validator->fails()) {
                // Validation fail
                $errors = $validator->errors();
                return response()->json($errors);
            } else {
                //Update dog
                $dog->name = $request->name;
                $dog->age = $request->age;
                $dog->weight = $request->weight;
                $dog->race_id = $request->race_id;
                $dog->color_id = $request->color_id;
                $dog->size_id = $request->size_id;
                
                if ($request->image != '') {
                    $imagen = $request->file('image');
                    $file_name =  time() . '_' . $imagen->getClientOriginalName();
                    $imagen->move(public_path('images'), $file_name);
                    $dog->image = $file_name;
                }

                //Salvando la instancia
                $dog->save();
            }
            return response()->json(['success' => true, 'data' => $dog]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $dog = Dog::findOrFail($id);
            $dog->delete();
            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
