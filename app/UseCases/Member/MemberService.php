<?php

declare(strict_types=1);

namespace App\UseCases\Member;

use App\Event;
use App\Member;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class MemberService
 * @package App\UseCases\Member
 */
class MemberService
{
    /**
     * @param int    $eventId
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     *
     * @return Member
     */
    public function create(?int $eventId, string $firstName, string $lastName, string $email): Member
    {
        /** @var Event $event */
        $event = Event::findOrFail($eventId);

        return DB::transaction(function () use ($event, $firstName, $lastName, $email) {
            /** @var Member $member */
            $member = Member::make([
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'email'      => $email,
            ]);

            $member->event()->associate($event);
            $member->saveOrFail();

            return $member;
        });
    }

    /**
     * @param int|null $id
     *
     * @return Collection
     */
    public function getAll(?int $id): Collection
    {
        return Member::query()->when($id, function ($query) use ($id) {
            return $query->whereEventId($id);
        })->get();
    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return Member
     * @throws \Throwable
     */
    public function update(int $id, Request $request): Member
    {
        /** @var Member $member */
        $member = Member::findOrFail($id);

        $member->update($request->only([
            'first_name',
            'last_name',
            'email'
        ]));

        return $member;
    }

    /**
     * @param int $id
     *
     * @throws \Exception
     */
    public function delete(int $id)
    {
        /** @var Member $member */
        $member = Member::findOrFail($id);

        $member->delete();
    }
}
