<x-accounting_sidebar>

    @include('partials.notifications')

    <div class="flex items-center gap-4 mb-4">
        <a href="{{ route('accounting.cashier') }}" class="btn btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Back
        </a>
        <h2 class="font-bold text-4xl">Payment</h2>
        <select id="academicTermSelect" class="select select-bordered select-sm">
            <option value="">-- Select Academic Term --</option>
            @foreach ($academicTerms as $term)
                <option value="{{ $term->id }}">{{ $term->description }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex gap-5">
        <!-- LEFT SECTION: Student Info + Transaction Form + Transaction Table -->
        <div class="w-1/2 flex flex-col gap-5">
            <!-- Student Info Box -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Student Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-semibold text-gray-500">Student No.</span>
                        <p class="text-base">{{ $student->student_number }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-500">Name</span>
                        <p class="text-base">{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-500">Program</span>
                        <p class="text-base">{{ $student->program->code ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-500">Department</span>
                        <p class="text-base">{{ $student->department->code ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-500">Year Level</span>
                        <p class="text-base">{{ $student->level->description ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-500">Contact No.</span>
                        <p class="text-base">{{ $student->contact->mobile_number ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Add Transaction Form -->
            <div class="bg-white shadow rounded-lg p-6 hidden" id="transactionFormSection">
                <h3 class="font-semibold text-lg mb-4">Add Transaction</h3>
                <form id="transactionForm" class="space-y-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">OR Number</span></label>
                            <input type="text" id="orNumber" name="or_number" class="input input-bordered input-sm w-full bg-gray-100">
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Date</span></label>
                            <input type="date" id="transactionDate" name="date" class="input input-bordered input-sm w-full" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Type</span></label>
                            <select id="transactionType" name="type" class="select select-bordered select-sm w-full" required>
                                <option value="">-- Select Type --</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Description</span></label>
                            <select id="transactionDescription" name="description" class="select select-bordered select-sm w-full" required>
                                <option value="">-- Select Description --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Amount</span></label>
                        <input type="number" id="transactionAmount" name="amount" class="input input-bordered input-sm w-full" placeholder="Enter amount" step="0.01" min="0" required>
                    </div>
                    <div class="flex gap-2 justify-end mt-4">
                        <button type="reset" class="btn btn-ghost btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="submitTransactionBtn" disabled>
                            <span id="submitTransactionText">Add Transaction</span>
                            <span id="submitTransactionLoading" class="loading loading-spinner loading-xs hidden"></span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Transaction Table -->
            <div class="bg-white shadow rounded-lg p-6 hidden" id="transactionTableSection">
                <h3 class="font-semibold text-lg mb-4">Transaction History</h3>
                <div class="overflow-x-auto">
                    <table class="table table-zebra table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>OR No.</th>
                                <th>Description</th>
                                <th class="text-end">Amount</th>
                                <th class="w-24">Action</th>
                            </tr>
                        </thead>
                        <tbody id="transactionTableBody">
                            <tr><td colspan="5" class="text-center text-gray-500 py-4">Select an academic term.</td></tr>
                        </tbody>
                        <tfoot id="transactionTableFoot" class="hidden">
                            <tr class="font-semibold">
                                <td colspan="3" class="text-end">Total:</td>
                                <td class="text-end" id="transactionTotal">0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- RIGHT SECTION: Schedule of Fees & Fee Summary -->
        <div class="w-1/2 flex flex-col gap-5">
            <div class="bg-white shadow rounded-lg p-6 hidden" id="feeDetailsSection">
                <div class="flex gap-6">
                    <!-- Left: Schedule of Fees -->
                    <div class="flex-1">
                        <h4 class="font-semibold text-lg mb-4">Schedule of Fees</h4>
                        <div class="overflow-x-auto">
                            <table class="table table-zebra table-sm">
                                <thead>
                                    <tr><th>Schedule</th><th class="text-end">Amount</th></tr>
                                </thead>
                                <tbody id="scheduleFeesBody">
                                    <tr><td>Down Payment</td><td class="text-end" id="schedDownPayment">0.00</td></tr>
                                    <tr><td>1st Month Pay</td><td class="text-end" id="sched1stMonth">0.00</td></tr>
                                    <tr><td>2nd Month Pay</td><td class="text-end" id="sched2ndMonth">0.00</td></tr>
                                    <tr><td>3rd Month Pay</td><td class="text-end" id="sched3rdMonth">0.00</td></tr>
                                    <tr><td>4th Month Pay</td><td class="text-end" id="sched4thMonth">0.00</td></tr>
                                </tbody>
                                <tfoot>
                                    <tr class="font-semibold"><td>Total</td><td class="text-end" id="schedTotal">0.00</td></tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Right: Fee Summary -->
                    <div class="flex-1">
                        <h4 class="font-semibold text-lg mb-4">Fee Summary</h4>
                        <div class="overflow-x-auto">
                            <table class="table table-sm">
                                <tbody>
                                    <tr class=""><td>Total Amount to Pay</td><td class="text-end" id="summaryAmountToPay">0.00</td></tr>
                                    <tr class=""><td>Amount Paid</td><td class="text-end" id="summaryAmountPaid">0.00</td></tr>
                                    <tr class="font-bold"><td>Balance</td><td class="text-end" id="summaryBalance">0.00</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const studentId = {{ $student->id }};
        const studentFeesApiUrl = '{{ url("/accounting/api/student-fees") }}';
        const enlistmentsApiUrl = '{{ url("/accounting/api/enlistments") }}';
        const transactionsApiUrl = '{{ url("/accounting/api/transactions") }}';
        const paymentAccountsApiUrl = '{{ url("/accounting/api/payment-accounts") }}';
        const paymentTypesApiUrl = '{{ url("/accounting/api/payment-types") }}';
        const nextOrNumberApiUrl = '{{ url("/accounting/api/next-or-number") }}';
        const csrfToken = '{{ csrf_token() }}';

        function getSelectedTermId() {
            return document.getElementById('academicTermSelect').value;
        }

        // Number Formatting
        function formatMoney(value) {
            return Number(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }

        // Toggle submit button based on semester selection
        function updateSubmitButtonState() {
            const termId = getSelectedTermId();
            const btn = document.getElementById('submitTransactionBtn');
            btn.disabled = !termId;
        }

        // Toggle visibility of sections based on semester selection
        function updateSectionVisibility() {
            const termId = getSelectedTermId();
            const sections = ['transactionFormSection', 'transactionTableSection', 'feeDetailsSection'];
            sections.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    if (termId) {
                        el.classList.remove('hidden');
                    } else {
                        el.classList.add('hidden');
                    }
                }
            });
        }

        // Academic Term Change
        document.getElementById('academicTermSelect').addEventListener('change', function () {
            const termId = this.value;
            updateSectionVisibility();
            loadEnlistments(termId);
            loadStudentFees(termId);
            loadTransactions(termId);
            updateSubmitButtonState();
        });

        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('academicTermSelect');
            
            // Load dropdown options
            loadPaymentAccounts();
            loadPaymentTypes();
            loadNextOrNumber();
            
            // Update button state and section visibility
            updateSubmitButtonState();
            updateSectionVisibility();
            
            if (select.value) {
                loadEnlistments(select.value);
                loadStudentFees(select.value);
                loadTransactions(select.value);
            }
        });

        // Load Payment Accounts for Description dropdown
        async function loadPaymentAccounts() {
            try {
                const response = await fetch(paymentAccountsApiUrl);
                const result = await response.json();
                const select = document.getElementById('transactionDescription');
                
                select.innerHTML = '<option value="">-- Select Description --</option>';
                result.data.forEach(account => {
                    select.innerHTML += `<option value="${account.description}">${account.description}</option>`;
                });
            } catch (error) {
                console.error('Error loading payment accounts:', error);
            }
        }

        // Load Payment Types for Type dropdown
        async function loadPaymentTypes() {
            try {
                const response = await fetch(paymentTypesApiUrl);
                const result = await response.json();
                const select = document.getElementById('transactionType');
                
                select.innerHTML = '<option value="">-- Select Type --</option>';
                result.data.forEach(type => {
                    select.innerHTML += `<option value="${type.description}">${type.description}</option>`;
                });
            } catch (error) {
                console.error('Error loading payment types:', error);
            }
        }

        // Load Next OR Number
        async function loadNextOrNumber() {
            try {
                const response = await fetch(nextOrNumberApiUrl);
                const result = await response.json();
                document.getElementById('orNumber').value = result.or_number;
            } catch (error) {
                console.error('Error loading next OR number:', error);
            }
        }

        // Track enlistment count for Unit Fee calculation
        let currentEnlistmentCount = 0;

        async function loadEnlistments(academicTermId) {
            if (!academicTermId) {
                currentEnlistmentCount = 0;
                return;
            }

            try {
                const response = await fetch(`${enlistmentsApiUrl}/${studentId}/${academicTermId}`);
                if (!response.ok) throw new Error('Failed to fetch');
                const result = await response.json();
                currentEnlistmentCount = result.data ? result.data.length : 0;
            } catch (error) {
                console.error('Error loading enlistments:', error);
                currentEnlistmentCount = 0;
            }
        }

        // Track fee totals for summary panel
        let feeTotals = { major: 0, other: 0, additional: 0 };
        let totalAmountPaid = 0;

        async function loadStudentFees(academicTermId) {
            if (!academicTermId) {
                resetFeeSummary();
                return;
            }

            try {
                const response = await fetch(`${studentFeesApiUrl}/${studentId}/${academicTermId}`);
                if (!response.ok) throw new Error('Failed to fetch');
                const result = await response.json();
                const data = result.data;

                // Calculate totals
                feeTotals.major = calculateFeeTotal(data.major);
                feeTotals.other = calculateFeeTotal(data.other);
                feeTotals.additional = calculateFeeTotal(data.additional);
                
                updateFeeSummary();
            } catch (error) {
                console.error('Error loading fees:', error);
            }
        }

        function calculateFeeTotal(fees) {
            if (!fees || fees.length === 0) return 0;
            let total = 0;
            fees.forEach(f => {
                let amount = parseFloat(f.amount) || 0;
                if (f.description && f.description.toLowerCase() === 'unit fee') {
                    amount = amount * currentEnlistmentCount;
                }
                total += amount;
            });
            return total;
        }

        function resetFeeSummary() {
            feeTotals = { major: 0, other: 0, additional: 0 };
            totalAmountPaid = 0;
            document.getElementById('summaryAmountToPay').textContent = '0.00';
            document.getElementById('summaryAmountPaid').textContent = '0.00';
            document.getElementById('summaryBalance').textContent = '0.00';
            
            // Reset schedule
            document.getElementById('schedDownPayment').textContent = '0.00';
            document.getElementById('sched1stMonth').textContent = '0.00';
            document.getElementById('sched2ndMonth').textContent = '0.00';
            document.getElementById('sched3rdMonth').textContent = '0.00';
            document.getElementById('sched4thMonth').textContent = '0.00';
            document.getElementById('schedTotal').textContent = '0.00';
        }

        function updateFeeSummary() {
            const majorTotal = feeTotals.major || 0;
            const otherTotal = feeTotals.other || 0;
            const additionalTotal = feeTotals.additional || 0;
            const gross = majorTotal + otherTotal + additionalTotal;

            document.getElementById('summaryAmountToPay').textContent = formatMoney(gross);
            
            const balance = gross - totalAmountPaid;
            
            document.getElementById('summaryAmountPaid').textContent = formatMoney(totalAmountPaid);
            document.getElementById('summaryBalance').textContent = formatMoney(balance);

            // Update schedule of fees (simple computation)
            computeSchedule(gross);
        }

        function computeSchedule(grossTotal) {
            // Simple schedule: 20% down payment, 20% each for 4 months
            const downPayment = grossTotal * 0.20;
            const monthlyPay = grossTotal * 0.20;

            document.getElementById('schedDownPayment').textContent = formatMoney(downPayment);
            document.getElementById('sched1stMonth').textContent = formatMoney(monthlyPay);
            document.getElementById('sched2ndMonth').textContent = formatMoney(monthlyPay);
            document.getElementById('sched3rdMonth').textContent = formatMoney(monthlyPay);
            document.getElementById('sched4thMonth').textContent = formatMoney(monthlyPay);
            document.getElementById('schedTotal').textContent = formatMoney(grossTotal);
        }

        // ── Transactions ──────────────────────────────────────
        async function loadTransactions(academicTermId) {
            const tbody = document.getElementById('transactionTableBody');
            const tfoot = document.getElementById('transactionTableFoot');
            const totalEl = document.getElementById('transactionTotal');

            if (!academicTermId) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-gray-500 py-4">Select an academic term.</td></tr>';
                tfoot.classList.add('hidden');
                totalAmountPaid = 0;
                updateFeeSummary();
                return;
            }

            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-gray-500 py-4"><span class="loading loading-spinner loading-sm"></span> Loading...</td></tr>';

            try {
                const response = await fetch(`${transactionsApiUrl}/${studentId}/${academicTermId}`);
                if (!response.ok) throw new Error('Failed to fetch');
                const result = await response.json();

                tbody.innerHTML = '';
                let total = 0;

                if (result.data && result.data.length > 0) {
                    result.data.forEach(t => {
                        const amount = parseFloat(t.amount) || 0;
                        total += amount;
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${formatDate(t.date)}</td>
                            <td>${t.or_number || '-'}</td>
                            <td>${t.description}</td>
                            <td class="text-end">${formatMoney(amount)}</td>
                            <td>
                                <div class="flex gap-1">
                                    <button class="btn btn-ghost btn-xs" onclick="printTransaction(${t.id})">Print</button>
                                    <button class="btn btn-ghost btn-xs text-red-500" onclick="deleteTransaction(${t.id})">Delete</button>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                    totalEl.textContent = formatMoney(total);
                    tfoot.classList.remove('hidden');
                } else {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-gray-500 py-4">No transactions found.</td></tr>';
                    tfoot.classList.add('hidden');
                }

                totalAmountPaid = total;
                updateFeeSummary();
            } catch (error) {
                console.error('Error loading transactions:', error);
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-red-500 py-4">Error loading transactions.</td></tr>';
                tfoot.classList.add('hidden');
            }
        }

        // Add Transaction
        document.getElementById('transactionForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const termId = getSelectedTermId();
            if (!termId) {
                alert('Please select an academic term first.');
                return;
            }

            const btn = document.getElementById('submitTransactionBtn');
            const btnText = document.getElementById('submitTransactionText');
            const btnLoading = document.getElementById('submitTransactionLoading');

            btn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            const formData = {
                student_id: studentId,
                academic_term_id: termId,
                or_number: document.getElementById('orNumber').value,
                type: document.getElementById('transactionType').value,
                description: document.getElementById('transactionDescription').value,
                amount: document.getElementById('transactionAmount').value,
                date: document.getElementById('transactionDate').value,
            };

            try {
                const response = await fetch(`${transactionsApiUrl}/create`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(formData),
                });

                if (!response.ok) throw new Error('Failed to create');
                
                // Reset form but keep date
                document.getElementById('transactionType').selectedIndex = 0;
                document.getElementById('transactionDescription').selectedIndex = 0;
                document.getElementById('transactionAmount').value = '';
                document.getElementById('transactionDate').value = new Date().toISOString().split('T')[0];
                
                // Reload OR number and transactions
                loadNextOrNumber();
                loadTransactions(termId);
            } catch (error) {
                console.error('Error creating transaction:', error);
                alert('Error creating transaction. Please try again.');
            } finally {
                updateSubmitButtonState();
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            }
        });

        async function deleteTransaction(id) {
            if (!confirm('Are you sure you want to delete this transaction?')) return;

            try {
                const response = await fetch(`${transactionsApiUrl}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                if (!response.ok) throw new Error('Failed to delete');
                
                loadTransactions(getSelectedTermId());
                loadNextOrNumber();
            } catch (error) {
                console.error('Error deleting transaction:', error);
                alert('Error deleting transaction. Please try again.');
            }
        }

        function printTransaction(id) {
            window.open('{{ url("/accounting/print/sales-invoice") }}/' + id, '_blank');
        }
    </script>

</x-accounting_sidebar>
