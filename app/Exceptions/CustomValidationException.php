<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;


class CustomValidationException extends ValidationException
{
    public function render($request): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'message' => $this->validator->errors()->getMessages(),
        ], 422);
    }
}
