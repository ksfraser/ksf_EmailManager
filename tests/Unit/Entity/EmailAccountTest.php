<?php

use PHPUnit\Framework\TestCase;
use Ksfraser\EmailManager\Entity\EmailAccount;

class EmailAccountTest extends TestCase
{
    public function testCanCreateEmailAccount(): void
    {
        $account = new EmailAccount();
        $account->setAccountName('Support Account');
        $account->setEmailAddress('support@example.com');
        $account->setServerHost('imap.example.com');
        $account->setServerPort(993);
        $account->setEncryption('ssl');
        
        $this->assertEquals('Support Account', $account->getAccountName());
        $this->assertEquals('support@example.com', $account->getEmailAddress());
        $this->assertEquals('imap.example.com', $account->getServerHost());
        $this->assertEquals(993, $account->getServerPort());
        $this->assertEquals('ssl', $account->getEncryption());
    }
    
    public function testToArray(): void
    {
        $account = new EmailAccount();
        $account->id = 1;
        $account->setAccountName('Test Account');
        $account->setEmailAddress('test@example.com');
        $account->setAccountType('imap');
        $account->setServerHost('mail.example.com');
        $account->setServerPort(993);
        $account->setEncryption('ssl');
        $account->setSyncFolder('INBOX');
        $account->setIsActive(true);
        
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