<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Entity;

class InboundEmail
{
    public ?int $id = null;
    public ?string $messageId = null;
    public ?string $subject = null;
    public ?string $fromAddress = null;
    public ?string $fromName = null;
    public ?string $toAddress = null;
    public ?string $ccAddresses = null;
    public ?string $bccAddresses = null;
    public ?string $bodyText = null;
    public ?string $bodyHtml = null;
    public array $attachments = [];
    public ?string $receivedDate = null;
    public ?string $rawHeaders = null;
    public ?string $routingAction = null;
    public ?int $linkedEntityId = null;
    public ?string $linkedEntityType = null;
    public ?int $debtorNo = null;
    public ?int $contactId = null;
    public ?int $accountId = null;
    public ?int $isProcessed = 0;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    public function setMessageId(string $id): self
    {
        $this->messageId = $id;
        return $this;
    }

    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setFromAddress(string $address): self
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

    public function setToAddress(?string $address): self
    {
        $this->toAddress = $address;
        return $this;
    }

    public function getToAddress(): ?string
    {
        return $this->toAddress;
    }

    public function setBodyText(?string $body): self
    {
        $this->bodyText = $body;
        return $this;
    }

    public function getBodyText(): ?string
    {
        return $this->bodyText;
    }

    public function setBodyHtml(?string $body): self
    {
        $this->bodyHtml = $body;
        return $this;
    }

    public function getBodyHtml(): ?string
    {
        return $this->bodyHtml;
    }

    public function setAttachments(array $attachments): self
    {
        $this->attachments = $attachments;
        return $this;
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function setRoutingAction(?string $action): self
    {
        $this->routingAction = $action;
        return $this;
    }

    public function getRoutingAction(): ?string
    {
        return $this->routingAction;
    }

    public function setLinkedEntityId(?int $id): self
    {
        $this->linkedEntityId = $id;
        return $this;
    }

    public function getLinkedEntityId(): ?int
    {
        return $this->linkedEntityId;
    }

    public function setLinkedEntityType(?string $type): self
    {
        $this->linkedEntityType = $type;
        return $this;
    }

    public function getLinkedEntityType(): ?string
    {
        return $this->linkedEntityType;
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'message_id' => $this->messageId,
            'subject' => $this->subject,
            'from_address' => $this->fromAddress,
            'from_name' => $this->fromName,
            'to_address' => $this->toAddress,
            'cc_addresses' => $this->ccAddresses,
            'bcc_addresses' => $this->bccAddresses,
            'body_text' => $this->bodyText,
            'body_html' => $this->bodyHtml,
            'attachments' => json_encode($this->attachments),
            'received_date' => $this->receivedDate,
            'raw_headers' => $this->rawHeaders,
            'routing_action' => $this->routingAction,
            'linked_entity_id' => $this->linkedEntityId,
            'linked_entity_type' => $this->linkedEntityType,
            'debtor_no' => $this->debtorNo,
            'contact_id' => $this->contactId,
            'account_id' => $this->accountId,
            'is_processed' => $this->isProcessed,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public static function fromArray(array $data): self
    {
        $email = new self();
        if (isset($data['id'])) $email->id = $data['id'];
        if (isset($data['message_id'])) $email->messageId = $data['message_id'];
        if (isset($data['subject'])) $email->subject = $data['subject'];
        if (isset($data['from_address'])) $email->fromAddress = $data['from_address'];
        if (isset($data['from_name'])) $email->fromName = $data['from_name'];
        if (isset($data['to_address'])) $email->toAddress = $data['to_address'];
        if (isset($data['cc_addresses'])) $email->ccAddresses = $data['cc_addresses'];
        if (isset($data['bcc_addresses'])) $email->bccAddresses = $data['bcc_addresses'];
        if (isset($data['body_text'])) $email->bodyText = $data['body_text'];
        if (isset($data['body_html'])) $email->bodyHtml = $data['body_html'];
        if (isset($data['attachments'])) $email->attachments = is_array($data['attachments']) ? $data['attachments'] : json_decode($data['attachments'], true) ?? [];
        if (isset($data['received_date'])) $email->receivedDate = $data['received_date'];
        if (isset($data['raw_headers'])) $email->rawHeaders = $data['raw_headers'];
        if (isset($data['routing_action'])) $email->routingAction = $data['routing_action'];
        if (isset($data['linked_entity_id'])) $email->linkedEntityId = $data['linked_entity_id'];
        if (isset($data['linked_entity_type'])) $email->linkedEntityType = $data['linked_entity_type'];
        if (isset($data['debtor_no'])) $email->debtorNo = $data['debtor_no'];
        if (isset($data['contact_id'])) $email->contactId = $data['contact_id'];
        if (isset($data['account_id'])) $email->accountId = $data['account_id'];
        if (isset($data['is_processed'])) $email->isProcessed = $data['is_processed'];
        if (isset($data['created_at'])) $email->createdAt = $data['created_at'];
        if (isset($data['updated_at'])) $email->updatedAt = $data['updated_at'];
        return $email;
    }
}