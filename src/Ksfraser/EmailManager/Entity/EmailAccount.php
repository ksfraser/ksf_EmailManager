<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Entity;

class EmailAccount
{
    public ?int $id = null;
    public ?string $accountName = null;
    public ?string $emailAddress = null;
    public string $accountType = 'imap';
    public ?string $serverHost = null;
    public ?int $serverPort = null;
    public string $encryption = 'ssl';
    public ?string $username = null;
    public ?string $password = null;
    public string $syncFolder = 'INBOX';
    public bool $isActive = true;
    public ?int $debtorNo = null;
    public ?int $contactId = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    public function setAccountName(string $name): self
    {
        $this->accountName = $name;
        return $this;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setEmailAddress(string $address): self
    {
        $this->emailAddress = $address;
        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setAccountType(string $type): self
    {
        $this->accountType = $type;
        return $this;
    }

    public function getAccountType(): string
    {
        return $this->accountType;
    }

    public function setServerHost(string $host): self
    {
        $this->serverHost = $host;
        return $this;
    }

    public function getServerHost(): ?string
    {
        return $this->serverHost;
    }

    public function setServerPort(int $port): self
    {
        $this->serverPort = $port;
        return $this;
    }

    public function getServerPort(): ?int
    {
        return $this->serverPort;
    }

    public function setEncryption(string $encryption): self
    {
        $this->encryption = $encryption;
        return $this;
    }

    public function getEncryption(): string
    {
        return $this->encryption;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setSyncFolder(string $folder): self
    {
        $this->syncFolder = $folder;
        return $this;
    }

    public function getSyncFolder(): string
    {
        return $this->syncFolder;
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
            'account_name' => $this->accountName,
            'email_address' => $this->emailAddress,
            'account_type' => $this->accountType,
            'server_host' => $this->serverHost,
            'server_port' => $this->serverPort,
            'encryption' => $this->encryption,
            'username' => $this->username,
            'password' => $this->password,
            'sync_folder' => $this->syncFolder,
            'is_active' => $this->isActive,
            'debtor_no' => $this->debtorNo,
            'contact_id' => $this->contactId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public static function fromArray(array $data): self
    {
        $account = new self();
        if (isset($data['id'])) $account->id = $data['id'];
        if (isset($data['account_name'])) $account->accountName = $data['account_name'];
        if (isset($data['email_address'])) $account->emailAddress = $data['email_address'];
        if (isset($data['account_type'])) $account->accountType = $data['account_type'];
        if (isset($data['server_host'])) $account->serverHost = $data['server_host'];
        if (isset($data['server_port'])) $account->serverPort = $data['server_port'];
        if (isset($data['encryption'])) $account->encryption = $data['encryption'];
        if (isset($data['username'])) $account->username = $data['username'];
        if (isset($data['password'])) $account->password = $data['password'];
        if (isset($data['sync_folder'])) $account->syncFolder = $data['sync_folder'];
        if (isset($data['is_active'])) $account->isActive = $data['is_active'];
        if (isset($data['debtor_no'])) $account->debtorNo = $data['debtor_no'];
        if (isset($data['contact_id'])) $account->contactId = $data['contact_id'];
        if (isset($data['created_at'])) $account->createdAt = $data['created_at'];
        if (isset($data['updated_at'])) $account->updatedAt = $data['updated_at'];
        return $account;
    }
}