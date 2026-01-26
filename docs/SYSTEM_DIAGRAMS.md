# Enrollment Management System - Diagrams & Visualization

## Table of Contents

1. [Context Diagram (Level 0)](#1-context-diagram-level-0)
2. [ERD: Registrar Module](#2-erd-registrar-module)
3. [ERD: Accounting Module](#3-erd-accounting-module)
4. [ERD: Admission Module](#4-erd-admission-module)
5. [ERD: Student Module](#5-erd-student-module)
6. [System Architecture Design](#6-system-architecture-design)
7. [Complete Database ERD](#7-complete-database-erd)

---

## 1. Context Diagram (Level 0)

The Context Diagram shows the **Enrollment Management System** as a single process, highlighting all external entities that interact with it and the data flows between them.

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                                   CONTEXT DIAGRAM (Level 0)                              │
│                              Enrollment Management System                                │
└─────────────────────────────────────────────────────────────────────────────────────────┘

                            ┌─────────────────────┐
                            │      APPLICANT      │
                            │  (External Entity)  │
                            └──────────┬──────────┘
                                       │
                    ┌──────────────────┼──────────────────┐
                    │                  │                  │
                    ▼                  │                  │
         ┌──────────────────┐          │         ┌───────────────────┐
         │ Application Form │          │         │ Application Status│
         │ Personal Info    │          │         │ & Confirmation    │
         │ Program Choices  │          │         └───────────────────┘
         │ Educational BG   │          │                  ▲
         └────────┬─────────┘          │                  │
                  │                    │                  │
                  ▼                    ▼                  │
┌──────────────────────────────────────────────────────────────────────────────┐
│                                                                              │
│                      ┌────────────────────────────────┐                      │
│                      │                                │                      │
│    ┌────────────────►│     ENROLLMENT MANAGEMENT      │◄────────────────┐    │
│    │                 │           SYSTEM               │                 │    │
│    │                 │                                │                 │    │
│    │                 │  • Application Processing      │                 │    │
│    │                 │  • Admission Management        │                 │    │
│    │                 │  • Academic Structure Mgmt     │                 │    │
│    │                 │  • Fee Management              │                 │    │
│    │                 │  • Student Records             │                 │    │
│    │                 │  • Schedule Management         │                 │    │
│    │                 │                                │                 │    │
│    │                 └────────────────────────────────┘                 │    │
│    │                     │           │           │                     │    │
└────┼─────────────────────┼───────────┼───────────┼─────────────────────┼────┘
     │                     │           │           │                     │
     │                     ▼           ▼           ▼                     │
     │              ┌─────────┐ ┌─────────┐ ┌─────────┐                  │
     │              │ Reports │ │ Records │ │ Alerts  │                  │
     │              └────┬────┘ └────┬────┘ └────┬────┘                  │
     │                   │           │           │                       │
     │                   ▼           ▼           ▼                       │
┌────┴─────────┐  ┌──────┴─────────────┴───────────┴────────┐  ┌────────┴────────┐
│  REGISTRAR   │  │                 DATABASE                │  │   ACCOUNTING    │
│    STAFF     │  │         (MySQL/PostgreSQL)              │  │     STAFF       │
│              │  │                                         │  │                 │
│ • Dept Mgmt  │  │  ┌─────────┐  ┌─────────┐  ┌─────────┐  │  │ • Fee Config    │
│ • Program    │  │  │ Users   │  │Students │  │Applicant│  │  │ • Payment Sched │
│ • Curriculum │  │  ├─────────┤  ├─────────┤  ├─────────┤  │  │ • Fee Reports   │
│ • Subject    │  │  │ Depts   │  │ Fees    │  │Admission│  │  │                 │
│ • Prospectus │  │  ├─────────┤  ├─────────┤  ├─────────┤  │  └────────┬────────┘
│ • Academic   │  │  │Programs │  │Schedules│  │ Levels  │  │           │
│   Terms      │  │  ├─────────┤  ├─────────┤  ├─────────┤  │           │
│              │  │  │Curricula│  │Subjects │  │Prospectus│ │           │
└──────────────┘  │  └─────────┘  └─────────┘  └─────────┘  │  ┌────────┴────────┐
                  └─────────────────────────────────────────┘  │   ADMISSION     │
                                                              │     STAFF       │
                                                              │                 │
                                                              │ • Interview     │
                                                              │ • Examination   │
                                                              │ • Evaluation    │
                                                              │ • Scheduling    │
                                                              └─────────────────┘
```

### Data Flow Summary

| External Entity      | Data Flow IN (to system)                                                 | Data Flow OUT (from system)                    |
| -------------------- | ------------------------------------------------------------------------ | ---------------------------------------------- |
| **Applicant**        | Application form, Personal info, Program choices, Educational background | Application confirmation, Status updates       |
| **Registrar Staff**  | Academic structure data, Student records, Curriculum updates             | Reports, Student records, Prospectus data      |
| **Admission Staff**  | Interview scores, Exam scores, Evaluation decisions                      | Applicant lists, Schedule information, Results |
| **Accounting Staff** | Fee configurations, Payment schedules                                    | Fee reports, Program fees                      |

---

## 2. ERD: Registrar Module

The Registrar module manages the **academic structure** of the institution including departments, programs, curricula, subjects, levels, academic terms, and prospectuses.

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                           ERD: REGISTRAR MODULE                                          │
│                    (Academic Structure Management)                                       │
└─────────────────────────────────────────────────────────────────────────────────────────┘

┌───────────────────────┐         1:N         ┌───────────────────────┐
│      DEPARTMENT       │─────────────────────│        PROGRAM        │
├───────────────────────┤                     ├───────────────────────┤
│ PK  id                │                     │ PK  id                │
│     code              │                     │ FK  department_id     │
│     description       │                     │     code              │
│     status            │                     │     description       │
│     created_at        │                     │     status            │
│     updated_at        │                     │     created_at        │
└───────────────────────┘                     │     updated_at        │
           │                                  └───────────┬───────────┘
           │ 1:N                                          │
           │                                              │ 1:N
           ▼                                              ▼
┌───────────────────────┐                     ┌───────────────────────┐
│     ACADEMIC_TERM     │                     │        LEVEL          │
├───────────────────────┤                     ├───────────────────────┤
│ PK  id                │                     │ PK  id                │
│ FK  department_id     │                     │ FK  program_id        │
│     code              │                     │     code              │
│     description       │                     │     description       │
│     type              │                     │     order             │
│     academic_year     │                     │     created_at        │
│     start_date        │                     │     updated_at        │
│     end_date          │                     └───────────┬───────────┘
│     status            │                                 │
│     created_at        │                                 │
│     updated_at        │                                 │
└───────────┬───────────┘                                 │
            │                                             │
            │                                             │
            │              ┌───────────────────────┐      │
            │              │      CURRICULUM       │      │
            │              ├───────────────────────┤      │
            │              │ PK  id                │      │
            └──────────────│ FK  department_id     │      │
                    1:N    │     curriculum (name) │      │
                           │     status            │      │
                           │     created_at        │      │
                           │     updated_at        │      │
                           └───────────┬───────────┘      │
                                       │                  │
                                       │ 1:N              │ 1:N
                                       │                  │
                                       ▼                  │
                           ┌───────────────────────────┐  │
                           │       PROSPECTUS          │◄─┘
                           │    (Junction Table)       │
                           ├───────────────────────────┤
                           │ PK  id                    │
                           │ FK  curriculum_id         │──────────┐
                           │ FK  subject_id            │────┐     │
                           │ FK  academic_term_id      │    │     │
                           │ FK  level_id              │    │     │
                           │     status                │    │     │
                           │     created_at            │    │     │
                           │     updated_at            │    │     │
                           └───────────────────────────┘    │     │
                                       ▲                    │     │
                                       │                    │     │
                                       │ N:1                │     │
                                       │                    │     │
                           ┌───────────┴───────────┐        │     │
                           │        SUBJECT        │◄───────┘     │
                           ├───────────────────────┤              │
                           │ PK  id                │              │
                           │     code              │              │
                           │     description       │              │
                           │     unit              │              │
                           │     lech (lecture hrs)│              │
                           │     labh (lab hours)  │              │
                           │     lecu (lec units)  │              │
                           │     labu (lab units)  │              │
                           │     type              │              │
                           │     status            │              │
                           │     created_at        │              │
                           │     updated_at        │              │
                           └───────────────────────┘              │
                                                                  │
                                       Links back to CURRICULUM ──┘
```

### Registrar Module Entity Descriptions

| Entity            | Description                                            | Key Relationships                                                |
| ----------------- | ------------------------------------------------------ | ---------------------------------------------------------------- |
| **Department**    | Academic divisions (e.g., College of Computer Studies) | Has many Programs, Curricula, Academic Terms                     |
| **Program**       | Degree courses (e.g., BSIT, BSCS)                      | Belongs to Department; Has many Levels                           |
| **Curriculum**    | Version-controlled academic plan                       | Belongs to Department; Has many Prospectus entries               |
| **Subject**       | Individual course offerings                            | Has many Prospectus entries                                      |
| **Level**         | Year/Grade levels within a program                     | Belongs to Program; Has many Prospectus entries                  |
| **Academic Term** | Semesters/Trimesters configuration                     | Belongs to Department; Has many Prospectus entries               |
| **Prospectus**    | Maps subjects to curriculum-term-level combinations    | Junction table linking Curriculum, Subject, Academic Term, Level |

---

## 3. ERD: Accounting Module

The Accounting module manages **fee structures** and payment configurations per program.

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                           ERD: ACCOUNTING MODULE                                         │
│                        (Fee Management System)                                           │
└─────────────────────────────────────────────────────────────────────────────────────────┘

┌───────────────────────┐                     ┌───────────────────────────────┐
│      DEPARTMENT       │         1:N         │           PROGRAM             │
├───────────────────────┤─────────────────────├───────────────────────────────┤
│ PK  id                │                     │ PK  id                        │
│     code              │                     │ FK  department_id             │
│     description       │                     │     code                      │
│     status            │                     │     description               │
└───────────────────────┘                     │     status                    │
                                              └───────────────┬───────────────┘
                                                              │
                                                              │ 1:N
                                                              │
                                                              ▼
                                              ┌───────────────────────────────┐
                                              │             FEE               │
                                              ├───────────────────────────────┤
                                              │ PK  id                        │
                                              │ FK  program_id                │
                                              │     description               │
                                              │     amount (decimal 10,2)     │
                                              │     type                      │
                                              │     month_to_pay              │
                                              │     group                     │
                                              │     academic_year             │
                                              │     created_at                │
                                              │     updated_at                │
                                              └───────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                              FEE ATTRIBUTES BREAKDOWN                                    │
└─────────────────────────────────────────────────────────────────────────────────────────┘

    ┌─────────────────────┬─────────────────────────────────────────────────────────┐
    │    Attribute        │    Description & Sample Values                          │
    ├─────────────────────┼─────────────────────────────────────────────────────────┤
    │    description      │    Fee name (e.g., "Tuition Fee", "Lab Fee", "ID Fee")  │
    │    amount           │    Monetary value in decimal (e.g., 5000.00)            │
    │    type             │    Category: "Tuition", "Miscellaneous", "Lab"          │
    │    month_to_pay     │    Installment number (1-10) for payment schedule       │
    │    group            │    Fee grouping (e.g., "Upon Enrollment", "Monthly")    │
    │    academic_year    │    Year reference (e.g., "2025-2026")                   │
    └─────────────────────┴─────────────────────────────────────────────────────────┘
```

### Accounting Module Data Flow

```
                              ┌─────────────────────┐
                              │   Accounting Staff   │
                              └──────────┬──────────┘
                                         │
                    ┌────────────────────┼────────────────────┐
                    │                    │                    │
                    ▼                    ▼                    ▼
           ┌────────────────┐   ┌────────────────┐   ┌────────────────┐
           │ Configure Fees │   │ Set Payment    │   │ Generate Fee   │
           │ by Program     │   │ Schedule       │   │ Reports        │
           └────────┬───────┘   └────────┬───────┘   └────────┬───────┘
                    │                    │                    │
                    └────────────────────┼────────────────────┘
                                         │
                                         ▼
                              ┌─────────────────────┐
                              │    FEES TABLE       │
                              │  (by Program &      │
                              │   Academic Year)    │
                              └─────────────────────┘
```

---

## 4. ERD: Admission Module

The Admission module handles the **applicant lifecycle** from application submission through evaluation.

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                           ERD: ADMISSION MODULE                                          │
│                    (Applicant Processing Workflow)                                       │
└─────────────────────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                                  APPLICANT                                               │
├─────────────────────────────────────────────────────────────────────────────────────────┤
│  PK  id                                                                                 │
│      application_no (unique, auto-generated)                                            │
│  ┌──────────────────────────┬──────────────────────────┬──────────────────────────┐     │
│  │   ADMISSION INFO         │   PERSONAL INFO          │   CONTACT INFO           │     │
│  ├──────────────────────────┼──────────────────────────┼──────────────────────────┤     │
│  │  level                   │  last_name               │  present_address         │     │
│  │  student_type            │  first_name              │  zip_code                │     │
│  │  year_level              │  middle_name             │  permanent_address       │     │
│  │  strand                  │  sex                     │  telephone_number        │     │
│  │  first_program_choice    │  citizenship             │  mobile_number           │     │
│  │  second_program_choice   │  religion                │  email                   │     │
│  │  third_program_choice    │  birthdate               │                          │     │
│  │  lrn                     │  place_of_birth          │                          │     │
│  │  status                  │  civil_status            │                          │     │
│  └──────────────────────────┴──────────────────────────┴──────────────────────────┘     │
│  ┌──────────────────────────────────────────────┬────────────────────────────────────┐  │
│  │   PARENT/GUARDIAN INFO                       │   EDUCATIONAL BACKGROUND           │  │
│  ├──────────────────────────────────────────────┼────────────────────────────────────┤  │
│  │  mother_name, mother_occupation              │  elementary_school_name/address    │  │
│  │  mother_contact_number, mother_monthly_income│  elementary_inclusive_years        │  │
│  │  father_name, father_occupation              │  junior_school_name/address        │  │
│  │  father_contact_number, father_monthly_income│  junior_inclusive_years            │  │
│  │  guardian_name, guardian_occupation          │  senior_school_name/address        │  │
│  │  guardian_contact_number, guardian_income    │  senior_inclusive_years            │  │
│  │                                              │  college_school_name/address       │  │
│  │                                              │  college_inclusive_years           │  │
│  └──────────────────────────────────────────────┴────────────────────────────────────┘  │
│      created_at, updated_at                                                             │
└─────────────────────────────────────────────────────────────────────────────────────────┘
                    │
                    │ 1:1
                    ▼
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                                  ADMISSION                                               │
├─────────────────────────────────────────────────────────────────────────────────────────┤
│  PK  id                                                                                 │
│  FK  applicant_id                                                                       │
│  ┌──────────────────────────┬──────────────────────────┬──────────────────────────┐     │
│  │   INTERVIEW DATA         │   EXAMINATION DATA       │   EVALUATION DATA        │     │
│  ├──────────────────────────┼──────────────────────────┼──────────────────────────┤     │
│  │  FK interview_schedule_id│  FK exam_schedule_id     │  final_score             │     │
│  │  interview_score         │  math_score              │  decision                │     │
│  │  interview_remark        │  science_score           │  FK program_id           │     │
│  │  interview_result        │  english_score           │  evaluated_by            │     │
│  │                          │  filipino_score          │  evaluated_at            │     │
│  │                          │  abstract_score          │                          │     │
│  │                          │  exam_score (total)      │                          │     │
│  │                          │  exam_result             │                          │     │
│  └──────────────────────────┴──────────────────────────┴──────────────────────────┘     │
│      created_at, updated_at                                                             │
└─────────────────────────────────────────────────────────────────────────────────────────┘
         │                              │
         │ N:1                          │ N:1
         ▼                              ▼
┌───────────────────────┐    ┌───────────────────────┐
│       SCHEDULE        │    │       PROGRAM         │
│   (Interview/Exam)    │    │  (Final Assignment)   │
├───────────────────────┤    ├───────────────────────┤
│ PK  id                │    │ PK  id                │
│     proctor           │    │ FK  department_id     │
│     date              │    │     code              │
│     start_time        │    │     description       │
│     end_time          │    │     status            │
│     status            │    └───────────────────────┘
│     process (type)    │
└───────────────────────┘
```

### Admission Workflow State Machine

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                         ADMISSION STATUS WORKFLOW                                        │
└─────────────────────────────────────────────────────────────────────────────────────────┘

    ┌─────────────┐      Schedule        ┌─────────────┐      Record       ┌─────────────┐
    │   PENDING   │─────Interview───────►│ INTERVIEWED │────Results───────►│  EXAMINED   │
    │ (New App)   │                      │             │                   │             │
    └─────────────┘                      └──────┬──────┘                   └──────┬──────┘
           │                                    │                                 │
           │                                    │ Failed                          │ Failed
           │                                    ▼                                 ▼
           │                            ┌─────────────┐                   ┌─────────────┐
           │                            │  REJECTED   │                   │  REJECTED   │
           │                            │ (Interview) │                   │   (Exam)    │
           │                            └─────────────┘                   └─────────────┘
           │                                                                     │
           │                                                               Passed│
           │                                                                     ▼
           │                                                          ┌─────────────────┐
           │                                                          │   EVALUATION    │
           │                                                          │    PENDING      │
           │                                                          └────────┬────────┘
           │                                                                   │
           │                                    ┌───────────────────────────────┤
           │                                    │                               │
           │                                    ▼                               ▼
           │                            ┌─────────────┐                 ┌─────────────┐
           └───────────────────────────►│  ACCEPTED   │                 │  REJECTED   │
                                        │ (Enrolled)  │                 │  (Final)    │
                                        └─────────────┘                 └─────────────┘
                                               │
                                               │ Creates
                                               ▼
                                        ┌─────────────┐
                                        │   STUDENT   │
                                        │   RECORD    │
                                        └─────────────┘
```

---

## 5. ERD: Student Module

The Student module manages **enrolled student records** with related contact, guardian, and academic history information.

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                           ERD: STUDENT MODULE                                            │
│                    (Student Records Management)                                          │
└─────────────────────────────────────────────────────────────────────────────────────────┘

                              ┌───────────────────────────────────────────┐
                              │               APPLICANT                   │
                              │          (Source Record)                  │
                              ├───────────────────────────────────────────┤
                              │ PK  id                                    │
                              │     application_no                        │
                              │     ... (see Admission ERD)               │
                              └─────────────────────┬─────────────────────┘
                                                    │
                                                    │ 1:1
                                                    ▼
┌──────────────────────────────────────────────────────────────────────────────────────────┐
│                                     STUDENT                                               │
├──────────────────────────────────────────────────────────────────────────────────────────┤
│  PK  id                                                                                  │
│      student_number (unique, auto-generated)                                             │
│  FK  application_id (links to Applicant)                                                 │
│  FK  department_id                                                                       │
│  FK  program_id                                                                          │
│  FK  level_id                                                                            │
│  ┌──────────────────────────────────────────────────────────────────────────────────┐    │
│  │   PERSONAL INFORMATION                                                           │    │
│  ├──────────────────────────────────────────────────────────────────────────────────┤    │
│  │  lrn                 │  first_name        │  citizenship      │  civil_status    │    │
│  │  last_name           │  middle_name       │  religion         │  status          │    │
│  │  sex                 │  birthdate         │  place_of_birth   │                  │    │
│  └──────────────────────────────────────────────────────────────────────────────────┘    │
│      created_at, updated_at                                                              │
└───────────────────────────────────────────────────┬──────────────────────────────────────┘
                    │                               │                    │
                    │ N:1                           │ 1:1                │ 1:1
                    │                               │                    │
    ┌───────────────┴───────────────┐               │                    │
    │                               │               │                    │
    ▼                               ▼               ▼                    ▼
┌───────────────┐  ┌───────────────┐  ┌─────────────────────────┐  ┌─────────────────────────┐
│  DEPARTMENT   │  │    PROGRAM    │  │    STUDENT_CONTACT      │  │   STUDENT_GUARDIAN      │
├───────────────┤  ├───────────────┤  ├─────────────────────────┤  ├─────────────────────────┤
│ PK id         │  │ PK id         │  │ PK  id                  │  │ PK  id                  │
│    code       │  │ FK dept_id    │  │ FK  student_id          │  │ FK  student_id          │
│    description│  │    code       │  │     zip_code            │  │     mother_name         │
│    status     │  │    description│  │     present_address     │  │     mother_occupation   │
└───────────────┘  │    status     │  │     permanent_address   │  │     mother_contact      │
                   └───────────────┘  │     telephone_number    │  │     mother_income       │
                          │           │     mobile_number       │  │     father_name         │
                          │ N:1       │     email               │  │     father_occupation   │
                          ▼           └─────────────────────────┘  │     father_contact      │
                   ┌───────────────┐                               │     father_income       │
                   │     LEVEL     │                               │     guardian_name       │
                   ├───────────────┤                               │     guardian_occupation │
                   │ PK id         │                               │     guardian_contact    │
                   │ FK program_id │                               │     guardian_income     │
                   │    code       │                               └─────────────────────────┘
                   │    description│
                   │    order      │              ┌───────────────────────────────────────────┐
                   └───────────────┘              │    STUDENT_ACADEMIC_HISTORY               │
                                                 ├───────────────────────────────────────────┤
                                                 │ PK  id                                    │
                                                 │ FK  student_id                            │
                                                 │     elementary_school_name                │
                                                 │     elementary_school_address             │
                                                 │     elementary_inclusive_years            │
                                                 │     junior_school_name                    │
                                                 │     junior_school_address                 │
                                                 │     junior_inclusive_years                │
                                                 │     senior_school_name                    │
                                                 │     senior_school_address                 │
                                                 │     senior_inclusive_years                │
                                                 │     college_school_name                   │
                                                 │     college_school_address                │
                                                 │     college_inclusive_years               │
                                                 └───────────────────────────────────────────┘
```

### Student Status Lifecycle

```
    ┌─────────────┐         ┌─────────────┐         ┌─────────────┐
    │   ENROLLED  │────────►│  WITHDRAWN  │         │   DROPPED   │
    │   (Active)  │         │             │         │             │
    └──────┬──────┘         └─────────────┘         └─────────────┘
           │                       ▲                       ▲
           │                       │                       │
           │                       └───────────┬───────────┘
           │                                   │
           │                            Student Action
           │
           │ Completed Program
           ▼
    ┌─────────────┐
    │  GRADUATED  │
    │             │
    └─────────────┘
```

---

## 6. System Architecture Design

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                        SYSTEM ARCHITECTURE DESIGN                                        │
│                    Enrollment Management System                                          │
└─────────────────────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                              PRESENTATION LAYER                                          │
├─────────────────────────────────────────────────────────────────────────────────────────┤
│                                                                                         │
│   ┌───────────────────────┐  ┌───────────────────────┐  ┌───────────────────────┐      │
│   │    PUBLIC PORTAL      │  │   FILAMENT ADMIN      │  │    BLADE TEMPLATES    │      │
│   │  (Application Form)   │  │      PANELS           │  │    (Custom Views)     │      │
│   ├───────────────────────┤  ├───────────────────────┤  ├───────────────────────┤      │
│   │ • applicant.blade.php │  │ • Registrar Panel     │  │ • Layouts             │      │
│   │ • Form validation     │  │ • Auto-discovered     │  │ • Components          │      │
│   │ • Program selection   │  │   Resources           │  │ • Partials            │      │
│   │ • Multi-step form     │  │ • Dashboard Widgets   │  │                       │      │
│   └───────────────────────┘  └───────────────────────┘  └───────────────────────┘      │
│                                                                                         │
│   ┌─────────────────────────────────────────────────────────────────────────────────┐   │
│   │                         TAILWIND CSS + CUSTOM THEME                              │   │
│   │   resources/css/filament/registrar/theme.css                                    │   │
│   │   Colors: Primary #042042 | Secondary #eaea52 | Accent #4ea1d3                  │   │
│   └─────────────────────────────────────────────────────────────────────────────────┘   │
│                                                                                         │
└─────────────────────────────────────────────────────────────────────────────────────────┘
                                         │
                                         │ HTTP Requests
                                         ▼
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                              APPLICATION LAYER                                           │
├─────────────────────────────────────────────────────────────────────────────────────────┤
│                                                                                         │
│   ┌────────────────────────────────────────────────────────────────────────┐            │
│   │                        LARAVEL 12 FRAMEWORK                            │            │
│   ├────────────────────────────────────────────────────────────────────────┤            │
│   │                                                                        │            │
│   │  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐        │            │
│   │  │    ROUTING      │  │   MIDDLEWARE    │  │  CONTROLLERS    │        │            │
│   │  │   routes/web.php│  │ • Auth          │  │ • Web routes    │        │            │
│   │  │                 │  │ • Guest         │  │ • API endpoints │        │            │
│   │  └─────────────────┘  └─────────────────┘  └─────────────────┘        │            │
│   │                                                                        │            │
│   └────────────────────────────────────────────────────────────────────────┘            │
│                                                                                         │
│   ┌────────────────────────────────────────────────────────────────────────┐            │
│   │                        FILAMENT 4 FRAMEWORK                            │            │
│   ├────────────────────────────────────────────────────────────────────────┤            │
│   │                                                                        │            │
│   │  ┌─────────────────────────────────────────────────────────────────┐   │            │
│   │  │                     FILAMENT RESOURCES                          │   │            │
│   │  │  (Auto-discovered in app/Filament/Resources/)                   │   │            │
│   │  ├─────────────────────────────────────────────────────────────────┤   │            │
│   │  │                                                                 │   │            │
│   │  │  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐ ┌───────────┐  │   │            │
│   │  │  │ Department  │ │  Program    │ │ Curriculum  │ │  Subject  │  │   │            │
│   │  │  │  Resource   │ │  Resource   │ │  Resource   │ │  Resource │  │   │            │
│   │  │  └─────────────┘ └─────────────┘ └─────────────┘ └───────────┘  │   │            │
│   │  │  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐ ┌───────────┐  │   │            │
│   │  │  │ Prospectus  │ │    Fee      │ │  Applicant  │ │ Admission │  │   │            │
│   │  │  │  Resource   │ │  Resource   │ │  Resource   │ │  Resource │  │   │            │
│   │  │  └─────────────┘ └─────────────┘ └─────────────┘ └───────────┘  │   │            │
│   │  │  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐                │   │            │
│   │  │  │  Student    │ │  Schedule   │ │   Level     │                │   │            │
│   │  │  │  Resource   │ │  Resource   │ │  Resource   │                │   │            │
│   │  │  └─────────────┘ └─────────────┘ └─────────────┘                │   │            │
│   │  │                                                                 │   │            │
│   │  └─────────────────────────────────────────────────────────────────┘   │            │
│   │                                                                        │            │
│   │  ┌─────────────────────────────────────────────────────────────────┐   │            │
│   │  │                    DASHBOARD WIDGETS                            │   │            │
│   │  │         (Auto-discovered in app/Filament/Widgets/)              │   │            │
│   │  ├─────────────────────────────────────────────────────────────────┤   │            │
│   │  │  ┌─────────────────────┐  ┌─────────────────────────────────┐   │   │            │
│   │  │  │   StatsOverview     │  │      EnrolleesChart             │   │   │            │
│   │  │  │   Widget            │  │      Widget                     │   │   │            │
│   │  │  └─────────────────────┘  └─────────────────────────────────┘   │   │            │
│   │  └─────────────────────────────────────────────────────────────────┘   │            │
│   │                                                                        │            │
│   └────────────────────────────────────────────────────────────────────────┘            │
│                                                                                         │
└─────────────────────────────────────────────────────────────────────────────────────────┘
                                         │
                                         │ Eloquent ORM
                                         ▼
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                                DATA LAYER                                                │
├─────────────────────────────────────────────────────────────────────────────────────────┤
│                                                                                         │
│   ┌─────────────────────────────────────────────────────────────────────────────────┐   │
│   │                          ELOQUENT MODELS                                         │   │
│   │                         app/Models/*.php                                         │   │
│   ├─────────────────────────────────────────────────────────────────────────────────┤   │
│   │                                                                                 │   │
│   │  ┌────────────────────────────────────────────────────────────────────────┐     │   │
│   │  │              REGISTRAR MODELS                 ADMISSION MODELS         │     │   │
│   │  │  ┌─────────┐ ┌─────────┐ ┌────────────┐  ┌───────────┐ ┌───────────┐  │     │   │
│   │  │  │Department│ │ Program │ │ Curriculum │  │ Applicant │ │ Admission │  │     │   │
│   │  │  └─────────┘ └─────────┘ └────────────┘  └───────────┘ └───────────┘  │     │   │
│   │  │  ┌─────────┐ ┌─────────┐ ┌────────────┐  ┌───────────┐                │     │   │
│   │  │  │ Subject │ │  Level  │ │ Prospectus │  │ Schedule  │                │     │   │
│   │  │  └─────────┘ └─────────┘ └────────────┘  └───────────┘                │     │   │
│   │  │  ┌────────────────┐                                                   │     │   │
│   │  │  │  AcademicTerm  │                                                   │     │   │
│   │  │  └────────────────┘                                                   │     │   │
│   │  └────────────────────────────────────────────────────────────────────────┘     │   │
│   │                                                                                 │   │
│   │  ┌────────────────────────────────────────────────────────────────────────┐     │   │
│   │  │              ACCOUNTING MODEL                 STUDENT MODELS           │     │   │
│   │  │  ┌─────────┐                         ┌───────────┐ ┌─────────────────┐ │     │   │
│   │  │  │   Fee   │                         │  Student  │ │ StudentContact  │ │     │   │
│   │  │  └─────────┘                         └───────────┘ └─────────────────┘ │     │   │
│   │  │                                      ┌─────────────────┐ ┌───────────────────┐   │
│   │  │                                      │ StudentGuardian │ │StudentAcademicHist│   │
│   │  │                                      └─────────────────┘ └───────────────────┘   │
│   │  └────────────────────────────────────────────────────────────────────────┘     │   │
│   │                                                                                 │   │
│   └─────────────────────────────────────────────────────────────────────────────────┘   │
│                                                                                         │
│   ┌─────────────────────────────────────────────────────────────────────────────────┐   │
│   │                          DATABASE (MySQL)                                        │   │
│   │                     Managed via Laravel Migrations                               │   │
│   ├─────────────────────────────────────────────────────────────────────────────────┤   │
│   │   database/migrations/                                                          │   │
│   │                                                                                 │   │
│   │   ┌────────────────────────────────────────────────────────────────────────┐    │   │
│   │   │  TABLES                                                                │    │   │
│   │   │  • users                • programs             • applicants            │    │   │
│   │   │  • departments          • curricula            • admissions            │    │   │
│   │   │  • subjects             • levels               • schedules             │    │   │
│   │   │  • academic_terms       • prospectuses         • fees                  │    │   │
│   │   │  • students             • student_contacts     • student_guardians     │    │   │
│   │   │  • student_academic_histories                                          │    │   │
│   │   └────────────────────────────────────────────────────────────────────────┘    │   │
│   │                                                                                 │   │
│   └─────────────────────────────────────────────────────────────────────────────────┘   │
│                                                                                         │
└─────────────────────────────────────────────────────────────────────────────────────────┘
```

### Component Communication Flow

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                        COMPONENT COMMUNICATION FLOW                                      │
└─────────────────────────────────────────────────────────────────────────────────────────┘

                           PUBLIC APPLICATION FORM
                                    │
                                    │ POST /applicant
                                    ▼
┌───────────────────┐      ┌───────────────────┐      ┌───────────────────┐
│   Web Routes      │─────►│    Controller     │─────►│    Applicant      │
│   routes/web.php  │      │  (Store Logic)    │      │    Model          │
└───────────────────┘      └───────────────────┘      └─────────┬─────────┘
                                                                │
                                                                │ Eloquent
                                                                ▼
                                                      ┌───────────────────┐
                                                      │   applicants      │
                                                      │     TABLE         │
                                                      └───────────────────┘

                              ADMIN PANEL FLOW
                                    │
                                    │ HTTP Request
                                    ▼
┌───────────────────┐      ┌───────────────────┐      ┌───────────────────┐
│ Filament Routes   │─────►│ Filament Resource │─────►│   Eloquent Model  │
│  /registrar/*     │      │   (CRUD Logic)    │      │                   │
└───────────────────┘      └─────────┬─────────┘      └─────────┬─────────┘
                                     │                          │
                                     ▼                          ▼
                           ┌───────────────────┐      ┌───────────────────┐
                           │   Form Schema     │      │   Database Table  │
                           │   Table Columns   │      │                   │
                           │   Actions/Filters │      └───────────────────┘
                           └───────────────────┘
```

### Technology Stack Summary

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                            TECHNOLOGY STACK                                              │
├─────────────────────────────────────────────────────────────────────────────────────────┤
│                                                                                         │
│  ┌─────────────────────────┐    ┌─────────────────────────┐    ┌────────────────────┐   │
│  │       BACKEND           │    │       FRONTEND          │    │     DATABASE       │   │
│  ├─────────────────────────┤    ├─────────────────────────┤    ├────────────────────┤   │
│  │ • Laravel 12            │    │ • Blade Templates       │    │ • MySQL            │   │
│  │ • PHP 8.2+              │    │ • Tailwind CSS 4.x      │    │ • Laravel          │   │
│  │ • Filament 4.0          │    │ • Alpine.js (Filament)  │    │   Migrations       │   │
│  │ • Eloquent ORM          │    │ • Livewire (Filament)   │    │ • Eloquent ORM     │   │
│  │ • Service Providers     │    │ • Vite 7.x              │    │                    │   │
│  └─────────────────────────┘    └─────────────────────────┘    └────────────────────┘   │
│                                                                                         │
│  ┌─────────────────────────┐    ┌─────────────────────────┐    ┌────────────────────┐   │
│  │    AUTHENTICATION       │    │      BUILD TOOLS        │    │     TESTING        │   │
│  ├─────────────────────────┤    ├─────────────────────────┤    ├────────────────────┤   │
│  │ • Filament Auth         │    │ • Vite                  │    │ • PHPUnit 11.x     │   │
│  │ • Laravel Auth          │    │ • @tailwindcss/vite     │    │ • Mockery          │   │
│  │ • Role-Based Access     │    │ • NPM                   │    │ • FakerPHP         │   │
│  │   (user.type field)     │    │ • Composer              │    │                    │   │
│  └─────────────────────────┘    └─────────────────────────┘    └────────────────────┘   │
│                                                                                         │
└─────────────────────────────────────────────────────────────────────────────────────────┘
```

---

## 7. Complete Database ERD

### Full Entity Relationship Diagram

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                            COMPLETE DATABASE ERD                                         │
│                    Enrollment Management System                                          │
└─────────────────────────────────────────────────────────────────────────────────────────┘


    ┌─────────────────────────────────────────────────────────────────────────────────┐
    │                           AUTHENTICATION                                         │
    │   ┌───────────────────┐                                                         │
    │   │       USER        │                                                         │
    │   ├───────────────────┤                                                         │
    │   │ PK id             │                                                         │
    │   │    name           │                                                         │
    │   │    email (unique) │   type: "registrar" | "accounting" | "admission"        │
    │   │    type           │◄──────────────────────────────────────────────────────  │
    │   │    password       │                                                         │
    │   │    remember_token │                                                         │
    │   └───────────────────┘                                                         │
    └─────────────────────────────────────────────────────────────────────────────────┘


    ┌─────────────────────────────────────────────────────────────────────────────────┐
    │                        ACADEMIC STRUCTURE (REGISTRAR)                            │
    │                                                                                 │
    │   ┌───────────────┐        1:N        ┌───────────────┐                        │
    │   │  DEPARTMENT   │──────────────────►│    PROGRAM    │                        │
    │   ├───────────────┤                   ├───────────────┤                        │
    │   │ PK id         │                   │ PK id         │                        │
    │   │    code       │                   │ FK dept_id    │                        │
    │   │    description│                   │    code       │                        │
    │   │    status     │                   │    description│                        │
    │   └───────┬───────┘                   │    status     │                        │
    │           │                           └───────┬───────┘                        │
    │           │ 1:N                               │                                │
    │           │                                   │ 1:N                            │
    │           ▼                                   ▼                                │
    │   ┌───────────────┐               ┌───────────────┐        ┌───────────────┐  │
    │   │ ACADEMIC_TERM │               │     LEVEL     │        │      FEE      │  │
    │   ├───────────────┤               ├───────────────┤        ├───────────────┤  │
    │   │ PK id         │               │ PK id         │        │ PK id         │  │
    │   │ FK dept_id    │               │ FK program_id │        │ FK program_id │  │
    │   │    code       │               │    code       │        │    description│  │
    │   │    description│               │    description│        │    amount     │  │
    │   │    type       │               │    order      │        │    type       │  │
    │   │    acad_year  │               └───────┬───────┘        │    month_to_pay│ │
    │   │    start_date │                       │                │    group      │  │
    │   │    end_date   │                       │ 1:N            │    acad_year  │  │
    │   │    status     │                       │                └───────────────┘  │
    │   └───────┬───────┘                       │                                   │
    │           │                               │                                   │
    │           │ 1:N                           │                                   │
    │           │       ┌───────────────┐       │                                   │
    │           │       │  CURRICULUM   │       │                                   │
    │           │       ├───────────────┤       │                                   │
    │           │       │ PK id         │       │                                   │
    │           │       │ FK dept_id    │◄──────┼───── 1:N from DEPARTMENT          │
    │           │       │    curriculum │       │                                   │
    │           │       │    status     │       │                                   │
    │           │       └───────┬───────┘       │                                   │
    │           │               │               │                                   │
    │           │               │ 1:N           │                                   │
    │           │               │               │                                   │
    │           │               ▼               │                                   │
    │           │       ┌───────────────────────┴───────┐                           │
    │           └──────►│         PROSPECTUS            │◄──────────────────────────│
    │                   │      (Junction Table)         │                           │
    │                   ├───────────────────────────────┤                           │
    │                   │ PK id                         │                           │
    │                   │ FK curriculum_id              │                           │
    │                   │ FK subject_id ────────────────┼───────────────────────┐   │
    │                   │ FK academic_term_id           │                       │   │
    │                   │ FK level_id                   │                       │   │
    │                   │    status                     │                       │   │
    │                   └───────────────────────────────┘                       │   │
    │                                                                           │   │
    │                                   ┌───────────────┐                       │   │
    │                                   │    SUBJECT    │◄──────────────────────┘   │
    │                                   ├───────────────┤                           │
    │                                   │ PK id         │                           │
    │                                   │    code       │                           │
    │                                   │    description│                           │
    │                                   │    unit       │                           │
    │                                   │    lech, labh │                           │
    │                                   │    lecu, labu │                           │
    │                                   │    type       │                           │
    │                                   │    status     │                           │
    │                                   └───────────────┘                           │
    │                                                                               │
    └───────────────────────────────────────────────────────────────────────────────┘


    ┌─────────────────────────────────────────────────────────────────────────────────┐
    │                          ADMISSION WORKFLOW                                      │
    │                                                                                 │
    │   ┌───────────────────────────────────────────────────────────────────┐         │
    │   │                        APPLICANT                                  │         │
    │   ├───────────────────────────────────────────────────────────────────┤         │
    │   │ PK id                      │ application_no (unique)              │         │
    │   │ level, student_type        │ year_level, strand                   │         │
    │   │ first/second/third_program_choice                                 │         │
    │   │ Personal: last/first/middle_name, sex, citizenship, religion...  │         │
    │   │ Contact: present_address, zip, email, mobile, telephone...       │         │
    │   │ Parents: mother/father/guardian info...                          │         │
    │   │ Education: elementary/junior/senior/college school info...       │         │
    │   │ lrn, status                                                       │         │
    │   └───────────────────────────────────┬───────────────────────────────┘         │
    │                                       │                                         │
    │                                       │ 1:1                                     │
    │                                       ▼                                         │
    │   ┌───────────────────────────────────────────────────────────────────┐         │
    │   │                        ADMISSION                                  │         │
    │   ├───────────────────────────────────────────────────────────────────┤         │
    │   │ PK id                                                             │         │
    │   │ FK applicant_id                                                   │         │
    │   │ FK interview_schedule_id ─────────────────────────────────────────┼──┐      │
    │   │ interview_score, interview_remark, interview_result              │  │      │
    │   │ FK exam_schedule_id ──────────────────────────────────────────────┼──┤      │
    │   │ math_score, science_score, english_score, filipino_score,        │  │      │
    │   │ abstract_score, exam_score, exam_result                          │  │      │
    │   │ final_score, decision                                             │  │      │
    │   │ FK program_id (assigned program) ─────────────────────────────────┼──┼──┐   │
    │   │ evaluated_by, evaluated_at                                        │  │  │   │
    │   └───────────────────────────────────────────────────────────────────┘  │  │   │
    │                                                                          │  │   │
    │   ┌───────────────┐                                                      │  │   │
    │   │   SCHEDULE    │◄─────────────────────────────────────────────────────┘  │   │
    │   ├───────────────┤                                                         │   │
    │   │ PK id         │                                                         │   │
    │   │    proctor    │                                                         │   │
    │   │    date       │  process: "Interview" | "Exam"                          │   │
    │   │    start_time │                                                         │   │
    │   │    end_time   │                                                         │   │
    │   │    status     │                                                         │   │
    │   │    process    │                                                         │   │
    │   └───────────────┘                                                         │   │
    │                                                                             │   │
    │                         Links to PROGRAM ────────────────────────────────────┘   │
    └─────────────────────────────────────────────────────────────────────────────────┘


    ┌─────────────────────────────────────────────────────────────────────────────────┐
    │                          STUDENT RECORDS                                         │
    │                                                                                 │
    │   ┌───────────────────────────────────────────────────────────────────┐         │
    │   │                         STUDENT                                   │         │
    │   ├───────────────────────────────────────────────────────────────────┤         │
    │   │ PK id                      │ student_number (unique)              │         │
    │   │ FK application_id ─────────────────────────── Links to APPLICANT  │         │
    │   │ FK department_id ──────────────────────────── Links to DEPARTMENT │         │
    │   │ FK program_id ─────────────────────────────── Links to PROGRAM    │         │
    │   │ FK level_id ───────────────────────────────── Links to LEVEL      │         │
    │   │ lrn, last_name, first_name, middle_name                           │         │
    │   │ sex, citizenship, religion, birthdate, place_of_birth            │         │
    │   │ civil_status, status                                              │         │
    │   └──────────────────────────┬────────────────────────────────────────┘         │
    │                              │                                                  │
    │           ┌──────────────────┼──────────────────────────┐                       │
    │           │                  │                          │                       │
    │           │ 1:1              │ 1:1                      │ 1:1                   │
    │           ▼                  ▼                          ▼                       │
    │   ┌───────────────┐  ┌───────────────────┐  ┌────────────────────────────┐      │
    │   │STUDENT_CONTACT│  │ STUDENT_GUARDIAN  │  │ STUDENT_ACADEMIC_HISTORY   │      │
    │   ├───────────────┤  ├───────────────────┤  ├────────────────────────────┤      │
    │   │ PK id         │  │ PK id             │  │ PK id                      │      │
    │   │ FK student_id │  │ FK student_id     │  │ FK student_id              │      │
    │   │ zip_code      │  │ mother_name       │  │ elementary_school_name     │      │
    │   │ present_addr  │  │ mother_occupation │  │ elementary_school_address  │      │
    │   │ permanent_addr│  │ mother_contact    │  │ elementary_inclusive_years │      │
    │   │ telephone     │  │ mother_income     │  │ junior_school_name         │      │
    │   │ mobile        │  │ father_name       │  │ junior_school_address      │      │
    │   │ email         │  │ father_occupation │  │ junior_inclusive_years     │      │
    │   └───────────────┘  │ father_contact    │  │ senior_school_name         │      │
    │                      │ father_income     │  │ senior_school_address      │      │
    │                      │ guardian_name     │  │ senior_inclusive_years     │      │
    │                      │ guardian_occupatio│  │ college_school_name        │      │
    │                      │ guardian_contact  │  │ college_school_address     │      │
    │                      │ guardian_income   │  │ college_inclusive_years    │      │
    │                      └───────────────────┘  └────────────────────────────┘      │
    │                                                                                 │
    └─────────────────────────────────────────────────────────────────────────────────┘
```

---

## Relationship Summary Table

| Parent Entity | Child Entity           | Relationship | Foreign Key                                                     |
| ------------- | ---------------------- | ------------ | --------------------------------------------------------------- |
| Department    | Program                | 1:N          | `program.department_id`                                         |
| Department    | Curriculum             | 1:N          | `curriculum.department_id`                                      |
| Department    | AcademicTerm           | 1:N          | `academic_term.department_id`                                   |
| Program       | Level                  | 1:N          | `level.program_id`                                              |
| Program       | Fee                    | 1:N          | `fee.program_id`                                                |
| Curriculum    | Prospectus             | 1:N          | `prospectus.curriculum_id`                                      |
| Subject       | Prospectus             | 1:N          | `prospectus.subject_id`                                         |
| AcademicTerm  | Prospectus             | 1:N          | `prospectus.academic_term_id`                                   |
| Level         | Prospectus             | 1:N          | `prospectus.level_id`                                           |
| Applicant     | Admission              | 1:1          | `admission.applicant_id`                                        |
| Schedule      | Admission              | 1:N          | `admission.interview_schedule_id`, `admission.exam_schedule_id` |
| Program       | Admission              | 1:N          | `admission.program_id`                                          |
| Applicant     | Student                | 1:1          | `student.application_id`                                        |
| Department    | Student                | 1:N          | `student.department_id`                                         |
| Program       | Student                | 1:N          | `student.program_id`                                            |
| Level         | Student                | 1:N          | `student.level_id`                                              |
| Student       | StudentContact         | 1:1          | `student_contact.student_id`                                    |
| Student       | StudentGuardian        | 1:1          | `student_guardian.student_id`                                   |
| Student       | StudentAcademicHistory | 1:1          | `student_academic_history.student_id`                           |

---

## Module Access Matrix

| Module                   | Registrar | Accounting | Admission | Public |
| ------------------------ | :-------: | :--------: | :-------: | :----: |
| Department Management    |    ✅     |     ❌     |    ❌     |   ❌   |
| Program Management       |    ✅     |     ❌     |    ❌     |   ❌   |
| Curriculum Management    |    ✅     |     ❌     |    ❌     |   ❌   |
| Subject Management       |    ✅     |     ❌     |    ❌     |   ❌   |
| Prospectus Management    |    ✅     |     ❌     |    ❌     |   ❌   |
| Level Management         |    ✅     |     ❌     |    ❌     |   ❌   |
| Academic Term Management |    ✅     |     ❌     |    ❌     |   ❌   |
| Fee Management           |    ❌     |     ✅     |    ❌     |   ❌   |
| Application Submission   |    ❌     |     ❌     |    ❌     |   ✅   |
| Applicant Management     |    ❌     |     ❌     |    ✅     |   ❌   |
| Interview Scheduling     |    ❌     |     ❌     |    ✅     |   ❌   |
| Examination Scoring      |    ❌     |     ❌     |    ✅     |   ❌   |
| Final Evaluation         |    ❌     |     ❌     |    ✅     |   ❌   |
| Student Records          |    ✅     |     ❌     |    ❌     |   ❌   |
| Dashboard & Reports      |    ✅     |     ✅     |    ✅     |   ❌   |

---

_Document generated: January 25, 2026_  
_Enrollment Management System v1.0_
