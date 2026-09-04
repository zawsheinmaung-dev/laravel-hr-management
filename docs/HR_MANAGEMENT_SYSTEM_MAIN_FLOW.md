# HR Management System - Development Plan

> Framework: Laravel 12
> Frontend: Vue + Inertia
> Authentication: Laravel Breeze
> Authorization: Spatie Laravel Permission
> Database: MySQL / PostgreSQL
> Current Status: User + Employee + Role/Permission completed

---

# 1. Project Current Status

## Completed

- [x] User CRUD
- [x] Employee CRUD
- [x] User ↔ Employee relationship
- [x] Role management
- [x] Permission management
- [x] Spatie Laravel Permission
- [x] Employee Service Class
- [x] DB Transaction
- [x] User / Employee Soft Delete
- [x] Employee Code Auto Generation
- [x] User Email Auto Generation

---

# 2. Phase 1 - Organization Management

Priority: ⭐⭐⭐⭐⭐

## 2.1 Branches

Table:

- id
- name
- code
- address
- phone
- manager_id
- timestamps
- softDeletes

Tasks:

- [ ] Branch migration
- [ ] Branch model
- [ ] Branch relationships
- [ ] BranchRequest
- [ ] BranchService
- [ ] BranchController
- [ ] Branch CRUD
- [ ] Branch validation
- [ ] Branch soft delete
- [ ] Branch restore
- [ ] Branch list/search

---

## 2.2 Departments

Table:

- id
- branch_id
- name
- code
- parent_department_id
- head_employee_id
- description
- timestamps
- softDeletes

Tasks:

- [ ] Department migration
- [ ] Department model
- [ ] Branch relationship
- [ ] Parent department relationship
- [ ] Head employee relationship
- [ ] DepartmentRequest
- [ ] DepartmentService
- [ ] DepartmentController
- [ ] Department CRUD
- [ ] Department validation
- [ ] Department soft delete
- [ ] Department restore

---

## 2.3 Designations

> Use `designations` consistently.
> Do not mix `positions` and `designations`.

Table:

- id
- department_id
- title
- level
- description
- timestamps
- softDeletes

Tasks:

- [ ] Rename/decide `positions` → `designations`
- [ ] Designation migration
- [ ] Designation model
- [ ] Department relationship
- [ ] DesignationRequest
- [ ] DesignationService
- [ ] DesignationController
- [ ] Designation CRUD
- [ ] Validation
- [ ] Soft delete
- [ ] Restore

---

# 3. Phase 2 - Employee Profile

Priority: ⭐⭐⭐⭐

## 3.1 Qualifications

Table:

- id
- employee_id
- qualification
- institution
- year_completed
- certificate_path
- timestamps

Tasks:

- [ ] Migration
- [ ] Model
- [ ] Employee relationship
- [ ] Request validation
- [ ] Service
- [ ] CRUD
- [ ] Certificate upload

---

## 3.2 Emergency Contacts

Table:

- id
- employee_id
- name
- relationship
- phone
- address
- timestamps

Tasks:

- [ ] Migration
- [ ] Model
- [ ] Employee relationship
- [ ] CRUD
- [ ] Validation

---

## 3.3 Bank Accounts

Table:

- id
- employee_id
- bank_name
- account_name
- account_number
- branch
- timestamps

Tasks:

- [ ] Migration
- [ ] Model
- [ ] Employee relationship
- [ ] CRUD
- [ ] Validation

---

## 3.4 Employee Contracts

Table:

- id
- employee_id
- contract_type
- start_date
- end_date
- salary
- signed_document
- status
- timestamps

Tasks:

- [ ] Migration
- [ ] Model
- [ ] Employee relationship
- [ ] Contract CRUD
- [ ] Contract validation
- [ ] Signed document upload
- [ ] Contract status
- [ ] Expiry handling

---

# 4. Phase 3 - Shift Management

Priority: ⭐⭐⭐⭐

## 4.1 Shifts

Table:

- id
- name
- start_time
- end_time
- grace_minutes
- break_minutes
- timestamps

Tasks:

- [ ] Shift CRUD
- [ ] Validation
- [ ] Active/inactive status if needed

---

## 4.2 Shift Assignments

Table:

- id
- employee_id
- shift_id
- effective_date
- timestamps

Tasks:

