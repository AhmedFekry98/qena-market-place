<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait ApiResponses
{
    /**
     * Return Ok 200 response with data
     *
     * @param $data
     *
     * @return JsonResponse
     */
    protected function okResponse($data = null, $message = null): JsonResponse
    {
        $data = array_merge(
            [
                'success' => true,
                'message' => $message ?? "ok response."
            ],
            $this->resolveData($data)
        );

        return response()->json(
            $this->resolveKeys($data),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Return Bad Request 400 response with data
     *
     * @param $data
     *
     * @return JsonResponse
     */
    protected function badResponse($message = null): JsonResponse
    {
        $data = array_merge(
            [
                'success' => false,
                'message' => $message ?? "bad request response."
            ]
        );

        return response()->json(
            $this->resolveKeys($data),
            JsonResponse::HTTP_BAD_REQUEST
        );
    }

    /**
     * Return Created 201 response with data
     *
     * @param $data

     *
     * @return JsonResponse
     */
    protected function createdResponse($data = null, $message = null): JsonResponse
    {
        $data = array_merge(
            [
                'success' => true,
                'message' => $message ?? "created response."
            ],
            $this->resolveData($data)
        );

        return response()->json(
            $this->resolveKeys($data),
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Return unauthenticated 401 response with data
     *
     * @param $data
     *
     * @return JsonResponse
     */
    protected function unauthorizedResponse($data = null, $message = null): JsonResponse
    {
        $data = array_merge(
            [
                'success' => true,
                'message' => $message ?? "unauthorized response"
            ],
            $this->resolveData($data)
        );

        return response()->json(
            $this->resolveKeys($data),
            JsonResponse::HTTP_UNAUTHORIZED
        );
    }

    /**
     * Resolving api response data
     *
     * @param mixed $data
     *
     * @return array
     */
    public function resolveData(mixed $data): array
    {
        if (is_array($data)) {
            return ['data' => $data];
        }

        if (is_object($data) && method_exists($data, 'toArray')) {
            return ['data' => $data->toArray(request())];
        }

        return ['data' => $data];
    }

    /**
     * Resolving the api response keys.
     *
     * @param array $data
     * @return array
     */
    public function resolveKeys(array $data): array
    {
        return collect($data)->reduce(function ($items, $value, $key) {

            if (is_array($value)) {
                $value = $this->resolveKeys($value);
            } else if ($value instanceof JsonResource || $value instanceof Collection) {
                $value = $this->resolveKeys($value->toArray(request()));
            }

            $items[Str::camel($key)] = $value;

            return $items;
        }, []);
    }
}
