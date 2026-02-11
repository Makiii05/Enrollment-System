<x-department_sidebar>

    @include('partials.notifications')

    <div class="flex items-center gap-4 mb-4">
        <h2 class="font-bold text-4xl">Enlistment</h2>
        @if(isset($academicTerm))
        <h2 class="flex-1 text-2xl"><span>(Academic Term: <strong>{{ $academicTerm->description }}</strong>)</span></h2>
        @endif
        <div class="flex gap-2">
            <input type="text" id="searchInput" placeholder="Search students..." class="input input-bordered w-64" />
            <select id="statusFilter" class="select select-bordered">
                <option value="">All Status</option>
                <option value="enrolled">Enrolled</option>
                <option value="regular">Regular</option>
                <option value="irregular">Irregular</option>
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
                    <th>Program</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                <tr class="hover:bg-base-200 cursor-pointer" onclick="window.location='#'">
                    <td>{{ $student->student_number }}</td>
                    <td>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}</td>
                    <td>{{ $student->program->code ?? '-' }}</td>
                    <td>{{ $student->level->description ?? '-' }}</td>
                    <td>{{ ucfirst($student->status) }}</td>
                    <td>
                        <div class="flex gap-1 flex-wrap">
                            <button 
                                type="button" 
                                class="btn btn-sm btn-ghost text-primary font-semibold"
                                onclick="event.stopPropagation();"
                            >
                                View Subject
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-8">No students found.</td>
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
                    const statusCell = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase().trim() || '';
                    
                    const matchesSearch = text.includes(searchTerm);
                    const matchesStatus = statusValue === '' || statusCell.includes(statusValue);
                    
                    row.style.display = matchesSearch && matchesStatus ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
        });
    </script>

</x-department_sidebar>
