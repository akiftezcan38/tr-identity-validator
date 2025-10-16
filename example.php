<?php

require_once __DIR__ . '/vendor/autoload.php';

use TrIdentityValidator\IdentityValidator;

// Initialize validator
$validator = new IdentityValidator();

echo "=== TCKN & VKN Validator Examples ===\n\n";

// Example 1: Simple TCKN validation
echo "Example 1: TCKN Validation\n";
$tckn = '10000000146';
$isValid = $validator->validateTckn($tckn);
echo "TCKN: {$tckn} => " . ($isValid ? '✓ Valid' : '✗ Invalid') . "\n\n";

// Example 2: Simple VKN validation
echo "Example 2: VKN Validation\n";
$vkn = '1234567801';
$isValid = $validator->validateVkn($vkn);
echo "VKN: {$vkn} => " . ($isValid ? '✓ Valid' : '✗ Invalid') . "\n\n";

// Example 3: Detailed TCKN validation
echo "Example 3: Detailed TCKN Validation\n";
$result = $validator->validateTcknWithDetails('10000000146');
print_r($result);
echo "\n";

// Example 4: Detailed VKN validation
echo "Example 4: Detailed VKN Validation\n";
$result = $validator->validateVknWithDetails('1234567801');
print_r($result);
echo "\n";

// Example 5: Auto detection
echo "Example 5: Auto Detection\n";
$numbers = ['10000000146', '1234567801', '12345'];

foreach ($numbers as $number) {
    $result = $validator->validateAuto($number);
    echo "Number: {$number}\n";
    echo "  Type: {$result['detected_type']}\n";
    echo "  Valid: " . ($result['valid'] ? '✓ Yes' : '✗ No') . "\n";
    if (isset($result['error'])) {
        echo "  Error: {$result['error']}\n";
    }
    echo "\n";
}

// Example 6: Invalid cases
echo "Example 6: Invalid Cases\n";
$invalidNumbers = [
    '01234567890',  // Starts with 0
    '12345678901',  // Wrong checksum
    '123456789',    // Too short
    '1234567890A',  // Contains letter
];

foreach ($invalidNumbers as $number) {
    $isValid = $validator->validateTckn($number);
    echo "TCKN: {$number} => " . ($isValid ? '✓ Valid' : '✗ Invalid') . "\n";
}

echo "\n=== Examples completed ===\n";
