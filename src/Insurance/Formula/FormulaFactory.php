<?php

namespace Persona\Hris\Insurance\Formula;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class FormulaFactory
{
    /**
     * @var Formula[]
     */
    private $formulas = [];

    /**
     * @param string  $formulaId
     * @param Formula $formula
     */
    public function addFormula(string $formulaId, Formula $formula): void
    {
        $this->formulas[$formulaId] = $formula;
    }

    /**
     * @param string $formulaId
     *
     * @return Formula
     */
    public function getFormula(string $formulaId): Formula
    {
        if (array_key_exists($formulaId, $this->formulas)) {
            throw new \InvalidArgumentException(sprintf('Formula with id %s is not found.', $formulaId));
        }

        return $this->formulas[$formulaId];
    }
}
