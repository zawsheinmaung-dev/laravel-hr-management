# HRM System — Single Company Architecture

> **HRM System for One Company**
> Laravel 12 · Laravel Breeze · Spatie Laravel Permission · MySQL/PostgreSQL · NativePHP
> **License:** Private HRM System
> **Copyright © 2026 DESIGN**

---

# 1. Project Overview

This HRM system is designed specifically for **one company**.

The company can have:

* Multiple branches
* Multiple departments
* Multiple designations
* Multiple shifts
* Multiple employees

The system manages the complete employee lifecycle:

```text
Recruitment
    ↓
Employee
    ↓
Attendance
    ↓
Leave
    ↓
Payroll
    ↓
Training
    ↓
Performance
```

The system supports:

* Web
* NativePHP Desktop
* NativePHP Mobile
* Role-based access
* Employee documents
* Attendance
* Leave
* Payroll
* Recruitment
* Training
* Performance
* Reports
* Notifications
* Activity logs

---

# 2. Technology Stack

| Component      | Technology                |
| -------------- | ------------------------- |
| Framework      | Laravel 12                |
| Authentication | Laravel Breeze            |
| Authorization  | Spatie Laravel Permission |
| Database       | MySQL / PostgreSQL        |
| Desktop        | NativePHP Desktop         |
| Mobile         | NativePHP Mobile          |
| Queue          | Notifications, Email      |
| Scheduler      | Attendance, Payroll       |
| Storage        | Employee Documents        |
| CSS            | Tailwind CSS              |

---

# 3. Single Company Architecture

```text
                         ONE COMPANY
                              │
             ┌────────────────┼────────────────┐
             │                │                │
          Branches        Departments      Employees
             │                │                │
             │                └───────┬────────┘
             │                        │
             └────────────────────────┤
                                      │
                  ┌───────────────────┼───────────────────┐
                  │                   │                   │
              Attendance           Leave              Payroll
                  │                   │                   │
                  └───────────────────┼───────────────────┘
                                      │
                         ┌────────────┴────────────┐
                         │                         │
                    Recruitment                Training
                         │                         │
                         └────────────┬────────────┘
                                      │
                                Performance
                                      │
                                   Reports
```

---

# 4. What Is Removed From Multi-Company Architecture

Because this is a **single-company system**, do not add unnecessary multi-tenancy fields and logic.

Remove:

```text
company_id from every table
tenant_id
tenant middleware
company switching
company selector
multi-company dashboard
multi-company permissions
multi-company reports
```

Instead, the system has one company record.

```text
companies
└── One company record
```

The company information can be managed through:

```text
Settings
└── Company Profile
```

---

# 5. Core Modules

```text
HRM SYSTEM
│
├── Dashboard
│
├── Organization
│   ├── Company Profile
│   ├── Branches
│   ├── Departments
│   ├── Designations
│   ├── Shifts
│   └── Holidays
│
├── Employees
│   ├── Employees
│   ├── Documents
│   ├── Contracts
│   ├── Transfers
│   └── Promotions
│
├── Attendance
│   ├── Attendance
│   ├── Check In / Out
│   ├── Shift Schedule
│   └── Overtime
│
├── Leave
│   ├── Leave Requests
│   ├── Leave Types
│   └── Leave Balance
│
├── Payroll
│   ├── Payroll
│   ├── Salary Structure
│   ├── Allowances
│   ├── Deductions
│   └── Payslips
│
├── Recruitment
│   ├── Jobs
│   ├── Applicants
│   └── Interviews
│
├── Training
│   ├── Courses
│   └── Training Sessions
│
├── Performance
│   ├── KPI
│   └── Performance Reviews
│
├── Reports
│
├── Administration
│   ├── Users
│   ├── Roles
│   ├── Permissions
│   └── Activity Logs
│
└── Settings
```

---

# 6. Sidebar Navigation

