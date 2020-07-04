<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberDetailResource;
use App\Http\Resources\MemberListResource;
use App\Member;
use App\UseCases\Member\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
     * @param Event $event
     *
     * @return AnonymousResourceCollection
     */
    public function index(Event $event = null)
    {
        $members = $this->service->getAll($event->id ?? null);

        return MemberListResource::collection($members);
    }

    /**
     * @param Request $request
     *
     * @param Event   $event
     *
     * @return JsonResponse|object
     */
    public function create(Request $request, Event $event = null)
    {
        $member = $this->service->create($event->id ?? null, $request['firstName'], $request['lastName'],
            $request['email']);

        return (new MemberDetailResource($member))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param Member  $member
     *
     * @return JsonResponse|object
     * @throws \Throwable
     */
    public function edit(Request $request, Member $member)
    {
        $member = $this->service->update($member->id, $request);

        return (new MemberDetailResource($member))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Member  $member
     *
     * @return mixed
     */
    public function delete(Request $request, Member $member)
    {
        $this->service->delete($member->id);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
