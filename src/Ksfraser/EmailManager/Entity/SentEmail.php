<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Entity;

class SentEmail
{
    private ?string $id = null;
    private ?string $templateId = null;
    private string $fromAddress = '';
    private ?string $fromName = null;
    private string $toAddress = '';
    private string $subject = '';
    private string $body = '';
    private ?string $entityType = null;
    private ?string $entityId = null;
    private int $opens = 0;
    private int $clicks = 0;
    private bool $bounced = false;
    private bool $unsubscribed = false;
    private ?\DateTime $sentAt = null;
    private ?\DateTime $createdAt = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTemplateId(): ?string
    {
        return $this->templateId;
    }

    public function setTemplateId(?string $templateId): self
    {
        $this->templateId = $templateId;
        return $this;
    }

    public function getFromAddress(): string
    {
        return $this->fromAddress;
    }

    public function setFromAddress(string $fromAddress): self
    {
        $this->fromAddress = $fromAddress;
        return $this;
    }

    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    public function setFromName(?string $fromName): self
    {
        $this->fromName = $fromName;
        return $this;
    }

    public function getToAddress(): string
    {
        return $this->toAddress;
    }

    public function setToAddress(string $toAddress): self
    {
        $this->toAddress = $toAddress;
        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function getEntityType(): ?string
    {
        return $this->entityType;
    }

    public function setEntityType(?string $entityType): self
    {
        $this->entityType = $entityType;
        return $this;
    }

    public function getEntityId(): ?string
    {
        return $this->entityId;
    }

    public function setEntityId(?string $entityId): self
    {
        $this->entityId = $entityId;
        return $this;
    }

    public function getOpens(): int
    {
        return $this->opens;
    }

    public function setOpens(int $opens): self
    {
        $this->opens = $opens;
        return $this;
    }

    public function incrementOpens(): self
    {
        $this->opens++;
        return $this;
    }

    public function getClicks(): int
    {
        return $this->clicks;
    }

    public function setClicks(int $clicks): self
    {
        $this->clicks = $clicks;
        return $this;
    }

    public function incrementClicks(): self
    {
        $this->clicks++;
        return $this;
    }

    public function isBounced(): bool
    {
        return $this->bounced;
    }

    public function setBounced(bool $bounced): self
    {
        $this->bounced = $bounced;
        return $this;
    }

    public function isUnsubscribed(): bool
    {
        return $this->unsubscribed;
    }

    public function setUnsubscribed(bool $unsubscribed): self
    {
        $this->unsubscribed = $unsubscribed;
        return $this;
    }

    public function getSentAt(): ?\DateTime
    {
        return $this->sentAt;
    }

    public function setSentAt(?\DateTime $sentAt): self
    {
        $this->sentAt = $sentAt;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getOpenRate(): float
    {
        return $this->opens > 0 ? ($this->opens / 100) : 0.0;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'template_id' => $this->templateId,
            'from_address' => $this->fromAddress,
            'from_name' => $this->fromName,
            'to_address' => $this->toAddress,
            'subject' => $this->subject,
            'body' => $this->body,
            'entity_type' => $this->entityType,
            'entity_id' => $this->entityId,
            'opens' => $this->opens,
            'clicks' => $this->clicks,
            'bounced' => $this->bounced,
            'unsubscribed' => $this->unsubscribed,
            'sent_at' => $this->sentAt?->format('Y-m-d H:i:s'),
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromArray(array $data): self
    {
        $email = new self();
        
        if (isset($data['id'])) $email->setId($data['id']);
        if (isset($data['template_id'])) $email->setTemplateId($data['template_id']);
        if (isset($data['from_address'])) $email->setFromAddress($data['from_address']);
        if (isset($data['from_name'])) $email->setFromName($data['from_name']);
        if (isset($data['to_address'])) $email->setToAddress($data['to_address']);
        if (isset($data['subject'])) $email->setSubject($data['subject']);
        if (isset($data['body'])) $email->setBody($data['body']);
        if (isset($data['entity_type'])) $email->setEntityType($data['entity_type']);
        if (isset($data['entity_id'])) $email->setEntityId($data['entity_id']);
        if (isset($data['opens'])) $email->setOpens((int)$data['opens']);
        if (isset($data['clicks'])) $email->setClicks((int)$data['clicks']);
        if (isset($data['bounced'])) $email->setBounced((bool)$data['bounced']);
        if (isset($data['unsubscribed'])) $email->setUnsubscribed((bool)$data['unsubscribed']);
        
        return $email;
    }
}
