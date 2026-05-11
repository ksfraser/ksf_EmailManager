# Architecture - ksf_EmailManager

## Document Information
- **Module**: ksf_EmailManager
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Proposed

## 1. Directory Structure

```
ksf_EmailManager/
├── src/Ksfraser/EmailManager/
│   ├── EmailService.php
│   ├── TemplateService.php
│   ├── CampaignService.php
│   ├── Contract/
│   │   ├── MailerInterface.php
│   │   └── TrackerInterface.php
│   ├── Entity/
│   │   ├── EmailAccount.php
│   │   ├── EmailTemplate.php
│   │   ├── SentEmail.php
│   │   └── EmailCampaign.php
│   └── Exception/
└── composer.json
```

## 2. Core Design

### EmailService
Handles sending, tracking, threading

### TemplateService
Manages templates with variable substitution

### CampaignService
Orchestrates campaign sending and tracking

## 3. Composer Dependencies

| Package | Version |
|---------|---------|
| ksfraser/exceptions | ^1.3 |

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*