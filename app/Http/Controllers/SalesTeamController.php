<?php

namespace App\Http\Controllers;

use App\Models\SalesTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Utils\RespondsWithHttpStatus;

class SalesTeamController extends Controller
{
    use RespondsWithHttpStatus;


    /**
     * @return string[]
     */
    private function rules()
    {
        return [
            'name'          => 'required|string|min:5|max:50',
            'email'         => 'required|email|max:100',
            'telephone'     => 'required|string|max:10',
            'current_route' => 'required|string|min:5|max:100',
            'joined_date'   => 'required|date',
            'comments'      => 'required|string|min:5|max:500'
        ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respond(SalesTeam::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name', 'email', 'telephone', 'current_route', 'joined_date', 'comments'
        ]);

        $validator = Validator::make($data, $this->rules());

        if ($validator->fails()) {
            return $this->respondWithError($validator->errors(), 422);
        }

        $salesTeam = SalesTeam::create($data);

        return $this->respond($salesTeam, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesTeam  $salesTeam
     * @return \Illuminate\Http\Response
     */
    public function show(SalesTeam $salesTeam)
    {
        return $this->respond($salesTeam, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesTeam  $salesTeam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesTeam $salesTeam)
    {
        $data = $request->only([
            'name', 'email', 'telephone', 'current_route', 'joined_date', 'comments'
        ]);

        $validator = Validator::make($data, $this->rules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $salesTeam->update($data);

        return $this->respond($salesTeam, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesTeam  $salesTeam
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesTeam $salesTeam)
    {
        $salesTeam->delete();

        return $this->respond($salesTeam, 200);
    }
}
