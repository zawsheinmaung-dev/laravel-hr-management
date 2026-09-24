# HR Management System - Database Schema

> **Version:** 1.0
> **Framework:** Laravel 12
> **Database:** MySQL / PostgreSQL
> **Authentication:** Laravel Breeze
> **Authorization:** Spatie Laravel Permission
> **Desktop:** NativePHP Desktop
> **Mobile:** NativePHP Mobile

---

# Naming Convention

အောက်ပါ table အမည်များကို Project Structure နှင့် ကိုက်ညီအောင် အသုံးပြုထားသည်။

| Old Name           | New Name              |
| ------------------ | --------------------- |
| positions          | designations          |
| work_shifts        | shifts                |
| employee_shifts    | shift_assignments     |
| leaves             | leave_requests        |
| candidates         | applicants            |
| trainings          | training_courses      |
| employee_trainings | training_participants |
| audit_logs         | activity_logs         |

> **Note**
>
> Recruitment Module အတွက် `job_vacancies` ကို အသုံးပြုထားသည်။
>
> Laravel Queue System ၏ default `jobs` table နှင့် မတိုက်စေရန် `jobs` အမည်ကို မသုံးပါ။

---

# Database Tables

## Organization
<!-- 
### companies _(Optional)_

- id
- name
- code
- phone
- email
- address
- logo
- timestamps -->

---

<!-- ### branches

- id
- name
- code
- address
- phone
- manager_id
- timestamps
- softDeletes

--- -->

<!-- ### departments

- id
- branch_id
- name
- code
- parent_department_id
- head_employee_id
- description
- timestamps
- softDeletes -->

---
<!-- 
### positions

- id -->
- department_id
- title
- level
- description
- timestamps
- softDeletes

---

<!-- ### shifts

- id
- name
- start_time
- end_time
- grace_minutes
- break_minutes
- timestamps

---

### shift_assignments

- id
- employee_id
- shift_id
- effective_date
- timestamps

---
 -->
### holidays

- id
- name
- holiday_date
- is_recurring
- description
- timestamps

---

# Authentication

<!-- ### users

- id
- name
- email
- password
- status
- email_verified_at
- remember_token
- timestamps

> Roles & Permissions ကို **Spatie Laravel Permission** မှ စီမံမည်။

--- -->

# Employee

<!-- ### employees

- id
- user_id
- employee_code
- first_name
- last_name
- gender
- dob
- national_id
- phone
- personal_email
- address
- branch_id
- department_id
- designation_id
- manager_id
- salary_structure_id
- basic_salary
- join_date
- resign_date
- employment_type
- employment_status
- profile_photo
- timestamps
- softDeletes -->

---

### employee_documents

- id
- employee_id
- document_type
- title
- file_path
- expiry_date
- timestamps

---

### employee_contracts

- id
- employee_id
- contract_type
- start_date
- end_date
- salary
- signed_document
- status
- timestamps

---

### employee_emergency_contacts

- id
- employee_id
- name
- relationship
- phone
- address
- timestamps

---

### employee_bank_accounts

- id
- employee_id
- bank_name
- account_name
- account_number
- branch
- timestamps

---

### employee_qualifications

- id
- employee_id
- qualification
- institution
- year_completed
- certificate_path
- timestamps

---

### skills

- id
- name
- category
- timestamps

---

### employee_skills

- id
- employee_id
- skill_id
- proficiency_level
- timestamps

---

### employee_assets

- id
- employee_id
- asset_id
- assigned_date
- returned_date
- status
- timestamps

---

### company_assets

- id
- asset_name
- serial_number
- asset_type
- purchase_date
- status
- timestamps

---

### employee_transfers

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

---

### employee_promotions

- id
- employee_id
- old_designation_id
- new_designation_id
- old_salary
- new_salary
- effective_date
- approved_by
- timestamps

---

<!-- # Attendance

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
- check_in_ip
- check_out_ip
- timestamps

--- -->

<!-- ### attendance_logs

- id
- employee_id
- log_type
- log_time
- device
- ip_address
- gps_location
- timestamps

--- -->

<!-- ### overtime_requests

- id
- employee_id
- attendance_id
- from_time
- to_time
- reason
- status
- approved_by
- timestamps

--- -->

<!-- # Leave

### leave_types

- id
- name
- days_allowed_per_year
- is_paid
- timestamps

