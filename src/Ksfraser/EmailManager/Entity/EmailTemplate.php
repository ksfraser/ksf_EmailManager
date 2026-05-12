<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Entity;

class EmailTemplate
{
    private ?string $id = null;
    private string $name = '';
    private ?string $category = null;
    private string $subject = '';
    private string $bodyHtml = '';
    private ?string $bodyText = null;
    private array $variables = [];
    private bool $isDefault = false;
    private ?\DateTime $createdAt = null;
    private ?\DateTime $updatedAt = null;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;
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

    public function getBodyHtml(): string
    {
        return $this->bodyHtml;
    }

    public function setBodyHtml(string $bodyHtml): self
    {
        $this->bodyHtml = $bodyHtml;
        return $this;
    }

    public function getBodyText(): ?string
    {
        return $this->bodyText;
    }

    public function setBodyText(?string $bodyText): self
    {
        $this->bodyText = $bodyText;
        return $this;
    }

    public function getVariables(): array
    {
        return $this->variables;
    }

    public function setVariables(array $variables): self
    {
        $this->variables = $variables;
        return $this;
    }

    public function addVariable(string $name, ?string $default = null): self
    {
        $this->variables[$name] = $default;
        return $this;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): self
    {
        $this->isDefault = $isDefault;
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

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function render(array $data): string
    {
        $body = $this->bodyHtml;
        foreach ($data as $key => $value) {
            $body = str_replace('{{' . $key . '}}', (string)$value, $body);
        }
        return $body;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'subject' => $this->subject,
            'body_html' => $this->bodyHtml,
            'body_text' => $this->bodyText,
            'variables' => $this->variables,
            'is_default' => $this->isDefault,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromArray(array $data): self
    {
        $template = new self();
        
        if (isset($data['id'])) $template->setId($data['id']);
        if (isset($data['name'])) $template->setName($data['name']);
        if (isset($data['category'])) $template->setCategory($data['category']);
        if (isset($data['subject'])) $template->setSubject($data['subject']);
        if (isset($data['body_html'])) $template->setBodyHtml($data['body_html']);
        if (isset($data['body_text'])) $template->setBodyText($data['body_text']);
        if (isset($data['variables'])) $template->setVariables($data['variables']);
        if (isset($data['is_default'])) $template->setIsDefault((bool)$data['is_default']);
        
        return $template;
    }
}
