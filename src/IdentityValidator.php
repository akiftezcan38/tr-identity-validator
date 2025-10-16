<?php

declare(strict_types=1);

namespace TrIdentityValidator;

use TrIdentityValidator\Validators\TcknValidator;
use TrIdentityValidator\Validators\VknValidator;

class IdentityValidator
{
    private TcknValidator $tcknValidator;
    private VknValidator $vknValidator;

    public function __construct()
    {
        $this->tcknValidator = new TcknValidator();
        $this->vknValidator = new VknValidator();
    }

    /**
     * Validate TCKN (Turkish Identity Number)
     *
     * @param string $tckn The TCKN to validate
     * @return bool Returns true if valid, false otherwise
     */
    public function validateTckn(string $tckn): bool
    {
        return $this->tcknValidator->validate($tckn);
    }

    /**
     * Validate VKN (Turkish Tax Number)
     *
     * @param string $vkn The VKN to validate
     * @return bool Returns true if valid, false otherwise
     */
    public function validateVkn(string $vkn): bool
    {
        return $this->vknValidator->validate($vkn);
    }

    /**
     * Validate TCKN with details
     *
     * @param string $tckn The TCKN to validate
     * @return array Returns validation details
     */
    public function validateTcknWithDetails(string $tckn): array
    {
        return $this->tcknValidator->validateWithDetails($tckn);
    }

    /**
     * Validate VKN with details
     *
     * @param string $vkn The VKN to validate
     * @return array Returns validation details
     */
    public function validateVknWithDetails(string $vkn): array
    {
        return $this->vknValidator->validateWithDetails($vkn);
    }

    /**
     * Auto-detect and validate (tries both TCKN and VKN)
     *
     * @param string $number The number to validate
     * @return array Returns validation result with type detection
     */
    public function validateAuto(string $number): array
    {
        $number = trim($number);
        $length = strlen($number);

        if ($length === 11) {
            $result = $this->validateTcknWithDetails($number);
            $result['detected_type'] = 'TCKN';
            return $result;
        }

        if ($length === 10) {
            $result = $this->validateVknWithDetails($number);
            $result['detected_type'] = 'VKN';
            return $result;
        }

        return [
            'valid' => false,
            'number' => $number,
            'type' => 'UNKNOWN',
            'detected_type' => 'UNKNOWN',
            'length' => $length,
            'error' => 'Invalid length. Must be 10 (VKN) or 11 (TCKN) digits.'
        ];
    }

    /**
     * Get TCKN validator instance
     *
     * @return TcknValidator
     */
    public function getTcknValidator(): TcknValidator
    {
        return $this->tcknValidator;
    }

    /**
     * Get VKN validator instance
     *
     * @return VknValidator
     */
    public function getVknValidator(): VknValidator
    {
        return $this->vknValidator;
    }
}
