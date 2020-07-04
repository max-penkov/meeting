<?php

namespace Tests\Feature;

use App\Event;
use App\Member;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use DatabaseMigrations;

    public function testMemberCreate()
    {
        $this->withoutExceptionHandling();

        $member = factory(Member::class)->make();

        // Создание участника
        $response = self::json('POST', route('api.members.create', ['event' => $member->event_id]), [
            'firstName' => $member->first_name,
            'lastName'  => $member->last_name,
            'email'     => $member->email,
        ]);
        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($content = $response->getContent());

        $data = json_decode($content, true);
        $this->assertEquals(1, $data['data']['id']);
        $this->assertEquals(1, $data['data']['event']['id']);
    }

    public function testGetMembersFilterByEvent()
    {
        $this->withoutExceptionHandling();

        $eventOne = factory(Event::class)->create();
        $eventTwo = factory(Event::class)->create();

        $count = 5;
        factory(Member::class, $count)->create([
            'event_id' => $eventOne->id,
        ]);

        factory(Member::class)->create([
            'event_id' => $eventTwo->id,
        ]);

        $response = self::json('GET', route('api.members', ['event' => $eventOne->id]));
        self::assertJson($content = $response->getContent());

        $data = json_decode($content, true);
        self::assertCount($count, $data['data']);
    }

    public function testGetAllMembers()
    {
        $this->withoutExceptionHandling();

        $eventOne = factory(Event::class)->create();
        $eventTwo = factory(Event::class)->create();

        $count1 = 5;
        factory(Member::class, $count1)->create([
            'event_id' => $eventOne->id,
        ]);

        $count2 = 10;
        factory(Member::class, $count2)->create([
            'event_id' => $eventTwo->id,
        ]);

        $response = self::json('GET', route('api.members'));
        self::assertJson($content = $response->getContent());

        $data = json_decode($content, true);
        self::assertCount($count1 + $count2, $data['data']);
    }

    public function testUpdateMember()
    {
        $member = factory(Member::class)->create([
            'first_name' => 'Alex',
            'last_name'  => 'Miller',
            'email'      => 'al@gmail.com',
        ]);

        $response = self::json('PUT', route('api.members.edit', ['member' => $member]), [
            'first_name' => 'Ivan',
            'last_name'  => 'Ivanov',
            'email'      => 'ivan@mail.ru',
        ]);
        self::assertJson($content = $response->getContent());

        $data = json_decode($content, true);
        self::assertEquals('Ivan Ivanov', $data['data']['name']);
        self::assertEquals('ivan@mail.ru', $data['data']['email']);
    }

    public function testRemovedMember()
    {
        $member = factory(Member::class);

        $response = self::json('DELETE', route('api.members.delete', ['member' => $member]));
        self::assertJson($content = $response->getContent());

        $data = json_decode($content, true);
        self::assertNull($data);
        self::assertDatabaseMissing('memmbers', ['id' => $member->id]);
    }
}
