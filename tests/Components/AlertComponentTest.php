<?php

namespace Enabel\LayoutBundle\Tests\Components;

use Enabel\LayoutBundle\Components\AlertComponent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

class AlertComponentTest extends TestCase
{
    public function testPreMountWithDefaults(): void
    {
        $component = new AlertComponent();

        $data = [
            'message' => 'Test message'
        ];

        $result = $component->preMount($data);

        $this->assertSame('Test message', $result['message']);
        $this->assertSame('success', $result['alertType']);
    }

    public function testPreMountWithCustomAlertType(): void
    {
        $component = new AlertComponent();

        $data = [
            'message' => 'Test message',
            'alertType' => 'warning'
        ];

        $result = $component->preMount($data);

        $this->assertSame('Test message', $result['message']);
        $this->assertSame('warning', $result['alertType']);
    }

    public function testPreMountWithInvalidAlertType(): void
    {
        $component = new AlertComponent();

        $data = [
            'message' => 'Test message',
            'alertType' => 'invalid'
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The option "alertType" with value "invalid" is invalid');

        $component->preMount($data);
    }

    public function testPreMountWithMissingMessage(): void
    {
        $component = new AlertComponent();

        $data = [
            'alertType' => 'success'
        ];

        $this->expectException(MissingOptionsException::class);
        $this->expectExceptionMessage('The required option "message" is missing');

        $component->preMount($data);
    }

    /**
     * @dataProvider alertTypeProvider
     */
    public function testIconSetByAlertType(string $alertType, string $expectedIcon, string $expectedType): void
    {
        $component = new AlertComponent();

        $component->mount($alertType);
        $component->setMessage('Test message');

        $this->assertSame($expectedIcon, $component->getIcon());
        $this->assertSame($expectedType, $component->getType());
        $this->assertSame('Test message', $component->getMessage());
    }

    /**
     * @return array<string, array{0: string, 1: string, 2: string}>
     */
    public function alertTypeProvider(): array
    {
        return [
            'success' => ['success', 'fa-circle-check', 'success'],
            'danger' => ['danger', 'fa-circle-exclamation', 'danger'],
            'error' => ['error', 'fa-circle-exclamation', 'danger'],
            'warning' => ['warning', 'fa-triangle-exclamation', 'warning'],
            'info' => ['info', 'fa-circle-info', 'info'],
            'default' => ['unknown', 'fa-circle-check', 'success'], // Should use success as default
        ];
    }
}
