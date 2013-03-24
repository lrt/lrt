<?php

namespace Lrt\CarmaBundle\Tests\Service;

use Lrt\CarmaBundle\Tests\CarmaWebTestCase;

class MailServiceTest extends CarmaWebTestCase
{

    /**
     * @test
     * @group grdf_carma
     * @group grdf_carma_service
     * @group service_mail
     *
     * @expectedException \Swift_RfcComplianceException
     */
    public function testSendMessageWithException()
    {
        $mail = $this->container->get('carma.service.mail');
        $mail->sendMessage('exception', 'Subject', 'Hello');
    }

    /**
     * @test
     * @group grdf_carma
     * @group grdf_carma_service
     * @group service_mail
     */
    public function testSendMessage()
    {
        $mail = $this->container->get('carma.service.mail');
        $failures = $mail->sendMessage('test@test.com', 'Subject', 'Hello');
        $this->assertTrue(is_array($failures));
        $this->assertCount(0, $failures);
    }

    /**
     * @test
     * @group grdf_carma
     * @group grdf_carma_service
     * @group grdf_carma_service_mail
     */
    public function testSendMessageInCli()
    {
        $mail = $this->container->get('carma.service.mail');
        $failures = $mail->sendMessage('test@test.com', 'Subject', 'Hello', true);
        $this->assertTrue(is_array($failures));
        $this->assertCount(0, $failures);
    }

}
