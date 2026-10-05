<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::pluck('id', 'code');

        $courses = [
            // =========================
            // Computer Science - CS
            // =========================
            [
                'name' => 'Introduction to Programming',
                'code' => 'CS101',
                'description' => 'Fundamentals of programming, algorithms, and problem solving.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'CS',
            ],
            [
                'name' => 'Data Structures',
                'code' => 'CS201',
                'description' => 'Study of fundamental data structures and their algorithms.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'CS',
            ],
            [
                'name' => 'Database Systems',
                'code' => 'CS301',
                'description' => 'Relational databases, SQL, normalization, and database design.',
                'credits' => 3,
                'semester_level' => 3,
                'department_code' => 'CS',
            ],
            [
                'name' => 'Operating Systems',
                'code' => 'CS302',
                'description' => 'Processes, threads, memory management, and file systems.',
                'credits' => 3,
                'semester_level' => 3,
                'department_code' => 'CS',
            ],
            [
                'name' => 'Computer Networks',
                'code' => 'CS303',
                'description' => 'Network architectures, protocols, routing, and network security fundamentals.',
                'credits' => 3,
                'semester_level' => 3,
                'department_code' => 'CS',
            ],
            [
                'name' => 'Artificial Intelligence',
                'code' => 'CS401',
                'description' => 'Introduction to artificial intelligence, search, reasoning, and intelligent agents.',
                'credits' => 3,
                'semester_level' => 4,
                'department_code' => 'CS',
            ],

            // =========================
            // Information Systems - IS
            // =========================
            [
                'name' => 'Systems Analysis and Design',
                'code' => 'IS201',
                'description' => 'Methods and techniques for analyzing and designing information systems.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'IS',
            ],
            [
                'name' => 'Information Systems Management',
                'code' => 'IS301',
                'description' => 'Management principles and practices for organizational information systems.',
                'credits' => 3,
                'semester_level' => 3,
                'department_code' => 'IS',
            ],
            [
                'name' => 'Enterprise Systems',
                'code' => 'IS401',
                'description' => 'Enterprise applications, integration, and business process management.',
                'credits' => 3,
                'semester_level' => 4,
                'department_code' => 'IS',
            ],

            // =========================
            // Software Engineering - SE
            // =========================
            [
                'name' => 'Software Engineering Fundamentals',
                'code' => 'SE201',
                'description' => 'Software development processes, methodologies, and engineering practices.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'SE',
            ],
            [
                'name' => 'Software Architecture',
                'code' => 'SE301',
                'description' => 'Architectural styles, design principles, and software architecture patterns.',
                'credits' => 3,
                'semester_level' => 3,
                'department_code' => 'SE',
            ],
            [
                'name' => 'Software Testing',
                'code' => 'SE302',
                'description' => 'Software testing techniques, test planning, and quality assurance.',
                'credits' => 3,
                'semester_level' => 3,
                'department_code' => 'SE',
            ],
            [
                'name' => 'Software Project Management',
                'code' => 'SE401',
                'description' => 'Planning, estimation, risk management, and delivery of software projects.',
                'credits' => 3,
                'semester_level' => 4,
                'department_code' => 'SE',
            ],

            // =========================
            // Civil Engineering - CE
            // =========================
            [
                'name' => 'Engineering Mechanics',
                'code' => 'CE101',
                'description' => 'Fundamental principles of statics and mechanics for engineering applications.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'CE',
            ],
            [
                'name' => 'Structural Analysis',
                'code' => 'CE301',
                'description' => 'Analysis of structures under different loading conditions.',
                'credits' => 3,
                'semester_level' => 3,
                'department_code' => 'CE',
            ],

            // =========================
            // Electrical Engineering - EE
            // =========================
            [
                'name' => 'Electrical Circuits',
                'code' => 'EE101',
                'description' => 'Fundamental concepts of electrical circuits and circuit analysis.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'EE',
            ],
            [
                'name' => 'Digital Logic Design',
                'code' => 'EE201',
                'description' => 'Digital systems, logic gates, Boolean algebra, and combinational circuits.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'EE',
            ],

            // =========================
            // Mechanical Engineering - ME
            // =========================
            [
                'name' => 'Thermodynamics',
                'code' => 'ME201',
                'description' => 'Fundamental laws of thermodynamics and engineering applications.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'ME',
            ],
            [
                'name' => 'Fluid Mechanics',
                'code' => 'ME301',
                'description' => 'Behavior of fluids and fundamental principles of fluid flow.',
                'credits' => 3,
                'semester_level' => 3,
                'department_code' => 'ME',
            ],

            // =========================
            // Mathematics - MATH
            // =========================
            [
                'name' => 'Calculus I',
                'code' => 'MATH101',
                'description' => 'Limits, derivatives, integrals, and applications of calculus.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'MATH',
            ],
            [
                'name' => 'Calculus II',
                'code' => 'MATH102',
                'description' => 'Advanced integration techniques, sequences, series, and applications.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'MATH',
            ],
            [
                'name' => 'Linear Algebra',
                'code' => 'MATH201',
                'description' => 'Vectors, matrices, linear transformations, and systems of equations.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'MATH',
            ],

            // =========================
            // Physics - PHY
            // =========================
            [
                'name' => 'General Physics I',
                'code' => 'PHY101',
                'description' => 'Mechanics, motion, forces, work, and energy.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'PHY',
            ],
            [
                'name' => 'General Physics II',
                'code' => 'PHY102',
                'description' => 'Electricity, magnetism, waves, and basic optics.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'PHY',
            ],

            // =========================
            // Chemistry - CHEM
            // =========================
            [
                'name' => 'General Chemistry',
                'code' => 'CHEM101',
                'description' => 'Fundamental concepts of chemistry, matter, reactions, and chemical bonding.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'CHEM',
            ],
            [
                'name' => 'Organic Chemistry',
                'code' => 'CHEM201',
                'description' => 'Structure, properties, reactions, and synthesis of organic compounds.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'CHEM',
            ],

            // =========================
            // Business Administration - BA
            // =========================
            [
                'name' => 'Principles of Management',
                'code' => 'BA101',
                'description' => 'Fundamental principles of management and organizational behavior.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'BA',
            ],
            [
                'name' => 'Marketing Principles',
                'code' => 'BA201',
                'description' => 'Marketing concepts, strategies, consumer behavior, and market analysis.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'BA',
            ],

            // =========================
            // Accounting - ACC
            // =========================
            [
                'name' => 'Financial Accounting',
                'code' => 'ACC101',
                'description' => 'Fundamentals of financial accounting and preparation of financial statements.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'ACC',
            ],
            [
                'name' => 'Management Accounting',
                'code' => 'ACC201',
                'description' => 'Accounting information for planning, decision making, and management control.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'ACC',
            ],

            // =========================
            // Finance - FIN
            // =========================
            [
                'name' => 'Financial Management',
                'code' => 'FIN201',
                'description' => 'Financial decision making, capital budgeting, and financial planning.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'FIN',
            ],
            [
                'name' => 'Investment Analysis',
                'code' => 'FIN301',
                'description' => 'Analysis of investments, risk, return, and portfolio management.',
                'credits' => 3,
                'semester_level' => 3,
                'department_code' => 'FIN',
            ],

            // =========================
            // English Language - ENG-L
            // =========================
            [
                'name' => 'Academic English',
                'code' => 'ENG101',
                'description' => 'Academic reading, writing, vocabulary, and communication skills.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'ENG-L',
            ],
            [
                'name' => 'Advanced English',
                'code' => 'ENG201',
                'description' => 'Advanced academic communication, writing, and presentation skills.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'ENG-L',
            ],

            // =========================
            // History - HIS
            // =========================
            [
                'name' => 'World History',
                'code' => 'HIS101',
                'description' => 'Major historical developments and civilizations throughout world history.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'HIS',
            ],
            [
                'name' => 'Modern History',
                'code' => 'HIS201',
                'description' => 'Major political, social, and economic developments in the modern era.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'HIS',
            ],

            // =========================
            // Arabic Language - AR
            // =========================
            [
                'name' => 'Arabic Language Skills',
                'code' => 'AR101',
                'description' => 'Fundamentals of Arabic grammar, writing, reading, and communication.',
                'credits' => 3,
                'semester_level' => 1,
                'department_code' => 'AR',
            ],
            [
                'name' => 'Arabic Literature',
                'code' => 'AR201',
                'description' => 'Introduction to major works, genres, and developments in Arabic literature.',
                'credits' => 3,
                'semester_level' => 2,
                'department_code' => 'AR',
            ],
        ];

        foreach ($courses as $course) {
            Course::create([
                'name' => $course['name'],
                'code' => $course['code'],
                'description' => $course['description'],
                'credits' => $course['credits'],
                'semester_level' => $course['semester_level'],
                'department_id' => $departments[$course['department_code']],
            ]);
        }
    }
}