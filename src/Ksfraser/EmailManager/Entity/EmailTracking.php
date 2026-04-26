<?php

namespace Ksfraser\EmailManager\Entity;

class EmailTracking extends Entity
{
    protected $table = 'ksf_email_tracking';
    protected $primaryKey = 'id';

    protected $fillable = [
        'email_id',
        'recipient',
        'opened_at',
        'clicked_at',
        'bounced_at',
        'spam_complaint',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
        'bounced_at' => 'datetime',
    ];

    public function email()
    {
        return $this->belongsTo(InboundEmail::class, 'email_id');
    }

    public function markAsOpened()
    {
        if (!$this->opened_at) {
            $this->update(['opened_at' => now()]);
        }
        return $this;
    }

    public function markAsClicked()
    {
        if (!$this->clicked_at) {
            $this->update(['clicked_at' => now()]);
        }
        return $this;
    }

    public function markAsBounced()
    {
        if (!$this->bounced_at) {
            $this->update(['bounced_at' => now()]);
        }
        return $this;
    }

    public function markAsSpamComplaint()
    {
        $this->update(['spam_complaint' => true]);
        return $this;
    }

    public function isOpened()
    {
        return !is_null($this->opened_at);
    }

    public function isClicked()
    {
        return !is_null($this->clicked_at);
    }

    public function isBounced()
    {
        return !is_null($this->bounced_at);
    }

    public function getOpenRate()
    {
        return $this->whereNotNull('opened_at')->count() / $this->count() * 100;
    }

    public function getClickRate()
    {
        return $this->whereNotNull('clicked_at')->count() / $this->count() * 100;
    }}