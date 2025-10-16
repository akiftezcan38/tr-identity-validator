<?php

declare(strict_types=1);

namespace TrIdentityValidator\Tests;

use PHPUnit\Framework\TestCase;
use TrIdentityValidator\Validators\VknValidator;

class VknValidatorTest extends TestCase
{
    private VknValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new VknValidator();
    }

    public function testValidVkn(): void
    {
        // Valid VKN examples (these are test numbers)
        $validNumbers = [
            '1234567801',
            '8123456789',
        ];

        foreach ($validNumbers as $vkn) {
            $this->assertTrue(
                $this->validator->validate($vkn),
                "VKN {$vkn} should be valid"
            );
        }
    }

    public function testInvalidVknLength(): void
    {
        $this->assertFalse($this->validator->validate('123456789'));
        $this->assertFalse($this->validator->validate('12345678901'));
    }

    public function testInvalidVknWithLetters(): void
    {
        $this->assertFalse($this->validator->validate('123456789A'));
    }

    public function testInvalidVknChecksum(): void
    {
        $this->assertFalse($this->validator->validate('1234567890'));
    }

    public function testValidateWithDetails(): void
    {
        $result = $this->validator->validateWithDetails('1234567801');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('valid', $result);
        $this->assertArrayHasKey('number', $result);
        $this->assertArrayHasKey('type', $result);
        $this->assertTrue($result['valid']);
        $this->assertEquals('VKN', $result['type']);
    }

    public function testVknWithWhitespace(): void
    {
        $this->assertTrue($this->validator->validate(' 1234567801 '));
    }
}
