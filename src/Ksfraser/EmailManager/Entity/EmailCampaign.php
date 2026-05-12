<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Entity;

class EmailCampaign
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_SENDING = 'sending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_PAUSED = 'paused';
    public const STATUS_CANCELLED = 'cancelled';

    private ?string $id = null;
    private string $name = '';
    private string $templateId = '';
    private ?string $segmentId = null;
    private string $subject = '';
    private string $status = self::STATUS_DRAFT;
    private ?\DateTime $scheduledAt = null;
    private ?\DateTime $sentAt = null;
    private int $totalSent = 0;
    private int $totalOpened = 0;
    private int $totalClicked = 0;
    private int $totalBounced = 0;
    private int $totalUnsubscribed = 0;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getTemplateId(): string
    {
        return $this->templateId;
    }

    public function setTemplateId(string $templateId): self
    {
        $this->templateId = $templateId;
        return $this;
    }

    public function getSegmentId(): ?string
    {
        return $this->segmentId;
    }

    public function setSegmentId(?string $segmentId): self
    {
        $this->segmentId = $segmentId;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getScheduledAt(): ?\DateTime
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(?\DateTime $scheduledAt): self
    {
        $this->scheduledAt = $scheduledAt;
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

    public function getTotalSent(): int
    {
        return $this->totalSent;
    }

    public function setTotalSent(int $totalSent): self
    {
        $this->totalSent = $totalSent;
        return $this;
    }

    public function incrementTotalSent(): self
    {
        $this->totalSent++;
        return $this;
    }

    public function getTotalOpened(): int
    {
        return $this->totalOpened;
    }

    public function setTotalOpened(int $totalOpened): self
    {
        $this->totalOpened = $totalOpened;
        return $this;
    }

    public function getTotalClicked(): int
    {
        return $this->totalClicked;
    }

    public function setTotalClicked(int $totalClicked): self
    {
        $this->totalClicked = $totalClicked;
        return $this;
    }

    public function getTotalBounced(): int
    {
        return $this->totalBounced;
    }

    public function setTotalBounced(int $totalBounced): self
    {
        $this->totalBounced = $totalBounced;
        return $this;
    }

    public function getTotalUnsubscribed(): int
    {
        return $this->totalUnsubscribed;
    }

    public function setTotalUnsubscribed(int $totalUnsubscribed): self
    {
        $this->totalUnsubscribed = $totalUnsubscribed;
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

    public function schedule(\DateTime $scheduledAt): self
    {
        $this->status = self::STATUS_SCHEDULED;
        $this->scheduledAt = $scheduledAt;
        return $this;
    }

    public function startSending(): self
    {
        $this->status = self::STATUS_SENDING;
        return $this;
    }

    public function complete(): self
    {
        $this->status = self::STATUS_COMPLETED;
        $this->sentAt = new \DateTime();
        return $this;
    }

    public function pause(): self
    {
        $this->status = self::STATUS_PAUSED;
        return $this;
    }

    public function cancel(): self
    {
        $this->status = self::STATUS_CANCELLED;
        return $this;
    }

    public function getOpenRate(): float
    {
        return $this->totalSent > 0 ? ($this->totalOpened / $this->totalSent) * 100 : 0.0;
    }

    public function getClickRate(): float
    {
        return $this->totalSent > 0 ? ($this->totalClicked / $this->totalSent) * 100 : 0.0;
    }

    public function getBounceRate(): float
    {
        return $this->totalSent > 0 ? ($this->totalBounced / $this->totalSent) * 100 : 0.0;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'template_id' => $this->templateId,
            'segment_id' => $this->segmentId,
            'subject' => $this->subject,
            'status' => $this->status,
            'scheduled_at' => $this->scheduledAt?->format('Y-m-d H:i:s'),
            'sent_at' => $this->sentAt?->format('Y-m-d H:i:s'),
            'total_sent' => $this->totalSent,
            'total_opened' => $this->totalOpened,
            'total_clicked' => $this->totalClicked,
            'total_bounced' => $this->totalBounced,
            'total_unsubscribed' => $this->totalUnsubscribed,
            'open_rate' => $this->getOpenRate(),
            'click_rate' => $this->getClickRate(),
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromArray(array $data): self
    {
        $campaign = new self();
        
        if (isset($data['id'])) $campaign->setId($data['id']);
        if (isset($data['name'])) $campaign->setName($data['name']);
        if (isset($data['template_id'])) $campaign->setTemplateId($data['template_id']);
        if (isset($data['segment_id'])) $campaign->setSegmentId($data['segment_id']);
        if (isset($data['subject'])) $campaign->setSubject($data['subject']);
        if (isset($data['status'])) $campaign->setStatus($data['status']);
        if (isset($data['scheduled_at'])) $campaign->setScheduledAt(new \DateTime($data['scheduled_at']));
        if (isset($data['sent_at'])) $campaign->setSentAt(new \DateTime($data['sent_at']));
        if (isset($data['total_sent'])) $campaign->setTotalSent((int)$data['total_sent']);
        if (isset($data['total_opened'])) $campaign->setTotalOpened((int)$data['total_opened']);
        if (isset($data['total_clicked'])) $campaign->setTotalClicked((int)$data['total_clicked']);
        if (isset($data['total_bounced'])) $campaign->setTotalBounced((int)$data['total_bounced']);
        if (isset($data['total_unsubscribed'])) $campaign->setTotalUnsubscribed((int)$data['total_unsubscribed']);
        
        return $campaign;
    }
}
