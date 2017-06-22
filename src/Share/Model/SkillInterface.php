<?php

namespace Persona\Hris\Share\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface SkillInterface
{
    const LEVEL_BEGINNER = 'b';
    const LEVEL_INTERMEDIATE = 'i';
    const LEVEL_ADVANCED = 'a';
    const LEVEL_EXPERT = 'e';

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getName(): string;
}
