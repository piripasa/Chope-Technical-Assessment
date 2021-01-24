<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;


class ApiController extends Controller
{
    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @param int $code
     * @return Response
     */
    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        if (empty($result)) {
            unset($response['data']);
        }

        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