- [ ] Migration
- [ ] Relationships
- [ ] Assign shift to employee
- [ ] Change shift
- [ ] Shift history

---

## 4.3 Holidays

Table:

- id
- name
- holiday_date
- is_recurring
- description
- timestamps

Tasks:

- [ ] Holiday CRUD
- [ ] Recurring holiday support
- [ ] Holiday validation

---

# 5. Phase 4 - Attendance

Priority: ⭐⭐⭐⭐⭐

Tables:

### attendances

- id
- employee_id
- attendance_date
- check_in
- check_out
- working_hours
- late_minutes
- early_leave_minutes
- overtime_minutes
- status
- timestamps

### attendance_logs

- id
- employee_id
- log_type
- log_time
- device
- ip_address
- gps_location
- timestamps

### overtime_requests

- id
- employee_id
- attendance_id
- requested_hours
- reason
- status
- approved_by
- timestamps

Tasks:

- [ ] Attendance migration
- [ ] Attendance model
- [ ] Check-in
- [ ] Check-out
- [ ] Working hours calculation
- [ ] Late calculation
- [ ] Early leave calculation
- [ ] Overtime calculation
- [ ] Attendance history
- [ ] Attendance logs
- [ ] Overtime request
- [ ] Overtime approval
- [ ] Monthly attendance report

---

# 6. Phase 5 - Leave Management

Priority: ⭐⭐⭐⭐⭐

## 6.1 Leave Types

- [ ] Leave Type CRUD
- [ ] Paid/unpaid
- [ ] Annual allocation

## 6.2 Leave Requests

- [ ] Leave request
- [ ] Validation
- [ ] Approve
- [ ] Reject
- [ ] Cancel
- [ ] Leave history

## 6.3 Leave Balances

- [ ] Yearly leave balance
- [ ] Allocated days
- [ ] Used days
- [ ] Remaining days
- [ ] Automatic balance update

---

# 7. Phase 6 - Employee Skills

Priority: ⭐⭐⭐

## Skills

Table:

- id
- name
- category
- timestamps

Tasks:

- [ ] Skill CRUD
- [ ] Skill categories

## Employee Skills

Table:

- id
- employee_id
- skill_id
- proficiency_level
- timestamps

Tasks:

- [ ] Assign skill
- [ ] Remove skill
- [ ] Update proficiency
- [ ] Employee skill list

Relationship:

Employee ↔ Skills = Many-to-Many

---

# 8. Phase 7 - Company Assets

Priority: ⭐⭐⭐

## Company Assets

Table:

- id
- asset_name
- serial_number
- asset_type
- purchase_date
- status
- timestamps

Tasks:

- [ ] Asset CRUD
- [ ] Asset validation
- [ ] Asset status

## Employee Assets

Table:

- id
- employee_id
- asset_id
- assigned_date
- returned_date
- status
- timestamps

Tasks:

- [ ] Assign asset
- [ ] Return asset
- [ ] Asset history
- [ ] Current assigned assets

---

# 9. Phase 8 - Employee Transfers

Priority: ⭐⭐⭐

Table:

- id
- employee_id
- from_department_id
- to_department_id
- from_designation_id
- to_designation_id
- effective_date
- approved_by
- remarks
- timestamps

Tasks:

- [ ] Transfer request
- [ ] Approval
- [ ] Update employee department
- [ ] Update employee designation
- [ ] Transfer history
- [ ] Approved by user

---

# 10. Phase 9 - Employee Promotions

Priority: ⭐⭐⭐

Table:

- id
- employee_id
- old_designation_id
- new_designation_id
- old_salary
- new_salary
- effective_date
- approved_by
- timestamps

Tasks:

- [ ] Promotion request
- [ ] Approval
- [ ] Update designation
- [ ] Update salary
- [ ] Promotion history

---

# 11. Phase 10 - Employee Documents

Priority: ⭐⭐⭐

> Implement after the core employee modules are stable.

Table:

- id
- employee_id
- document_type
- title
- file_path
- expiry_date
- timestamps

Tasks:

- [ ] Document upload
- [ ] Document list
- [ ] Document preview
- [ ] Document download
- [ ] Document delete
- [ ] Expiry date
- [ ] Expired document filter
- [ ] File validation
- [ ] File size validation

---

# 12. Phase 11 - Recruitment

