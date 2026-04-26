<?php

namespace Ksfraser\EmailManager\Service;

use Ksfraser\EmailManager\Entity\EmailTracking;

class EmailTrackingService
{
    private $db;

    public function __construct($db = null)
    {
        $this->db = $db;
    }

    public function track_sent_email($email_id, $recipient, $metadata = [])
    {
        $tracking = new EmailTracking();
        $tracking->email_id = $email_id;
        $tracking->recipient = $recipient;
        $tracking->metadata = json_encode($metadata);
        $tracking->save();

        return $tracking->id;
    }

    public function get_open_stats($email_id = null)
    {
        $query = EmailTracking::query();

        if ($email_id) {
            $query->where('email_id', $email_id);
        }

        $total = $query->count();
        $opened = $query->whereNotNull('opened_at')->count();
        $clicked = $query->whereNotNull('clicked_at')->count();
        $bounced = $query->whereNotNull('bounced_at')->count();

        return [
            'total' => $total,
            'opened' => $opened,
            'clicked' => $clicked,
            'bounced' => $bounced,
            'open_rate' => $total > 0 ? round($opened / $total * 100, 2) : 0,
            'click_rate' => $total > 0 ? round($clicked / $total * 100, 2) : 0,
            'bounce_rate' => $total > 0 ? round($bounced / $total * 100, 2) : 0,
        ];
    }

    public function generate_tracking_pixel($email_id, $recipient)
    {
        $tracking = $this->track_sent_email($email_id, $recipient);
        $token = base64_encode(json_encode([
            'id' => $tracking,
            'r' => $recipient,
            'ts' => time(),
        ]));

        return home_url("/?ksf_email_open={$token}");
    }

    public function generate_click_link($original_url, $email_id, $recipient)
    {
        $tracking = $this->track_sent_email($email_id, $recipient, ['original_url' => $original_url]);
        $token = base64_encode(json_encode([
            'id' => $tracking,
            'url' => $original_url,
        ]));

        return home_url("/?ksf_email_click={$token}");
    }

    public function process_open_tracking($token)
    {
        try {
            $data = json_decode(base64_decode($token), true);
            if (!$data || !isset($data['id'])) {
                return false;
            }

            $tracking = EmailTracking::find($data['id']);
            if ($tracking) {
                $tracking->markAsOpened();
                return true;
            }
        } catch (\Exception $e) {
            error_log('Email tracking error: ' . $e->getMessage());
        }

        return false;
    }

    public function process_click_tracking($token)
    {
        try {
            $data = json_decode(base64_decode($token), true);
            if (!$data || !isset($data['id'], $data['url'])) {
                return null;
            }

            $tracking = EmailTracking::find($data['id']);
            if ($tracking) {
                $tracking->markAsClicked();
            }

            return $data['url'];
        } catch (\Exception $e) {
            error_log('Email click tracking error: ' . $e->getMessage());
        }

        return null;
    }

    public function get_recipient_tracking($email_id, $recipient)
    {
        return EmailTracking::where('email_id', $email_id)
            ->where('recipient', $recipient)
            ->first();
    }

    public function get_email_tracking_report($email_id)
    {
        $trackings = EmailTracking::where('email_id', $email_id)->get();

        $report = [
            'email_id' => $email_id,
            'total' => $trackings->count(),
            'opened' => $trackings->filter(fn($t) => $t->isOpened())->count(),
            'clicked' => $trackings->filter(fn($t) => $t->isClicked())->count(),
            'bounced' => $trackings->filter(fn($t) => $t->isBounced())->count(),
            'recipients' => [],
        ];

        foreach ($trackings as $tracking) {
            $report['recipients'][] = [
                'recipient' => $tracking->recipient,
                'opened' => $tracking->isOpened(),
                'opened_at' => $tracking->opened_at,
                'clicked' => $tracking->isClicked(),
                'clicked_at' => $tracking->clicked_at,
                'bounced' => $tracking->isBounced(),
                'bounced_at' => $tracking->bounced_at,
            ];
        }

        return $report;
    }
}