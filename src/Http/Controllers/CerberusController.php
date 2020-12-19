<?php

namespace Emodyz\Cerberus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CerberusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @param Request $request
     * @param $ability
     * @return JsonResponse
     */
    public function checkAuthorization(Request $request, $ability): JsonResponse
    {
        $user = auth()->user();

        return response()->json($user->can($ability));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAuthorizations(Request $request): JsonResponse
    {
        return response()->json(config('cerberus.authorizations'));
    }
}
