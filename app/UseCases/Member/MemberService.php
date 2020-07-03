<?php

declare(strict_types=1);

namespace App\UseCases\Member;

use App\Member;

/**
 * Class MemberService
 * @package App\UseCases\Member
 */
class MemberService
{
    public function create(string $firstName, string $lastName, string $email): Member
    {
        $member = Member::new($firstName, $lastName, $email);

        return $member;
    }
}
