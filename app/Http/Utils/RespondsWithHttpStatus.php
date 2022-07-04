<?php


namespace App\Http\Utils;

trait RespondsWithHttpStatus
{
    public function respond($data, $status = 200)
    {
        return response()->json(['data' => $data], $status);
    }

    public function respondWithError($data, $status = 400)
    {
        return response()->json(['errors' => $data], $status);
    }
}
