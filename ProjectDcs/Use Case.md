# Use Cases - ksf_EmailManager

## UC-EM-001: Send Email from CRM
**Actor**: Sales Rep, Support Agent

**Flow**:
1. Navigate to customer/contact in ksf_CRM
2. Click "Send Email"
3. Compose email:
   - To: Pre-filled from contact
   - Subject, Body
   - Use template (optional)
   - Attach files (ksf_Documents)
4. Send
5. System:
   - Saves to sent folder
   - Links to customer record
   - Shows in customer timeline
   - Tracks opens/clicks if enabled

---

## UC-EM-002: Email Template Creation
**Actor**: Marketing, Sales Manager, Admin

**Flow**:
1. Navigate to Email > Templates > New
2. Enter template details:
   - Name, category
   - Subject line
   - Body (WYSIWYG editor)
   - Plain text version
3. Add merge variables:
   - {{customer_name}}
   - {{contact_first_name}}
   - {{account_manager}}
   - etc.
4. Preview with sample data
5. Save template
6. Set as default for:
   - Specific customer type
   - Specific workflow
   - Manual use only

---

## UC-EM-003: Email Campaign Creation
**Actor**: Marketing

**Flow**:
1. Navigate to Marketing > Campaigns > New
2. Enter campaign details:
   - Name, objective
   - Start/end dates
   - Target list/segment (ksf_CRM segments)
3. Create email:
   - Select or create template
   - Personalize content
   - Add images/links
4. Configure tracking:
   - Open tracking
   - Click tracking
   - Unsubscribe link
5. Test send to self
6. Schedule or send immediately
7. Monitor results:
   - Delivered, opened, clicked
   - Unsubscribed
   - Bounced

---

## UC-EM-004: Auto-Reply to Support Email
**Actor**: System

**Trigger**: New email to support address

**Flow**:
1. Customer emails support@company.com
2. System (ksf_EmailManager):
   - Creates ticket (ksf_SupportTickets)
   - Sends auto-reply with ticket ID
3. Auto-reply content:
   - Thank you message
   - Ticket number
   - Expected response time
   - Link to portal

---

## UC-EM-005: Meeting Request via Email
**Actor**: Sales Rep, Manager

**Flow**:
1. In CRM, click "Schedule Meeting"
2. Compose meeting:
   - Attendees (from CRM contacts)
   - Date/time
   - Duration
   - Location or video link
   - Agenda
3. Send as email with calendar invite
4. System:
   - Creates calendar event (ksf_Calendar)
   - Sends iCal invite
   - Tracks acceptance
5. Recipient can:
   - Accept → Shows on their calendar
   - Decline → Notification sent
   - Tentative → Tracked

---

## UC-EM-006: Email Link to Customer Record
**Actor**: System, Support Agent

**Trigger**: Incoming email

**Flow**:
1. Email received (via POP/IMAP or API)
2. System parses:
   - Sender email address
   - Subject, body
3. Match against CRM:
   - Search contacts by email
   - Search customers by domain
4. If match found:
   - Link email to customer record
   - Add to customer timeline
   - Show in customer view
5. If no match:
   - Create lead in CRM (optional)
   - Or flag for manual assignment

---

## UC-EM-007: Email Open Tracking
**Actor**: System, Marketing, Sales

**Flow**:
1. Marketing sends email campaign
2. System embeds tracking pixel
3. When recipient opens:
   - Pixel loads (1x1 transparent image)
   - System records open with:
     - Timestamp
     - IP address
     - Email client
4. Results:
   - Marketing sees open count
   - Sales rep sees customer engagement
   - Triggers workflow if opened (ksf_Workflow)

---

## UC-EM-008: Email Unsubscribe Handling
**Actor**: System, Contact

**Trigger**: Contact clicks unsubscribe link

**Flow**:
1. Email sent with unsubscribe link
2. Contact clicks link
3. System:
   - Removes from campaign lists
   - Marks contact as 'Unsubscribed' in CRM
   - Logs unsubscribe with timestamp
4. Contact sees confirmation page
5. Future campaigns skip unsubscribed
6. Single opt-out respects compliance

---

## UC-EM-009: Email-to-Ticket Threading
**Actor**: System, Support Agent

**Flow**:
1. Customer replies to existing ticket email
2. System identifies:
   - Original ticket ID in subject
   - Customer email
3. Links reply to existing ticket
4. Agent sees:
   - Full email thread
   - All previous correspondence
5. Reply added to ticket timeline (ksf_SupportTickets)

---

## UC-EM-010: Bulk Email with Segmentation
**Actor**: Marketing

**Flow**:
1. Marketing selects segment (ksf_CRM):
   - Industry = 'Technology'
   - Region = 'North'
   - Customer type = 'Enterprise'
2. Creates targeted email:
   - Content specific to segment
   - Personalized greeting
3. System:
   - Sends to all segment members
   - Tracks individual delivery
   - Respects unsubscribes
4. Report per segment:
   - Open rate by segment
   - Conversion by segment

---

## UC-EM-011: SMTP Configuration
**Actor**: System Administrator

**Flow**:
1. Navigate to Settings > Email
2. Configure SMTP:
   - Server address
   - Port
   - Username/password
   - Encryption (TLS/SSL)
3. Test connection
4. Set default sender:
   - From name
   - From email
   - Reply-to
5. Configure bounce handling:
   - Bounce email address
   - Auto-process bounces

---

## UC-EM-012: Email Analytics Dashboard
**Actor**: Marketing, Management

**Flow**:
1. Navigate to Reports > Email
2. Dashboard shows:
   - Total sent/delivered
   - Open rate (by campaign)
   - Click rate
   - Unsubscribe rate
   - Bounce rate
3. Charts:
   - Trends over time
   - By campaign
   - By segment
4. Drill-down:
   - Click campaign → see recipients
   - Click recipient → see email history

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*