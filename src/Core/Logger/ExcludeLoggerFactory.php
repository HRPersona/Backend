<?php

namespace Persona\Hris\Core\Logger;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ExcludeLoggerFactory
{
    /**
     * @var ExcludePathInterface[]
     */
    private $excludePaths;

    /**
     * @param ExcludePathInterface[] $excludePaths
     */
    public function __construct(array $excludePaths = [])
    {
        $this->excludePaths = $excludePaths;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public function isExcludeLog(string $path): bool
    {
        foreach ($this->excludePaths as $excludePath) {
            if ($excludePath->isExclude($path)) {
                return true;
            }
        }

        return false;
    }
}
