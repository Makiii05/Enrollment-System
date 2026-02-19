<x-accounting_sidebar>

    @include('partials.notifications')

    <div class="flex items-center justify-between mb-4 px-4">
        <h2 class="font-bold text-4xl">Cashier</h2>
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('printDateModal').showModal()">
            Print Daily Report
        </button>
    </div>

    <!-- Search Section -->
    <div class="flex justify-end gap-2 mb-4 px-4">
        <input 
            type="text" 
            id="studentSearchInput" 
            placeholder="Search students by name, student number, program, etc..." 
            class="input input-bordered w-96"
        >
    </div>

    <!--TABLE-->
    <div data-table-wrapper>
    <!-- Hidden search input to prevent auto-injection -->
    <input type="hidden" data-table-search>
    <div class="overflow-x-auto bg-white shadow">
        <table class="table" data-sortable-table>
            <thead>
                <tr>
                    <th>Student No.</th>
                    <th>Full Name</th>
                    <th>Department</th>
                    <th>Program</th>
                    <th>Level</th>
                    <th data-no-sort>Action</th>
                </tr>
            </thead>
            <tbody id="studentTableBody">
                <tr id="initialMessage">
                    <td colspan="6" class="text-center text-gray-500 py-8">Enter a search term to find students.</td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('studentSearchInput');
        const tableBody = document.getElementById('studentTableBody');
        let debounceTimer;

        function performSearch() {
            const searchTerm = searchInput.value.trim();
            
            if (!searchTerm) {
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-gray-500 py-8">Enter a search term to find students.</td></tr>';
                return;
            }

            tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-gray-500 py-8"><span class="loading loading-spinner loading-sm"></span> Searching...</td></tr>';

            fetch(`{{ route('accounting.api.students.search') }}?search=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-gray-500 py-8">No students found.</td></tr>';
                        return;
                    }

                    tableBody.innerHTML = data.data.map(student => `
                        <tr>
                            <td>${student.student_number}</td>
                            <td>${student.last_name}, ${student.first_name} ${student.middle_name || ''}</td>
                            <td>${student.department?.code || '-'}</td>
                            <td>${student.program?.code || '-'}</td>
                            <td>${student.level?.description || '-'}</td>
                            <td>
                                <a href="/accounting/payment/${student.id}" class="btn btn-sm btn-primary">Pay</a>
                            </td>
                        </tr>
                    `).join('');
                })
                .catch(error => {
                    console.error('Search error:', error);
                    tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-red-500 py-8">Error searching students. Please try again.</td></tr>';
                });
        }

        // Search on input change with debounce
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(performSearch, 300);
        });
    });
    </script>

    @include('partials.table-sort-search')

    <!-- Print Date Modal -->
    <dialog id="printDateModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Print Daily Transaction Report</h3>
            <form action="{{ route('accounting.print.daily-transactions') }}" method="GET" target="_blank">
                <div class="form-control">
                    <label class="label"><span class="label-text">Select Date</span></label>
                    <input type="date" name="date" class="input input-bordered w-full" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" onclick="document.getElementById('printDateModal').close()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Print</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

</x-accounting_sidebar>
