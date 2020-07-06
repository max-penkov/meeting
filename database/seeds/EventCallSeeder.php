<?php

declare(strict_types=1);

use App\Event;
use Illuminate\Database\Seeder;


/**
 * Class EventCallSeeder
 */
class EventCallSeeder extends Seeder
{
    public function run(): void
    {
        factory(Event::class, 10)->create();
    }
}
