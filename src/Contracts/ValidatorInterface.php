<?php

declare(strict_types=1);

namespace TrIdentityValidator\Contracts;

interface ValidatorInterface
{
    /**
     * Validate the given identity number
     *
     * @param string $number The identity number to validate
     * @return bool Returns true if valid, false otherwise
     */
    public function validate(string $number): bool;

    /**
     * Get validation result with details
     *
     * @param string $number The identity number to validate
     * @return array Returns validation details
     */
    public function validateWithDetails(string $number): array;
}
