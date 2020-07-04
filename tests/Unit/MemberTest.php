<?php

namespace Tests\Unit;

use App\Event;
use App\Member;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use DatabaseMigrations;

    public function testNew(): void
    {
        $member = Member::new(
            $firstName = 'firstName',
            $lastName = 'lastName',
            $email = 'email@mail.ru'
        );

        self::assertNotEmpty($member);

        self::assertEquals($firstName, $member->first_name);
        self::assertEquals($lastName, $member->last_name);
        self::assertEquals($email, $member->email);
    }

    public function testMemberBelongsToEvent()
    {
        $member = factory(Member::class)->create();

        $this->assertInstanceOf(Event::class, $member->event);
    }
}
