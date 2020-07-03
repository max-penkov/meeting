<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberDetailResource;
use App\UseCases\Member\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class MemberController
 * @package App\Http\Controllers\Api
 */
class MemberController extends Controller
{
    private MemberService $service;

    public function __construct(MemberService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|object
     */
    public function create(Request $request)
    {
        $member = $this->service->create($request['firstName'], $request['lastName'], $request['email']);

        return (new MemberDetailResource($member))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
