<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Service;

use Ksfraser\EmailManager\Entity\InboundEmail;
use Ksfraser\Event\EventDispatcher;

class EmailRoutingService
{
    private array $routes = [];
    
    public function addRoute(string $toAddress, string $action, array $keywords = []): self
    {
        $this->routes[] = [
            'to_address' => strtolower($toAddress),
            'action' => $action,
            'keywords' => array_map('strtolower', $keywords),
        ];
        return $this;
    }
    
    public function route(InboundEmail $email): array
    {
        $toAddress = strtolower($email->getToAddress() ?? '');
        $subject = strtolower($email->getSubject() ?? '');
        $body = strtolower($email->getBodyText() ?? '');
        
        foreach ($this->routes as $route) {
            if ($route['to_address'] === $toAddress) {
                $keywords = $route['keywords'];
                
                if (empty($keywords)) {
                    return [
                        'action' => $route['action'],
                        'reason' => 'TO address match',
                    ];
                }
                
                foreach ($keywords as $keyword) {
                    if (strpos($subject, $keyword) !== false || strpos($body, $keyword) !== false) {
                        return [
                            'action' => $route['action'],
                            'reason' => "Keyword match: {$keyword}",
                        ];
                    }
                }
            }
        }
        
        return [
            'action' => 'ticket',
            'reason' => 'default',
        ];
    }
    
    public function addTicketKeyword(string $keyword): self
    {
        return $this->addRoute('support@', 'ticket', [$keyword]);
    }
    
    public function addOpportunityKeyword(string $keyword): self
    {
        return $this->addRoute('sales@', 'opportunity', [$keyword]);
    }
    
    public function getDefaultRoute(): array
    {
        return [
            'action' => 'ticket',
            'reason' => 'no match',
        ];
    }
}

class EmailAssociationService
{
    public function findDebtorByEmail(string $emailAddress): ?int
    {
        return $this->findEntityByEmail('debtors_master', 'debtor_no', $emailAddress);
    }
    
    public function findContactByEmail(string $emailAddress): ?int
    {
        return $this->findEntityByEmail('crm_contacts', 'contact_id', $emailAddress);
    }
    
    private function findEntityByEmail(string $table, string $idField, string $emailAddress): ?int
    {
        if (!function_exists('db_query')) {
            return null;
        }
        
        global $db;
        
        $emailColumn = $idField === 'debtor_no' ? 'email' : 'email';
        
        $sql = "SELECT {$idField} FROM " . TB_PREF . "{$table} 
            WHERE {$emailColumn} = " . db_escape($emailAddress) . " 
            LIMIT 1";
        
        $result = @db_query($sql);
        if (!$result) {
            return null;
        }
        
        $row = @db_fetch_assoc($result);
        if (!$row) {
            return null;
        }
        
        return (int) $row[$idField];
    }
    
    public function associateWithDebtor(InboundEmail $email, int $debtorNo): void
    {
        $email->setDebtorNo($debtorNo);
        
        if (class_exists(EventDispatcher::class)) {
            EventDispatcher::dispatch('email.associated', [
                'email_id' => $email->id,
                'debtor_no' => $debtorNo,
            ]);
        }
    }
    
    public function associateWithContact(InboundEmail $email, int $contactId): void
    {
        $email->setContactId($contactId);
    }
}