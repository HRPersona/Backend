<?php

namespace Persona\Hris\Share\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface SkillAwareInterface
{
    /**
     * @return string
     */
    public function getSkillId(): string;

    /**
     * @param string|null $skill
     */
    public function setSkillId(string $skill = null);

    /**
     * @return null|SkillInterface
     */
    public function getSkill(): ? SkillInterface;

    /**
     * @param SkillInterface|null $skill
     */
    public function setSkill(SkillInterface $skill = null): void;
}
