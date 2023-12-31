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
use Illuminate\Support\Facades\Storage;


class DogController extends Controller
{
    public function index()
    {
        try {
            $dogs = Dog::orderBy('name')->get();
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
                'weight' => 'required|numeric',
                'race_id' =>  'required|in:' . implode(',', $raceID),
                'color_id' => 'required|in:' . implode(',', $colorID),
                'size_id' => 'required|in:' . implode(',', $sizeID),
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'

            ]);

            if ($validator->fails()) {
                // Validation fail
                $errors = $validator->errors();
                return response()->json(['success' => false, 'error' => $errors]);
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
        try {
            $dog = Dog::findOrFail($id);

            $raceID = Race::pluck('id')->toArray();
            $colorID = Color::pluck('id')->toArray();
            $sizeID = Size::pluck('id')->toArray();

            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'age' => 'integer',
                'weight' => 'numeric',
                'race_id' => 'in:' . implode(',', $raceID),
                'color_id' => 'in:' . implode(',', $colorID),
                'size_id' => 'in:' . implode(',', $sizeID),
                'image' => $request->hasFile('image') ? 'image|mimes:jpg,png,jpeg,gif,svg|max:2048' : '',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            $dog->name = $request->input('name');
            $dog->age = $request->input('age');
            $dog->weight = $request->input('weight');
            $dog->race_id = $request->input('race_id');
            $dog->color_id = $request->input('color_id');
            $dog->size_id = $request->input('size_id');

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $oldImage = $dog->image;
                $newImage = $request->file('image');
                $newImageName = time() . '_' . $newImage->getClientOriginalName();
                $newImage->move(public_path('images'), $newImageName);

                if ($oldImage) {
                    $image_path = public_path() . '/images'. '/'. $oldImage;
                    if(file_exists($image_path)){
                        unlink($image_path);
                    }
                }
                $dog->image = $newImageName;
            }

            $dog->save();

            return response()->json(['success' => true, 'data' => $dog]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            $dog = Dog::findOrFail($id);
            $oldImage = $dog->image;
            if ($oldImage) {
                $image_path = public_path() . '/images'. '/'. $oldImage;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $dog->delete();
            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