```text
🏢 HRM SYSTEM

MAIN
├── 🏠 Dashboard

ORGANIZATION
├── 🏢 Company Profile
├── 🌿 Branches
├── 🏬 Departments
├── 💼 Designations
├── 🕐 Shifts
└── 📅 Holidays

EMPLOYEES
├── 👥 Employees
├── 📄 Documents
├── 📝 Contracts
├── 🔄 Transfers
└── 📈 Promotions

ATTENDANCE
├── 🕐 Attendance
├── ▶ Check In / Out
├── 📅 Shift Schedule
└── ⏱ Overtime

LEAVE
├── 🏖 Leave Requests
├── 📋 Leave Types
└── 📊 Leave Balance

PAYROLL
├── 💰 Payroll
├── 💵 Salary Structure
├── ➕ Allowances
├── ➖ Deductions
└── 🧾 Payslips

RECRUITMENT
├── 💼 Jobs
├── 👤 Applicants
└── 🎤 Interviews

TRAINING
├── 📚 Courses
└── 🎓 Training Sessions

PERFORMANCE
├── 🎯 KPI
└── ⭐ Performance Reviews

REPORTS
├── 👥 Employee Reports
├── 🕐 Attendance Reports
├── 🏖 Leave Reports
├── 💰 Payroll Reports
├── 💼 Recruitment Reports
└── ⭐ Performance Reports

ADMINISTRATION
├── 👤 Users
├── 🔐 Roles
├── 🛡 Permissions
└── 📜 Activity Logs

⚙ Settings
🚪 Logout
```

---

# 7. Company Structure

Since there is only one company:

```text
Company
│
├── Branch 1
│   ├── Department A
│   ├── Department B
│   └── Department C
│
├── Branch 2
│   ├── Department A
│   └── Department B
│
└── Branch 3
    ├── Department A
    └── Department B
```

An employee belongs to:

```text
Employee
├── Branch
├── Department
├── Designation
└── Shift
```

---

# 8. Database Tables

## Authentication

```text
users
```

## Organization

```text
company
branches
departments
designations
shifts
holidays
```

> Because this is a single-company application, `company` can contain exactly one record.

## Employees

```text
employees
employee_documents
employee_contracts
employee_transfers
employee_promotions
```

## Attendance

```text
attendances
attendance_logs
shift_assignments
overtimes
```

## Leave

```text
leave_types
leave_requests
leave_balances
```

## Payroll

```text
salary_structures
payrolls
payroll_items
allowances
deductions
```

## Recruitment

```text
jobs
applicants
interviews
```

## Training

```text
training_courses
training_sessions
training_participants
```

## Performance

```text
kpis
performance_reviews
performance_review_items
```

## Documents

```text
documents
```

## Notifications

```text
notifications
```

## Administration

```text
roles
permissions
model_has_roles
model_has_permissions
role_has_permissions
activity_logs
```

---

# 9. Database Relationships

```text
Company
   │
   ├── Branches
   │      │
   │      └── Employees
   │
   ├── Departments
   │      │
   │      └── Employees
   │
   ├── Designations
   │      │
   │      └── Employees
   │
   └── Shifts
          │
          └── Shift Assignments
                  │
                  └── Employees
```

Employee:

```text
Employee
│
├── Branch
├── Department
├── Designation
├── Shift Assignment
├── Attendance
├── Attendance Logs
├── Leave Requests
├── Leave Balance
├── Payroll
├── Documents
├── Contracts
├── Transfers
├── Promotions
├── Training
└── Performance Reviews
```

---

# 10. Company Profile

The company table should contain:

```text
Company
├── id
├── name
├── legal_name
├── registration_number
├── tax_number
├── email
├── phone
├── website
├── address
├── city
├── state
├── country
├── postal_code
├── logo
├── timezone
├── currency
├── date_format
├── created_at
└── updated_at
```

Example:

