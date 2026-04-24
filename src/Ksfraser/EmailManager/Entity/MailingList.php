<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Entity;

use Ksfraser\Core\BaseEntity;

class MailingList extends BaseEntity
{
    private ?string $listName = null;
    private ?string $description = null;
    private ?string $fromAddress = null;
    private ?string $fromName = null;
    private ?string $replyTo = null;
    private string $subscriptionType = 'double_optin';
    private bool $isActive = true;
    private array $subscribers = [];

    public function setListName(string $name): self
    {
        $this->listName = $name;
        return $this;
    }

    public function getListName(): ?string
    {
        return $this->listName;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setFromAddress(?string $address): self
    {
        $this->fromAddress = $address;
        return $this;
    }

    public function getFromAddress(): ?string
    {
        return $this->fromAddress;
    }

    public function setFromName(?string $name): self
    {
        $this->fromName = $name;
        return $this;
    }

    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    public function setReplyTo(?string $replyTo): self
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }

    public function setSubscriptionType(string $type): self
    {
        $this->subscriptionType = $type;
        return $this;
    }

    public function getSubscriptionType(): string
    {
        return $this->subscriptionType;
    }

    public function setIsActive(bool $active): self
    {
        $this->isActive = $active;
        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setSubscribers(array $subscribers): self
    {
        $this->subscribers = $subscribers;
        return $this;
    }

    public function getSubscribers(): array
    {
        return $this->subscribers;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'list_name' => $this->listName,
            'description' => $this->description,
            'from_address' => $this->fromAddress,
            'from_name' => $this->fromName,
            'reply_to' => $this->replyTo,
            'subscription_type' => $this->subscriptionType,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromArray(array $data): self
    {
        $list = new self();
        if (isset($data['id'])) $list->id = $data['id'];
        if (isset($data['list_name'])) $list->listName = $data['list_name'];
        if (isset($data['description'])) $list->description = $data['description'];
        if (isset($data['from_address'])) $list->fromAddress = $data['from_address'];
        if (isset($data['from_name'])) $list->fromName = $data['from_name'];
        if (isset($data['reply_to'])) $list->replyTo = $data['reply_to'];
        if (isset($data['subscription_type'])) $list->subscriptionType = $data['subscription_type'];
        if (isset($data['is_active'])) $list->isActive = $data['is_active'];
        if (isset($data['created_at'])) $list->createdAt = new \DateTime($data['created_at']);
        if (isset($data['updated_at'])) $list->updatedAt = new \DateTime($data['updated_at']);
        return $list;
    }
}

class MailingListSubscriber extends BaseEntity
{
    private ?int $listId = null;
    private ?string $email = null;
    private ?string $name = null;
    private ?int $debtorNo = null;
    private ?int $contactId = null;
    private string $status = 'pending';
    private ?string $unsubscribeToken = null;
    private ?string $subscribeToken = null;

    public function setListId(int $id): self
    {
        $this->listId = $id;
        return $this;
    }

    public function getListId(): ?int
    {
        return $this->listId;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setDebtorNo(?int $debtorNo): self
    {
        $this->debtorNo = $debtorNo;
        return $this;
    }

    public function getDebtorNo(): ?int
    {
        return $this->debtorNo;
    }

    public function setContactId(?int $contactId): self
    {
        $this->contactId = $contactId;
        return $this;
    }

    public function getContactId(): ?int
    {
        return $this->contactId;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setUnsubscribeToken(?string $token): self
    {
        $this->unsubscribeToken = $token;
        return $this;
    }

    public function getUnsubscribeToken(): ?string
    {
        return $this->unsubscribeToken;
    }

    public function setSubscribeToken(?string $token): self
    {
        $this->subscribeToken = $token;
        return $this;
    }

    public function getSubscribeToken(): ?string
    {
        return $this->subscribeToken;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'list_id' => $this->listId,
            'email' => $this->email,
            'name' => $this->name,
            'debtor_no' => $this->debtorNo,
            'contact_id' => $this->contactId,
            'status' => $this->status,
            'unsubscribe_token' => $this->unsubscribeToken,
            'subscribe_token' => $this->subscribeToken,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromArray(array $data): self
    {
        $sub = new self();
        if (isset($data['id'])) $sub->id = $data['id'];
        if (isset($data['list_id'])) $sub->listId = $data['list_id'];
        if (isset($data['email'])) $sub->email = $data['email'];
        if (isset($data['name'])) $sub->name = $data['name'];
        if (isset($data['debtor_no'])) $sub->debtorNo = $data['debtor_no'];
        if (isset($data['contact_id'])) $sub->contactId = $data['contact_id'];
        if (isset($data['status'])) $sub->status = $data['status'];
        if (isset($data['unsubscribe_token'])) $sub->unsubscribeToken = $data['unsubscribe_token'];
        if (isset($data['subscribe_token'])) $sub->subscribeToken = $data['subscribe_token'];
        if (isset($data['created_at'])) $sub->createdAt = new \DateTime($data['created_at']);
        if (isset($data['updated_at'])) $sub->updatedAt = new \DateTime($data['updated_at']);
        return $sub;
    }
}