Priority: ⭐⭐

## Job Vacancies

- [ ] Vacancy CRUD
- [ ] Department
- [ ] Designation
- [ ] Vacancy count
- [ ] Salary range
- [ ] Closing date
- [ ] Vacancy status

## Applicants

- [ ] Applicant CRUD
- [ ] Resume upload
- [ ] Applicant status
- [ ] Application history

## Interviews

- [ ] Schedule interview
- [ ] Interviewer
- [ ] Feedback
- [ ] Result

Recruitment Flow:

Vacancy
  ↓
Applicant
  ↓
Interview
  ↓
Selected
  ↓
Employee

---

# 13. Phase 12 - Training

Priority: ⭐⭐

## Training Courses

- [ ] Course CRUD
- [ ] Trainer
- [ ] Date
- [ ] Location

## Training Participants

- [ ] Assign employee
- [ ] Completion status
- [ ] Completion date
- [ ] Certificate upload

---

# 14. Phase 13 - Performance

Priority: ⭐⭐

Table:

- id
- employee_id
- reviewer_id
- review_period
- rating
- feedback
- review_date
- timestamps

Tasks:

- [ ] Performance review
- [ ] Reviewer
- [ ] Rating
- [ ] Feedback
- [ ] Review history
- [ ] Employee performance report

---

# 15. Phase 14 - Payroll

Priority: ⭐⭐⭐⭐⭐
Difficulty: High

## Salary Structures

- [ ] Salary structure CRUD
- [ ] Salary structure items
- [ ] Components

## Allowances

- [ ] Allowance CRUD
- [ ] Fixed amount
- [ ] Percentage

## Deductions

- [ ] Deduction CRUD
- [ ] Fixed amount
- [ ] Percentage

## Employee Loans

- [ ] Loan creation
- [ ] Monthly deduction
- [ ] Remaining balance
- [ ] Loan status

## Tax

- [ ] Tax brackets
- [ ] Effective year
- [ ] Tax calculation

## Payroll

- [ ] Payroll batch
- [ ] Generate payroll
- [ ] Payroll calculation
- [ ] Allowance calculation
- [ ] Deduction calculation
- [ ] Tax calculation
- [ ] Net salary
- [ ] Payroll items
- [ ] Payroll approval
- [ ] Payroll history
- [ ] Payslip generation

Payroll Flow:

Employee
    ↓
Salary Structure
    ↓
Allowances
    ↓
Deductions
    ↓
Attendance / Overtime
    ↓
Loan
    ↓
Tax
    ↓
Payroll
    ↓
Payslip

---

# 16. Phase 15 - Administration

Priority: ⭐⭐⭐

## Activity Logs

- [ ] User activity log
- [ ] Create log
- [ ] Update log
- [ ] Delete log
- [ ] Login log
- [ ] IP address
- [ ] Old values
- [ ] New values

## Settings

- [ ] System settings
- [ ] Company information
- [ ] Default settings
- [ ] General configuration

---

# 17. Notifications

Priority: ⭐⭐⭐

Tasks:

- [ ] Laravel Notifications
- [ ] Notification list
- [ ] Mark as read
- [ ] Mark all as read
- [ ] Notification templates
- [ ] Leave approval notification
- [ ] Contract expiry notification
- [ ] Document expiry notification
- [ ] Payroll notification

---

# 18. Reports

Priority: ⭐⭐⭐⭐

Tasks:

- [ ] Employee report
- [ ] Attendance report
- [ ] Leave report
- [ ] Payroll report
- [ ] Department report
- [ ] Branch report
- [ ] Asset report
- [ ] Training report
- [ ] Performance report

Export:

- [ ] Excel
- [ ] PDF
- [ ] CSV

---

# 19. Dashboard

Priority: ⭐⭐⭐⭐

Dashboard cards:

- [ ] Total employees
- [ ] Active employees
- [ ] Resigned employees
- [ ] New employees
- [ ] Today's attendance
- [ ] Today's absent employees
- [ ] Pending leave requests
- [ ] Pending overtime requests
- [ ] Expiring contracts
- [ ] Expiring documents

Charts:

- [ ] Employees by department
- [ ] Employees by branch
- [ ] Attendance overview
- [ ] Leave overview
- [ ] Employee growth

---

# 20. Security

