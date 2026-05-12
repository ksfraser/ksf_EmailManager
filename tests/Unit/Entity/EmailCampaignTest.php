<?php

declare(strict_types=1);

namespace Ksfraser\EmailManager\Tests\Unit\Entity;

use DateTime;
use Ksfraser\EmailManager\Entity\EmailCampaign;
use PHPUnit\Framework\TestCase;

class EmailCampaignTest extends TestCase
{
    private EmailCampaign $campaign;

    protected function setUp(): void
    {
        $this->campaign = new EmailCampaign();
    }

    public function testSetAndGetName(): void
    {
        $result = $this->campaign->setName('Summer Sale');
        $this->assertSame($this->campaign, $result);
        $this->assertSame('Summer Sale', $this->campaign->getName());
    }

    public function testSetAndGetTemplateId(): void
    {
        $result = $this->campaign->setTemplateId('tmpl_123');
        $this->assertSame($this->campaign, $result);
        $this->assertSame('tmpl_123', $this->campaign->getTemplateId());
    }

    public function testSetAndGetSegmentId(): void
    {
        $result = $this->campaign->setSegmentId('seg_vip');
        $this->assertSame($this->campaign, $result);
        $this->assertSame('seg_vip', $this->campaign->getSegmentId());
    }

    public function testSchedule(): void
    {
        $scheduled = new DateTime('2024-06-01 10:00');
        $this->campaign->schedule($scheduled);

        $this->assertSame(EmailCampaign::STATUS_SCHEDULED, $this->campaign->getStatus());
        $this->assertSame($scheduled, $this->campaign->getScheduledAt());
    }

    public function testStartSending(): void
    {
        $this->campaign->startSending();
        $this->assertSame(EmailCampaign::STATUS_SENDING, $this->campaign->getStatus());
    }

    public function testComplete(): void
    {
        $this->campaign->complete();
        $this->assertSame(EmailCampaign::STATUS_COMPLETED, $this->campaign->getStatus());
        $this->assertNotNull($this->campaign->getSentAt());
    }

    public function testPause(): void
    {
        $this->campaign->pause();
        $this->assertSame(EmailCampaign::STATUS_PAUSED, $this->campaign->getStatus());
    }

    public function testCancel(): void
    {
        $this->campaign->cancel();
        $this->assertSame(EmailCampaign::STATUS_CANCELLED, $this->campaign->getStatus());
    }

    public function testIncrementTotalSent(): void
    {
        $this->assertSame(0, $this->campaign->getTotalSent());
        $this->campaign->incrementTotalSent();
        $this->campaign->incrementTotalSent();
        $this->assertSame(2, $this->campaign->getTotalSent());
    }

    public function testGetOpenRate(): void
    {
        $this->campaign->setTotalSent(100);
        $this->campaign->setTotalOpened(25);
        $this->assertSame(25.0, $this->campaign->getOpenRate());
    }

    public function testGetClickRate(): void
    {
        $this->campaign->setTotalSent(100);
        $this->campaign->setTotalClicked(10);
        $this->assertSame(10.0, $this->campaign->getClickRate());
    }

    public function testGetBounceRate(): void
    {
        $this->campaign->setTotalSent(100);
        $this->campaign->setTotalBounced(5);
        $this->assertSame(5.0, $this->campaign->getBounceRate());
    }

    public function testToArray(): void
    {
        $this->campaign->setId('camp_123');
        $this->campaign->setName('Test Campaign');
        $this->campaign->setTemplateId('tmpl_001');
        $this->campaign->setTotalSent(1000);
        $this->campaign->setTotalOpened(300);
        $this->campaign->setTotalClicked(50);

        $array = $this->campaign->toArray();

        $this->assertSame('camp_123', $array['id']);
        $this->assertSame('Test Campaign', $array['name']);
        $this->assertSame(1000, $array['total_sent']);
        $this->assertSame(300, $array['total_opened']);
        $this->assertSame(50, $array['total_clicked']);
        $this->assertSame(30.0, $array['open_rate']);
        $this->assertSame(5.0, $array['click_rate']);
    }

    public function testFromArray(): void
    {
        $data = [
            'id' => 'camp_456',
            'name' => 'Newsletter',
            'template_id' => 'tmpl_002',
            'subject' => 'Monthly Update',
            'status' => EmailCampaign::STATUS_DRAFT,
            'total_sent' => 500,
            'total_opened' => 150,
        ];

        $campaign = EmailCampaign::fromArray($data);

        $this->assertSame('camp_456', $campaign->getId());
        $this->assertSame('Newsletter', $campaign->getName());
        $this->assertSame('tmpl_002', $campaign->getTemplateId());
        $this->assertSame(EmailCampaign::STATUS_DRAFT, $campaign->getStatus());
        $this->assertSame(500, $campaign->getTotalSent());
    }
}