```text
Company Profile

┌──────────────────────────────────────────┐
│ 🏢 Company Information                   │
│                                          │
│ Company Name                             │
│ [ DESIGN COMPANY                       ] │
│                                          │
│ Legal Name                               │
│ [ DESIGN COMPANY LTD                  ] │
│                                          │
│ Registration Number                      │
│ [ REG-2026-001                         ] │
│                                          │
│ Email                                    │
│ [ admin@company.com                    ] │
│                                          │
│ Phone                                    │
│ [ +66 XX XXX XXXX                      ] │
│                                          │
│ Address                                  │
│ [ ..................................... ] │
│                                          │
│ Country                                  │
│ [ Thailand                            ] │
│                                          │
│ Currency                                 │
│ [ THB                                 ] │
│                                          │
│                    [ Save Changes ]      │
└──────────────────────────────────────────┘
```

---

# 11. Employee Management

## Employee Table

```text
employees

id
employee_code
first_name
last_name
email
phone
gender
date_of_birth
address
branch_id
department_id
designation_id
shift_id
manager_id
join_date
employment_type
status
profile_photo
created_at
updated_at
```

Recommended employee statuses:

```text
ACTIVE
INACTIVE
ON_LEAVE
RESIGNED
TERMINATED
RETIRED
```

---

# 12. Employee Profile

```text
Employee Profile

👤 John Doe
EMP-0001
Software Developer
IT Department
🟢 Active

[Edit Employee] [Documents] [More]

────────────────────────────────────────

Overview
Personal
Employment
Documents
Attendance
Leave
Payroll
Training
Performance
```

---

# 13. Attendance

Attendance workflow:

```text
Employee
   │
   ▼
Check In
   │
   ▼
Working
   │
   ▼
Check Out
   │
   ▼
Attendance Record
   │
   ├── Regular Hours
   ├── Late
   ├── Early Checkout
   └── Overtime
```

Attendance statuses:

```text
PRESENT
ABSENT
LATE
HALF_DAY
ON_LEAVE
HOLIDAY
WEEKEND
```

---

# 14. Leave

Leave workflow:

```text
Employee
   │
   ▼
Leave Request
   │
   ▼
Department Manager
   │
   ├── Reject
   │
   └── Approve
          │
          ▼
    Update Leave Balance
          │
          ▼
       Notify Employee
```

Leave types:

```text
Annual Leave
Sick Leave
Personal Leave
Maternity Leave
Paternity Leave
Unpaid Leave
Other
```

---

# 15. Payroll

Payroll workflow:

```text
Employee
   │
   ▼
Salary Structure
   │
   ├── Basic Salary
   ├── Allowances
   ├── Overtime
   └── Bonuses
          │
          ▼
       Gross Pay
          │
          ├── Tax
          ├── Insurance
          ├── Loans
          └── Other Deductions
                 │
                 ▼
              Net Pay
                 │
                 ▼
              Payslip
```

Payroll statuses:

```text
DRAFT
PROCESSING
GENERATED
APPROVED
PAID
CANCELLED
```

---

# 16. Recruitment

```text
Job
 │
 ▼
Applicant
 │
 ▼
Screening
 │
 ▼
Interview
 │
 ├── Rejected
 │
 └── Selected
       │
       ▼
     Hired
       │
       ▼
    Employee
```

---

# 17. Training

```text
Course
   │
   ▼
Training Session
   │
   ▼
Participants
   │
   ▼
Completion
```

Training records should track:

* Course
* Instructor
* Start date
* End date
* Duration
* Participants
* Completion
* Certificate

---

# 18. Performance

```text
Employee
   │
   ▼
KPI
   │
   ▼
Performance Review
   │
   ▼
Score
   │
   ▼
Manager Feedback
```

---

# 19. Dashboard

The single-company dashboard should focus on the company's overall HR status.

