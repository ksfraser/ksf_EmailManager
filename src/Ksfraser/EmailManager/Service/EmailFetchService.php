<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Service;

use Ksfraser\EmailManager\Entity\InboundEmail;

class EmailFetchService
{
    private ?object $imapConnection = null;
    private array $config = [];
    
    public function connect(array $config): bool
    {
        $this->config = $config;
        
        $host = $config['server_host'] ?? 'localhost';
        $port = $config['server_port'] ?? 993;
        $encryption = $config['encryption'] ?? 'ssl';
        
        $mailbox = "{" . $host . ":" . $port . "/imap/" . $encryption . "}";
        
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';
        
        $this->imapConnection = @imap_open($mailbox, $username, $password);
        
        return $this->imapConnection !== false;
    }
    
    public function disconnect(): void
    {
        if ($this->imapConnection) {
            imap_close($this->imapConnection);
            $this->imapConnection = false;
        }
    }
    
    public function fetchUnread(int $limit = 50): array
    {
        if (!$this->imapConnection) {
            return [];
        }
        
        $emails = [];
        $headers = imap_headers($this->imapConnection);
        
        if (!$headers) {
            return [];
        }
        
        $count = min($limit, count($headers));
        
        for ($i = 1; $i <= $count; $i++) {
            $header = imap_headerinfo($this->imapConnection, $i);
            
            if (isset($header->Unseen) && $header->Unseen === 'U') {
                $emails[] = $this->parseEmail($i);
            }
        }
        
        return $emails;
    }
    
    public function fetchAll(int $limit = 50): array
    {
        if (!$this->imapConnection) {
            return [];
        }
        
        $emails = [];
        $headers = imap_headers($this->imapConnection);
        
        if (!$headers) {
            return [];
        }
        
        $count = min($limit, count($headers));
        
        for ($i = 1; $i <= $count; $i++) {
            $emails[] = $this->parseEmail($i);
        }
        
        return $emails;
    }
    
    private function parseEmail(int $messageNumber): InboundEmail
    {
        $header = imap_headerinfo($this->imapConnection, $messageNumber);
        $structure = imap_fetchstructure($this->imapConnection, $messageNumber);
        
        $email = new InboundEmail();
        $email->setMessageId($header->message_id ?? uniqid());
        $email->setSubject($header->subject ?? '');
        
        $from = $header->from[0] ?? null;
        if ($from) {
            $email->setFromAddress($from->mailbox . '@' . $from->host);
            $email->setFromName($from->personal ?? '');
        }
        
        $to = $header->to[0] ?? null;
        if ($to) {
            $email->setToAddress($to->mailbox . '@' . $to->host);
        }
        
        $email->setReceivedDate(new \DateTime($header->date));
        
        $bodyText = $this->getBody($messageNumber, 'text');
        $bodyHtml = $this->getBody($messageNumber, 'html');
        
        $email->setBodyText($bodyText);
        $email->setBodyHtml($bodyHtml);
        
        return $email;
    }
    
    private function getBody(int $messageNumber, string $type): ?string
    {
        if (!$this->imapConnection) {
            return null;
        }
        
        $body = imap_fetchbody($this->imapConnection, $messageNumber, $type === 'html' ? '2' : '1');
        
        $encoding = imap_utf8($body);
        
        return $encoding ?: $body;
    }
    
    public function markAsRead(int $messageNumber): void
    {
        if ($this->imapConnection) {
            imap_setflag_full($this->imapConnection, $messageNumber, '\\Seen');
        }
    }
    
    public function moveToFolder(int $messageNumber, string $folder): void
    {
        if ($this->imapConnection) {
            imap_mail_move($this->imapConnection, $messageNumber, $folder);
        }
    }
    
    public function delete(int $messageNumber): void
    {
        if ($this->imapConnection) {
            imap_delete($this->imapConnection, $messageNumber);
        }
    }
    
    public function getConnection()
    {
        return $this->imapConnection;
    }
}