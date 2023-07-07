<?php

namespace App\Http\Controllers\API;

use App\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class SizeController extends Controller
{
    public function index()
    {
        try {
            $size = Size::orderBy('name')->get();
            return response()->json(['success' => true, 'data' => $size]);
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
            return response()->json(['success' => true, 'data' => $size]);
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
        } catch (ModelNotFoundException $e) {
            // El elemento no existe
            return response()->json(['success' => false, 'error' => 'El elemento no existe.']);
        } catch (QueryException $e) {
            // Captura la excepción de restricción de clave externa
            if ($e->getCode() == '23000') {
                return response()->json(['success' => false, 'error' => 'No puedes eliminar este elemento porque se encuentra en uso en otra entidad']);
            }
            // Otras excepciones de consulta
            return response()->json(['success' => false, 'error' => 'Error al eliminar el elemento.']);
        }
    }
}