```text
Dashboard

Good morning, Admin 👋
Here's what's happening in your company today.

┌────────────┐ ┌────────────┐ ┌────────────┐ ┌────────────┐
│ Employees  │ │ Present    │ │ On Leave   │ │ Absent     │
│    248     │ │    231     │ │     12     │ │      5     │
│ ↑ 8.2%     │ │ 93.1%      │ │ 4.8%       │ │ 2.1%       │
└────────────┘ └────────────┘ └────────────┘ └────────────┘

┌──────────────────────────────┐
│ Attendance Overview          │
│                              │
│          📈 Chart            │
│                              │
└──────────────────────────────┘

┌──────────────────────────────┐
│ Employees by Department      │
│                              │
│          🥧 Chart            │
│                              │
└──────────────────────────────┘

┌──────────────────────────────┐
│ Pending Leave Requests       │
│                              │
│ John Doe       Annual   4d   │
│ Sarah Smith    Sick     1d   │
│                              │
└──────────────────────────────┘
```

---

# 20. Role-Based Dashboard

Different users should see different dashboard information.

## Super Admin

```text
Company Statistics
Attendance
Leave
Payroll
Employees
Recruitment
Training
Performance
Reports
```

## HR Manager

```text
Employees
Attendance
Leave
Recruitment
Training
Performance
HR Reports
```

## Department Manager

```text
Department Employees
Department Attendance
Leave Requests
Team Performance
Department Reports
```

## Payroll Officer

```text
Payroll
Salary
Allowances
Deductions
Payslips
Payroll Reports
```

## Recruitment Officer

```text
Open Jobs
Applicants
Interviews
Recruitment Pipeline
Recruitment Reports
```

## Employee

```text
My Profile
My Attendance
Check In / Out
My Leave
My Payslips
My Training
My Performance
Notifications
```

---

# 21. Roles

```text
Super Admin
HR Manager
Department Manager
Payroll Officer
Recruitment Officer
Employee
```

---

# 22. Permissions

## Employees

```text
employee.create
employee.view
employee.edit
employee.delete
```

## Departments

```text
department.manage
```

## Attendance

```text
attendance.create
attendance.view
attendance.edit
attendance.delete
```

## Leave

```text
leave.request
leave.view
leave.approve
leave.reject
leave.manage
```

## Payroll

```text
payroll.generate
payroll.manage
payroll.view
payroll.delete
```

## Recruitment

```text
job.create
job.view
job.edit
job.delete

applicant.create
applicant.view
applicant.edit
applicant.delete

interview.create
interview.view
interview.edit
```

## Training

```text
training.create
training.view
training.edit
training.delete
```

## Performance

```text
kpi.manage
performance.view
performance.manage
```

## Reports

```text
report.view
report.export
```

## Administration

```text
user.manage
role.manage
permission.manage
activity-log.view
```

## Settings

```text
settings.manage
```

---

# 23. Role Access

| Module      | Super Admin | HR Manager | Dept Manager | Payroll | Recruitment | Employee |
| ----------- | ----------: | ---------: | -----------: | ------: | ----------: | -------: |
| Dashboard   |           ✓ |          ✓ |            ✓ |       ✓ |           ✓ |        ✓ |
| Company     |           ✓ |          ✓ |            - |       - |           - |        - |
| Branches    |           ✓ |          ✓ |            - |       - |           - |        - |
| Departments |           ✓ |          ✓ |         View |       - |           - |        - |
| Employees   |           ✓ |          ✓ |         Team |       - |           - |      Own |
| Attendance  |           ✓ |          ✓ |         Team |       - |           - |      Own |
| Leave       |           ✓ |          ✓ |      Approve |       - |           - |      Own |
| Payroll     |           ✓ |       View |            - |       ✓ |           - |      Own |
| Recruitment |           ✓ |          ✓ |            - |       - |           ✓ |        - |
| Training    |           ✓ |          ✓ |         Team |       - |           - |      Own |
| Performance |           ✓ |          ✓ |         Team |       - |           - |      Own |
| Reports     |           ✓ |          ✓ |         Team | Payroll | Recruitment |      Own |
| Users       |           ✓ |          ✓ |            - |       - |           - |        - |
| Roles       |           ✓ |          - |            - |       - |           - |        - |
| Permissions |           ✓ |          - |            - |       - |           - |        - |
| Settings    |           ✓ |    Limited |            - |       - |           - |  Profile |

