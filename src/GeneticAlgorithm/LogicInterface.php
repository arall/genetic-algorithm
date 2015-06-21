<?php

namespace Arall\GeneticAlgorithm;

/**
 * Logic interface.
 * Represents the logic for the Genetic Algorithm.
 *
 * @author Gerard Arall <gerard.arall@gmail.com>
 *
 * @link https://github.com/arall/genetic-algorithm
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
     * @param mixed $individual
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
