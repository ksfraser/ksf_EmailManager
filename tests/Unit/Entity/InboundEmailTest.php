<?php

use PHPUnit\Framework\TestCase;
use Ksfraser\EmailManager\Entity\InboundEmail;

class InboundEmailTest extends TestCase
{
    public function testCanCreateInboundEmail(): void
    {
        $email = new InboundEmail();
        $email->setMessageId('<test@example.com>');
        $email->setSubject('Test Subject');
        $email->setFromAddress('sender@example.com');
        $email->setFromName('Test Sender');
        $email->setToAddress('recipient@example.com');
        
        $this->assertEquals('<test@example.com>', $email->getMessageId());
        $this->assertEquals('Test Subject', $email->getSubject());
        $this->assertEquals('sender@example.com', $email->getFromAddress());
        $this->assertEquals('Test Sender', $email->getFromName());
        $this->assertEquals('recipient@example.com', $email->getToAddress());
    }
    
    public function testToArray(): void
    {
        $email = new InboundEmail();
        $email->id = 1;
        $email->setMessageId('<msg123>');
        $email->setSubject('Test Email');
        $email->setFromAddress('from@example.com');
        $email->setToAddress('to@example.com');
        $email->setBodyText('Plain text body');
        $email->setBodyHtml('<p>HTML body</p>');
        $email->setRoutingAction('ticket');
        $email->setLinkedEntityId(5);
        $email->setLinkedEntityType('ticket');
        
        $arr = $email->toArray();
        
        $this->assertEquals(1, $arr['id']);
        $this->assertEquals('Test Email', $arr['subject']);
        $this->assertEquals('ticket', $arr['routing_action']);
        $this->assertEquals(5, $arr['linked_entity_id']);
        $this->assertEquals('ticket', $arr['linked_entity_type']);
    }
    
    public function testAttachments(): void
    {
        $email = new InboundEmail();
        $email->setAttachments([
            ['name' => 'file1.pdf', 'size' => 1024],
            ['name' => 'file2.jpg', 'size' => 2048],
        ]);
        
        $attachments = $email->getAttachments();
        
        $this->assertCount(2, $attachments);
        $this->assertEquals('file1.pdf', $attachments[0]['name']);
    }
    
    public function testFromArray(): void
    {
        $data = [
            'id' => 10,
            'message_id' => '<msg@test>',
            'subject' => 'From Array',
            'from_address' => 'array@example.com',
            'to_address' => 'list@example.com',
            'body_text' => 'Text body',
            'routing_action' => 'opportunity',
            'linked_entity_id' => 100,
            'linked_entity_type' => 'opportunity',
        ];
        
        $email = InboundEmail::fromArray($data);
        
        $this->assertEquals(10, $email->id);
        $this->assertEquals('From Array', $email->getSubject());
        $this->assertEquals('opportunity', $email->getRoutingAction());
    }
}