<?php

namespace Arall\GeneticAlgorithm;

/**
 * Logic interface.
 */
interface LogicInterface
{
    /**
     * Random individual generation.
     * Used for the initial population.
     *
     * @return midex
     */
    public function random();

    /**
     * Fitness calculation.
     * The more, the better.
     *
     * @return float
     */
    public function fitness($individual);

    /**
     * Individual crossover.
     *
     * @param mixed $x
     * @param mixed $y
     *
     * @return mixed
     */
    public function crossover($x, $y);

    /**
     * Individual mutation.
     *
     * @param mixed $individual
     *
     * @return mixed
     */
    public function mutate($individual);
}