Tasks:

- [ ] Authorization with Spatie Permission
- [ ] Route middleware
- [ ] Policy
- [ ] Form Request validation
- [ ] File validation
- [ ] File upload security
- [ ] Login protection
- [ ] Password reset
- [ ] Email verification
- [ ] Activity logging

---

# 21. Testing

## Feature Tests

- [ ] User CRUD
- [ ] Employee CRUD
- [ ] Branch CRUD
- [ ] Department CRUD
- [ ] Designation CRUD
- [ ] Attendance
- [ ] Leave
- [ ] Payroll
- [ ] Recruitment

## Unit Tests

- [ ] EmployeeService
- [ ] Attendance calculation
- [ ] Leave calculation
- [ ] Payroll calculation

## Authorization Tests

- [ ] Admin permissions
- [ ] HR permissions
- [ ] Manager permissions
- [ ] Employee permissions

---

# 22. UI / UX

Tasks:

- [ ] Responsive layout
- [ ] Form validation messages
- [ ] Loading states
- [ ] Confirmation dialogs
- [ ] Toast notifications
- [ ] Empty states
- [ ] Pagination
- [ ] Search
- [ ] Filters
- [ ] Sorting
- [ ] Modal forms
- [ ] File upload UI
- [ ] Error handling

---

# 23. Deployment / Production

Tasks:

- [ ] Production environment
- [ ] Database backup
- [ ] Storage configuration
- [ ] Queue configuration
- [ ] Scheduler
- [ ] Cache
- [ ] Logging
- [ ] Error monitoring
- [ ] Backup strategy
- [ ] Production testing

---

# 24. Development Priority

Recommended order:

1. [x] User
2. [x] Employee
3. [x] Roles & Permissions

4. [ ] Branch
5. [ ] Department
6. [ ] Designation

7. [ ] Qualifications
8. [ ] Emergency Contacts
9. [ ] Bank Accounts
10. [ ] Contracts

11. [ ] Shifts
12. [ ] Shift Assignments
13. [ ] Holidays

14. [ ] Attendance
15. [ ] Overtime
16. [ ] Leave

17. [ ] Skills
18. [ ] Assets
19. [ ] Transfers
20. [ ] Promotions

21. [ ] Employee Documents

22. [ ] Recruitment
23. [ ] Training
24. [ ] Performance

25. [ ] Payroll

26. [ ] Notifications
27. [ ] Activity Logs
28. [ ] Settings

29. [ ] Reports
30. [ ] Dashboard

31. [ ] Testing
32. [ ] Security Review
33. [ ] Production Deployment

---

# 25. Estimated Timeline

## MVP

Approximately:

- Organization: 1–2 days
- Employee profile modules: 2–4 days
- Shift + Leave: 2–4 days
- Attendance: 3–5 days
- Basic Assets / Skills: 2–3 days
- Documents: 2–3 days

Estimated MVP:

**15–25 days**

---

## Full HR System

Recruitment + Training + Performance + Payroll + Reports + Notifications + Testing included:

**40–60+ days**

Payroll and Attendance complexity may increase the timeline.

---

# 26. Important Architecture Rules

Use the same pattern for business modules:

Request
    ↓
Controller
    ↓
Service
    ↓
Model
    ↓
Database

Example:

EmployeeRequest
    ↓
EmployeeController
    ↓
EmployeeService
    ↓
Employee Model

Rules:

- [ ] Use Form Requests for validation
- [ ] Use Services for business logic
- [ ] Use DB::transaction() for multi-step operations
- [ ] Use Policies / Spatie Permission for authorization
- [ ] Use Eloquent relationships
- [ ] Use SoftDeletes where historical records are important
- [ ] Avoid putting business logic directly in Controllers
- [ ] Keep naming consistent
- [ ] Use `designations` consistently instead of mixing `positions` and `designations`

---

# 27. Current Next Step

Current completed:

User + Employee + Role/Permission

Next:

**Branch CRUD**
    ↓
**Department CRUD**
    ↓
**Designation CRUD**

After that:

**Employee Qualifications**
    ↓
**Emergency Contacts**
    ↓
**Bank Accounts**
    ↓
**Contracts**

Do not start Payroll yet.

Build the foundation and HR core first, then implement complex modules such as Attendance, Leave and Payroll.