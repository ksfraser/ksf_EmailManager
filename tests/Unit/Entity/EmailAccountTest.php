<?php

use PHPUnit\Framework\TestCase;
use Ksfraser\EmailManager\Entity\EmailAccount;

class EmailAccountTest extends TestCase
{
    public function testCanCreateEmailAccount(): void
    {
        $account = new EmailAccount();
        $account->accountName = 'Support Account';
        $account->emailAddress = 'support@example.com';
        $account->serverHost = 'imap.example.com';
        $account->serverPort = 993;
        $account->encryption = 'ssl';
        
        $this->assertEquals('Support Account', $account->accountName);
        $this->assertEquals('support@example.com', $account->emailAddress);
        $this->assertEquals('imap.example.com', $account->serverHost);
        $this->assertEquals(993, $account->serverPort);
        $this->assertEquals('ssl', $account->encryption);
    }
    
    public function testToArray(): void
    {
        $account = new EmailAccount();
        $account->id = 1;
        $account->accountName = 'Test Account';
        $account->emailAddress = 'test@example.com';
        $account->accountType = 'imap';
        $account->serverHost = 'mail.example.com';
        $account->serverPort = 993;
        $account->encryption = 'ssl';
        $account->syncFolder = 'INBOX';
        $account->isActive = true;
        
        $arr = $account->toArray();
        
        $this->assertEquals(1, $arr['id']);
        $this->assertEquals('Test Account', $arr['account_name']);
        $this->assertEquals('test@example.com', $arr['email_address']);
        $this->assertEquals('imap', $arr['account_type']);
    }
    
    public function testFromArray(): void
    {
        $data = [
            'id' => 5,
            'account_name' => 'From Array',
            'email_address' => 'from@example.com',
            'account_type' => 'imap',
            'server_host' => 'host.example.com',
            'server_port' => 993,
            'encryption' => 'ssl',
            'username' => 'user',
            'sync_folder' => 'INBOX',
            'is_active' => true,
            'debtor_no' => 10,
            'contact_id' => 20,
        ];
        
        $account = EmailAccount::fromArray($data);
        
        $this->assertEquals(5, $account->id);
        $this->assertEquals('From Array', $account->getAccountName());
        $this->assertEquals(10, $account->getDebtorNo());
        $this->assertEquals(20, $account->getContactId());
    }
    
    public function testDefaultValues(): void
    {
        $account = new EmailAccount();
        
        $this->assertEquals('imap', $account->getAccountType());
        $this->assertEquals('INBOX', $account->getSyncFolder());
        $this->assertTrue($account->getIsActive());
        $this->assertEquals('ssl', $account->getEncryption());
    }
}