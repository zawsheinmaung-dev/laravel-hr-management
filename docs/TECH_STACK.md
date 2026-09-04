# HR Management System (HRM)

## Technology Stack Documentation

## 1. Project Overview

HR Management System ကို Laravel Backend, Vue.js Frontend, Inertia.js Architecture ဖြင့် တည်ဆောက်ထားသည်။

ရည်ရွယ်ချက်များ:

* Employee Management
* Role & Permission Based Access Control
* Attendance Management
* Leave Management
* Payroll Management
* Recruitment
* Training
* Reporting

System ကို Web, Desktop, Mobile Platform များအတွက် Extend လုပ်နိုင်အောင် Architecture ချထားသည်။

---

# 2. Backend Technology

## Laravel Framework

Version:

```
Laravel 12
```

တာဝန်များ:

* Routing
* Controller Logic
* Database Management
* Authentication
* Authorization
* API Development
* Queue / Scheduler

Project Structure:

```
app
│
├── Http
│   ├── Controllers
│   └── Middleware
│
├── Models
│
├── Services
│
└── Providers
```

---

# 3. Authentication

## Laravel Breeze

Authentication System အတွက် Laravel Breeze အသုံးပြုထားသည်။

Features:

* Login
* Register
* Password Reset
* Session Authentication
* User Profile

Authentication Flow:

```
User
 |
 |
Laravel Breeze
 |
 |
users table
 |
 |
Authenticated Session
```

---

# 4. Frontend Technology

## Vue.js

Version:

```
Vue 3
```

အသုံးပြုရခြင်း:

* Component Based UI
* Reactive Interface
* SPA Experience
* Mobile/Desktop Extend လုပ်နိုင်ခြင်း

Structure:

```
resources/js

├── Components
│
├── Layouts
│
├── Pages
│
└── app.js
```

---

# 5. Inertia.js

Laravel + Vue Integration အတွက် Inertia.js အသုံးပြုထားသည်။

Architecture:

```
Browser

   |
   |

Vue Component

   |
   |

Inertia.js

   |
   |

Laravel Controller

   |
   |

Database
```

Example:

Controller:

```php
return Inertia::render(
    'Users/Index'
);
```

Vue:

```
resources/js/Pages/Users/Index.vue
```

---

# 6. Frontend Build System

## Vite

အသုံးပြုမှု:

* Vue Compile
* Asset Bundling
* Development Server

Command:

Development:

```
npm run dev
```

Production:

```
npm run build
```

Configuration:

```
vite.config.js
```

---

# 7. CSS Framework

## Tailwind CSS

Version:

```
Tailwind CSS v4
```

အသုံးပြုမှု:

* Responsive UI
* Dashboard Design
* Component Styling

Vite Integration:

```javascript
import tailwindcss from '@tailwindcss/vite'
```

---

# 8. Authorization System

## Spatie Laravel Permission

Package:

```
spatie/laravel-permission
```

အသုံးပြုမှု:

* Role Management
* Permission Management
* Middleware Authorization

Database Tables:

```
roles

permissions

model_has_roles

model_has_permissions

role_has_permissions
```

Flow:

```
User

 |

Role

 |

Permission

 |

Middleware

 |

Controller Access
```

---

# 9. Current Roles

```
Super Admin

HR Manager

Department Manager

Payroll Officer

Recruitment Officer

Employee
```

---

# 10. Current Permissions

Employee:

```
employee.create
employee.view
employee.edit
employee.delete
```

Department:

```
department.manage
```

Attendance:

```
attendance.create
attendance.view
attendance.edit
```

Leave:

```
leave.request
leave.approve
leave.reject
```

Payroll:

```
payroll.generate
payroll.manage
payroll.view
```

System:

```
role.manage

permission.manage

settings.manage
```

Recruitment:

```
job.manage

applicant.create

applicant.view

applicant.edit

applicant.delete

interview.manage
```

Training:

```
training.manage

training.view
```

Performance:

```
performance.manage

performance.view
```

---

# 11. Database

Current Database Support:

```
MySQL
PostgreSQL
SQLite (Testing)
```

ORM:

```
Laravel Eloquent ORM
```

Migration Structure:

```
database
│
└── migrations
```

---

# 12. Testing Environment

Testing Database:

```
SQLite :memory:
```

Testing Framework:

```
PHPUnit
```

Current Tests:

```
tests

├── Feature

│   └── RolePermissionTest


└── Unit
```

Role Permission Test:

Verified:

```
Roles Created

Permissions Created

Super Admin Has All Permissions
```

---

# 13. Current Development Status

Completed:

```
✅ Laravel 12 Installation

✅ Laravel Breeze Authentication

✅ Vue 3 Setup

✅ Inertia.js Setup

✅ Vite Configuration

✅ Tailwind CSS Setup

✅ Spatie Permission Installation

✅ Role Seeder

✅ Permission Seeder

✅ Role Permission Testing
```

---

# 14. Next Development Phase

## User Management

```
User CRUD

Assign Role

Permission Middleware

User Permission Testing
```

## Core HRM

```


Departments

Designations

Employees
```

---

# 15. Future Platform Support

Architecture Target:

```
                Laravel 12

                    |

        -----------------------

        |                     |

   Inertia Vue Web       API Layer

                              |

                 ---------------------

                 |                   |

          NativePHP Desktop   NativePHP Mobile

```

---

# Summary

Current HRM Technology Stack:

```
Backend
--------
Laravel 12


Authentication
--------
Laravel Breeze


Frontend
--------
Vue 3


SPA Bridge
--------
Inertia.js


Build Tool
--------
Vite


CSS
--------
Tailwind CSS v4


Authorization
--------
Spatie Laravel Permission


Database
--------
MySQL/PostgreSQL


Testing
--------
PHPUnit + SQLite
```
