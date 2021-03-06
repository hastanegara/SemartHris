<?php

namespace KejawenLab\Application\SemartHris\Component;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@kejawenlab.com>
 */
interface ValidateTypeInterface
{
    /**
     * @param string $type
     *
     * @return bool
     */
    public static function isValidType(string $type): bool;

    /**
     * @return array
     */
    public static function getTypes(): array;

    /**
     * @param string $type
     *
     * @return string
     */
    public static function convertToText(string $type): string;
}