---

### leave_requests

- id
- employee_id
- leave_type_id
- start_date
- end_date
- total_days
- reason
- status
- approved_by
- approved_at
- timestamps

---

### leave_balances

- id
- employee_id
- leave_type_id
- year
- allocated_days
- used_days
- remaining_days
- timestamps

--- -->

# Payroll

<!-- ### salary_structures

- id
- name
- description
- timestamps

---

### salary_structure_items

- id
- salary_structure_id
- component_name
- component_type
- calculation_type
- amount
- percentage
- timestamps -->

---

<!-- ### allowances

- id
- name
- calculation_type
- amount
- timestamps -->

---

<!-- ### deductions

- id
- name
- calculation_type
- amount
- timestamps

--- -->


<!-- 
### tax_brackets

- id
- min_amount
- max_amount
- rate_percentage
- effective_year
- timestamps

--- -->

<!-- ### payroll_batches

- id
- month
- year
- generated_by
- status
- timestamps

--- -->

<!-- ### payrolls

- id
- payroll_batch_id
- employee_id
- month
- year
- basic_salary
- total_allowance
- total_bonus
- total_deduction
- tax
- net_salary
- status
- generated_at
- timestamps

--- -->
<!-- 
### payroll_items

- id
- payroll_id
- item_type
- description
- amount
- timestamps

--- -->

# Recruitment

### job_vacancies

- id
- title
- department_id
- designation_id
- vacancy_count
- employment_type
- salary_min
- salary_max
- description
- requirements
- closing_date
- status
- posted_by
- timestamps

---

### applicants

- id
- vacancy_id
- name
- email
- phone
- resume_path
- status
- applied_at
- timestamps

---

### interviews

- id
- applicant_id
- interviewer_id
- scheduled_at
- location
- feedback
- result
- timestamps

---

# Training

### training_courses

- id
- title
- trainer
- description
- start_date
- end_date
- location
- timestamps

---

### training_participants

- id
- training_course_id
- employee_id
- status
- completion_date
- certificate_path
- timestamps

---

# Performance

### performance_reviews

- id
- employee_id
- reviewer_id
- review_period
- rating
- feedback
- review_date
- timestamps

---

# Documents

### documents

- id
- title
- category
- file_path
- description
- uploaded_by
- timestamps

---

# Notifications

### notifications

Laravel Built-in Notifications Table

---

### notification_templates

- id
- name
- subject
- message
- timestamps

---

# Administration

### activity_logs

- id
- user_id
- action
- model_type
- model_id
- old_values
- new_values
- ip_address
- timestamps

---

### settings

- id
- key
- value
- timestamps

---

# Laravel Default Tables

- password_reset_tokens
- sessions
- jobs
- failed_jobs
- personal_access_tokens

---

# Spatie Permission Tables

- roles
- permissions
- model_has_roles
- model_has_permissions
- role_has_permissions

---

# Relationships

```text

Branch
    └── Department
        ├── Designation
        └── Employee
            ├── Attendance
            ├── Leave
            ├── Payroll
            ├── Training
            ├── Performance
            ├── Documents
            └── Contracts
```

---

# Recommended Indexes

- employees(employee_code) UNIQUE
- users(email) UNIQUE
- departments(code) UNIQUE
- attendances(employee_id, attendance_date) UNIQUE
- payrolls(employee_id, month, year) UNIQUE
- leave_balances(employee_id, leave_type_id, year) UNIQUE
- activity_logs(model_type, model_id)
- applicants(vacancy_id)
- payroll_items(payroll_id)

---

# Recommended Packages

- Laravel Breeze
- Spatie Laravel Permission
- Laravel Sanctum _(Optional API)_
- Laravel Excel
- Laravel DomPDF
- Intervention Image
- Laravel Backup
- Laravel Activitylog _(Optional)_

---

# Estimated Migration Count

| Module            | Tables |
| ----------------- | -----: |
| Core              |      8 |
| Employee          |     11 |
| Attendance        |      3 |
| Leave             |      3 |
| Payroll           |      8 |
| Recruitment       |      3 |
| Training          |      2 |
| Performance       |      1 |
| Documents         |      1 |
| Administration    |      2 |
| Laravel Default   |      5 |
| Spatie Permission |      5 |

**Estimated Total:** **50+ Migration Files**
