<?php

namespace Arall\GeneticAlgorithm;

/**
 * Genetic Algorithm class.
 *
 * @author Gerard Arall <gerard.arall@gmail.com>
 *
 * @link https://github.com/arall/genetic-algorithm
 */
class GeneticAlgorithm
{
    /**
     * Population size for each generation.
     *
     * @var int
     */
    private $populationSize = 500;

    /**
     * Candidates to move through generations.
     *
     * @var int
     */
    private $candidatesSize = 100;

    /**
     * Mutation provability percentage.
     *
     * @var int
     */
    private $mutationProvability = 30;

    /**
     * Min score wanted.
     *
     * @var int
     */
    private $minScore = 100;

    /**
     * Max generations allowed.
     *
     * @var int
     */
    private $maxGenerations = 100;

    /**
     * Logic interface.
     *
     * @var LogicInterface
     */
    private $logic;

    /**
     * Population container.
     *
     * @var array
     */
    private $population = [];

    /**
     * Current generation.
     *
     * @var int
     */
    private $generation = 0;

    /**
     * Individual cementery.
     *
     * @var array
     */
    private $cementery = [];

    /**
     * Construct.
     *
     * @param LogicInterface $logic
     */
    public function __construct(LogicInterface $logic)
    {
        $this->logic = $logic;
    }

    /**
     * Set population size.
     *
     * @param int $populationSize
     *
     * @return bool
     */
    public function setPopulationSize($populationSize)
    {
        return $this->populationSize = $populationSize;
    }

    /**
     * Set candidates size.
     *
     * @param int $candidatesSize
     *
     * @return bool
     */
    public function setCandidatesSize($candidatesSize)
    {
        return $this->candidatesSize = $candidatesSize;
    }

    /**
     * Set mutation provability.
     *
     * @param int $mutationProvability
     *
     * @return bool
     */
    public function setmutationProvability($mutationProvability)
    {
        return $this->mutationProvability = $mutationProvability;
    }

    /**
     * Set min score.
     *
     * @param int $minScore
     *
     * @return bool
     */
    public function setminScore($minScore)
    {
        return $this->minScore = $minScore;
    }

    /**
     * Set max generations.
     *
     * @param int $maxGenerations
     *
     * @return bool
     */
    public function setmaxGenerations($maxGenerations)
    {
        return $this->maxGenerations = $maxGenerations;
    }

    /**
     * Main function (runs the algoritm).
     *
     * @return mixed
     */
    public function run()
    {
        // Initialize
        $this->initialPopulation();

        // Start
        return $this->evolve();
    }

    /**
     * Evolution function.
     *
     * @return mixed
     */
    public function evolve()
    {
        // Crossover
        $individuals = $this->cross();

        // Kill all the population
        $this->genocide();

        // Next generation
        $this->generation++;

        // Set the best candidates
        $this->setCandidates($individuals);

        // Finish?
        return $this->check();
    }

    /**
     * Cross all the current population.
     *
     * @return array
     */
    private function cross()
    {
        $individuals = [];

        // For each population...
        for ($i = 0; $i < $this->populationSize; $i++) {
            // Crossover
            $individual = $this->logic->crossover(
                $this->getRandomIndividual(), $this->getRandomIndividual()
            );
            // Mutation
            if (rand(0, 100) <= $this->mutationProvability) {
                do {
                    $individual = $this->logic->mutate($individual);
                } while (in_array($individual, $this->cementery));
            }
            // Store the individual
            $individuals[] = $individual;
        }

        return $individuals;
    }

    /**
     * Generate a random individual.
     *
     * @return mixed
     */
    public function getRandomIndividual()
    {
        return $this->population[array_rand($this->population)];
    }

    /**
     * Sets the initial population.
     */
    public function initialPopulation()
    {
        for ($i = 0; $i < $this->populationSize; $i++) {
            // Create a new individual
            $individual = $this->logic->random();

            // Add it
            $this->addIndividual($individual);
        }
    }

    /**
     * Add an individual to the current population.
     *
     * @param mixed $individual
     *
     * @return bool
     */
    public function addIndividual($individual)
    {
        return $this->population[] = $individual;
    }

    /**
     * Kill all the current population.
     */
    public function genocide()
    {
        $this->cementery += $this->population;
        array_unique($this->cementery);
        $this->population = [];
    }

    /**
     * Set the best candidates as current population.
     *
     * @param array $individuals
     *
     * @return array $individuals
     */
    private function setCandidates($individuals)
    {
        // Sort using fitness
        usort($individuals, [$this->logic, 'fitness']);
        $individuals = array_reverse($individuals);

        // Select only the firsts based on candidates size
        for ($i = 0; $i < $this->candidatesSize; $i++) {
            $this->addIndividual($individuals[$i]);
        }
    }

    /**
     * Check the current population.
     * Will try to return an individual that matches the desired min score.
     *
     * @return mixed
     */
    private function check()
    {
        // Get the first one (since its sorted)
        $bestCandidate = reset($this->population);

        // Check its fitness
        $score = $this->logic->fitness($bestCandidate);

        // Check score
        if ($score < $this->minScore) {
            // Check generations number
            if ($this->maxGenerations >= $this->generation) {
                // Next generation
                return $this->evolve();
            }
        }

        return $bestCandidate;
    }
}
