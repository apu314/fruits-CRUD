<?php

namespace App\Http\Controllers;

use App\Fruit;
use App\FruitDetails;
use App\Http\Resources\FruitResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FruitController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index() {
        //$fruits = Fruit::with('fruitDetails')->get();
        //return response()->json($fruits);

        $fruits = Fruit::with('fruitDetails')->get();
        return FruitResource::collection($fruits);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        DB::beginTransaction();
        try {
            $fruit = new Fruit();
            $fields = $request->only($fruit->getFillable());
            $fruit->fill($fields);
            $fruit->save();

            $fruitDetails = new FruitDetails();
            $fruitDetails->fruit_id = $fruit->id;
            $fruitDetails->size = $request->size;

            if (isset($request->color) && $request->color != '') {
                $fruitDetails->color = $request->color;
            }

            $fruitDetails->save();

            DB::commit();
            //return response()->json(Fruit::whereId($fruit->id)->with('fruitDetails')->get());

            $fruit = Fruit::whereId($fruit->id)->with('fruitDetails')->get();
            return FruitResource::collection($fruit);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Fruit $fruit
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $fruit = Fruit::whereId($id)->with('fruitDetails')->get();

        return response()->json($fruit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Fruit $fruit
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(Request $request, $id) {
        // Validate the request data.
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        DB::beginTransaction();
        try {
            $fruit = Fruit::with('fruitDetails')->whereId($id)->first();
            $fruit->name = $request->name; // Requerido
            $fruit->save();

            $fruitDetails = FruitDetails::where('fruit_id', $id)->first();
            $fruitDetails->size = $request->size;
            $fruitDetails->color = $request->color;
            $fruit->fruitDetails()->update($request->only($fruitDetails->getFillable()));

            DB::commit();

            return response()->json($fruit->load('fruitDetails'));
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Fruit $fruit
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id) {
        DB::beginTransaction();
        try {
            Fruit::find($id)->delete();

            DB::commit();

            return response()->json('Registro eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Valida que los datos introducidos sean correctos
     *
     * @param $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator($data) {
        $rules = [
            'name' => 'required|min:3|max:50',
            'size' => 'required|in:pequeño,mediano,grande',
            'color' => 'min:3|max:50'
        ];

        $messages = [
            'name.required' => 'El nombre es requerido',
            'size.required' => 'El tamaño es requerido',
        ];

        $validator = Validator::make($data, $rules, $messages);
        return $validator;
    }
}
