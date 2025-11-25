<?php

namespace Coff\Framework\Http;

class ApiResponse
{
    public static function json($data, int $status = 200, array $headers = [])
    {
        http_response_code($status);
        
        foreach ($headers as $key => $value) {
            header("$key: $value");
        }
        
        header('Content-Type: application/json');
        
        echo json_encode($data);
        exit;
    }

    public static function success($data = null, string $message = 'Success', int $status = 200)
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];
        
        return self::json($response, $status);
    }

    public static function error(string $message = 'Error', int $status = 400, $errors = null)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];
        
        if ($errors) {
            $response['errors'] = $errors;
        }
        
        return self::json($response, $status);
    }

    public static function notFound(string $message = 'Not Found')
    {
        return self::error($message, 404);
    }

    public static function unauthorized(string $message = 'Unauthorized')
    {
        return self::error($message, 401);
    }
}

