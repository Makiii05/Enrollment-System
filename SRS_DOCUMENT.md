# Software Requirements Specification (SRS)

## Enrollment Management System

**Document Version:** 1.0  
**Date:** January 20, 2026  
**Project Name:** Academic Enrollment Management System

---

## Table of Contents

1. [Introduction](#1-introduction)
    - 1.1 [Project Scope](#11-project-scope)
    - 1.2 [Project Value](#12-project-value)
    - 1.3 [Intended Audience](#13-intended-audience)
    - 1.4 [Intended Use](#14-intended-use)
    - 1.5 [Definitions and Acronyms](#15-definitions-and-acronyms)
2. [Functional Requirements](#2-functional-requirements)
3. [External Interface Requirements](#3-external-interface-requirements)
4. [Non-Functional Requirements](#4-non-functional-requirements)

---

## 1. Introduction

### 1.1 Project Scope

The **Enrollment Management System** is a comprehensive, web-based application designed to streamline and automate the academic enrollment process for educational institutions. The system covers the entire student lifecycle from initial application through admission, enrollment, and academic records management.

#### In Scope:

- **Application Management:** Online submission and tracking of student applications
- **Admission Processing:** Interview scheduling, entrance examination management, and final evaluation
- **Academic Structure Management:** Departments, programs, curricula, subjects, and prospectuses
- **Student Records Management:** Student profiles, contact information, guardian details, and academic history
- **Fee Management:** Tuition fees, miscellaneous fees, and payment tracking by program
- **Schedule Management:** Interview and examination scheduling with proctor assignment
- **Academic Term Management:** Semester/term configuration with date ranges
- **User Access Control:** Role-based authentication for Registrar, Accounting, and Admission staff

#### Out of Scope:

- Online payment gateway integration
- Student portal for self-service
- Learning Management System (LMS) features
- Alumni management
- Mobile native applications

### 1.2 Project Value

The Enrollment Management System provides significant value to educational institutions by:

1. **Operational Efficiency:**
    - Eliminates manual paper-based enrollment processes
    - Reduces data entry errors through form validation
    - Automates application number generation and tracking
    - Streamlines the admission pipeline from application to enrollment

2. **Data Centralization:**
    - Single source of truth for all enrollment-related data
    - Unified database for students, programs, and academic records
    - Consistent data structure across all departments

3. **Process Standardization:**
    - Standardized admission workflow (Application → Interview → Exam → Evaluation)
    - Consistent fee structures per program and academic year
    - Uniform curriculum and prospectus management across departments

4. **Time Savings:**
    - Faster application processing with digital forms
    - Quick access to student and applicant records
    - Efficient searching and filtering capabilities

5. **Decision Support:**
    - Comprehensive admission scoring (interview + exam scores)
    - Final evaluation with program assignment capabilities
    - Status tracking throughout the admission process

6. **Scalability:**
    - Support for multiple departments and programs
    - Flexible academic term configuration (semester/yearly)
    - Expandable fee structure management

### 1.3 Intended Audience

This document is intended for:

| Audience                    | Purpose                                                  |
| --------------------------- | -------------------------------------------------------- |
| **Project Stakeholders**    | Understanding system capabilities and limitations        |
| **System Administrators**   | System deployment, configuration, and maintenance        |
| **Software Developers**     | System development, enhancement, and debugging           |
| **QA/Testing Team**         | Test case development and validation                     |
| **Registrar Staff**         | Understanding available features for academic management |
| **Admission Staff**         | Understanding the admission workflow and features        |
| **Accounting Staff**        | Understanding fee management capabilities                |
| **IT Support Team**         | Technical support and troubleshooting                    |
| **Database Administrators** | Database structure and relationship understanding        |

### 1.4 Intended Use

The system is designed to be used by three primary user roles within an educational institution:

#### 1.4.1 Registrar Department

- Manage academic structure (departments, programs, curricula)
- Configure subjects and prospectuses
- Define academic terms and year levels
- Maintain student academic records
- Generate enrollment reports

#### 1.4.2 Admission Department

- Process new student applications
- Schedule and conduct interviews
- Administer entrance examinations
- Evaluate applicants and make admission decisions
- Assign accepted students to programs

#### 1.4.3 Accounting Department

- Configure fee structures by program
- Set up payment schedules (monthly installments)
- Categorize fees by type and group
- Manage fee records per academic year

#### 1.4.4 Applicants (External Users)

- Submit online applications
- Provide personal, family, and educational information
- Select preferred programs (up to 3 choices)
- Receive application confirmation

### 1.5 Definitions and Acronyms

| Term              | Definition                                                      |
| ----------------- | --------------------------------------------------------------- |
| **CRUD**          | Create, Read, Update, Delete - basic data operations            |
| **LRN**           | Learner Reference Number - unique student identifier from DepEd |
| **SHS**           | Senior High School                                              |
| **JHS**           | Junior High School                                              |
| **Curriculum**    | A structured plan of academic subjects for a specific program   |
| **Prospectus**    | The assignment of subjects to specific year levels and terms    |
| **Academic Term** | A specific period within an academic year (semester/trimester)  |
| **Program**       | An academic degree or course of study (e.g., BSIT, BSCS)        |
| **Department**    | An academic division (e.g., College of Computer Studies)        |
| **Level**         | Year level or grade level within a program                      |
| **Proctor**       | Staff member assigned to supervise examinations/interviews      |
| **MVC**           | Model-View-Controller architectural pattern                     |
| **ORM**           | Object-Relational Mapping                                       |
| **API**           | Application Programming Interface                               |
| **UI**            | User Interface                                                  |
| **RBAC**          | Role-Based Access Control                                       |
| **Lech**          | Lecture Hours                                                   |
| **Labh**          | Laboratory Hours                                                |
| **Lecu**          | Lecture Units                                                   |
| **Labu**          | Laboratory Units                                                |

---

## 2. Functional Requirements

### 2.1 User Authentication and Authorization

| ID          | Requirement                                                                     | Priority |
| ----------- | ------------------------------------------------------------------------------- | -------- |
| FR-AUTH-001 | The system shall allow users to log in using email and password credentials     | High     |
| FR-AUTH-002 | The system shall support three user types: Registrar, Accounting, and Admission | High     |
| FR-AUTH-003 | The system shall restrict access to modules based on user type                  | High     |
| FR-AUTH-004 | The system shall provide secure logout functionality                            | High     |
| FR-AUTH-005 | The system shall hash and securely store user passwords                         | High     |

### 2.2 Application Management Module

| ID         | Requirement                                                                                       | Priority |
| ---------- | ------------------------------------------------------------------------------------------------- | -------- |
| FR-APP-001 | The system shall allow external users (applicants) to submit applications online                  | High     |
| FR-APP-002 | The system shall auto-generate unique application numbers                                         | High     |
| FR-APP-003 | The system shall capture the following applicant information:                                     | High     |
|            | - Level (Nursery, Kindergarten, Grade School, JHS, SHS, College)                                  |          |
|            | - Student Type (New, Transferee)                                                                  |          |
|            | - Year Level                                                                                      |          |
|            | - Strand (for SHS)                                                                                |          |
|            | - Program Choices (1st, 2nd, 3rd choice for College)                                              |          |
| FR-APP-004 | The system shall capture personal information including:                                          | High     |
|            | - Full Name (Last, First, Middle)                                                                 |          |
|            | - Sex, Citizenship, Religion                                                                      |          |
|            | - Birthdate, Place of Birth, Civil Status                                                         |          |
| FR-APP-005 | The system shall capture contact information including:                                           | High     |
|            | - Present and Permanent Address                                                                   |          |
|            | - Zip Code, Telephone, Mobile, Email                                                              |          |
| FR-APP-006 | The system shall capture parent/guardian information including:                                   | Medium   |
|            | - Mother's details (name, occupation, contact, income)                                            |          |
|            | - Father's details (name, occupation, contact, income)                                            |          |
|            | - Guardian's details (name, occupation, contact, income)                                          |          |
| FR-APP-007 | The system shall capture educational background including:                                        | Medium   |
|            | - Elementary School details                                                                       |          |
|            | - Junior High School details                                                                      |          |
|            | - Senior High School details                                                                      |          |
|            | - College/Previous School details (for transferees)                                               |          |
| FR-APP-008 | The system shall capture the applicant's LRN (Learner Reference Number)                           | High     |
| FR-APP-009 | The system shall validate required fields before submission                                       | High     |
| FR-APP-010 | The system shall allow resubmission using the same email address                                  | Medium   |
| FR-APP-011 | The system shall track application status (pending, interviewed, exam_passed, rejected, accepted) | High     |

### 2.3 Admission Processing Module

| ID         | Requirement                                                                        | Priority |
| ---------- | ---------------------------------------------------------------------------------- | -------- |
| FR-ADM-001 | The system shall display all applicants with filtering capabilities                | High     |
| FR-ADM-002 | The system shall allow marking applicants for interview                            | High     |
| FR-ADM-003 | The system shall support interview scheduling with the following details:          | High     |
|            | - Proctor assignment                                                               |          |
|            | - Date, Start Time, End Time                                                       |          |
|            | - Process type (Interview/Exam)                                                    |          |
|            | - Status (Active/Inactive)                                                         |          |
| FR-ADM-004 | The system shall record interview results including:                               | High     |
|            | - Interview Score                                                                  |          |
|            | - Interview Remark (text notes)                                                    |          |
|            | - Interview Result (Passed/Failed/Pending)                                         |          |
| FR-ADM-005 | The system shall allow marking interviewed applicants for examination              | High     |
| FR-ADM-006 | The system shall record examination scores including:                              | High     |
|            | - Math Score                                                                       |          |
|            | - Science Score                                                                    |          |
|            | - English Score                                                                    |          |
|            | - Filipino Score                                                                   |          |
|            | - Abstract Reasoning Score                                                         |          |
|            | - Total Exam Score                                                                 |          |
|            | - Exam Result (Passed/Failed/Pending)                                              |          |
| FR-ADM-007 | The system shall calculate final scores combining interview and exam results       | High     |
| FR-ADM-008 | The system shall support final evaluation with:                                    | High     |
|            | - Decision (Accepted/Rejected/Pending)                                             |          |
|            | - Program Assignment (from applicant's choices)                                    |          |
|            | - Evaluator identification                                                         |          |
|            | - Evaluation timestamp                                                             |          |
| FR-ADM-009 | The system shall allow marking applicants for final evaluation                     | Medium   |
| FR-ADM-010 | The system shall display separate views for Interview, Exam, and Evaluation stages | Medium   |

### 2.4 Department Management Module

| ID          | Requirement                                                        | Priority |
| ----------- | ------------------------------------------------------------------ | -------- |
| FR-DEPT-001 | The system shall allow CRUD operations for departments             | High     |
| FR-DEPT-002 | The system shall capture department code and description           | High     |
| FR-DEPT-003 | The system shall track department status (Active/Inactive)         | Medium   |
| FR-DEPT-004 | The system shall associate departments with programs (one-to-many) | High     |
| FR-DEPT-005 | The system shall provide searchable department listings            | Medium   |

### 2.5 Program Management Module

| ID          | Requirement                                                      | Priority |
| ----------- | ---------------------------------------------------------------- | -------- |
| FR-PROG-001 | The system shall allow CRUD operations for programs              | High     |
| FR-PROG-002 | The system shall capture program code and description            | High     |
| FR-PROG-003 | The system shall associate programs with departments             | High     |
| FR-PROG-004 | The system shall track program status (Active/Inactive)          | Medium   |
| FR-PROG-005 | The system shall associate programs with curricula (one-to-many) | High     |
| FR-PROG-006 | The system shall associate programs with levels (one-to-many)    | High     |
| FR-PROG-007 | The system shall associate programs with fees (one-to-many)      | High     |

### 2.6 Curriculum Management Module

| ID          | Requirement                                                            | Priority |
| ----------- | ---------------------------------------------------------------------- | -------- |
| FR-CURR-001 | The system shall allow CRUD operations for curricula                   | High     |
| FR-CURR-002 | The system shall capture curriculum name and associate with department | High     |
| FR-CURR-003 | The system shall track curriculum status (Active/Inactive)             | Medium   |
| FR-CURR-004 | The system shall associate curricula with prospectuses (one-to-many)   | High     |

### 2.7 Subject Management Module

| ID          | Requirement                                                            | Priority |
| ----------- | ---------------------------------------------------------------------- | -------- |
| FR-SUBJ-001 | The system shall allow CRUD operations for subjects                    | High     |
| FR-SUBJ-002 | The system shall capture subject details including:                    | High     |
|             | - Subject Code                                                         |          |
|             | - Description                                                          |          |
|             | - Total Units                                                          |          |
|             | - Lecture Hours (Lech)                                                 |          |
|             | - Laboratory Hours (Labh)                                              |          |
|             | - Lecture Units (Lecu)                                                 |          |
|             | - Laboratory Units (Labu)                                              |          |
| FR-SUBJ-003 | The system shall classify subjects by type (Lecture, Lab, Lecture+Lab) | High     |
| FR-SUBJ-004 | The system shall track subject status (Active/Inactive)                | Medium   |
| FR-SUBJ-005 | The system shall provide searchable subject listings                   | Medium   |

### 2.8 Level/Year Level Management Module

| ID         | Requirement                                                           | Priority |
| ---------- | --------------------------------------------------------------------- | -------- |
| FR-LVL-001 | The system shall allow CRUD operations for levels                     | High     |
| FR-LVL-002 | The system shall capture level code and description                   | High     |
| FR-LVL-003 | The system shall associate levels with programs                       | High     |
| FR-LVL-004 | The system shall support ordering of levels (sequence within program) | Medium   |

### 2.9 Academic Term Management Module

| ID          | Requirement                                               | Priority |
| ----------- | --------------------------------------------------------- | -------- |
| FR-TERM-001 | The system shall allow CRUD operations for academic terms | High     |
| FR-TERM-002 | The system shall capture the following term information:  | High     |
|             | - Term Code                                               |          |
|             | - Description                                             |          |
|             | - Type (Semester/Full Year)                               |          |
|             | - Associated Department                                   |          |
|             | - Academic Year                                           |          |
|             | - Start Date and End Date                                 |          |
| FR-TERM-003 | The system shall track term status (Active/Inactive)      | Medium   |

### 2.10 Prospectus Management Module

| ID          | Requirement                                                                         | Priority |
| ----------- | ----------------------------------------------------------------------------------- | -------- |
| FR-PROS-001 | The system shall allow CRUD operations for prospectus entries                       | High     |
| FR-PROS-002 | The system shall link subjects to curricula, academic terms, and levels             | High     |
| FR-PROS-003 | The system shall track prospectus entry status (Active/Inactive)                    | Medium   |
| FR-PROS-004 | The system shall provide search/filter functionality by curriculum, term, and level | High     |
| FR-PROS-005 | The system shall provide API endpoints for dynamic prospectus loading               | Medium   |

### 2.11 Fee Management Module

| ID         | Requirement                                                         | Priority |
| ---------- | ------------------------------------------------------------------- | -------- |
| FR-FEE-001 | The system shall allow CRUD operations for fees                     | High     |
| FR-FEE-002 | The system shall capture fee details including:                     | High     |
|            | - Description                                                       |          |
|            | - Amount (with 2 decimal precision)                                 |          |
|            | - Type (categorization)                                             |          |
|            | - Month to Pay (installment number)                                 |          |
|            | - Group (fee grouping)                                              |          |
|            | - Academic Year                                                     |          |
|            | - Associated Program                                                |          |
| FR-FEE-003 | The system shall associate fees with specific programs              | High     |
| FR-FEE-004 | The system shall support search/filter by program and academic year | Medium   |

### 2.12 Student Records Management Module

| ID         | Requirement                                                                     | Priority |
| ---------- | ------------------------------------------------------------------------------- | -------- |
| FR-STU-001 | The system shall create student records from accepted applicants                | High     |
| FR-STU-002 | The system shall auto-generate unique student numbers                           | High     |
| FR-STU-003 | The system shall capture student details including:                             | High     |
|            | - Student Number                                                                |          |
|            | - LRN                                                                           |          |
|            | - Department, Program, and Level assignment                                     |          |
|            | - Personal information (name, sex, citizenship, religion, etc.)                 |          |
| FR-STU-004 | The system shall track student status (Enrolled, Withdrawn, Dropped, Graduated) | High     |
| FR-STU-005 | The system shall maintain student contact information separately                | Medium   |
| FR-STU-006 | The system shall maintain student guardian information separately               | Medium   |
| FR-STU-007 | The system shall maintain student academic history separately                   | Medium   |
| FR-STU-008 | The system shall link students to their original application records            | High     |

### 2.13 Schedule Management Module

| ID           | Requirement                                              | Priority |
| ------------ | -------------------------------------------------------- | -------- |
| FR-SCHED-001 | The system shall allow CRUD operations for schedules     | High     |
| FR-SCHED-002 | The system shall capture schedule details including:     | High     |
|              | - Proctor (staff assignment)                             |          |
|              | - Date                                                   |          |
|              | - Start Time and End Time                                |          |
|              | - Process Type (Interview/Exam)                          |          |
| FR-SCHED-003 | The system shall track schedule status (Active/Inactive) | Medium   |
| FR-SCHED-004 | The system shall associate schedules with admissions     | High     |

### 2.14 Dashboard and Reporting

| ID          | Requirement                                                      | Priority |
| ----------- | ---------------------------------------------------------------- | -------- |
| FR-DASH-001 | The system shall provide dashboard views for each department     | Medium   |
| FR-DASH-002 | The system shall display statistics overview widgets             | Medium   |
| FR-DASH-003 | The system shall provide enrollee charts for trend visualization | Low      |

---

## 3. External Interface Requirements

### 3.1 User Interfaces

#### 3.1.1 General UI Requirements

| ID        | Requirement                                                                                            | Priority |
| --------- | ------------------------------------------------------------------------------------------------------ | -------- |
| EI-UI-001 | The system shall provide a responsive web interface compatible with desktop and mobile browsers        | High     |
| EI-UI-002 | The system shall use a consistent color scheme (Primary: #042042, Secondary: #eaea52, Accent: #4ea1d3) | Medium   |
| EI-UI-003 | The system shall provide intuitive navigation with clear labeling                                      | High     |
| EI-UI-004 | The system shall display appropriate error messages for invalid inputs                                 | High     |
| EI-UI-005 | The system shall provide success/confirmation notifications for completed actions                      | Medium   |
| EI-UI-006 | The system shall support dark mode theming                                                             | Low      |

#### 3.1.2 Login Interface

| ID        | Requirement                                                                                          | Priority |
| --------- | ---------------------------------------------------------------------------------------------------- | -------- |
| EI-UI-007 | The system shall provide separate login pages for each department (Registrar, Accounting, Admission) | High     |
| EI-UI-008 | The system shall display login forms with email and password fields                                  | High     |
| EI-UI-009 | The system shall show appropriate error messages for invalid credentials                             | High     |

#### 3.1.3 Landing Page Interface

| ID        | Requirement                                                                | Priority |
| --------- | -------------------------------------------------------------------------- | -------- |
| EI-UI-010 | The system shall display a landing page with department selection cards    | High     |
| EI-UI-011 | The system shall provide visual icons and descriptions for each department | Medium   |
| EI-UI-012 | The system shall include direct link to application form for applicants    | High     |

#### 3.1.4 Application Form Interface

| ID        | Requirement                                                                                   | Priority |
| --------- | --------------------------------------------------------------------------------------------- | -------- |
| EI-UI-013 | The system shall provide a multi-section application form with clear groupings                | High     |
| EI-UI-014 | The system shall use appropriate input types (text, select, date pickers)                     | High     |
| EI-UI-015 | The system shall provide dynamic field population based on selections (e.g., strands for SHS) | Medium   |
| EI-UI-016 | The system shall display validation errors inline with form fields                            | High     |

#### 3.1.5 Data Management Interfaces

| ID        | Requirement                                                         | Priority |
| --------- | ------------------------------------------------------------------- | -------- |
| EI-UI-017 | The system shall provide tabular data displays with pagination      | High     |
| EI-UI-018 | The system shall support inline search and filtering                | High     |
| EI-UI-019 | The system shall provide modal dialogs for create/edit operations   | High     |
| EI-UI-020 | The system shall display confirmation dialogs for delete operations | High     |
| EI-UI-021 | The system shall support sortable columns in data tables            | Medium   |

#### 3.1.6 Admission Processing Interfaces

| ID        | Requirement                                                                        | Priority |
| --------- | ---------------------------------------------------------------------------------- | -------- |
| EI-UI-022 | The system shall provide separate views for Interview, Exam, and Evaluation stages | High     |
| EI-UI-023 | The system shall display score entry forms in modal dialogs                        | High     |
| EI-UI-024 | The system shall show applicant details during evaluation                          | High     |
| EI-UI-025 | The system shall provide program selection dropdown based on applicant's choices   | High     |

### 3.2 Hardware Interfaces

| ID        | Requirement                                                                   | Priority |
| --------- | ----------------------------------------------------------------------------- | -------- |
| EI-HW-001 | The system shall operate on standard web servers with PHP support             | High     |
| EI-HW-002 | The system shall be accessible via standard web browsers on desktop computers | High     |
| EI-HW-003 | The system shall be accessible via mobile device browsers                     | Medium   |
| EI-HW-004 | No specialized hardware required for end users                                | N/A      |

### 3.3 Software Interfaces

| ID        | Requirement          | Description                           | Priority |
| --------- | -------------------- | ------------------------------------- | -------- |
| EI-SW-001 | **PHP 8.2+**         | Server-side programming language      | High     |
| EI-SW-002 | **Laravel 12.0**     | PHP web application framework         | High     |
| EI-SW-003 | **MySQL/SQLite**     | Relational database management system | High     |
| EI-SW-004 | **Tailwind CSS 4.x** | Utility-first CSS framework           | High     |
| EI-SW-005 | **DaisyUI 5.x**      | Tailwind CSS component library        | Medium   |
| EI-SW-006 | **Vite 7.x**         | Frontend build tool                   | High     |
| EI-SW-007 | **Axios**            | HTTP client for AJAX requests         | Medium   |
| EI-SW-008 | **Blade**            | Laravel templating engine             | High     |
| EI-SW-009 | **Composer**         | PHP dependency manager                | High     |
| EI-SW-010 | **NPM**              | Node.js package manager               | High     |

### 3.4 Communication Interfaces

| ID         | Requirement                                                             | Priority |
| ---------- | ----------------------------------------------------------------------- | -------- |
| EI-COM-001 | The system shall communicate over HTTP/HTTPS protocols                  | High     |
| EI-COM-002 | The system shall use CSRF tokens for form submissions                   | High     |
| EI-COM-003 | The system shall provide RESTful API endpoints for dynamic data loading | Medium   |
| EI-COM-004 | The system shall support AJAX requests for real-time updates            | Medium   |

### 3.5 API Endpoints

| Endpoint                         | Method   | Description                              | Module     |
| -------------------------------- | -------- | ---------------------------------------- | ---------- |
| `/api/levels-by-department/{id}` | GET      | Retrieve levels filtered by department   | Prospectus |
| `/api/prospectuses`              | GET      | Retrieve prospectus entries with filters | Prospectus |
| `/prospectuses/search`           | GET/POST | Search prospectus entries                | Prospectus |
| `/fee/search`                    | GET/POST | Search fee entries                       | Fee        |

---

## 4. Non-Functional Requirements

### 4.1 Performance Requirements

| ID           | Requirement                                                 | Metric      | Priority |
| ------------ | ----------------------------------------------------------- | ----------- | -------- |
| NFR-PERF-001 | Page load time shall not exceed 3 seconds under normal load | < 3 seconds | High     |
| NFR-PERF-002 | Form submissions shall be processed within 2 seconds        | < 2 seconds | High     |
| NFR-PERF-003 | Search results shall be returned within 1 second            | < 1 second  | High     |
| NFR-PERF-004 | The system shall support at least 100 concurrent users      | 100+ users  | Medium   |
| NFR-PERF-005 | Database queries shall be optimized with proper indexing    | N/A         | High     |
| NFR-PERF-006 | Static assets shall be minified and compiled for production | N/A         | Medium   |

### 4.2 Security Requirements

| ID          | Requirement                                                       | Priority |
| ----------- | ----------------------------------------------------------------- | -------- |
| NFR-SEC-001 | All passwords shall be hashed using secure algorithms (bcrypt)    | High     |
| NFR-SEC-002 | The system shall implement CSRF protection on all forms           | High     |
| NFR-SEC-003 | The system shall use prepared statements to prevent SQL injection | High     |
| NFR-SEC-004 | The system shall implement role-based access control (RBAC)       | High     |
| NFR-SEC-005 | Session data shall be securely managed with appropriate timeouts  | High     |
| NFR-SEC-006 | Sensitive data shall not be exposed in URLs or logs               | High     |
| NFR-SEC-007 | The system shall validate and sanitize all user inputs            | High     |
| NFR-SEC-008 | Authentication shall be required for all administrative functions | High     |
| NFR-SEC-009 | The system should support HTTPS deployment                        | Medium   |

### 4.3 Reliability and Availability

| ID          | Requirement                                                     | Metric | Priority |
| ----------- | --------------------------------------------------------------- | ------ | -------- |
| NFR-REL-001 | The system shall maintain 99% uptime during operational hours   | 99%    | High     |
| NFR-REL-002 | The system shall gracefully handle database connection failures | N/A    | High     |
| NFR-REL-003 | The system shall log all errors for debugging purposes          | N/A    | High     |
| NFR-REL-004 | The system shall provide meaningful error messages to users     | N/A    | Medium   |
| NFR-REL-005 | The system shall support database backups                       | Daily  | High     |
| NFR-REL-006 | The system shall recover from failures without data loss        | N/A    | High     |

### 4.4 Scalability Requirements

| ID           | Requirement                                                             | Priority |
| ------------ | ----------------------------------------------------------------------- | -------- |
| NFR-SCAL-001 | The database schema shall support addition of new departments           | High     |
| NFR-SCAL-002 | The system shall accommodate growing numbers of students and applicants | High     |
| NFR-SCAL-003 | The system shall allow addition of new program types                    | High     |
| NFR-SCAL-004 | The codebase shall follow modular architecture for easy extension       | High     |
| NFR-SCAL-005 | The system shall support horizontal scaling through load balancing      | Low      |

### 4.5 Maintainability Requirements

| ID            | Requirement                                                          | Priority |
| ------------- | -------------------------------------------------------------------- | -------- |
| NFR-MAINT-001 | The system shall follow MVC architectural pattern                    | High     |
| NFR-MAINT-002 | Code shall follow PSR-12 coding standards (enforced by Laravel Pint) | High     |
| NFR-MAINT-003 | Database changes shall be managed through migrations                 | High     |
| NFR-MAINT-004 | The system shall use Eloquent ORM for database operations            | High     |
| NFR-MAINT-005 | Frontend assets shall be managed through Vite build system           | High     |
| NFR-MAINT-006 | The system shall include comprehensive inline documentation          | Medium   |
| NFR-MAINT-007 | Configuration shall be externalized through environment variables    | High     |

### 4.6 Usability Requirements

| ID          | Requirement                                                   | Priority |
| ----------- | ------------------------------------------------------------- | -------- |
| NFR-USE-001 | The interface shall be intuitive and require minimal training | High     |
| NFR-USE-002 | Navigation shall be consistent across all modules             | High     |
| NFR-USE-003 | Forms shall provide clear labels and placeholder text         | High     |
| NFR-USE-004 | Error messages shall be clear and actionable                  | High     |
| NFR-USE-005 | The system shall provide visual feedback for user actions     | Medium   |
| NFR-USE-006 | The interface shall support keyboard navigation               | Low      |
| NFR-USE-007 | Color contrast shall meet accessibility guidelines            | Medium   |

### 4.7 Compatibility Requirements

| ID           | Requirement                                                              | Priority |
| ------------ | ------------------------------------------------------------------------ | -------- |
| NFR-COMP-001 | The system shall support modern browsers (Chrome, Firefox, Safari, Edge) | High     |
| NFR-COMP-002 | The system shall be responsive on screen sizes from 320px to 1920px      | High     |
| NFR-COMP-003 | The system shall function on Windows, macOS, and Linux servers           | High     |
| NFR-COMP-004 | The system shall support MySQL 8.0+ and SQLite 3.x databases             | High     |

### 4.8 Data Integrity Requirements

| ID           | Requirement                                                                     | Priority |
| ------------ | ------------------------------------------------------------------------------- | -------- |
| NFR-DATA-001 | The system shall enforce referential integrity through foreign keys             | High     |
| NFR-DATA-002 | The system shall prevent orphaned records through cascade deletions             | High     |
| NFR-DATA-003 | Unique constraints shall be enforced on application numbers and student numbers | High     |
| NFR-DATA-004 | The system shall maintain timestamps for all records (created_at, updated_at)   | High     |
| NFR-DATA-005 | Status fields shall use predefined enumerated values                            | High     |

### 4.9 Compliance Requirements

| ID           | Requirement                                                           | Priority |
| ------------ | --------------------------------------------------------------------- | -------- |
| NFR-COMP-001 | The system shall protect personally identifiable information (PII)    | High     |
| NFR-COMP-002 | Data handling shall comply with educational institution data policies | High     |
| NFR-COMP-003 | The system shall maintain audit trails for critical operations        | Medium   |

### 4.10 Deployment Requirements

| ID          | Requirement                                                            | Priority |
| ----------- | ---------------------------------------------------------------------- | -------- |
| NFR-DEP-001 | The system shall support deployment on shared hosting with PHP support | High     |
| NFR-DEP-002 | The system shall provide setup scripts for initial configuration       | High     |
| NFR-DEP-003 | Database migrations shall be executable via artisan commands           | High     |
| NFR-DEP-004 | Frontend assets shall be pre-compiled for production deployment        | High     |
| NFR-DEP-005 | The system shall support Docker containerization (Laravel Sail)        | Low      |

---

## Appendix A: Data Model Summary

### Entity Relationship Overview

```
Department (1) ──────< (Many) Program
Program (1) ──────< (Many) Curriculum
Program (1) ──────< (Many) Level
Program (1) ──────< (Many) Fee
Department (1) ──────< (Many) AcademicTerm
Curriculum (1) ──────< (Many) Prospectus
Subject (1) ──────< (Many) Prospectus
Level (1) ──────< (Many) Prospectus
AcademicTerm (1) ──────< (Many) Prospectus
Applicant (1) ──────< (One) Admission
Schedule (1) ──────< (Many) Admission (Interview)
Schedule (1) ──────< (Many) Admission (Exam)
Applicant (1) ──────< (One) Student
Student (1) ──────< (One) StudentContact
Student (1) ──────< (One) StudentGuardian
Student (1) ──────< (One) StudentAcademicHistory
Department (1) ──────< (Many) Student
Program (1) ──────< (Many) Student
Level (1) ──────< (Many) Student
```

### Core Entities

| Entity                 | Description                     | Key Attributes                                                                          |
| ---------------------- | ------------------------------- | --------------------------------------------------------------------------------------- |
| User                   | System users for authentication | id, name, email, type, password                                                         |
| Department             | Academic departments            | id, code, description, status                                                           |
| Program                | Academic programs/courses       | id, code, description, status, department_id                                            |
| Curriculum             | Academic curricula              | id, curriculum, status, department_id                                                   |
| Subject                | Academic subjects               | id, code, description, unit, lech, labh, lecu, labu, type, status                       |
| Level                  | Year levels                     | id, code, description, program_id, order                                                |
| AcademicTerm           | Semesters/terms                 | id, code, description, type, department_id, academic_year, start_date, end_date, status |
| Prospectus             | Subject-curriculum mapping      | id, curriculum_id, subject_id, academic_term_id, level_id, status                       |
| Fee                    | Fee structures                  | id, description, amount, type, month_to_pay, group, academic_year, program_id           |
| Applicant              | Student applications            | id, application_no, personal info, contact info, educational background, status         |
| Admission              | Admission records               | id, applicant_id, interview scores, exam scores, final_score, decision, program_id      |
| Schedule               | Interview/Exam schedules        | id, proctor, date, start_time, end_time, status, process                                |
| Student                | Enrolled students               | id, student_number, lrn, department_id, program_id, level_id, personal info, status     |
| StudentContact         | Student contact details         | id, student_id, address, contact numbers, email                                         |
| StudentGuardian        | Guardian information            | id, student_id, mother/father/guardian details                                          |
| StudentAcademicHistory | Educational background          | id, student_id, school history                                                          |

---

## Appendix B: System Architecture

### Technology Stack

| Layer        | Technology                                         |
| ------------ | -------------------------------------------------- |
| Presentation | Blade Templates, Tailwind CSS, DaisyUI, JavaScript |
| Application  | Laravel 12.0 (PHP 8.2+)                            |
| Data Access  | Eloquent ORM                                       |
| Database     | MySQL / SQLite                                     |
| Build Tools  | Vite, NPM, Composer                                |
| Testing      | PHPUnit, Mockery                                   |

### Architectural Pattern

The system follows the **Model-View-Controller (MVC)** architectural pattern:

- **Models:** Eloquent models representing database entities with relationships
- **Views:** Blade templates for HTML rendering with Tailwind CSS styling
- **Controllers:** Handle HTTP requests, business logic, and response generation

---

## Appendix C: Revision History

| Version | Date             | Author           | Description                                     |
| ------- | ---------------- | ---------------- | ----------------------------------------------- |
| 1.0     | January 20, 2026 | System Generated | Initial SRS document based on codebase analysis |

---

_End of Software Requirements Specification Document_
