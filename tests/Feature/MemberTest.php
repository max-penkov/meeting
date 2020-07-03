<?php

namespace Tests\Feature;

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
        $response = self::json('POST', route('api.members.create'), [
            'firstName' => $member->first_name,
            'lastName'  => $member->last_name,
            'email'     => $member->email,
        ]);
        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($content = $response->getContent());

        $data = json_decode($content, true);
        $this->assertEquals(1, $data['data']['id']);
    }
}
