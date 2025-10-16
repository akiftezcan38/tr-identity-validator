<?php

declare(strict_types=1);

namespace TrIdentityValidator\Tests;

use PHPUnit\Framework\TestCase;
use TrIdentityValidator\IdentityValidator;

class IdentityValidatorTest extends TestCase
{
    private IdentityValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new IdentityValidator();
    }

    public function testValidateTckn(): void
    {
        $this->assertTrue($this->validator->validateTckn('10000000146'));
        $this->assertFalse($this->validator->validateTckn('12345678901'));
    }

    public function testValidateVkn(): void
    {
        $this->assertTrue($this->validator->validateVkn('1234567801'));
        $this->assertFalse($this->validator->validateVkn('1234567890'));
    }

    public function testValidateAutoWithTckn(): void
    {
        $result = $this->validator->validateAuto('10000000146');

        $this->assertTrue($result['valid']);
        $this->assertEquals('TCKN', $result['detected_type']);
    }

    public function testValidateAutoWithVkn(): void
    {
        $result = $this->validator->validateAuto('1234567801');

        $this->assertTrue($result['valid']);
        $this->assertEquals('VKN', $result['detected_type']);
    }

    public function testValidateAutoWithInvalidLength(): void
    {
        $result = $this->validator->validateAuto('12345');

        $this->assertFalse($result['valid']);
        $this->assertEquals('UNKNOWN', $result['detected_type']);
        $this->assertArrayHasKey('error', $result);
    }

    public function testGetValidatorInstances(): void
    {
        $this->assertInstanceOf(
            \TrIdentityValidator\Validators\TcknValidator::class,
            $this->validator->getTcknValidator()
        );

        $this->assertInstanceOf(
            \TrIdentityValidator\Validators\VknValidator::class,
            $this->validator->getVknValidator()
        );
    }
}
