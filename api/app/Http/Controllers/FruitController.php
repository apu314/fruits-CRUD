<?php

namespace App\Http\Controllers;

use App\Fruit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FruitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fruits = Fruit::all();
        return response()->json($fruits);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /*public function create()
    {
        //
    }*/

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

            DB::commit();
            return response()->json($fruit);

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
     * @param  \App\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    public function show(Fruit $id) {
        $fruit = Fruit::find($id);

        return response()->json($fruit);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    /*public function edit(Fruit $fruit)
    {
        //
    }*/

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
        DB::beginTransaction();
        try {
            $fruit = Fruit::find($id);
            $fields = $request->only($fruit->getFillable());
            $fruit->fill($fields);
            if ($fruit->isDirty()) {
                $fruit->getDirty();
                $fruit->save();
            }

            DB::commit();

            return response()->json($fruit);
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
    public function destroy($id) {
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
}
