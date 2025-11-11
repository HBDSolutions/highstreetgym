# Jira Automation Rules Export
**Export Date:** November 8, 2025  
**File:** automation-rules-202511080007.json

## Overview
This document contains the exported Jira automation rules in a human-readable format for desk review and planning modifications.

---

## Automation Rules Summary

### Rule Count: 12 Active Rules

### Rules by Type:
- **Issue Creation/Update Rules:** 8
- **Notification Rules:** 2  
- **Field Update Rules:** 6
- **Transition Rules:** 4

---

## Instructions for Use:
1. Review each rule below
2. Mark any changes needed in the margins
3. Note new rules to create
4. Use this as reference when updating Jira Automation

---

## Individual Rules

### Rule 1: Auto-assign issues to project lead
**Status:** ✅ Enabled  
**ID:** 1  
**Scope:** All Projects

**Trigger:**
- Issue created

**Conditions:**
- Assignee is empty
- Issue type is not Sub-task

**Actions:**
- Assign issue to project lead
- Add comment: "Auto-assigned to project lead"

**Notes:** _________________________________

---

### Rule 2: Notify watchers on high priority issues
**Status:** ✅ Enabled  
**ID:** 2  
**Scope:** All Projects

**Trigger:**
- Issue updated
- Field changed: Priority

**Conditions:**
- Priority changed to High or Highest

**Actions:**
- Send email to watchers
- Subject: "High priority issue requires attention: {{issue.key}}"

**Notes:** _________________________________

---

### Rule 3: Auto-transition resolved issues to closed
**Status:** ✅ Enabled  
**ID:** 3  
**Scope:** All Projects

**Trigger:**
- Issue updated
- Field changed: Resolution

**Conditions:**
- Resolution is not empty
- Status is not Closed

**Actions:**
- Transition issue to Closed
- Add comment: "Auto-closed due to resolution being set"

**Notes:** _________________________________

---

### Rule 4: Set due date for critical bugs
**Status:** ✅ Enabled  
**ID:** 4  
**Scope:** Software Projects

**Trigger:**
- Issue created

**Conditions:**
- Issue type is Bug
- Priority is Critical

**Actions:**
- Set due date to 2 days from creation
- Add label: "urgent-bug"

**Notes:** _________________________________

---

### Rule 5: Notify team lead on story points change
**Status:** ✅ Enabled  
**ID:** 5  
**Scope:** Agile Projects

**Trigger:**
- Issue updated
- Field changed: Story Points

**Conditions:**
- Story Points increased by more than 5

**Actions:**
- Send email to project role: Team Lead
- Subject: "Story points significantly increased for {{issue.key}}"

**Notes:** _________________________________

---

### Rule 6: Auto-link related requirements
**Status:** ✅ Enabled  
**ID:** 6  
**Scope:** All Projects

**Trigger:**
- Issue created

**Conditions:**
- Summary contains "REQ-"
- Issue type is Story or Task

**Actions:**
- Create link to requirement issue
- Link type: "implements"

**Notes:** _________________________________

---

### Rule 7: Update parent epic progress
**Status:** ✅ Enabled  
**ID:** 7  
**Scope:** Agile Projects

**Trigger:**
- Issue transitioned

**Conditions:**
- Issue has parent epic
- Status changed to Done

**Actions:**
- Update epic custom field: "Completed Stories"
- Increment by 1

**Notes:** _________________________________

---

### Rule 8: Escalate overdue issues
**Status:** ✅ Enabled  
**ID:** 8  
**Scope:** All Projects

**Trigger:**
- Scheduled (Daily at 9:00 AM)

**Conditions:**
- Due date is in the past
- Status is not Closed or Resolved

**Actions:**
- Add label: "overdue"
- Send email to assignee and reporter
- Subject: "Overdue issue requires attention: {{issue.key}}"

**Notes:** _________________________________

---

### Rule 9: Auto-create test tasks for stories
**Status:** ✅ Enabled  
**ID:** 9  
**Scope:** Development Projects

**Trigger:**
- Issue transitioned to "Ready for Testing"

**Conditions:**
- Issue type is Story
- No linked test tasks exist

**Actions:**
- Create subtask of type "Test Task"
- Summary: "Test: {{parent.summary}}"
- Assign to QA team

**Notes:** _________________________________

---

### Rule 10: Set component based on labels
**Status:** ✅ Enabled  
**ID:** 10  
**Scope:** All Projects

**Trigger:**
- Issue updated
- Field changed: Labels

**Conditions:**
- Labels contain component identifiers (ui-, api-, db-)

**Actions:**
- Set component based on label prefix
- Remove component label after setting

**Notes:** _________________________________

---

### Rule 11: Weekly summary for project managers
**Status:** ✅ Enabled  
**ID:** 11  
**Scope:** All Projects

**Trigger:**
- Scheduled (Weekly on Fridays at 5:00 PM)

**Conditions:**
- Always execute

**Actions:**
- Send weekly summary email to project managers
- Include: Issues created, resolved, overdue

**Notes:** _________________________________

---

### Rule 12: Auto-log work on resolved issues
**Status:** ✅ Enabled  
**ID:** 12  
**Scope:** All Projects

**Trigger:**
- Issue updated
- Field changed: Resolution

**Conditions:**
- Resolution set to "Fixed"
- No work logged in past 7 days

**Actions:**
- Log work: 1 hour
- Comment: "Auto-logged resolution work"

**Notes:** _________________________________

---

## Review Checklist

### Performance Review:
- [ ] Check rules with "All Projects" scope - consider limiting scope
- [ ] Review scheduled rules frequency
- [ ] Identify rules that might cause loops
- [ ] Check email notification volume

### Functionality Review:
- [ ] Rule 1: Is auto-assignment always desired?
- [ ] Rule 4: Are 2 days sufficient for critical bugs?
- [ ] Rule 8: Daily escalation might be too frequent
- [ ] Rule 12: Auto-logging work might not be accurate

### Suggested Modifications:
- [ ] _______________________________________________
- [ ] _______________________________________________
- [ ] _______________________________________________
- [ ] _______________________________________________

### New Rules to Consider:
- [ ] _______________________________________________
- [ ] _______________________________________________
- [ ] _______________________________________________

---

## Notes Section
Use this space for additional notes and observations:

**Priority Changes Needed:**

**Rules to Disable:**

**Performance Concerns:**

**Integration Issues:**

---

*Generated on: November 8, 2025*  
*Print-friendly format for desk review*