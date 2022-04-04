<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Program;
use App\Http\Resources\ProgramResource;

class ProgramController extends Controller{

    /**
     * Afficher la liste de ressources
     * @return \Illuminate\Http\response
     */
     public function index()
     {
         $data = Program::latest()->get();
         return Response()->json([ProgramResource::collection($data), 'Prommes trouvés']);
     }

     public function store(Request $request){

        $validator = validator::make($request->all(),[

            'name'=>'required|string||max:255',
            'desc'=>'required'

        ]);

        if ($validator->fails()){
            return response()->json($Validator->erros());
        }

        $program = Program::create([

            'name'=>$request->name,
            'desc'=>$request->desc
            $program->save();
        ]);

        return response()->json(['Programme crée avec succes', new ProgramResource($program)]);
     }


     /**
      * Afficher en fonction de ID
      * @param int $id
      * @return \Illuminate\Http\Response
      */
      public function show($id){

        $program = Program::find($id);

        if (is_null($program)){
            return response()->json('Pas de resultats', 404);
        }
        return response()->json([new ProgramResource($program)]);
      }


      /**
       * Mise a jour des ressoucres
       * 
       * @param \Illuminate\Http\Request $request
       * @param int $id
       * @return \Illuminate\Http\Response
       */
      public function update(Request $request, Program $program){

        $validator = Validator::make($request->all(),[

            'name'=>'required|string|max:255',
            'desc'=>'required'

        ]);

        if ($validator->fails()){

            return response()->json($validator->errors());
        }

        $program->name = $request->name;
        $program->desc=$request->desc;
        $program->save();

        return response()->json(['Programme mis a jour avec succes', new ProgramResource($program)]);
      }

      /**
       * Suppression d'elements
       * @param int $id
       * @return \Illuminate\Http\Response
       */
      public function delete(Program $program){

        $program->delete();
        return response()->json('Suppression effectuée');
      }
}
