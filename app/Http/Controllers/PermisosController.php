<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permisos;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermisosResources;
use Exception;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;


class PermisosController extends Controller
{

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $request->validate([
            'page' => 'integer',
            'paginate' => 'integer',
            'from_date' => 'date',
            'to_date' => 'date',
        ]);

        $id = Auth()->user()->id;
        if($request->filled('from_date') && $request->filled('to_date')){
            $query = Permisos::where('enabled', true)
                        ->whereBetween(\DB::raw('DATE(created_at)'), array($request->input('from_date'),$request->input('to_date')))
                        ->orderByDesc('id');
        }else{
            $query = Permisos::where('enabled', true)
                        ->orderByDesc('id');
        }
        
        $paginate = $request->filled('paginate') ? $request->input('paginate') : 20;
        return PermisosResources::collection($query->paginate($paginate));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
    {
        try {
            $requestData = $request->all();

            //TODO: Validate user Permisos role.
            $validatePermisos = $this->validatereg($requestData);
            if ($validatePermisos->fails()) {
                return response()->json(
                    [
                        'response' => false,
                        'message' => 'Datos inválidos en el nuevo registro',
                        'errors' => $validatePermisos->messages(),
                        'data' => null
                    ], Response::HTTP_BAD_REQUEST
                );
            }

            $newregister = Permisos::create([
                'name' => $requestData['name'],
            ]);    

            return response()->json([
                'response' => true,
                'message' => 'Registro creado exitosamente',
                'data' => new PermisosResources($newregister),
                'errors' => [],
            ], Response::HTTP_OK);

        }catch (Exception $e) {
            app('sentry')->captureException($e);
            return response()->json(
                [
                    'response' => false,
                    'message' => 'Ocurrió un error al crear el registro',
                    'errors' => [],
                    'data' => null
                ], Response::HTTP_BAD_REQUEST
            );
        }
    }

    private function validatereg($personData){
        return Validator::make($personData, [
            "name" => 'required|string|min:3|max:10',
        ]);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permisos  $Permisos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Permisos = Permisos::find($id);
        if(!$Permisos){
            return response()->json(
                [
                    'response' => false,
                    'message' => 'Registro no encontrado',
                    'errors' => [],
                    'data' => null
                ], Response::HTTP_NOT_FOUND
            );
        }
        
        return new PermisosResources($Permisosn);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permisos $Permisos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $register = Permisos::find($id);
        if ($register == null) {
            return response()->json(
                [
                    'response' => false,
                    'message' => 'Registro no encontrado',
                    'errors' => [],
                    'data' => null
                ], Response::HTTP_NOT_FOUND
            );
        }
        
        $requestData = $request->all();
        $this->validatereg($requestData);

        $register->name = $requestData['name'];
        $register->save();

        return response()->json([
            'response' => true,
            'message' => 'Registro actualizado exitosamente',
            'data' => new  PermisosResources($register),
            'errors' => [],
        ], Response::HTTP_OK);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permisos  $Permisosn
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Permisos::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado exitosamente',
                'data' => null,
                'errors' => [],
            ], Response::HTTP_OK);


        }catch(Exception $ex){
           app('sentry')->captureException($ex);
            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar el registro',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
