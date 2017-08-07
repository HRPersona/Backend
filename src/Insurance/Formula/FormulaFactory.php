<?php

namespace Persona\Hris\Insurance\Formula;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class FormulaFactory
{
    /**
     * @var FormulaInterface[]
     */
    private $formulas = [];

    /**
     * @param string           $formulaId
     * @param FormulaInterface $formula
     */
    public function addFormula(string $formulaId, FormulaInterface $formula): void
    {
        $this->formulas[$formulaId] = $formula;
    }

    /**
     * @param string $formulaId
     *
     * @return FormulaInterface
     */
    public function getFormula(string $formulaId): FormulaInterface
    {
        if (array_key_exists($formulaId, $this->formulas)) {
            throw new \InvalidArgumentException(sprintf('Formula with id %s is not found.', $formulaId));
        }

        return $this->formulas[$formulaId];
    }
}
