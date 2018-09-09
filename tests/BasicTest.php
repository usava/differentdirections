<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Nav;

class BasicTest extends TestCase
{
    /** @test */
    public function one_input_without_changing_direction()
    {
        $this->assertEquals(
            "40.00000 40.00000 0.00000",
            Nav::make("30 40 start 0 walk 10")->calc(),
            "Found way is wrong"
        );
    }

    /** @test */
    public function two_inputs_without_changing_direction()
    {
        /** @var string $input1 Just go ahead */
        $input1 = "30 40 start 0 walk 10";

        /** @var string $input2 Go farther */
        $input2 = "30 40 start 0 walk 30";

        /** @var \App\Nav $nav Navigator */
        $nav = new Nav;

        $nav->addInput($input1)
            ->addInput($input2);

        $this->assertEquals("50.00000 40.00000 10.00000", $nav->calc(), "Found way is wrong");

    }

    /** @test */
    public function one_input_with_changing_direction()
    {
        $this->assertEquals(
            "40.00000 10.00000 0.00000",
            Nav::make("30 40 start 0 walk 10 turn -90 walk 30")->calc(),
            "Found way is wrong"
        );
    }

    /** @test */
    public function multiple_inputs_with_changing_direction()
    {
        /** @var string $inputs Raw inputs*/
        $inputs  = "87.342 34.30 start 0 walk 10.0";
        $inputs .= "\n2.6762 75.2811 start -45.0 walk 40 turn 40.0 walk 60";
        $inputs .= "\n58.518 93.508 start 270 walk 50 turn 90 walk 40 turn 13 walk 5";

        /** @var \App\Nav $nav Navigator */
        $nav = Nav::make($inputs);

        $this->assertEquals("97.15467 40.23341 7.63097", $nav->calc(), "Found way is wrong");
    }

}