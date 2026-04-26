<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Service;

use Ksfraser\EmailManager\Entity\InboundEmail;

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
        $toAddress = strtolower($email->toAddress ?? '');
        $subject = strtolower($email->subject ?? '');
        $body = strtolower($email->bodyText ?? '');
        
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