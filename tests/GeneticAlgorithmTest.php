<?php

use Arall\GeneticAlgorithm\GeneticAlgorithm;
use Arall\Tests\Mocks\StringLogic;

class GeneticAlgorithmTest extends PHPUnit_Framework_TestCase
{
    private $geneticAlgorithm;

    protected function setUp()
    {
        $this->geneticAlgorithm = new GeneticAlgorithm(new StringLogic('ayylmao', 'abcdefghijklmnopqrstuvwxyz'));
    }

    public function testGResult()
    {
        $result = $this->geneticAlgorithm->run();
        $this->assertEquals($result, 'ayylmao');
    }
}
