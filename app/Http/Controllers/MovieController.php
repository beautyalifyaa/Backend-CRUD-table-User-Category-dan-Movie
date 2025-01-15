<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Movie;
use Illuminate\Validation\Rule;
use Hash;


class MovieController extends Controller
{
    function createMovie(Request $request) {
        $validator = Validator::make($request->all(), [
            "tittle"=>'required',
            'voteaverage'=>'required',
            "overview"=>'required',
            "posterpath"=>'required',
            'category_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'message'=> $validator->errors(),
            ]);
        }
        $data = [
            'tittle'=>$request->get('tittle'),
            'voteaverage'=>$request->get('voteaverage'),
            'overview'=>$request->get('overview'),
            'posterpath'=>$request->get('posterpath'),
            "category_id"=>$request->get("category_id"),
        ];
        try {
            $insert = Movie::create($data);
            return Response()->json(["status"=>true, 'message'=>'Data berhasil ditambahkan']);
        } catch(Exception $e) {
            return Response()->json(["status"=>false, 'message'=>$e]);
        }
    }
    function getMovie() {
        try {
            $movie = Movie::get();
            return Response()->json([
                'status'=>true, 
                'message'=>'berhasil load data Movie',
                'data'=>$movie,
            ]);
        } catch(Exception $e) {
            return Response()->json([
                'status'=>false, 
                'message'=>'gagal load data Movie.'.$e,
            ]);
        }  
    }
    function getDetailMovie($id){
        try{
            $movie = Movie::where('id',$id)->first();
            return response()->json([
                'status'=>true,
                'message'=>'berhasil load data detail movie',
                'data' =>$movie,
            ]);
        } catch(Exception $e) {
            return response()->json([
                'status'=>false,
                'message'=>'gagal load data detail movie. '.$e,
            ]);
        }
    }
    function update_movie($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'tittle'=>'required',
            'voteaverage'=>'required', 
            "overview"=>'required',
            "posterpath"=>'required',
            'category_id'=>'required',
        ]);


        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }
        $data = [
            'tittle'=>$request->get('tittle'),
            'voteaverage'=>$request->get('voteaverange'),
            'overview'=>$request->get('overview'),
            'posterpath'=>$request->get('posterpath'),
            "category_id"=>$request->get("category_id"),
        ];
        try {
            $update = Movie::where('id',$id)->update($data);
            return Response()->json([
                "status"=>true,
                'message'=>'Data berhasil diupdate'
            ]);


        } catch (Exception $e) {
            return Response()->json([
                "status"=>false,
                'message'=>$e
            ]);
        }
    }
    function hapus_movie($id) {
        try{
            movie::where('id',$id)->delete();
            return Response()->json([
                "status"=>true,
                'message'=>'Data berhasil dihapus'
            ]);
        } catch(Exception $e){
            return Response()->json([
                "status"=>false,
                'message'=>'gagal hapus movie. '.$e,
            ]);
        }
    }
}