---

# 24. Authentication

Laravel Breeze:

```text
Login
Register
Forgot Password
Reset Password
Profile
Change Password
Logout
```

Recommended production behavior:

```text
Public
  │
  ▼
Login
  │
  ▼
Authenticated User
  │
  ▼
Role / Permission Check
  │
  ▼
Dashboard
```

---

# 25. Project Structure

```text
app/
├── Console/
├── Enums/
├── Events/
├── Helpers/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   ├── Requests/
│   └── Resources/
├── Jobs/
├── Models/
├── Notifications/
├── Policies/
├── Repositories/
└── Services/

database/
├── factories/
├── migrations/
└── seeders/

resources/
├── css/
├── js/
└── views/
    ├── layouts/
    ├── components/
    ├── dashboard/
    ├── company/
    ├── branches/
    ├── departments/
    ├── designations/
    ├── shifts/
    ├── holidays/
    ├── employees/
    ├── attendance/
    ├── leave/
    ├── payroll/
    ├── recruitment/
    ├── training/
    ├── performance/
    ├── reports/
    ├── administration/
    └── settings/

routes/
├── web.php
├── auth.php
├── console.php
└── api.php

storage/
├── app/
├── framework/
└── logs/

tests/
├── Feature/
└── Unit/
```

---

# 26. Services

```text
app/Services/

CompanyService.php

EmployeeService.php
EmployeeTransferService.php
EmployeePromotionService.php
DocumentService.php

AttendanceService.php
AttendanceCalculationService.php

LeaveService.php
LeaveBalanceService.php

PayrollService.php
PayrollCalculationService.php
PayslipService.php

RecruitmentService.php

TrainingService.php

PerformanceService.php

ReportService.php

NotificationService.php
```

---

# 27. Enums

```text
app/Enums/

EmployeeStatus.php
EmploymentType.php
AttendanceStatus.php
LeaveStatus.php
PayrollStatus.php
PaymentStatus.php
ApplicantStatus.php
InterviewStatus.php
TrainingStatus.php
PerformanceStatus.php
DocumentType.php
```

---

# 28. Policies

```text
EmployeePolicy
AttendancePolicy
LeavePolicy
PayrollPolicy
JobPolicy
ApplicantPolicy
TrainingPolicy
PerformancePolicy
ReportPolicy
UserPolicy
RolePolicy
PermissionPolicy
SettingsPolicy
```

Use Spatie Permission for general access and Laravel Policies for contextual authorization.

Example:

```text
Department Manager
       │
       ▼
employee.edit
       │
       ▼
Can edit employees?
       │
       ▼
Only employees in manager's department
```

---

# 29. Queue

Use Laravel queues for:

```text
Email Notifications
Leave Notifications
Payroll Notifications
Payslip Email
Interview Notifications
Training Notifications
Document Expiry Notifications
Contract Expiry Notifications
```

---

# 30. Scheduler

Scheduled tasks:

```text
Daily
├── Process Attendance
├── Mark Missing Attendance
└── Check Expiring Documents

Monthly
├── Payroll Processing
└── Leave Balance Processing

Scheduled
├── Contract Expiry Reminder
├── Interview Reminder
├── Training Reminder
└── Payslip Notification
```

---

# 31. Document Storage

Employee documents:

```text
storage/app/private/employees/

EMP-0001/
├── identity/
├── contracts/
├── certificates/
└── other/

EMP-0002/
├── identity/
├── contracts/
└── certificates/
```

Documents must be protected by authorization.

Do not expose private employee documents through public URLs.

---

# 32. Activity Logs

Track:

```text
Employee Created
Employee Updated
Employee Deleted

Leave Submitted
Leave Approved
Leave Rejected

Payroll Generated
Payroll Updated
Payroll Approved
Payroll Paid

Salary Updated

Role Created
Role Updated
Role Deleted

Permission Changed

Document Uploaded
Document Deleted

Settings Updated
```

