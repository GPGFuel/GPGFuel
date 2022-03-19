<?php

use App\Utilities;

class FilterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider emailProvider
     */
    public function testFilterEmailAddresses($emails, $domains, $expected, $exception = false)
    {
        if ($exception) {
            $this->expectException(InvalidArgumentException::class);
        }

        $result = Utilities::filterEmailAddresses($emails, $domains);
        $this->assertEquals($expected, $result); // Should work for simple arrays
    }

    public function emailProvider()
    {
        return [
            [
                ['john@example.com', 'scott@test.com'],
                ['example.com'],
                ['john@example.com'],
            ],
            [
                [],
                ['example.com'],
                [],
            ],
            [
                ['john@example.com', 'scott@test.com'],
                [],
                [],
            ],
            [
                ['johnexample.com', 'scott@test.com'],
                ['example.com'],
                [],
            ],
            [
                'string',
                ['example.com'],
                ['john@example.com'],
                true,
            ],
            [
                ['john@example.com', 'scott@test.com'],
                42,
                ['john@example.com'],
                true,
            ],
        ];
    }
}