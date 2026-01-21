<x-admission_sidebar>

    @include('partials.notifications')
    @include('partials.student-detail-modal')
    @include('partials.student-contact-modal')
    @include('partials.student-guardian-modal')
    @include('partials.student-academic-history-modal')

    <div class="flex items-center gap-4 mb-4">
        <h2 class="font-bold text-4xl flex-1">Students</h2>
        <div class="flex gap-2">
            <input type="text" id="searchInput" placeholder="Search students..." class="input input-bordered w-64" />
            <select id="statusFilter" class="select select-bordered">
                <option value="">All Status</option>
                <option value="enrolled">Enrolled</option>
                <option value="withdrawn">Withdrawn</option>
                <option value="dropped">Dropped</option>
                <option value="graduated">Graduated</option>
            </select>
        </div>
    </div>
    
    <!--TABLE-->
    <div class="overflow-x-auto bg-white shadow">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Student No.</th>
                    <th>Full Name</th>
                    <th>Department</th>
                    <th>Program</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                <tr>
                    <td>{{ $student->student_number }}</td>
                    <td>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}</td>
                    <td>{{ $student->department->code ?? '-' }}</td>
                    <td>{{ $student->program->code ?? '-' }}</td>
                    <td>{{ $student->level->code ?? '-' }}</td>
                    <td>{{ ucfirst($student->status) }}</td>
                    <td>
                        <div class="flex gap-1 flex-wrap">
                            <button 
                                type="button" 
                                class="btn btn-xs btn-primary"
                                onclick="openStudentDetailModal({{ json_encode($student->load(['department', 'program', 'level'])) }})"
                            >
                                Details
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-xs btn-info"
                                onclick="openStudentContactModal({{ json_encode($student->contact) }}, '{{ $student->student_number }}')"
                            >
                                Contact
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-xs btn-secondary"
                                onclick="openStudentGuardianModal({{ json_encode($student->guardian) }}, '{{ $student->student_number }}')"
                            >
                                Guardian
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-xs btn-accent"
                                onclick="openStudentAcademicHistoryModal({{ json_encode($student->academicHistory) }}, '{{ $student->student_number }}')"
                            >
                                Academic
                            </button>
                            <a 
                                href="{{ route('admission.student.edit', $student->id) }}" 
                                class="btn btn-xs btn-warning"
                            >
                                Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-8">No students found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($students) && $students->hasPages())
    <div class="mt-4">
        {{ $students->links() }}
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const tableRows = document.querySelectorAll('tbody tr');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value.toLowerCase();

                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const statusCell = row.querySelector('td:nth-child(6)')?.textContent.toLowerCase().trim() || '';
                    
                    const matchesSearch = text.includes(searchTerm);
                    const matchesStatus = statusValue === '' || statusCell.includes(statusValue);
                    
                    row.style.display = matchesSearch && matchesStatus ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
        });
    </script>

</x-admission_sidebar>        