---

# 33. Reports

```text
Reports
│
├── Employee Report
├── Attendance Report
├── Leave Report
├── Payroll Report
├── Overtime Report
├── Recruitment Report
├── Training Report
└── Performance Report
```

All reports should support:

* Date filters
* Branch filter
* Department filter
* Employee filter
* Status filter
* Search
* PDF export
* CSV/Excel export
* Print

---

# 34. Mobile Application

NativePHP Mobile should use a bottom navigation.

```text
┌─────────────────────────────┐
│ HRM                 🔔 👤   │
├─────────────────────────────┤
│                             │
│ Good morning, John 👋       │
│                             │
│ ┌─────────────────────────┐ │
│ │ Today's Attendance      │ │
│ │                         │ │
│ │       08:54 AM          │ │
│ │                         │ │
│ │     [ CHECK IN ]        │ │
│ └─────────────────────────┘ │
│                             │
│ Leave Balance               │
│                             │
│ Annual Leave     12 days    │
│ Sick Leave        8 days    │
│                             │
├─────────────────────────────┤
│ 🏠       🕐       🏖      👤 │
│ Home   Attendance  Leave  Me│
└─────────────────────────────┘
```

Employee mobile features:

```text
Dashboard
Attendance
Check In
Check Out
Leave
Leave Balance
Payslips
Profile
Documents
Training
Performance
Notifications
```

---

# 35. Desktop Application

NativePHP Desktop:

```text
Dashboard
Employees
Attendance
Leave
Payroll
Recruitment
Training
Performance
Reports
Administration
Settings
```

Desktop-specific features:

* File management
* Printing
* PDF generation
* Desktop notifications
* Keyboard shortcuts
* Native menus

---

# 36. Future Attendance Integrations

The system can later support:

```text
Manual Attendance
       │
       ├── QR Code
       ├── GPS
       ├── Fingerprint
       ├── Biometric Device
       └── External API
```

Use an attendance provider/service abstraction so integrations can be added without changing the main attendance module.

---

# 37. Future Notifications

```text
In-App
Email
SMS
Push Notification
Desktop Notification
```

Examples:

```text
Leave Approved
Leave Rejected
Payroll Generated
Payslip Available
Interview Scheduled
Training Scheduled
Contract Expiring
Document Expiring
Birthday
Work Anniversary
```

---

# 38. Development Roadmap

## Phase 1 — Foundation

```text
Laravel 12
Laravel Breeze
Spatie Permission
Tailwind CSS
Base Layout
Sidebar
Top Navigation
Company Profile
Departments
Designations
Branches
```

## Phase 2 — Employee Management

```text
Employees
Employee Profile
Documents
Contracts
Transfers
Promotions
```

## Phase 3 — Attendance

```text
Shifts
Shift Assignments
Attendance
Check In / Out
Attendance Logs
Overtime
```

## Phase 4 — Leave

```text
Leave Types
Leave Requests
Approval
Rejection
Leave Balance
Leave Calendar
```

## Phase 5 — Payroll

```text
Salary Structure
Allowances
Deductions
Payroll
Payroll Items
Payslips
```

## Phase 6 — Recruitment

```text
Jobs
Applicants
Interviews
Recruitment Pipeline
```

## Phase 7 — Training & Performance

```text
Courses
Training Sessions
Participants
KPI
Performance Reviews
```

## Phase 8 — Reports

```text
Employee Reports
Attendance Reports
Leave Reports
Payroll Reports
Recruitment Reports
Training Reports
Performance Reports
PDF Export
Excel/CSV Export
```

## Phase 9 — Administration

```text
Users
Roles
Permissions
Activity Logs
Notifications
Settings
```

## Phase 10 — NativePHP

```text
NativePHP Desktop
NativePHP Mobile
Desktop Notifications
Push Notifications
Native File Handling
```

