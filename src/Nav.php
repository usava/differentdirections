<?php

namespace App;

/**
 * Navigation class
 *
 * @author Sviatoslav Poliakov <uptofly73@gmail.com>
 */
class Nav
{
    /** @var string $input Raw input */
    protected $input;

    public function __construct(string $input = '')
    {
        $this->input = $input;
    }

    /**
     *  Make instance statically
     * @param string $input
     * @return Nav
     */
    public static function make(string $input) : Nav
    {
        $self = new static($input);

        return $self;
    }

    /**
     *  Add input
     *
     * @param string $command
     * @return Nav
     */
    public function addInput(string $command) : Nav
    {
        $this->input .= $this->input ? PHP_EOL . $command : $command;

        return $this;
    }

    /**
     *  Calculate result
     * @return string
     */
    public function calc() : string
    {
        /** @var array $points Commands end points */
        $points = [];

        /** @var float $x_summary */
        $x_summary = 0.0;

        /** @var float $y_summary */
        $y_summary = 0.0;

        /** @var array $rawCommands */
        $rawCommands = explode(PHP_EOL, $this->input);

        foreach ($rawCommands as $rawCommand) {
            if (!trim($rawCommand)) {
                throw new \InvalidArgumentException('Command cannot be empty');
            }
            /** @var \App\Command $command */
            $command = new Command($rawCommand);

            /** @var array $end_point Current command end point */
            $end_point = $command->getEndPoint();

            $points[] = $end_point;

            $x_summary += $end_point['x'];
            $y_summary += $end_point['y'];
        }

        $average = [ 'x' => $x_summary / count($points), 'y' => $y_summary / count($points)];

        /** @var float $distance Result distance */
        $distance = 0;

        foreach ($points as $point) {
            $command_distance = $this->squaredDistance($point, $average);

            if ($command_distance > $distance) {
                $distance = $command_distance;
            }
        }

        $distance = sqrt($distance);

        return sprintf("%.2f %.2f %.2f", $average['x'], $average['y'], $distance);
    }

    /**
     *  Squared distance between two points
     * @param array $start
     * @param array $end
     * @return float
     */
    protected function squaredDistance(array $start, array $end) : float
    {
        return (($start['x'] - $end['x']) ** 2) + (($start['y'] - $end['y']) ** 2);
    }

}