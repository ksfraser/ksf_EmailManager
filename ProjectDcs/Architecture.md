# Architecture - ksf_EmailManager

## Document Information
- **Module**: ksf_EmailManager
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Implemented
- **Author**: KSFII Development Team

---

## 1. Module Overview

ksf_EmailManager provides email tracking, templates, campaigns, and CRM integration.

### 1.1 Namespace
```php
Ksfraser\EmailManager\
```

### 1.2 Layer Pattern
```
ksf_EmailManager/           → Business Logic
    ├── Entity/            → Domain entities
    ├── Service/           → Business services
    ├── Repository/        → Data access
    └── Exception/        → Domain exceptions
```

---

## 2. Core Entities

| Entity | Description |
|--------|-------------|
| EmailAccount | SMTP/IMAP configuration |
| EmailTemplate | Email templates with variables |
| SentEmail | Sent email tracking |
| EmailCampaign | Campaign management |

---

## 3. Service Layer

| Service | Description |
|---------|-------------|
| EmailService | Send emails via SMTP |
| TemplateService | Manage templates |
| CampaignService | Manage campaigns |
| TrackingService | Open/click tracking |

---

## 4. Integration

### Provided To
| Module | Data |
|--------|------|
| ksf_CRM | Customer emails |
| ksf_FA_EmailManager | Email sync |

### Consumed From
| Module | Data |
|--------|------|
| ksf_CRM | Customer emails, segments |

---

## 5. RBAC Integration (ksfraser/rbac)

### 5.1 Module Registration

ksf_EmailManager registers with ksfraser/rbac:
- record_types: 'email_template', 'campaign', 'email_log', 'mailing_list'
- projections: 'public' (name, subject, status, dates), 'full' (all fields including internal notes, tracking data, SMTP credentials)
- allow_invite: false
- children: email_log (child of campaign); no parent-child relationships for other types

### 5.2 Entity Projections

| Entity | PUBLIC Fields | FULL Fields |
|--------|---------------|-------------|
| EmailTemplate | name, category, subject, body_html (rendered), variables | + created_at, updated_at, version_history |
| Campaign | name, subject, status, scheduled_at, sent_at, total_sent, total_opened, total_clicked | + template_id, segment_id, bounce_data, unsubscribe_data |
| EmailLog | from_address, to_address, subject, sent_at, opens | + body, template_id, entity_type, entity_id, clicks, bounce_status |
| MailingList | name, description, member_count | + full member list, source_segment_id, created_at, updated_at |

### 5.3 Access Model

- **Marketing Team**: FULL to campaigns, mailing_lists, email_templates (create/edit)
- **Sales Team**: PUBLIC to email_templates (use only), PUBLIC to own sent emails; can view customer-linked emails
- **Support Team**: PUBLIC to email_templates (use only), PUBLIC to ticket-linked sent emails
- **System Administrator**: FULL to all record types including EmailAccount SMTP configuration
- **Customer (portal)**: PUBLIC only to own sent emails (delivery status)

### 5.4 SQL Enforcement

All email-fetching queries MUST JOIN against 0_rbac_record_access:
```sql
JOIN 0_rbac_record_access ra
  ON ra.record_id    = e.id
 AND ra.record_type  = 'email_template'
 AND ra.module       = 'email_manager'
 AND ra.inactive     = 0
 AND ra.can_view     = 1
JOIN 0_rbac_team_members tm
  ON tm.team_id  = ra.team_id
 AND tm.user_id  = :currentUserId
 AND tm.inactive = 0
```

### 5.5 Access Inheritance

- Campaign access does NOT auto-grant access to child email_log records; campaign stats are aggregate, individual log access is separately managed
- Email templates used in campaigns inherit no automatic visibility from the campaign

### 5.6 Soft Delete

- Email templates use soft delete: `deleted = 1`, `deleted_by`, `deleted_at`
- Campaigns use soft delete (maintains analytics integrity)
- Email logs are append-only (never modified or deleted)
- Hard delete is super-admin only for templates and campaigns
- Soft-deleted record visibility gated by `can_view_deleted` type-level permission

### 5.7 Persons Registry Integration

- Email recipients (to_address, from_address) are resolved against ksf_PersonsRegistry for unified identity resolution
- Sent email records reference person_id for cross-module visibility enforcement
- CRM customer/contact segments used for campaign targeting resolve persons through PersonsRegistry

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-24*