---

# 39. Security

Required:

```text
Authentication
Authorization
CSRF Protection
Request Validation
Password Hashing
Rate Limiting
Role-Based Access
Policy-Based Access
Activity Logging
Secure File Upload
Private Document Storage
Session Security
Database Backups
```

---

# 40. Backup

```text
Database
├── Daily Backup
├── Weekly Backup
└── Monthly Backup

Employee Documents
├── Daily Backup
└── Off-site Backup
```

Regular restoration tests should be performed to verify backups.

---

# 41. Final Architecture

```text
                           ONE COMPANY
                               │
                               ▼
                        Laravel 12 HRM
                               │
             ┌─────────────────┼─────────────────┐
             │                 │                 │
       Laravel Breeze    Spatie Permission    Storage
             │                 │                 │
             └─────────────────┼─────────────────┘
                               │
                         HRM Dashboard
                               │
       ┌───────────────┬───────┼────────┬──────────────┐
       │               │       │        │              │
  Organization     Employees Attendance Leave        Payroll
       │               │       │        │              │
       └───────────────┴───────┴────────┴──────────────┘
                               │
                   ┌───────────┼───────────┐
                   │           │           │
              Recruitment   Training   Performance
                   │           │           │
                   └───────────┼───────────┘
                               │
                            Reports
                               │
                 ┌─────────────┴─────────────┐
                 │                           │
             NativePHP                  Database
             Desktop/Mobile             MySQL/PostgreSQL
```

---

# 42. Final Sidebar

```text
🏢 HRM SYSTEM

MAIN
└── 🏠 Dashboard

ORGANIZATION
├── 🏢 Company Profile
├── 🌿 Branches
├── 🏬 Departments
├── 💼 Designations
├── 🕐 Shifts
└── 📅 Holidays

EMPLOYEES
├── 👥 Employees
├── 📄 Documents
├── 📝 Contracts
├── 🔄 Transfers
└── 📈 Promotions

ATTENDANCE
├── 🕐 Attendance
├── ▶ Check In / Out
├── 📅 Shift Schedule
└── ⏱ Overtime

LEAVE
├── 🏖 Leave Requests
├── 📋 Leave Types
└── 📊 Leave Balance

PAYROLL
├── 💰 Payroll
├── 💵 Salary Structure
├── ➕ Allowances
├── ➖ Deductions
└── 🧾 Payslips

RECRUITMENT
├── 💼 Jobs
├── 👤 Applicants
└── 🎤 Interviews

TRAINING
├── 📚 Courses
└── 🎓 Training Sessions

PERFORMANCE
├── 🎯 KPI
└── ⭐ Performance Reviews

REPORTS
├── 👥 Employees
├── 🕐 Attendance
├── 🏖 Leave
├── 💰 Payroll
├── 💼 Recruitment
└── ⭐ Performance

ADMINISTRATION
├── 👤 Users
├── 🔐 Roles
├── 🛡 Permissions
└── 📜 Activity Logs

⚙ Settings
🚪 Logout
```

---

# 43. Project Goal

The goal is to build a **simple, scalable, single-company HRM system** that manages the complete employee lifecycle.

```text
Recruitment
     ↓
Applicant
     ↓
Employee
     ↓
Contract
     ↓
Department / Branch
     ↓
Attendance
     ↓
Leave
     ↓
Payroll
     ↓
Training
     ↓
Performance
     ↓
Promotion / Transfer
     ↓
Resignation / Termination
```

The architecture intentionally avoids multi-company complexity while retaining **multiple branches, departments, roles, permissions, and employees**.

This makes the application easier to develop, maintain, test, and deploy while leaving a clean path for future integrations such as:

* QR attendance
* GPS attendance
* Fingerprint
* Biometric devices
* Email/SMS
* Push notifications
* REST API
* NativePHP Desktop
* NativePHP Mobile

---

# License

**Private HRM System**

Copyright © 2026 DESIGN

All rights reserved.
