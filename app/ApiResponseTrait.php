<?php

namespace App;

trait ApiResponseTrait
{
    public function sendSuccessResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function sendNotFoundResponse($result, $message)
    {
        $response = [
            'success' => false,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 404);
    }

    public function sendValidationErrorResponse($result, $message)
    {
        $response = [
            'success' => false,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 400);
    }
}
