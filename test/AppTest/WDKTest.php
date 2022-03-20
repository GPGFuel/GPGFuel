<?php

use App\Utilities;

class WDKTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider emailProvider
     */
    public function testWDKHash($email, $expected, $exception = null)
    {
        if ($exception) {
            $this->expectException($exception);
        }

        $result = Utilities::emailToWDKHash($email);
        $this->assertEquals($expected, $result);
    }

    public function emailProvider()
    {
        return [
            [
                'wklonowski@tsukaeru.net',
                '6gq6mmastou5sbu9cpmx795ersu9j4mq',
            ],
            [
                'wklonowski@gmail.com',
                '6gq6mmastou5sbu9cpmx795ersu9j4mq',
            ],
            [
                'Wiktor.Klonowski@gmail.com',
                'e3feac8hbrnkex4f9iuwtq384wrz6w6n',
            ],
            [
                'cloudfest2@test.gpgfuel.com',
                'ihj5xzfdri3sfinmzjzsdq5nzmoqaoec',
            ],
            [
                'invalid_email',
                '',
                InvalidArgumentException::class,
            ],
        ];
    }
}