<?php

use PHPUnit\Framework\TestCase;
use Ksfraser\EmailManager\Service\EmailRoutingService;
use Ksfraser\EmailManager\Entity\InboundEmail;

class EmailRoutingServiceTest extends TestCase
{
    private EmailRoutingService $service;
    
    protected function setUp(): void
    {
        $this->service = new EmailRoutingService();
    }
    
    public function testRouteToTicketByKeyword(): void
    {
        $this->service->addRoute('support@company.com', 'ticket', ['help', 'issue', 'problem']);
        
        $email = new InboundEmail();
        $email->setToAddress('support@company.com');
        $email->setSubject('Need help with login');
        $email->setBodyText('I cannot login to my account');
        
        $result = $this->service->route($email);
        
        $this->assertEquals('ticket', $result['action']);
        $this->assertStringContainsString('help', $result['reason']);
    }
    
    public function testRouteToOpportunityByTOAddress(): void
    {
        $this->service->addRoute('sales@company.com', 'opportunity', []);
        
        $email = new InboundEmail();
        $email->setToAddress('sales@company.com');
        $email->setSubject('Interested in your product');
        $email->setBodyText('Please send me more info');
        
        $result = $this->service->route($email);
        
        $this->assertEquals('opportunity', $result['action']);
        $this->assertEquals('TO address match', $result['reason']);
    }
    
    public function testDefaultRoute(): void
    {
        $email = new InboundEmail();
        $email->setToAddress('unknown@company.com');
        $email->setSubject('Random email');
        
        $result = $this->service->route($email);
        
        $this->assertEquals('ticket', $result['action']);
    }
    
    public function testHelperMethods(): void
    {
        $this->service->addTicketKeyword('refund');
        $this->service->addOpportunityKeyword('quote');
        
        $email = new InboundEmail();
        $email->setToAddress('support@company.com');
        $email->setSubject('Refund request');
        
        $result = $this->service->route($email);
        
        $this->assertEquals('ticket', $result['action']);
    }
}