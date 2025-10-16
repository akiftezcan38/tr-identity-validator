<?php

declare(strict_types=1);

namespace TrIdentityValidator\Validators;

use TrIdentityValidator\Contracts\ValidatorInterface;

class VknValidator implements ValidatorInterface
{
    /**
     * Validate Turkish Tax Number (VKN)
     * Algorithm based on Turkish Revenue Administration specification
     *
     * @param string $vkn The VKN to validate
     * @return bool Returns true if valid, false otherwise
     */
    public function validate(string $vkn): bool
    {
        // Remove any whitespace
        $vkn = trim($vkn);

        // Must be exactly 10 digits
        if (!preg_match('/^\d{10}$/', $vkn)) {
            return false;
        }

        // Convert to array of integers
        $digits = array_map('intval', str_split($vkn));

        // VKN Algorithm
        $sum = 0;
        
        for ($i = 0; $i < 9; $i++) {
            $digit = $digits[$i];
            $order = 9 - $i;
            
            // Calculate: (digit + order) mod 10
            $temp = ($digit + $order) % 10;
            
            // Multiply by 2^(9-i) and get mod 9
            $multiplier = 1 << $order; // 2^order
            $temp = ($temp * $multiplier) % 9;
            
            // If result is 0, add 9 instead
            if ($temp === 0) {
                $temp = 9;
            }
            
            $sum += $temp;
        }

        // Last digit should be (10 - (sum mod 10)) mod 10
        $checkDigit = (10 - ($sum % 10)) % 10;

        return $digits[9] === $checkDigit;
    }

    /**
     * Get validation result with details
     *
     * @param string $vkn The VKN to validate
     * @return array Returns validation details
     */
    public function validateWithDetails(string $vkn): array
    {
        $isValid = $this->validate($vkn);

        return [
            'valid' => $isValid,
            'number' => $vkn,
            'type' => 'VKN',
            'length' => strlen(trim($vkn)),
            'algorithm' => 'Turkish Revenue Administration VKN Algorithm'
        ];
    }
}
