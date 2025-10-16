<?php

declare(strict_types=1);

namespace TrIdentityValidator\Validators;

use TrIdentityValidator\Contracts\ValidatorInterface;

class TcknValidator implements ValidatorInterface
{
    /**
     * Validate Turkish Identity Number (TCKN)
     * Algorithm based on Turkish Ministry of Interior specification
     *
     * @param string $tckn The TCKN to validate
     * @return bool Returns true if valid, false otherwise
     */
    public function validate(string $tckn): bool
    {
        // Remove any whitespace
        $tckn = trim($tckn);

        // Must be exactly 11 digits
        if (!preg_match('/^\d{11}$/', $tckn)) {
            return false;
        }

        // First digit cannot be 0
        if ($tckn[0] === '0') {
            return false;
        }

        // Convert to array of integers
        $digits = array_map('intval', str_split($tckn));

        // Calculate 10th digit
        // Sum of odd positioned digits (1,3,5,7,9) multiplied by 7
        $oddSum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8];
        
        // Sum of even positioned digits (2,4,6,8)
        $evenSum = $digits[1] + $digits[3] + $digits[5] + $digits[7];
        
        // (oddSum * 7 - evenSum) mod 10 should equal 10th digit
        $digit10 = (($oddSum * 7) - $evenSum) % 10;
        
        if ($digit10 < 0) {
            $digit10 += 10;
        }

        if ($digits[9] !== $digit10) {
            return false;
        }

        // Calculate 11th digit
        // Sum of first 10 digits mod 10 should equal 11th digit
        $sumFirst10 = array_sum(array_slice($digits, 0, 10));
        $digit11 = $sumFirst10 % 10;

        return $digits[10] === $digit11;
    }

    /**
     * Get validation result with details
     *
     * @param string $tckn The TCKN to validate
     * @return array Returns validation details
     */
    public function validateWithDetails(string $tckn): array
    {
        $isValid = $this->validate($tckn);

        return [
            'valid' => $isValid,
            'number' => $tckn,
            'type' => 'TCKN',
            'length' => strlen(trim($tckn)),
            'algorithm' => 'Turkish Ministry of Interior TCKN Algorithm'
        ];
    }
}
