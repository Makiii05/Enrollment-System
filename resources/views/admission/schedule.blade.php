<x-admission_sidebar>

    <div class="m-4 font-bold text-4xl">
        <h2>Schedule</h2>
    </div>

    @include('partials.notifications')
    @include('partials.schedule-applicants-modal')
    @if(auth()->user()->role == 'head')
    <div class="m-4 grid">
        <button class="btn w-auto justify-self-end bg-white shadow" onclick="form_modal.showModal()">Add Schedule</button>
    </div>
    <dialog id="form_modal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold mb-4">Add Schedule</h3>
            <form action="{{ route('admission.schedule.create') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Proctor</span>
                    </label>
                    <select name="proctor_id" class="select select-bordered w-full" required>
                        <option value="">Select Proctor</option>
                        @foreach($proctors as $proctor)
                            <option value="{{ $proctor->id }}">{{ $proctor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Date</span>
                    </label>
                    <input type="date" name="date" class="input input-bordered w-full" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Start Time</span>
                        </label>
                        <input type="time" name="start_time" class="input input-bordered w-full" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">End Time</span>
                        </label>
                        <input type="time" name="end_time" class="input input-bordered w-full" required>
                    </div>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Process</span>
                    </label>
                    <select name="process" class="select select-bordered w-full">
                        <option value="exam">Exam</option>
                        <option value="interview">Interview</option>
                        <option value="evaluation">Evaluation</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select name="status" class="select select-bordered w-full">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn" onclick="form_modal.close()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Schedule</button>
                </div>
            </form>
        </div>
    </dialog>
    @endif
    <!--TABLE-->
    <div class="overflow-x-auto bg-white shadow">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Proctor</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Type</th>
                    <th>Applicants</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                <tr>
                    <td>{{$schedule->id}}</td>
                    <td>{{ $schedule->proctor?->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->date)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                    <td>{{ $schedule->process }}</td>
                    <td>{{ $schedule->applicants->count() }}</td>
                    <td>{{ $schedule->status }}</td>
                    <td class="flex gap-2 items-center">
                        @if(auth()->user()->role === 'proctor')
                            {{-- Proctor: redirect to appropriate process page --}}
                            @php
                                $redirectRoute = match($schedule->process) {
                                    'exam' => route('admission.exam'),
                                    'interview' => route('admission.interview'),
                                    'evaluation' => route('admission.evaluation'),
                                    default => route('admission.exam'),
                                };
                            @endphp
                            <a href="{{ $redirectRoute }}?schedule_id={{ $schedule->id }}" class="text-blue-600 hover:underline">view</a>
                            <a href="{{ route('admission.print.schedule.applicants', $schedule->id) }}" target="_blank" class="text-purple-600 hover:underline">print</a>
                        @else
                            <button 
                                class="text-blue-600 hover:underline"
                                onclick="showScheduleApplicants(
                                    {{ $schedule->id }}, 
                                    '{{ $schedule->proctor?->name ?? 'N/A' }}', 
                                    '{{ \Carbon\Carbon::parse($schedule->date)->format('M d, Y') }}', 
                                    '{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}', 
                                    '{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}', 
                                    '{{ $schedule->process }}',
                                    '{{ $schedule->applicants->map(fn($a) => [
                                        'application_no' => $a->application_no,
                                        'last_name' => $a->last_name,
                                        'first_name' => $a->first_name,
                                        'middle_name' => $a->middle_name,
                                        'email' => $a->email,
                                        'mobile_number' => $a->mobile_number,
                                        'status' => $a->status
                                    ])->values()->toJson() }}'
                                )"
                            >view</button>
                            <a href="{{ route('admission.print.schedule.applicants', $schedule->id) }}" target="_blank" class="text-purple-600 hover:underline">print</a>
                        @endif
                        @if(auth()->user()->role == 'head')
                        <button class="text-green-600 hover:underline" onclick="editSchedule({{ $schedule->id }}, {{ $schedule->proctor_id ?? 'null' }}, '{{ $schedule->date->format('Y-m-d') }}', '{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}', '{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}', '{{ $schedule->status }}', '{{ $schedule->process }}')">edit</button>
                        <form action="{{ route('admission.schedule.delete', $schedule->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $schedules->links() }}
    </div>
    
    <script>
        const proctorsList = @json($proctors);
        
        function editSchedule(id, proctorId, date, start_time, end_time, status, process) {
            const proctorOptions = proctorsList.map(p => 
                `<option value="${p.id}" ${p.id === proctorId ? 'selected' : ''}>${p.name}</option>`
            ).join('');
            
            document.getElementById('form_modal').innerHTML = `
                <div class="modal-box w-11/12 max-w-5xl">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <h3 class="text-lg font-bold mb-4">Edit Schedule</h3>
                    <form action="/admission/schedules/${id}/update" method="POST" class="space-y-4">
                        @csrf
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Proctor</span>
                            </label>
                            <select name="proctor_id" class="select select-bordered w-full" required>
                                <option value="">Select Proctor</option>
                                ${proctorOptions}
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Date</span>
                            </label>
                            <input type="date" name="date" class="input input-bordered w-full" value="${date}" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Start Time</span>
                                </label>
                                <input type="time" name="start_time" class="input input-bordered w-full" value="${start_time}" required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">End Time</span>
                                </label>
                                <input type="time" name="end_time" class="input input-bordered w-full" value="${end_time}" required>
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Process</span>
                            </label>
                            <select name="process" class="select select-bordered w-full">
                                <option value="exam" ${process === 'exam' ? 'selected' : ''}>Exam</option>
                                <option value="interview" ${process === 'interview' ? 'selected' : ''}>Interview</option>
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Status</span>
                            </label>
                            <select name="status" class="select select-bordered w-full">
                                <option value="active" ${status === 'active' ? 'selected' : ''}>Active</option>
                                <option value="inactive" ${status === 'inactive' ? 'selected' : ''}>Inactive</option>
                            </select>
                        </div>

                        <div class="modal-action">
                            <button type="button" class="btn" onclick="form_modal.close()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Schedule</button>
                        </div>
                    </form>
                </div>
            `;
            form_modal.showModal();
        }
    </script>
</x-admission_sidebar>
