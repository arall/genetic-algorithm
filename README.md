# Genetic Algorithm

This is an implementation of genetic optimization algorithms. Check the tests files to know exactly how it works.

## How to use it

A new `GeneticAlgorithm` model should be initialized. The following parameters can be setted, using the setters:

* setPopulationSize($int): Max population size (childrens) for each generation.
* setCandidatesSize($int): Amount of candidates (sorted by fitness score) that will remain on the next generation.
* setmutationProvability($int): Percentage (over 100) of mutation provability.
* setminScore($int): Min score that we are looking for. Once reached, the algorithm will stop.
* setmaxGenerations($int): Max generations limit. Once reached, the algorithm will stop.

Also, a class that uses the `LogicInterface` interface is needed. That interface have the following methods, and should be implemented.

### random()

Generates a random Individual. Used to generate the first Population.

### fitness($individual)

Should return a score for the Individual recived. The more score, the better.

### mutate($individual)

Mutates an Individual.Mutation is used to slightly alter an Individual gen (mostly random) to provide diversity in you developing population.

### crossover($individual, $individual)

Cross two Individuals (mixing the gens), generating a new Individual.