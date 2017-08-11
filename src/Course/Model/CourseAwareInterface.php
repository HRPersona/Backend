<?php

namespace Persona\Hris\Course\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CourseAwareInterface
{
    /**
     * @return string
     */
    public function getCourseId(): string;

    /**
     * @param string|null $course
     */
    public function setCourseId(string $course = null);

    /**
     * @return null|CourseInterface
     */
    public function getCourse(): ? CourseInterface;

    /**
     * @param CourseInterface|null $course
     */
    public function setCourse(CourseInterface $course = null): void;
}
