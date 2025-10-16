<?php

declare(strict_types=1);

namespace TrIdentityValidator\Tests;

use PHPUnit\Framework\TestCase;
use TrIdentityValidator\Validators\TcknValidator;

class TcknValidatorTest extends TestCase
{
    private TcknValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new TcknValidator();
    }

    public function testValidTckn(): void
    {
        // Valid TCKN examples (these are test numbers)
        $validNumbers = [
            '10000000146',
            '10000000302',
            '10000000476',
        ];

        foreach ($validNumbers as $tckn) {
            $this->assertTrue(
                $this->validator->validate($tckn),
                "TCKN {$tckn} should be valid"
            );
        }
    }

    public function testInvalidTcknStartingWithZero(): void
    {
        $this->assertFalse($this->validator->validate('01234567890'));
    }

    public function testInvalidTcknLength(): void
    {
        $this->assertFalse($this->validator->validate('123456789'));
        $this->assertFalse($this->validator->validate('123456789012'));
    }

    public function testInvalidTcknWithLetters(): void
    {
        $this->assertFalse($this->validator->validate('1234567890A'));
    }

    public function testInvalidTcknChecksum(): void
    {
        $this->assertFalse($this->validator->validate('12345678901'));
    }

    public function testValidateWithDetails(): void
    {
        $result = $this->validator->validateWithDetails('10000000146');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('valid', $result);
        $this->assertArrayHasKey('number', $result);
        $this->assertArrayHasKey('type', $result);
        $this->assertTrue($result['valid']);
        $this->assertEquals('TCKN', $result['type']);
    }

    public function testTcknWithWhitespace(): void
    {
        $this->assertTrue($this->validator->validate(' 10000000146 '));
    }
}
