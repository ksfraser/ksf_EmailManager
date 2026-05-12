# Test Plan - ksf_EmailManager

## Document Information
- **Module**: ksf_EmailManager
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Implemented
- **Author**: KSFII Development Team

---

## 1. Overview

### 1.1 Purpose
This test plan defines the testing strategy for ksf_EmailManager module, covering email sending, templates, campaigns, and tracking.

### 1.2 Scope
- Email account management
- Template creation and usage
- Campaign execution
- Open/click tracking
- CRM integration

---

## 2. Test Strategy

### 2.1 Coverage Targets
| Layer | Target |
|-------|--------|
| Entity | 100% |
| Service | 90% |
| Events | 100% |
| Integration | 80% |

---

## 3. Unit Tests

### 3.1 EmailAccount Entity Tests

| Test ID | Description | Expected Result |
|---------|-------------|-----------------|
| EM-ACCT-001 | Create account with required fields | Account created |
| EM-ACCT-002 | Create account without email | ValidationException |
| EM-ACCT-003 | Set default account | isDefault = true |
| EM-ACCT-004 | Only one default | Previous cleared |
| EM-ACCT-005 | Encrypt password | Password stored encrypted |

### 3.2 EmailTemplate Entity Tests

| Test ID | Description | Expected Result |
|---------|-------------|-----------------|
| EM-TPL-001 | Create template with required fields | Template created |
| EM-TPL-002 | Create template without subject | ValidationException |
| EM-TPL-003 | Set HTML body | bodyHtml set |
| EM-TPL-004 | Set text body | bodyText set |
| EM-TPL-005 | Define variables | Variables stored |
| EM-TPL-006 | Substitute variables | Variables replaced |

### 3.3 SentEmail Entity Tests

| Test ID | Description | Expected Result |
|---------|-------------|-----------------|
| EM-SENT-001 | Create sent email record | Record created |
| EM-SENT-002 | Link to entity | entityType/entityId set |
| EM-SENT-003 | Track opens | Opens incremented |
| EM-SENT-004 | Track clicks | Clicks incremented |
| EM-SENT-005 | Get open rate | Returns percentage |

### 3.4 EmailCampaign Entity Tests

| Test ID | Description | Expected Result |
|---------|-------------|-----------------|
| EM-CAMP-001 | Create campaign | Campaign created |
| EM-CAMP-002 | Link to template | templateId set |
| EM-CAMP-003 | Set segment | segmentId set |
| EM-CAMP-004 | Schedule campaign | status = scheduled |
| EM-CAMP-005 | Start sending | status = sending |
| EM-CAMP-006 | Complete sending | status = completed |
| EM-CAMP-007 | Cancel campaign | status = cancelled |
| EM-CAMP-008 | Get open rate | Returns percentage |
| EM-CAMP-009 | Get click rate | Returns percentage |

---

## 4. Service Layer Tests

### 4.1 EmailService Tests

| Test ID | Description | Expected Result |
|---------|-------------|-----------------|
| EM-SVC-001 | Send email via SMTP | SentEmail created |
| EM-SVC-002 | Send with template | Variables substituted |
| EM-SVC-003 | Send to multiple recipients | Multiple SentEmail records |
| EM-SVC-004 | Handle SMTP error | Exception thrown |
| EM-SVC-005 | Record bounce | Bounce tracked |
| EM-SVC-006 | Track open | Open recorded |
| EM-SVC-007 | Track click | Click recorded |

### 4.2 TemplateService Tests

| Test ID | Description | Expected Result |
|---------|-------------|-----------------|
| EM-SVC-TPL-001 | Create template | Template persisted |
| EM-SVC-TPL-002 | Update template | Template updated |
| EM-SVC-TPL-003 | Delete template | Template removed |
| EM-SVC-TPL-004 | List templates by category | Returns filtered |
| EM-SVC-TPL-005 | Render template with variables | Variables replaced |
| EM-SVC-TPL-006 | Preview template | HTML rendered |

### 4.3 CampaignService Tests

| Test ID | Description | Expected Result |
|---------|-------------|-----------------|
| EM-SVC-CAMP-001 | Create campaign | Campaign persisted |
| EM-SVC-CAMP-002 | Schedule campaign | scheduledAt set |
| EM-SVC-CAMP-003 | Start sending | status = sending |
| EM-SVC-CAMP-004 | Pause campaign | status = paused |
| EM-SVC-CAMP-005 | Cancel campaign | status = cancelled |
| EM-SVC-CAMP-006 | Get campaign stats | Returns stats object |
| EM-SVC-CAMP-007 | Get segment recipients | Returns email list |

---

## 5. Integration Tests

### 5.1 ksf_CRM Integration

| Test ID | Description | Expected Result |
|---------|-------------|-----------------|
| EM-INT-CRM-001 | Get segment email addresses | Returns email array |
| EM-INT-CRM-002 | Link email to customer | customerId set |
| EM-INT-CRM-003 | Import email to timeline | Communication created |

### 5.2 ksf_Calendar Integration

| Test ID | Description | Expected Result |
|---------|-------------|-----------------|
| EM-INT-CAL-001 | Create follow-up from email | CalendarEvent created |
| EM-INT-CAL-002 | Schedule reminder | Reminder sent |

---

## 6. Test Data

### 6.1 Fixtures

```php
$accountData = [
    'id' => 'acct-001',
    'user_id' => 'user-001',
    'email_address' => 'sender@example.com',
    'smtp_host' => 'smtp.example.com',
    'smtp_port' => 587,
    'is_default' => true
];

$templateData = [
    'id' => 'tpl-001',
    'name' => 'Welcome Email',
    'subject' => 'Welcome to {{company_name}}',
    'body_html' => '<h1>Hello {{first_name}}</h1>',
    'variables' => ['company_name', 'first_name']
];

$campaignData = [
    'id' => 'camp-001',
    'name' => 'Q2 Newsletter',
    'template_id' => 'tpl-001',
    'segment_id' => 'seg-enterprise',
    'subject' => 'Q2 Update'
];
```

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*