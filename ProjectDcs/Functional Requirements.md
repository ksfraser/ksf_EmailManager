# Functional Requirements - ksf_EmailManager

## Document Information
- **Module**: ksf_EmailManager
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Proposed
- **Author**: KSFII Development Team

## 1. Overview

### 1.1 Purpose
ksf_EmailManager provides email tracking, templates, campaigns, and CRM integration.

### 1.2 Scope
- Email tracking and linking
- Template management
- Campaign management
- Open/click tracking
- Calendar integration

## 2. Core Entities

### 2.1 EmailAccount

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| user_id | string | Yes | User who owns |
| email_address | string | Yes | Email address |
| smtp_host | string | Yes | SMTP server |
| smtp_port | int | Yes | SMTP port |
| smtp_username | string | Yes | Username |
| smtp_password | string | No | Encrypted password |
| imap_host | string | No | IMAP server |
| is_default | bool | Yes | Default account |
| created_at | DateTime | Yes | Auto |

### 2.2 EmailTemplate

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| name | string | Yes | Template name |
| category | string | No | Category |
| subject | string | Yes | Email subject |
| body_html | text | Yes | HTML body |
| body_text | text | No | Plain text body |
| variables | json | No | Available variables |
| is_default | bool | Yes | Default flag |
| created_at | DateTime | Yes | Auto |
| updated_at | DateTime | Yes | Auto |

### 2.3 SentEmail

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| template_id | string | No | FK to EmailTemplate |
| from_address | string | Yes | From email |
| from_name | string | No | From name |
| to_address | string | Yes | To email |
| subject | string | Yes | Subject |
| body | text | Yes | Body sent |
| entity_type | string | No | Linked entity type |
| entity_id | string | No | Linked entity ID |
| opens | int | Yes | Open count |
| clicks | int | Yes | Click count |
| sent_at | DateTime | Yes | Send timestamp |
| created_at | DateTime | Yes | Auto |

### 2.4 EmailCampaign

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| name | string | Yes | Campaign name |
| template_id | string | Yes | FK to EmailTemplate |
| segment_id | string | No | CRM segment |
| subject | string | Yes | Campaign subject |
| status | string | Yes | draft/scheduled/sending/completed |
| scheduled_at | DateTime | No | Scheduled send |
| sent_at | DateTime | No | Actual send |
| total_sent | int | Yes | Emails sent |
| total_opened | int | Yes | Opens |
| total_clicked | int | Yes | Clicks |
| total_bounced | int | Yes | Bounces |
| total_unsubscribed | int | Yes | Unsubscribes |
| created_at | DateTime | Yes | Auto |

## 3. Functional Requirements

### FR-EM-001: Email Sending
**Requirement**: System shall send emails via SMTP.

**Features**:
- Send individual emails
- Use templates with variable substitution
- Track sent status
- Handle bounces
- Retry on failure

### FR-EM-002: Email Template Management
**Requirement**: System shall manage email templates.

**Features**:
- Create/edit templates
- WYSIWYG editor
- Variable placeholders: {{customer_name}}, {{contact_first_name}}, etc.
- Template categories
- Version history

### FR-EM-003: CRM Integration
**Requirement**: System shall link emails to CRM records.

**Features**:
- Link to Customer
- Link to Contact
- Link to Opportunity
- Show in customer timeline
- Email threading

### FR-EM-004: Tracking
**Requirement**: System shall track email engagement.

**Features**:
- Open tracking (pixel)
- Click tracking (rewritten links)
- Unsubscribe tracking
- Aggregate statistics per campaign

### FR-EM-005: Campaign Management
**Requirement**: System shall manage email campaigns.

**Features**:
- Create campaigns from templates
- Target CRM segments
- Schedule sends
- Track campaign metrics
- Handle unsubscribes

### FR-EM-006: Support Ticket Integration
**Requirement**: System shall integrate with support tickets.

**Features**:
- Auto-create ticket from email
- Thread replies to tickets
- Notification templates

## 4. Composer Dependencies

| Package | Version | Purpose |
|---------|---------|---------|
| ksfraser/exceptions | ^1.3 | Exception hierarchy |

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*