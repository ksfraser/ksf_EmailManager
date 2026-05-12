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

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*
