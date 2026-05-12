<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Tests\Unit\Entity;

use Ksfraser\EmailManager\Entity\SentEmail;
use PHPUnit\Framework\TestCase;

class SentEmailTest extends TestCase
{
    private SentEmail $email;

    protected function setUp(): void
    {
        $this->email = new SentEmail();
    }

    public function testSetAndGetTemplateId(): void
    {
        $result = $this->email->setTemplateId('tmpl_123');
        $this->assertSame($this->email, $result);
        $this->assertSame('tmpl_123', $this->email->getTemplateId());
    }

    public function testSetAndGetFromAddress(): void
    {
        $result = $this->email->setFromAddress('sender@example.com');
        $this->assertSame($this->email, $result);
        $this->assertSame('sender@example.com', $this->email->getFromAddress());
    }

    public function testSetAndGetFromName(): void
    {
        $result = $this->email->setFromName('Sender Name');
        $this->assertSame($this->email, $result);
        $this->assertSame('Sender Name', $this->email->getFromName());
    }

    public function testSetAndGetToAddress(): void
    {
        $result = $this->email->setToAddress('recipient@example.com');
        $this->assertSame($this->email, $result);
        $this->assertSame('recipient@example.com', $this->email->getToAddress());
    }

    public function testSetAndGetEntity(): void
    {
        $this->email->setEntityType('customer');
        $this->email->setEntityId('cust_123');

        $this->assertSame('customer', $this->email->getEntityType());
        $this->assertSame('cust_123', $this->email->getEntityId());
    }

    public function testIncrementOpens(): void
    {
        $this->assertSame(0, $this->email->getOpens());
        $this->email->incrementOpens();
        $this->email->incrementOpens();
        $this->assertSame(2, $this->email->getOpens());
    }

    public function testIncrementClicks(): void
    {
        $this->assertSame(0, $this->email->getClicks());
        $this->email->incrementClicks();
        $this->assertSame(1, $this->email->getClicks());
    }

    public function testBounced(): void
    {
        $this->assertFalse($this->email->isBounced());
        $this->email->setBounced(true);
        $this->assertTrue($this->email->isBounced());
    }

    public function testUnsubscribed(): void
    {
        $this->assertFalse($this->email->isUnsubscribed());
        $this->email->setUnsubscribed(true);
        $this->assertTrue($this->email->isUnsubscribed());
    }

    public function testToArray(): void
    {
        $this->email->setId('email_123');
        $this->email->setFromAddress('from@test.com');
        $this->email->setToAddress('to@test.com');
        $this->email->setSubject('Test');
        $this->email->setOpens(5);
        $this->email->setClicks(2);

        $array = $this->email->toArray();

        $this->assertSame('email_123', $array['id']);
        $this->assertSame('from@test.com', $array['from_address']);
        $this->assertSame('to@test.com', $array['to_address']);
        $this->assertSame('Test', $array['subject']);
        $this->assertSame(5, $array['opens']);
        $this->assertSame(2, $array['clicks']);
    }

    public function testFromArray(): void
    {
        $data = [
            'id' => 'email_456',
            'template_id' => 'tmpl_001',
            'from_address' => 'sender@example.com',
            'to_address' => 'receiver@example.com',
            'subject' => 'Hello',
            'body' => 'Message body',
            'opens' => 10,
            'clicks' => 3,
        ];

        $email = SentEmail::fromArray($data);

        $this->assertSame('email_456', $email->getId());
        $this->assertSame('tmpl_001', $email->getTemplateId());
        $this->assertSame('sender@example.com', $email->getFromAddress());
        $this->assertSame('receiver@example.com', $email->getToAddress());
        $this->assertSame(10, $email->getOpens());
        $this->assertSame(3, $email->getClicks());
    }
}
