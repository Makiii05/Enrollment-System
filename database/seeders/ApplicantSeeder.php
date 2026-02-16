<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Program;
use App\Models\Level;
use App\Models\AcademicTerm;
use App\Models\Applicant;
use App\Models\Schedule;
use App\Models\User;

class ApplicantSeeder extends Seeder
{
    /**
     * Generate a timestamp-based application number.
     * Format: YYYYMMDDHHmmssSSS (e.g. 20260214192942456)
     */
    private function appNo(int $index): string
    {
        // Base time: 2026-02-14 08:00:00.000, offset each applicant by ~2 minutes
        $base = strtotime('2026-02-14 08:00:00');
        $ts   = $base + ($index * 127); // spread them out
        $ms   = str_pad($index * 37 % 1000, 3, '0', STR_PAD_LEFT);

        return date('YmdHis', $ts) . $ms;
    }

    public function run(): void
    {
        // =============================================
        // 1. DEPARTMENTS
        // =============================================
        $shsDept = Department::firstOrCreate(
            ['code' => 'SHS'],
            ['description' => 'Senior High School', 'status' => 'active']
        );

        $ccjeDept = Department::firstOrCreate(
            ['code' => 'CCJE'],
            ['description' => 'College of Criminal Justice Education', 'status' => 'active']
        );

        // =============================================
        // 2. PROGRAMS — SHS Strands
        // =============================================
        $shsPrograms = [
            ['code' => 'STEM',  'description' => 'Science, Technology, Engineering, and Mathematics'],
            ['code' => 'ABM',   'description' => 'Accountancy, Business, and Management'],
            ['code' => 'HUMSS', 'description' => 'Humanities and Social Sciences'],
            ['code' => 'GAS',   'description' => 'General Academic Strand'],
            ['code' => 'TVL',   'description' => 'Technical-Vocational-Livelihood'],
        ];

        foreach ($shsPrograms as $p) {
            Program::firstOrCreate(
                ['code' => $p['code'], 'department_id' => $shsDept->id],
                ['description' => $p['description'], 'status' => 'active']
            );
        }

        // =============================================
        // 3. PROGRAMS — CCJE College Programs
        // =============================================
        $ccjePrograms = [
            ['code' => 'BSCrim',   'description' => 'Bachelor of Science in Criminology'],
            ['code' => 'BSIndSec', 'description' => 'Bachelor of Science in Industrial Security Administration'],
            ['code' => 'BSForSci', 'description' => 'Bachelor of Science in Forensic Science'],
        ];

        $createdCcjePrograms = [];
        foreach ($ccjePrograms as $p) {
            $createdCcjePrograms[] = Program::firstOrCreate(
                ['code' => $p['code'], 'department_id' => $ccjeDept->id],
                ['description' => $p['description'], 'status' => 'active']
            );
        }

        // =============================================
        // 4. LEVELS — SHS: code = "<STRAND> <grade>"
        //    e.g. "STEM 11", "STEM 12", "ABM 11"
        // =============================================
        $shsDbPrograms = Program::where('department_id', $shsDept->id)->get();
        foreach ($shsDbPrograms as $prog) {
            Level::firstOrCreate(
                ['code' => "{$prog->code} 11", 'program_id' => $prog->id],
                ['description' => 'Grade 11', 'order' => 1]
            );
            Level::firstOrCreate(
                ['code' => "{$prog->code} 12", 'program_id' => $prog->id],
                ['description' => 'Grade 12', 'order' => 2]
            );
        }

        // =============================================
        // 5. LEVELS — College: code = "<PROGRAM> <year>"
        //    e.g. "BSCrim 1", "BSCrim 2"
        // =============================================
        $yearDescriptions = [1 => '1st Year', 2 => '2nd Year', 3 => '3rd Year', 4 => '4th Year'];
        foreach ($createdCcjePrograms as $prog) {
            foreach ($yearDescriptions as $num => $desc) {
                Level::firstOrCreate(
                    ['code' => "{$prog->code} {$num}", 'program_id' => $prog->id],
                    ['description' => $desc, 'order' => $num]
                );
            }
        }

        // =============================================
        // 6. ACADEMIC TERMS
        // =============================================
        AcademicTerm::firstOrCreate(
            ['code' => 'SHS-2025-2026', 'department_id' => $shsDept->id],
            [
                'description'   => 'SHS Academic Year 2025-2026',
                'type'          => 'full year',
                'academic_year' => '2025-2026',
                'start_date'    => '2025-08-01',
                'end_date'      => '2026-05-31',
                'status'        => 'active',
            ]
        );

        AcademicTerm::firstOrCreate(
            ['code' => 'CCJE-1S-2025-2026', 'department_id' => $ccjeDept->id],
            [
                'description'   => 'CCJE 1st Semester 2025-2026',
                'type'          => 'semester',
                'academic_year' => '2025-2026',
                'start_date'    => '2025-08-01',
                'end_date'      => '2025-12-20',
                'status'        => 'active',
            ]
        );

        AcademicTerm::firstOrCreate(
            ['code' => 'CCJE-2S-2025-2026', 'department_id' => $ccjeDept->id],
            [
                'description'   => 'CCJE 2nd Semester 2025-2026',
                'type'          => 'semester',
                'academic_year' => '2025-2026',
                'start_date'    => '2026-01-10',
                'end_date'      => '2026-05-31',
                'status'        => 'active',
            ]
        );

        // =============================================
        // 7. USERS — Principal, Guidance, Proctor
        // =============================================
        $principal = User::firstOrCreate(
            ['email' => 'principal@gmail.com'],
            [
                'name'     => 'Principal',
                'type'     => 'admissions',
                'role'     => 'principal',
                'password' => Hash::make('principal123'),
            ]
        );

        $guidance = User::firstOrCreate(
            ['email' => 'guidance@gmail.com'],
            [
                'name'     => 'Guidance Counselor',
                'type'     => 'admissions',
                'role'     => 'guidance',
                'password' => Hash::make('guidance123'),
            ]
        );

        $proctor = User::firstOrCreate(
            ['email' => 'proctor@gmail.com'],
            [
                'name'     => 'Proctor',
                'type'     => 'admission',
                'role'     => 'proctor',
                'password' => Hash::make('proctor123'),
            ]
        );

        // =============================================
        // 8. SCHEDULES — exam (proctor), interview (guidance), evaluation (principal)
        // =============================================
        // Exam schedules — assigned to proctor
        Schedule::firstOrCreate(
            ['proctor_id' => $proctor->id, 'date' => '2026-03-10', 'process' => 'exam'],
            [
                'start_time' => '08:00',
                'end_time'   => '10:00',
                'status'     => 'active',
            ]
        );
        Schedule::firstOrCreate(
            ['proctor_id' => $proctor->id, 'date' => '2026-03-12', 'process' => 'exam'],
            [
                'start_time' => '08:00',
                'end_time'   => '10:00',
                'status'     => 'active',
            ]
        );
        Schedule::firstOrCreate(
            ['proctor_id' => $proctor->id, 'date' => '2026-03-14', 'process' => 'exam'],
            [
                'start_time' => '13:00',
                'end_time'   => '15:00',
                'status'     => 'active',
            ]
        );

        // Interview schedules — assigned to guidance
        Schedule::firstOrCreate(
            ['proctor_id' => $guidance->id, 'date' => '2026-03-17', 'process' => 'interview'],
            [
                'start_time' => '09:00',
                'end_time'   => '11:00',
                'status'     => 'active',
            ]
        );
        Schedule::firstOrCreate(
            ['proctor_id' => $guidance->id, 'date' => '2026-03-19', 'process' => 'interview'],
            [
                'start_time' => '09:00',
                'end_time'   => '11:00',
                'status'     => 'active',
            ]
        );
        Schedule::firstOrCreate(
            ['proctor_id' => $guidance->id, 'date' => '2026-03-21', 'process' => 'interview'],
            [
                'start_time' => '14:00',
                'end_time'   => '16:00',
                'status'     => 'active',
            ]
        );

        // Evaluation schedules — assigned to principal
        Schedule::firstOrCreate(
            ['proctor_id' => $principal->id, 'date' => '2026-03-24', 'process' => 'evaluation'],
            [
                'start_time' => '10:00',
                'end_time'   => '12:00',
                'status'     => 'active',
            ]
        );
        Schedule::firstOrCreate(
            ['proctor_id' => $principal->id, 'date' => '2026-03-26', 'process' => 'evaluation'],
            [
                'start_time' => '10:00',
                'end_time'   => '12:00',
                'status'     => 'active',
            ]
        );

        // =============================================
        // 9. APPLICANTS — 24 sample records (all pending)
        //    application_no = timestamp format YYYYMMDDHHmmssSSS
        // =============================================

        $bsCrim   = Program::where('code', 'BSCrim')->first();
        $bsIndSec = Program::where('code', 'BSIndSec')->first();
        $bsForSci = Program::where('code', 'BSForSci')->first();

        $stemProg  = Program::where('code', 'STEM')->where('department_id', $shsDept->id)->first();
        $abmProg   = Program::where('code', 'ABM')->where('department_id', $shsDept->id)->first();
        $humssProg = Program::where('code', 'HUMSS')->where('department_id', $shsDept->id)->first();
        $gasProg   = Program::where('code', 'GAS')->where('department_id', $shsDept->id)->first();
        $tvlProg   = Program::where('code', 'TVL')->where('department_id', $shsDept->id)->first();

        $applicants = [
            // ── COLLEGE applicants (1st Year) — 8 applicants ──
            // Have elementary, junior, senior background. College = N/A.
            [
                'application_no' => $this->appNo(1),
                'level' => 'College', 'student_type' => 'new', 'year_level' => '1st Year', 'strand' => null,
                'first_program_choice' => $bsCrim->id, 'second_program_choice' => $bsIndSec->id, 'third_program_choice' => $bsForSci->id,
                'last_name' => 'Dela Cruz', 'first_name' => 'Juan', 'middle_name' => 'Santos',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2007-03-15', 'place_of_birth' => 'Manila', 'civil_status' => 'Single',
                'zip_code' => 1000, 'present_address' => '123 Rizal St., Tondo, Manila', 'permanent_address' => '123 Rizal St., Tondo, Manila',
                'telephone_number' => null, 'mobile_number' => '09171234501', 'email' => 'juan.delacruz@email.com',
                'mother_name' => 'Maria Santos Dela Cruz', 'mother_occupation' => 'Teacher', 'mother_contact_number' => '09171111101', 'mother_monthly_income' => 25000,
                'father_name' => 'Pedro Dela Cruz', 'father_occupation' => 'Engineer', 'father_contact_number' => '09171111102', 'father_monthly_income' => 35000,
                'guardian_name' => 'Maria Santos Dela Cruz', 'guardian_occupation' => 'Teacher', 'guardian_contact_number' => '09171111101', 'guardian_monthly_income' => 25000,
                'elementary_school_name' => 'Tondo Elementary School', 'elementary_school_address' => 'Tondo, Manila', 'elementary_inclusive_years' => '2013-2019',
                'junior_school_name' => 'Manila Science High School', 'junior_school_address' => 'Ermita, Manila', 'junior_inclusive_years' => '2019-2023',
                'senior_school_name' => 'Manila Science High School', 'senior_school_address' => 'Ermita, Manila', 'senior_inclusive_years' => '2023-2025',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201300001, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(2),
                'level' => 'College', 'student_type' => 'new', 'year_level' => '1st Year', 'strand' => null,
                'first_program_choice' => $bsForSci->id, 'second_program_choice' => $bsCrim->id, 'third_program_choice' => $bsIndSec->id,
                'last_name' => 'Reyes', 'first_name' => 'Angela', 'middle_name' => 'Garcia',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2007-07-22', 'place_of_birth' => 'Quezon City', 'civil_status' => 'Single',
                'zip_code' => 1100, 'present_address' => '45 Visayas Ave., Quezon City', 'permanent_address' => '45 Visayas Ave., Quezon City',
                'telephone_number' => null, 'mobile_number' => '09171234502', 'email' => 'angela.reyes@email.com',
                'mother_name' => 'Lourdes Garcia Reyes', 'mother_occupation' => 'Nurse', 'mother_contact_number' => '09172222201', 'mother_monthly_income' => 30000,
                'father_name' => 'Roberto Reyes', 'father_occupation' => 'Driver', 'father_contact_number' => '09172222202', 'father_monthly_income' => 18000,
                'guardian_name' => 'Lourdes Garcia Reyes', 'guardian_occupation' => 'Nurse', 'guardian_contact_number' => '09172222201', 'guardian_monthly_income' => 30000,
                'elementary_school_name' => 'Quezon City Central School', 'elementary_school_address' => 'Quezon City', 'elementary_inclusive_years' => '2013-2019',
                'junior_school_name' => 'Commonwealth High School', 'junior_school_address' => 'Quezon City', 'junior_inclusive_years' => '2019-2023',
                'senior_school_name' => 'Commonwealth High School', 'senior_school_address' => 'Quezon City', 'senior_inclusive_years' => '2023-2025',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201300002, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(3),
                'level' => 'College', 'student_type' => 'new', 'year_level' => '1st Year', 'strand' => null,
                'first_program_choice' => $bsCrim->id, 'second_program_choice' => $bsForSci->id, 'third_program_choice' => $bsIndSec->id,
                'last_name' => 'Santos', 'first_name' => 'Mark', 'middle_name' => 'Lopez',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Iglesia ni Cristo',
                'birthdate' => '2007-01-10', 'place_of_birth' => 'Caloocan City', 'civil_status' => 'Single',
                'zip_code' => 1400, 'present_address' => '78 Samson Rd., Caloocan City', 'permanent_address' => '78 Samson Rd., Caloocan City',
                'telephone_number' => '02-88123456', 'mobile_number' => '09171234503', 'email' => 'mark.santos@email.com',
                'mother_name' => 'Elena Lopez Santos', 'mother_occupation' => 'Accountant', 'mother_contact_number' => '09173333301', 'mother_monthly_income' => 40000,
                'father_name' => 'Ricardo Santos', 'father_occupation' => 'Mechanic', 'father_contact_number' => '09173333302', 'father_monthly_income' => 20000,
                'guardian_name' => 'Elena Lopez Santos', 'guardian_occupation' => 'Accountant', 'guardian_contact_number' => '09173333301', 'guardian_monthly_income' => 40000,
                'elementary_school_name' => 'Caloocan North Elementary School', 'elementary_school_address' => 'Caloocan City', 'elementary_inclusive_years' => '2013-2019',
                'junior_school_name' => 'Caloocan National High School', 'junior_school_address' => 'Caloocan City', 'junior_inclusive_years' => '2019-2023',
                'senior_school_name' => 'Caloocan National High School', 'senior_school_address' => 'Caloocan City', 'senior_inclusive_years' => '2023-2025',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201300003, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(4),
                'level' => 'College', 'student_type' => 'new', 'year_level' => '1st Year', 'strand' => null,
                'first_program_choice' => $bsIndSec->id, 'second_program_choice' => $bsCrim->id, 'third_program_choice' => $bsForSci->id,
                'last_name' => 'Garcia', 'first_name' => 'Patricia', 'middle_name' => 'Mendoza',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2007-11-05', 'place_of_birth' => 'Pasig City', 'civil_status' => 'Single',
                'zip_code' => 1600, 'present_address' => '22 Ortigas Ave., Pasig City', 'permanent_address' => '22 Ortigas Ave., Pasig City',
                'telephone_number' => null, 'mobile_number' => '09171234504', 'email' => 'patricia.garcia@email.com',
                'mother_name' => 'Rosa Mendoza Garcia', 'mother_occupation' => 'Housewife', 'mother_contact_number' => '09174444401', 'mother_monthly_income' => 0,
                'father_name' => 'Antonio Garcia', 'father_occupation' => 'Policeman', 'father_contact_number' => '09174444402', 'father_monthly_income' => 32000,
                'guardian_name' => 'Antonio Garcia', 'guardian_occupation' => 'Policeman', 'guardian_contact_number' => '09174444402', 'guardian_monthly_income' => 32000,
                'elementary_school_name' => 'Pasig Elementary School', 'elementary_school_address' => 'Pasig City', 'elementary_inclusive_years' => '2013-2019',
                'junior_school_name' => 'Rizal High School', 'junior_school_address' => 'Pasig City', 'junior_inclusive_years' => '2019-2023',
                'senior_school_name' => 'Rizal High School', 'senior_school_address' => 'Pasig City', 'senior_inclusive_years' => '2023-2025',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201300004, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(5),
                'level' => 'College', 'student_type' => 'new', 'year_level' => '1st Year', 'strand' => null,
                'first_program_choice' => $bsCrim->id, 'second_program_choice' => $bsIndSec->id, 'third_program_choice' => null,
                'last_name' => 'Villanueva', 'first_name' => 'Carlos', 'middle_name' => 'Ramos',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Born Again Christian',
                'birthdate' => '2006-12-20', 'place_of_birth' => 'Makati City', 'civil_status' => 'Single',
                'zip_code' => 1200, 'present_address' => '55 Ayala Ave., Makati City', 'permanent_address' => '55 Ayala Ave., Makati City',
                'telephone_number' => null, 'mobile_number' => '09171234505', 'email' => 'carlos.villanueva@email.com',
                'mother_name' => 'Carmen Ramos Villanueva', 'mother_occupation' => 'Businesswoman', 'mother_contact_number' => '09175555501', 'mother_monthly_income' => 50000,
                'father_name' => 'Manuel Villanueva', 'father_occupation' => 'OFW', 'father_contact_number' => '09175555502', 'father_monthly_income' => 60000,
                'guardian_name' => 'Carmen Ramos Villanueva', 'guardian_occupation' => 'Businesswoman', 'guardian_contact_number' => '09175555501', 'guardian_monthly_income' => 50000,
                'elementary_school_name' => 'Makati Elementary School', 'elementary_school_address' => 'Makati City', 'elementary_inclusive_years' => '2012-2018',
                'junior_school_name' => 'Makati Science High School', 'junior_school_address' => 'Makati City', 'junior_inclusive_years' => '2018-2022',
                'senior_school_name' => 'Makati Science High School', 'senior_school_address' => 'Makati City', 'senior_inclusive_years' => '2022-2024',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201200005, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(6),
                'level' => 'College', 'student_type' => 'new', 'year_level' => '1st Year', 'strand' => null,
                'first_program_choice' => $bsForSci->id, 'second_program_choice' => $bsIndSec->id, 'third_program_choice' => $bsCrim->id,
                'last_name' => 'Bautista', 'first_name' => 'Lovely', 'middle_name' => 'Torres',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2007-05-30', 'place_of_birth' => 'Marikina City', 'civil_status' => 'Single',
                'zip_code' => 1800, 'present_address' => '99 Shoe Ave., Marikina City', 'permanent_address' => '99 Shoe Ave., Marikina City',
                'telephone_number' => null, 'mobile_number' => '09171234506', 'email' => 'lovely.bautista@email.com',
                'mother_name' => 'Judith Torres Bautista', 'mother_occupation' => 'Vendor', 'mother_contact_number' => '09176666601', 'mother_monthly_income' => 12000,
                'father_name' => 'Rodrigo Bautista', 'father_occupation' => 'Security Guard', 'father_contact_number' => '09176666602', 'father_monthly_income' => 15000,
                'guardian_name' => 'Judith Torres Bautista', 'guardian_occupation' => 'Vendor', 'guardian_contact_number' => '09176666601', 'guardian_monthly_income' => 12000,
                'elementary_school_name' => 'Marikina Heights Elementary School', 'elementary_school_address' => 'Marikina City', 'elementary_inclusive_years' => '2013-2019',
                'junior_school_name' => 'Marikina High School', 'junior_school_address' => 'Marikina City', 'junior_inclusive_years' => '2019-2023',
                'senior_school_name' => 'Marikina High School', 'senior_school_address' => 'Marikina City', 'senior_inclusive_years' => '2023-2025',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201300006, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(7),
                'level' => 'College', 'student_type' => 'transferee', 'year_level' => '1st Year', 'strand' => null,
                'first_program_choice' => $bsCrim->id, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Fernandez', 'first_name' => 'Miguel', 'middle_name' => 'Cruz',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2006-09-14', 'place_of_birth' => 'Taguig City', 'civil_status' => 'Single',
                'zip_code' => 1630, 'present_address' => '10 C5 Road, Taguig City', 'permanent_address' => '10 C5 Road, Taguig City',
                'telephone_number' => null, 'mobile_number' => '09171234507', 'email' => 'miguel.fernandez@email.com',
                'mother_name' => 'Alma Cruz Fernandez', 'mother_occupation' => 'Office Clerk', 'mother_contact_number' => '09177777701', 'mother_monthly_income' => 20000,
                'father_name' => 'Danilo Fernandez', 'father_occupation' => 'Carpenter', 'father_contact_number' => '09177777702', 'father_monthly_income' => 18000,
                'guardian_name' => 'Alma Cruz Fernandez', 'guardian_occupation' => 'Office Clerk', 'guardian_contact_number' => '09177777701', 'guardian_monthly_income' => 20000,
                'elementary_school_name' => 'Taguig Central Elementary School', 'elementary_school_address' => 'Taguig City', 'elementary_inclusive_years' => '2012-2018',
                'junior_school_name' => 'Signal Village National High School', 'junior_school_address' => 'Taguig City', 'junior_inclusive_years' => '2018-2022',
                'senior_school_name' => 'Signal Village National High School', 'senior_school_address' => 'Taguig City', 'senior_inclusive_years' => '2022-2024',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201200007, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(8),
                'level' => 'College', 'student_type' => 'new', 'year_level' => '1st Year', 'strand' => null,
                'first_program_choice' => $bsIndSec->id, 'second_program_choice' => $bsForSci->id, 'third_program_choice' => $bsCrim->id,
                'last_name' => 'Mendoza', 'first_name' => 'Alyssa', 'middle_name' => 'Navarro',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Methodist',
                'birthdate' => '2007-02-18', 'place_of_birth' => 'Las Piñas City', 'civil_status' => 'Single',
                'zip_code' => 1740, 'present_address' => '88 Alabang-Zapote Rd., Las Piñas', 'permanent_address' => '88 Alabang-Zapote Rd., Las Piñas',
                'telephone_number' => null, 'mobile_number' => '09171234508', 'email' => 'alyssa.mendoza@email.com',
                'mother_name' => 'Grace Navarro Mendoza', 'mother_occupation' => 'Pharmacist', 'mother_contact_number' => '09178888801', 'mother_monthly_income' => 35000,
                'father_name' => 'Edwin Mendoza', 'father_occupation' => 'Electrician', 'father_contact_number' => '09178888802', 'father_monthly_income' => 22000,
                'guardian_name' => 'Grace Navarro Mendoza', 'guardian_occupation' => 'Pharmacist', 'guardian_contact_number' => '09178888801', 'guardian_monthly_income' => 35000,
                'elementary_school_name' => 'Las Piñas East Central School', 'elementary_school_address' => 'Las Piñas City', 'elementary_inclusive_years' => '2013-2019',
                'junior_school_name' => 'Las Piñas National High School', 'junior_school_address' => 'Las Piñas City', 'junior_inclusive_years' => '2019-2023',
                'senior_school_name' => 'Las Piñas National High School', 'senior_school_address' => 'Las Piñas City', 'senior_inclusive_years' => '2023-2025',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201300008, 'status' => 'pending', 'reject_reason' => null,
            ],

            // ── SHS applicants (Grade 11) — 8 applicants ──
            // Have elementary and junior background. Senior/college = N/A.
            [
                'application_no' => $this->appNo(9),
                'level' => 'Senior High School', 'student_type' => 'new', 'year_level' => 'Grade 11', 'strand' => $stemProg->id,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Aquino', 'first_name' => 'Daniel', 'middle_name' => 'Castillo',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2009-04-12', 'place_of_birth' => 'Valenzuela City', 'civil_status' => 'Single',
                'zip_code' => 1440, 'present_address' => '15 MacArthur Highway, Valenzuela City', 'permanent_address' => '15 MacArthur Highway, Valenzuela City',
                'telephone_number' => null, 'mobile_number' => '09171234509', 'email' => 'daniel.aquino@email.com',
                'mother_name' => 'Maricel Castillo Aquino', 'mother_occupation' => 'Seamstress', 'mother_contact_number' => '09179999901', 'mother_monthly_income' => 10000,
                'father_name' => 'Nestor Aquino', 'father_occupation' => 'Welder', 'father_contact_number' => '09179999902', 'father_monthly_income' => 16000,
                'guardian_name' => 'Maricel Castillo Aquino', 'guardian_occupation' => 'Seamstress', 'guardian_contact_number' => '09179999901', 'guardian_monthly_income' => 10000,
                'elementary_school_name' => 'Valenzuela Central School', 'elementary_school_address' => 'Valenzuela City', 'elementary_inclusive_years' => '2015-2021',
                'junior_school_name' => 'Valenzuela National High School', 'junior_school_address' => 'Valenzuela City', 'junior_inclusive_years' => '2021-2025',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201500009, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(10),
                'level' => 'Senior High School', 'student_type' => 'new', 'year_level' => 'Grade 11', 'strand' => $abmProg->id,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Torres', 'first_name' => 'Jasmine', 'middle_name' => 'Rivera',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2009-08-25', 'place_of_birth' => 'Muntinlupa City', 'civil_status' => 'Single',
                'zip_code' => 1770, 'present_address' => '33 National Highway, Muntinlupa City', 'permanent_address' => '33 National Highway, Muntinlupa City',
                'telephone_number' => null, 'mobile_number' => '09171234510', 'email' => 'jasmine.torres@email.com',
                'mother_name' => 'Beth Rivera Torres', 'mother_occupation' => 'Cook', 'mother_contact_number' => '09170000001', 'mother_monthly_income' => 14000,
                'father_name' => 'Leonardo Torres', 'father_occupation' => 'Tricycle Driver', 'father_contact_number' => '09170000002', 'father_monthly_income' => 12000,
                'guardian_name' => 'Beth Rivera Torres', 'guardian_occupation' => 'Cook', 'guardian_contact_number' => '09170000001', 'guardian_monthly_income' => 14000,
                'elementary_school_name' => 'Muntinlupa Central School', 'elementary_school_address' => 'Muntinlupa City', 'elementary_inclusive_years' => '2015-2021',
                'junior_school_name' => 'Muntinlupa National High School', 'junior_school_address' => 'Muntinlupa City', 'junior_inclusive_years' => '2021-2025',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201500010, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(11),
                'level' => 'Senior High School', 'student_type' => 'new', 'year_level' => 'Grade 11', 'strand' => $humssProg->id,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Ramos', 'first_name' => 'Ethan', 'middle_name' => 'Flores',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Born Again Christian',
                'birthdate' => '2009-06-03', 'place_of_birth' => 'Parañaque City', 'civil_status' => 'Single',
                'zip_code' => 1700, 'present_address' => '77 Dr. A. Santos Ave., Parañaque', 'permanent_address' => '77 Dr. A. Santos Ave., Parañaque',
                'telephone_number' => null, 'mobile_number' => '09171234511', 'email' => 'ethan.ramos@email.com',
                'mother_name' => 'Rowena Flores Ramos', 'mother_occupation' => 'Laundry Worker', 'mother_contact_number' => '09170000011', 'mother_monthly_income' => 8000,
                'father_name' => 'Joel Ramos', 'father_occupation' => 'Construction Worker', 'father_contact_number' => '09170000012', 'father_monthly_income' => 14000,
                'guardian_name' => 'Rowena Flores Ramos', 'guardian_occupation' => 'Laundry Worker', 'guardian_contact_number' => '09170000011', 'guardian_monthly_income' => 8000,
                'elementary_school_name' => 'Parañaque Central Elementary School', 'elementary_school_address' => 'Parañaque City', 'elementary_inclusive_years' => '2015-2021',
                'junior_school_name' => 'Parañaque National High School', 'junior_school_address' => 'Parañaque City', 'junior_inclusive_years' => '2021-2025',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201500011, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(12),
                'level' => 'Senior High School', 'student_type' => 'new', 'year_level' => 'Grade 11', 'strand' => $gasProg->id,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Cruz', 'first_name' => 'Samantha', 'middle_name' => 'De Leon',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2009-10-17', 'place_of_birth' => 'San Juan City', 'civil_status' => 'Single',
                'zip_code' => 1500, 'present_address' => '12 N. Domingo St., San Juan City', 'permanent_address' => '12 N. Domingo St., San Juan City',
                'telephone_number' => null, 'mobile_number' => '09171234512', 'email' => 'samantha.cruz@email.com',
                'mother_name' => 'Lilian De Leon Cruz', 'mother_occupation' => 'Cashier', 'mother_contact_number' => '09170000021', 'mother_monthly_income' => 15000,
                'father_name' => 'Ernesto Cruz', 'father_occupation' => 'Taxi Driver', 'father_contact_number' => '09170000022', 'father_monthly_income' => 18000,
                'guardian_name' => 'Lilian De Leon Cruz', 'guardian_occupation' => 'Cashier', 'guardian_contact_number' => '09170000021', 'guardian_monthly_income' => 15000,
                'elementary_school_name' => 'San Juan Central School', 'elementary_school_address' => 'San Juan City', 'elementary_inclusive_years' => '2015-2021',
                'junior_school_name' => 'San Juan National High School', 'junior_school_address' => 'San Juan City', 'junior_inclusive_years' => '2021-2025',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201500012, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(13),
                'level' => 'Senior High School', 'student_type' => 'new', 'year_level' => 'Grade 11', 'strand' => $tvlProg->id,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Padilla', 'first_name' => 'Joshua', 'middle_name' => 'Gutierrez',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Iglesia ni Cristo',
                'birthdate' => '2009-02-28', 'place_of_birth' => 'Navotas City', 'civil_status' => 'Single',
                'zip_code' => 1485, 'present_address' => '5 NBBS Rd., Navotas City', 'permanent_address' => '5 NBBS Rd., Navotas City',
                'telephone_number' => null, 'mobile_number' => '09171234513', 'email' => 'joshua.padilla@email.com',
                'mother_name' => 'Cynthia Gutierrez Padilla', 'mother_occupation' => 'Fish Vendor', 'mother_contact_number' => '09170000031', 'mother_monthly_income' => 10000,
                'father_name' => 'Rodel Padilla', 'father_occupation' => 'Fisherman', 'father_contact_number' => '09170000032', 'father_monthly_income' => 12000,
                'guardian_name' => 'Cynthia Gutierrez Padilla', 'guardian_occupation' => 'Fish Vendor', 'guardian_contact_number' => '09170000031', 'guardian_monthly_income' => 10000,
                'elementary_school_name' => 'Navotas Central School', 'elementary_school_address' => 'Navotas City', 'elementary_inclusive_years' => '2015-2021',
                'junior_school_name' => 'Navotas National High School', 'junior_school_address' => 'Navotas City', 'junior_inclusive_years' => '2021-2025',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201500013, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(14),
                'level' => 'Senior High School', 'student_type' => 'new', 'year_level' => 'Grade 11', 'strand' => $stemProg->id,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Mercado', 'first_name' => 'Kristine', 'middle_name' => 'Aguilar',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2009-12-09', 'place_of_birth' => 'Malabon City', 'civil_status' => 'Single',
                'zip_code' => 1470, 'present_address' => '20 Gov. Pascual Ave., Malabon City', 'permanent_address' => '20 Gov. Pascual Ave., Malabon City',
                'telephone_number' => null, 'mobile_number' => '09171234514', 'email' => 'kristine.mercado@email.com',
                'mother_name' => 'Nora Aguilar Mercado', 'mother_occupation' => 'Teacher', 'mother_contact_number' => '09170000041', 'mother_monthly_income' => 28000,
                'father_name' => 'Renato Mercado', 'father_occupation' => 'Plumber', 'father_contact_number' => '09170000042', 'father_monthly_income' => 15000,
                'guardian_name' => 'Nora Aguilar Mercado', 'guardian_occupation' => 'Teacher', 'guardian_contact_number' => '09170000041', 'guardian_monthly_income' => 28000,
                'elementary_school_name' => 'Malabon Central School', 'elementary_school_address' => 'Malabon City', 'elementary_inclusive_years' => '2015-2021',
                'junior_school_name' => 'Malabon National High School', 'junior_school_address' => 'Malabon City', 'junior_inclusive_years' => '2021-2025',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201500014, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(15),
                'level' => 'Senior High School', 'student_type' => 'new', 'year_level' => 'Grade 11', 'strand' => $abmProg->id,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Soriano', 'first_name' => 'Ralph', 'middle_name' => 'Ocampo',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2009-07-14', 'place_of_birth' => 'Mandaluyong City', 'civil_status' => 'Single',
                'zip_code' => 1550, 'present_address' => '10 Shaw Blvd., Mandaluyong City', 'permanent_address' => '10 Shaw Blvd., Mandaluyong City',
                'telephone_number' => '02-85341234', 'mobile_number' => '09171234515', 'email' => 'ralph.soriano@email.com',
                'mother_name' => 'Gemma Ocampo Soriano', 'mother_occupation' => 'Sales Lady', 'mother_contact_number' => '09170000051', 'mother_monthly_income' => 13000,
                'father_name' => 'Larry Soriano', 'father_occupation' => 'Janitor', 'father_contact_number' => '09170000052', 'father_monthly_income' => 14000,
                'guardian_name' => 'Larry Soriano', 'guardian_occupation' => 'Janitor', 'guardian_contact_number' => '09170000052', 'guardian_monthly_income' => 14000,
                'elementary_school_name' => 'Mandaluyong Elementary School', 'elementary_school_address' => 'Mandaluyong City', 'elementary_inclusive_years' => '2015-2021',
                'junior_school_name' => 'Mandaluyong High School', 'junior_school_address' => 'Mandaluyong City', 'junior_inclusive_years' => '2021-2025',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201500015, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(16),
                'level' => 'Senior High School', 'student_type' => 'transferee', 'year_level' => 'Grade 11', 'strand' => $humssProg->id,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Lim', 'first_name' => 'Christine', 'middle_name' => 'Tan',
                'sex' => 'Female', 'citizenship' => 'Filipino-Chinese', 'religion' => 'Buddhist',
                'birthdate' => '2009-03-20', 'place_of_birth' => 'Binondo, Manila', 'civil_status' => 'Single',
                'zip_code' => 1006, 'present_address' => '88 Ongpin St., Binondo, Manila', 'permanent_address' => '88 Ongpin St., Binondo, Manila',
                'telephone_number' => '02-82456789', 'mobile_number' => '09171234516', 'email' => 'christine.lim@email.com',
                'mother_name' => 'Susan Tan Lim', 'mother_occupation' => 'Businesswoman', 'mother_contact_number' => '09170000061', 'mother_monthly_income' => 45000,
                'father_name' => 'William Lim', 'father_occupation' => 'Businessman', 'father_contact_number' => '09170000062', 'father_monthly_income' => 55000,
                'guardian_name' => 'Susan Tan Lim', 'guardian_occupation' => 'Businesswoman', 'guardian_contact_number' => '09170000061', 'guardian_monthly_income' => 45000,
                'elementary_school_name' => 'Chiang Kai Shek College', 'elementary_school_address' => 'Taft Ave., Manila', 'elementary_inclusive_years' => '2015-2021',
                'junior_school_name' => 'Chiang Kai Shek College', 'junior_school_address' => 'Taft Ave., Manila', 'junior_inclusive_years' => '2021-2025',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201500016, 'status' => 'pending', 'reject_reason' => null,
            ],

            // ── JUNIOR HIGH SCHOOL applicants — 2 applicants ──
            // Have elementary background only. Junior/senior/college = N/A.
            [
                'application_no' => $this->appNo(17),
                'level' => 'Junior High School', 'student_type' => 'new', 'year_level' => null, 'strand' => null,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Manalo', 'first_name' => 'Jericho', 'middle_name' => 'Diaz',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2013-05-11', 'place_of_birth' => 'Pasay City', 'civil_status' => 'Single',
                'zip_code' => 1300, 'present_address' => '44 Taft Ave., Pasay City', 'permanent_address' => '44 Taft Ave., Pasay City',
                'telephone_number' => null, 'mobile_number' => '09171234517', 'email' => 'jericho.manalo@email.com',
                'mother_name' => 'Emilia Diaz Manalo', 'mother_occupation' => 'Housewife', 'mother_contact_number' => '09170000071', 'mother_monthly_income' => 0,
                'father_name' => 'Arnold Manalo', 'father_occupation' => 'Jeepney Driver', 'father_contact_number' => '09170000072', 'father_monthly_income' => 15000,
                'guardian_name' => 'Arnold Manalo', 'guardian_occupation' => 'Jeepney Driver', 'guardian_contact_number' => '09170000072', 'guardian_monthly_income' => 15000,
                'elementary_school_name' => 'Pasay West Central School', 'elementary_school_address' => 'Pasay City', 'elementary_inclusive_years' => '2019-2025',
                'junior_school_name' => 'N/A', 'junior_school_address' => 'N/A', 'junior_inclusive_years' => 'N/A',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201900017, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(18),
                'level' => 'Junior High School', 'student_type' => 'new', 'year_level' => null, 'strand' => null,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Gomez', 'first_name' => 'Bianca', 'middle_name' => 'Valdez',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2013-09-08', 'place_of_birth' => 'Quezon City', 'civil_status' => 'Single',
                'zip_code' => 1101, 'present_address' => '56 Congressional Ave., Quezon City', 'permanent_address' => '56 Congressional Ave., Quezon City',
                'telephone_number' => null, 'mobile_number' => '09171234518', 'email' => 'bianca.gomez@email.com',
                'mother_name' => 'Rosalinda Valdez Gomez', 'mother_occupation' => 'Clerk', 'mother_contact_number' => '09170000081', 'mother_monthly_income' => 16000,
                'father_name' => 'Federico Gomez', 'father_occupation' => 'Painter', 'father_contact_number' => '09170000082', 'father_monthly_income' => 14000,
                'guardian_name' => 'Rosalinda Valdez Gomez', 'guardian_occupation' => 'Clerk', 'guardian_contact_number' => '09170000081', 'guardian_monthly_income' => 16000,
                'elementary_school_name' => 'Commonwealth Elementary School', 'elementary_school_address' => 'Quezon City', 'elementary_inclusive_years' => '2019-2025',
                'junior_school_name' => 'N/A', 'junior_school_address' => 'N/A', 'junior_inclusive_years' => 'N/A',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 201900018, 'status' => 'pending', 'reject_reason' => null,
            ],

            // ── GRADE SCHOOL applicants — 2 applicants ──
            // All educational background = N/A.
            [
                'application_no' => $this->appNo(19),
                'level' => 'Grade School', 'student_type' => 'new', 'year_level' => null, 'strand' => null,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Enriquez', 'first_name' => 'Nathan', 'middle_name' => 'Pascual',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2019-01-22', 'place_of_birth' => 'Manila', 'civil_status' => 'Single',
                'zip_code' => 1008, 'present_address' => '9 Padre Faura St., Manila', 'permanent_address' => '9 Padre Faura St., Manila',
                'telephone_number' => null, 'mobile_number' => '09171234519', 'email' => 'nathan.enriquez@email.com',
                'mother_name' => 'Irene Pascual Enriquez', 'mother_occupation' => 'Call Center Agent', 'mother_contact_number' => '09170000091', 'mother_monthly_income' => 22000,
                'father_name' => 'Dennis Enriquez', 'father_occupation' => 'Delivery Rider', 'father_contact_number' => '09170000092', 'father_monthly_income' => 16000,
                'guardian_name' => 'Irene Pascual Enriquez', 'guardian_occupation' => 'Call Center Agent', 'guardian_contact_number' => '09170000091', 'guardian_monthly_income' => 22000,
                'elementary_school_name' => 'N/A', 'elementary_school_address' => 'N/A', 'elementary_inclusive_years' => 'N/A',
                'junior_school_name' => 'N/A', 'junior_school_address' => 'N/A', 'junior_inclusive_years' => 'N/A',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 202500019, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(20),
                'level' => 'Grade School', 'student_type' => 'new', 'year_level' => null, 'strand' => null,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Salvador', 'first_name' => 'Sophia', 'middle_name' => 'Reyes',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Evangelical',
                'birthdate' => '2019-06-15', 'place_of_birth' => 'Caloocan City', 'civil_status' => 'Single',
                'zip_code' => 1401, 'present_address' => '27 A. Mabini St., Caloocan City', 'permanent_address' => '27 A. Mabini St., Caloocan City',
                'telephone_number' => null, 'mobile_number' => '09171234520', 'email' => 'sophia.salvador@email.com',
                'mother_name' => 'Anna Reyes Salvador', 'mother_occupation' => 'Dressmaker', 'mother_contact_number' => '09170001001', 'mother_monthly_income' => 12000,
                'father_name' => 'Oliver Salvador', 'father_occupation' => 'Factory Worker', 'father_contact_number' => '09170001002', 'father_monthly_income' => 14000,
                'guardian_name' => 'Anna Reyes Salvador', 'guardian_occupation' => 'Dressmaker', 'guardian_contact_number' => '09170001001', 'guardian_monthly_income' => 12000,
                'elementary_school_name' => 'N/A', 'elementary_school_address' => 'N/A', 'elementary_inclusive_years' => 'N/A',
                'junior_school_name' => 'N/A', 'junior_school_address' => 'N/A', 'junior_inclusive_years' => 'N/A',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 202500020, 'status' => 'pending', 'reject_reason' => null,
            ],

            // ── KINDERGARTEN applicants — 2 applicants ──
            // All educational background = N/A.
            [
                'application_no' => $this->appNo(21),
                'level' => 'Kindergarten', 'student_type' => 'new', 'year_level' => null, 'strand' => null,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Roxas', 'first_name' => 'Lucas', 'middle_name' => 'Bernal',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2020-11-03', 'place_of_birth' => 'Manila', 'civil_status' => 'Single',
                'zip_code' => 1003, 'present_address' => '15 España Blvd., Sampaloc, Manila', 'permanent_address' => '15 España Blvd., Sampaloc, Manila',
                'telephone_number' => null, 'mobile_number' => '09171234521', 'email' => 'lucas.roxas@email.com',
                'mother_name' => 'Maribel Bernal Roxas', 'mother_occupation' => 'Receptionist', 'mother_contact_number' => '09170002001', 'mother_monthly_income' => 18000,
                'father_name' => 'Patrick Roxas', 'father_occupation' => 'IT Technician', 'father_contact_number' => '09170002002', 'father_monthly_income' => 25000,
                'guardian_name' => 'Maribel Bernal Roxas', 'guardian_occupation' => 'Receptionist', 'guardian_contact_number' => '09170002001', 'guardian_monthly_income' => 18000,
                'elementary_school_name' => 'N/A', 'elementary_school_address' => 'N/A', 'elementary_inclusive_years' => 'N/A',
                'junior_school_name' => 'N/A', 'junior_school_address' => 'N/A', 'junior_inclusive_years' => 'N/A',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 202600021, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(22),
                'level' => 'Kindergarten', 'student_type' => 'new', 'year_level' => null, 'strand' => null,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Castillo', 'first_name' => 'Mia', 'middle_name' => 'Santiago',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2020-08-19', 'place_of_birth' => 'Taguig City', 'civil_status' => 'Single',
                'zip_code' => 1632, 'present_address' => '30 McKinley Rd., BGC, Taguig', 'permanent_address' => '30 McKinley Rd., BGC, Taguig',
                'telephone_number' => null, 'mobile_number' => '09171234522', 'email' => 'mia.castillo@email.com',
                'mother_name' => 'Camille Santiago Castillo', 'mother_occupation' => 'Marketing Officer', 'mother_contact_number' => '09170003001', 'mother_monthly_income' => 35000,
                'father_name' => 'Jason Castillo', 'father_occupation' => 'Architect', 'father_contact_number' => '09170003002', 'father_monthly_income' => 45000,
                'guardian_name' => 'Camille Santiago Castillo', 'guardian_occupation' => 'Marketing Officer', 'guardian_contact_number' => '09170003001', 'guardian_monthly_income' => 35000,
                'elementary_school_name' => 'N/A', 'elementary_school_address' => 'N/A', 'elementary_inclusive_years' => 'N/A',
                'junior_school_name' => 'N/A', 'junior_school_address' => 'N/A', 'junior_inclusive_years' => 'N/A',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 202600022, 'status' => 'pending', 'reject_reason' => null,
            ],

            // ── NURSERY applicants — 2 applicants ──
            // All educational background = N/A.
            [
                'application_no' => $this->appNo(23),
                'level' => 'Nursery', 'student_type' => 'new', 'year_level' => null, 'strand' => null,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'De Guzman', 'first_name' => 'Gabriel', 'middle_name' => 'Panganiban',
                'sex' => 'Male', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2022-04-10', 'place_of_birth' => 'Makati City', 'civil_status' => 'Single',
                'zip_code' => 1210, 'present_address' => '5 Jupiter St., Makati City', 'permanent_address' => '5 Jupiter St., Makati City',
                'telephone_number' => null, 'mobile_number' => '09171234523', 'email' => 'gabriel.deguzman@email.com',
                'mother_name' => 'Joanna Panganiban De Guzman', 'mother_occupation' => 'Real Estate Agent', 'mother_contact_number' => '09170004001', 'mother_monthly_income' => 30000,
                'father_name' => 'Francis De Guzman', 'father_occupation' => 'Bank Teller', 'father_contact_number' => '09170004002', 'father_monthly_income' => 25000,
                'guardian_name' => 'Joanna Panganiban De Guzman', 'guardian_occupation' => 'Real Estate Agent', 'guardian_contact_number' => '09170004001', 'guardian_monthly_income' => 30000,
                'elementary_school_name' => 'N/A', 'elementary_school_address' => 'N/A', 'elementary_inclusive_years' => 'N/A',
                'junior_school_name' => 'N/A', 'junior_school_address' => 'N/A', 'junior_inclusive_years' => 'N/A',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 202600023, 'status' => 'pending', 'reject_reason' => null,
            ],
            [
                'application_no' => $this->appNo(24),
                'level' => 'Nursery', 'student_type' => 'new', 'year_level' => null, 'strand' => null,
                'first_program_choice' => null, 'second_program_choice' => null, 'third_program_choice' => null,
                'last_name' => 'Perez', 'first_name' => 'Isabella', 'middle_name' => 'Dela Rosa',
                'sex' => 'Female', 'citizenship' => 'Filipino', 'religion' => 'Roman Catholic',
                'birthdate' => '2022-07-25', 'place_of_birth' => 'Quezon City', 'civil_status' => 'Single',
                'zip_code' => 1105, 'present_address' => '100 Katipunan Ave., Quezon City', 'permanent_address' => '100 Katipunan Ave., Quezon City',
                'telephone_number' => null, 'mobile_number' => '09171234524', 'email' => 'isabella.perez@email.com',
                'mother_name' => 'Angelica Dela Rosa Perez', 'mother_occupation' => 'Freelance Writer', 'mother_contact_number' => '09170005001', 'mother_monthly_income' => 20000,
                'father_name' => 'Marco Perez', 'father_occupation' => 'Software Developer', 'father_contact_number' => '09170005002', 'father_monthly_income' => 50000,
                'guardian_name' => 'Angelica Dela Rosa Perez', 'guardian_occupation' => 'Freelance Writer', 'guardian_contact_number' => '09170005001', 'guardian_monthly_income' => 20000,
                'elementary_school_name' => 'N/A', 'elementary_school_address' => 'N/A', 'elementary_inclusive_years' => 'N/A',
                'junior_school_name' => 'N/A', 'junior_school_address' => 'N/A', 'junior_inclusive_years' => 'N/A',
                'senior_school_name' => 'N/A', 'senior_school_address' => 'N/A', 'senior_inclusive_years' => 'N/A',
                'college_school_name' => 'N/A', 'college_school_address' => 'N/A', 'college_inclusive_years' => 'N/A',
                'lrn' => 202600024, 'status' => 'pending', 'reject_reason' => null,
            ],
        ];

        foreach ($applicants as $data) {
            Applicant::firstOrCreate(
                ['application_no' => $data['application_no']],
                $data
            );
        }

        $this->command->info('Seeded: departments, programs, levels, academic terms, users (principal/guidance/proctor), schedules, and 24 applicants.');
    }
}
