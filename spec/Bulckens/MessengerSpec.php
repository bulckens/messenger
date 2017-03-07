<?php

namespace spec\Bulckens;

use Bulckens\Messenger;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessengerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Messenger::class);
    }
}
