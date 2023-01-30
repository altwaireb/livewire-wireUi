<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponses
{
    /**
     * Success Response.
     *
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(mixed $data, int $code = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $code);
    }

    /**
     * Error Response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse(mixed $data, string $message = '', int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        if (!$message) {
            $message = Response::$statusTexts[$code];
        }

        $data = [
            'message' => $message,
            'errors' => $data,
        ];

        return new JsonResponse($data, $code);
    }

    /**
     * Response with status code 200.
     *
     * @param mixed $data
     * @return JsonResponse
     */
    public function okResponse(mixed $data): JsonResponse
    {
        return $this->successResponse($data);
    }


    /**
     * Response with status code 201.
     *
     * @param mixed $data
     * @return JsonResponse
     */
    public function createdResponse(mixed $data): JsonResponse
    {
        return $this->successResponse($data, Response::HTTP_CREATED);
    }

    /**
     * Response with status code 204.
     *
     * @return JsonResponse
     */
    public function noContentResponse(): JsonResponse
    {
        return $this->successResponse([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Response with status code 400.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public function badRequestResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Response with status code 401.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public function unauthorizedResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Response with status code 403.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public function forbiddenResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_FORBIDDEN);
    }

    /**
     * Response with status code 404.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public function notFoundResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_NOT_FOUND);
    }

    /**
     * Response with status code 409.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public function conflictResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_CONFLICT);
    }

    /**
     * Response with status code 422.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public function unprocessableResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

}