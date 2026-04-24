<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Events;

use Ksfraser\Event\Event;

class EmailReceivedEvent extends Event
{
    public const NAME = 'email.received';
    
    private int $emailId;
    private ?string $routingAction;
    
    public function __construct(int $emailId, ?string $routingAction = null)
    {
        $this->emailId = $emailId;
        $this->routingAction = $routingAction;
        parent::__construct(self::NAME);
    }
    
    public function getEmailId(): int
    {
        return $this->emailId;
    }
    
    public function getRoutingAction(): ?string
    {
        return $this->routingAction;
    }
}

class EmailRoutedEvent extends Event
{
    public const NAME = 'email.routed';
    
    private int $emailId;
    private string $action;
    private int $entityId;
    
    public function __construct(int $emailId, string $action, int $entityId)
    {
        $this->emailId = $emailId;
        $this->action = $action;
        $this->entityId = $entityId;
        parent::__construct(self::NAME);
    }
    
    public function getEmailId(): int
    {
        return $this->emailId;
    }
    
    public function getAction(): string
    {
        return $this->action;
    }
    
    public function getEntityId(): int
    {
        return $this->entityId;
    }
}

class EmailAssociatedEvent extends Event
{
    public const NAME = 'email.associated';
    
    private int $emailId;
    private string $entityType;
    private int $entityId;
    
    public function __construct(int $emailId, string $entityType, int $entityId)
    {
        $this->emailId = $emailId;
        $this->entityType = $entityType;
        $this->entityId = $entityId;
        parent::__construct(self::NAME);
    }
    
    public function getEmailId(): int
    {
        return $this->emailId;
    }
    
    public function getEntityType(): string
    {
        return $this->entityType;
    }
    
    public function getEntityId(): int
    {
        return $this->entityId;
    }
}

class MailingListSubscribedEvent extends Event
{
    public const NAME = 'mailinglist.subscribed';
    
    private int $subscriberId;
    private int $listId;
    
    public function __construct(int $subscriberId, int $listId)
    {
        $this->subscriberId = $subscriberId;
        $this->listId = $listId;
        parent::__construct(self::NAME);
    }
    
    public function getSubscriberId(): int
    {
        return $this->subscriberId;
    }
    
    public function getListId(): int
    {
        return $this->listId;
    }
}

class MailingListUnsubscribedEvent extends Event
{
    public const NAME = 'mailinglist.unsubscribed';
    
    private int $subscriberId;
    private int $listId;
    
    public function __construct(int $subscriberId, int $listId)
    {
        $this->subscriberId = $subscriberId;
        $this->listId = $listId;
        parent::__construct(self::NAME);
    }
    
    public function getSubscriberId(): int
    {
        return $this->subscriberId;
    }
    
    public function getListId(): int
    {
        return $this->listId;
    }
}