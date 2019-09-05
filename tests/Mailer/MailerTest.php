<?php
/**
 *
 *
 * @author: Stefan Ovcharenko <s.ovcharenko@bintime.com>
 * @date: 05.09.2019
 */

namespace App\Tests\Mailer;

use App\Entity\User;
use Twig\Environment;
use App\Mailer\Mailer;
use PHPUnit\Framework\TestCase;
use function foo\func;

class MailerTest extends TestCase
{
    public function testConfirmationEmail()
    {
        $user = new User();
        $user->setEmail('john@doe.com');

        $swiftMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $swiftMailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function ($subject) {
                $messageStr = (string)$subject;
                return strpos($messageStr, "From: mail@from.com") !== false
                    && strpos($messageStr, "Content-Type: text/html; charset=utf-8") !== false
                    && strpos($messageStr, "Subject: Welcome to the micro-post app") !== false
                    && strpos($messageStr, "To: john@doe.com") !== false
                    && strpos($messageStr, "This is a message body") !== false;
            }));

        $twigMock = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
        $twigMock->expects($this->once())
            ->method('render')
            ->with('email/registration.html.twig', [
                    'user' => $user,
            ])->willReturn('This is a message body');

        $mailer = new Mailer($swiftMailer, $twigMock, 'mail@from.com');
        $mailer->sendConfirmationEmail($user);
    }
}
