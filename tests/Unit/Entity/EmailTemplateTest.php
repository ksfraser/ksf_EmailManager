<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Tests\Unit\Entity;

use Ksfraser\EmailManager\Entity\EmailTemplate;
use PHPUnit\Framework\TestCase;

class EmailTemplateTest extends TestCase
{
    private EmailTemplate $template;

    protected function setUp(): void
    {
        $this->template = new EmailTemplate();
    }

    public function testSetAndGetName(): void
    {
        $result = $this->template->setName('Welcome Email');
        $this->assertSame($this->template, $result);
        $this->assertSame('Welcome Email', $this->template->getName());
    }

    public function testSetAndGetCategory(): void
    {
        $result = $this->template->setCategory('Onboarding');
        $this->assertSame($this->template, $result);
        $this->assertSame('Onboarding', $this->template->getCategory());
    }

    public function testSetAndGetSubject(): void
    {
        $result = $this->template->setSubject('Welcome to our company!');
        $this->assertSame($this->template, $result);
        $this->assertSame('Welcome to our company!', $this->template->getSubject());
    }

    public function testSetAndGetBodyHtml(): void
    {
        $result = $this->template->setBodyHtml('<h1>Hello {{name}}</h1>');
        $this->assertSame($this->template, $result);
        $this->assertSame('<h1>Hello {{name}}</h1>', $this->template->getBodyHtml());
    }

    public function testSetAndGetBodyText(): void
    {
        $result = $this->template->setBodyText('Hello {{name}}');
        $this->assertSame($this->template, $result);
        $this->assertSame('Hello {{name}}', $this->template->getBodyText());
    }

    public function testSetAndGetVariables(): void
    {
        $variables = ['name' => 'John', 'company' => 'Acme'];
        $result = $this->template->setVariables($variables);
        $this->assertSame($this->template, $result);
        $this->assertSame($variables, $this->template->getVariables());
    }

    public function testAddVariable(): void
    {
        $this->template->addVariable('name', 'Default');
        $this->template->addVariable('email');

        $this->assertCount(2, $this->template->getVariables());
        $this->assertSame('Default', $this->template->getVariables()['name']);
        $this->assertNull($this->template->getVariables()['email']);
    }

    public function testIsDefault(): void
    {
        $this->assertFalse($this->template->isDefault());
        $this->template->setIsDefault(true);
        $this->assertTrue($this->template->isDefault());
    }

    public function testRender(): void
    {
        $this->template->setBodyHtml('<h1>Hello {{name}}, welcome to {{company}}!</h1>');
        
        $rendered = $this->template->render(['name' => 'John', 'company' => 'Acme Corp']);
        
        $this->assertSame('<h1>Hello John, welcome to Acme Corp!</h1>', $rendered);
    }

    public function testRenderWithMissingVariables(): void
    {
        $this->template->setBodyHtml('Hello {{name}}, your code is {{code}}');
        
        $rendered = $this->template->render(['name' => 'Jane']);
        
        $this->assertSame('Hello Jane, your code is {{code}}', $rendered);
    }

    public function testToArray(): void
    {
        $this->template->setId('tmpl_123');
        $this->template->setName('Test Template');
        $this->template->setSubject('Test Subject');
        $this->template->setBodyHtml('<p>Body</p>');
        $this->template->setIsDefault(true);

        $array = $this->template->toArray();

        $this->assertSame('tmpl_123', $array['id']);
        $this->assertSame('Test Template', $array['name']);
        $this->assertSame('Test Subject', $array['subject']);
        $this->assertSame('<p>Body</p>', $array['body_html']);
        $this->assertTrue($array['is_default']);
    }

    public function testFromArray(): void
    {
        $data = [
            'id' => 'tmpl_456',
            'name' => 'Welcome',
            'subject' => 'Welcome!',
            'body_html' => '<p>Hello {{name}}</p>',
            'variables' => ['name'],
            'is_default' => true,
        ];

        $template = EmailTemplate::fromArray($data);

        $this->assertSame('tmpl_456', $template->getId());
        $this->assertSame('Welcome', $template->getName());
        $this->assertSame('Welcome!', $template->getSubject());
        $this->assertSame('<p>Hello {{name}}</p>', $template->getBodyHtml());
        $this->assertTrue($template->isDefault());
    }
}
