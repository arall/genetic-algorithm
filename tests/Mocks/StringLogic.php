<?php

namespace Arall\Tests\Mocks;

use Arall\GeneticAlgorithm\LogicInterface;

/**
 * Dummy logic class.
 *
 * @author Gerard Arall <gerard.arall@gmail.com>
 */
class StringLogic implements LogicInterface
{
    /**
     * Avaliable chars.
     *
     * @var string
     */
    private $charset;

    /**
     * Desired string.
     *
     * @var string
     */
    private $string;

    /**
     * String length.
     *
     * @var int
     */
    private $length;

    public function __construct($string, $charset)
    {
        $this->string = $string;
        $this->charset = $charset;
        $this->length = strlen($this->string);
    }

    /**
     * @inherit
     */
    public function random()
    {
        $randomString = '';
        for ($i = 0; $i < $this->length; $i++) {
            $randomString .= $this->getRandomChar();
        }

        return $randomString;
    }

    /**
     * @inherit
     */
    public function fitness($individual)
    {
        $score = 0;

        for ($i = 0; $i < strlen($individual); $i++) {
            // Check chromosome
            if ($this->checkChromosome($individual[$i], $i)) {
                $score++;
            }
        }

        $score = $score / $this->length * 100;

        return $score;
    }

    /**
     * @inherit
     */
    public function crossover($x, $y)
    {
        $child = '';
        for ($i = 0; $i < strlen($x); $i++) {
            // Good chromosomes have preference
            if ($this->checkChromosome($x[$i], $i)) {
                $child .= $x[$i];
            } elseif ($this->checkChromosome($y[$i], $i)) {
                $child .= $y[$i];
            // Random
            } else {
                $child .= rand(0, 1) ? $x[$i] : $y[$i];
            }
        }

        return $child;
    }

    /**
     * @inherit
     */
    public function mutate($individual)
    {
        // Avoid to modify good chromosomes
        $mutableChromosomes = [];
        for ($i = 0; $i < strlen($individual); $i++) {
            if (!$this->checkChromosome($individual[$i], $i)) {
                $mutableChromosomes[] = $i;
            }
        }

        if (!empty($mutableChromosomes)) {
            // Get a random percentage of mutation
            $max = count($mutableChromosomes) - 1;
            $percentatge = rand(1, $max);

            // Shuffle
            shuffle($mutableChromosomes);
            foreach (array_slice($mutableChromosomes, 0, $percentatge) as $pos) {

                // Set a random char
                $individual[$pos] = $this->getRandomChar();
            }
        }

        return $individual;
    }

    /**
     * Check a single chromosome.
     *
     * @param string $value
     * @param int    $position
     *
     * @return bool
     */
    private function checkChromosome($value, $position)
    {
        if ($this->string[$position] == $value) {
            return true;
        }

        return false;
    }

    /**
     * Get a random char from the charset.
     *
     * @return string
     */
    private function getRandomChar()
    {
        return $this->charset[rand(0, strlen($this->charset) - 1)];
    }
}
