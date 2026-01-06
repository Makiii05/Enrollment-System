<x-layout>
    <div class="w-full p-6 max-w-7xl mx-auto">
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Submit Application</h3>
            <p class="text-gray-500 text-sm mt-1">Please fill out all required fields to complete your application.</p>
        </div>
        
        <form action="{{ route('applicant.create') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Applying For Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-3">
                    <h4 class="text-gray-800 font-semibold">Application No.</h4>
                </div>
                <div class="p-6 grid grid-cols-12 gap-4">
                    <div class="form-control col-span-4">
                        <input type="text" readonly name="application_no" class="input input-bordered w-full bg-white" placeholder="Enter application number" value="00000000000" required>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-3">
                    <h4 class="text-gray-800 font-semibold">Applying For</h4>
                </div>
                <div class="p-6 grid grid-cols-12 gap-4">
                    <div class="form-control col-span-3">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Level</label>
                        <select name="level" class="select select-bordered w-full bg-white" required>
                            <option value="">-- Select Level --</option>
                            <option value="nursery">Nursery</option>
                            <option value="kindergarten">Kindergarten</option>
                            <option value="grade school">Grade School</option>
                            <option value="junior high school">Junior High School</option>
                            <option value="senior high school">Senior High School</option>
                            <option value="college">College</option>
                        </select>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Student Type</label>
                        <select name="student_type" class="select select-bordered w-full bg-white" required>
                            <option value="">-- Select Type --</option>
                            <option value="new">New</option>
                            <option value="transferee">Transferee</option>
                        </select>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Year Level</label>
                        <select name="year_level" class="select select-bordered w-full bg-white" required>
                            <option value="">-- Select Year --</option>
                        </select>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Strand</label>
                        <select name="strand" class="select select-bordered w-full bg-white" required>
                            <option value="">-- Select Strand --</option>
                        </select>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">First Choice Program</label>
                        <select name="first_program_choice" class="select select-bordered w-full bg-white" required>
                            <option value="">-- Select Program --</option>
                        </select>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Second Choice Program</label>
                        <select name="second_program_choice" class="select select-bordered w-full bg-white" required>
                            <option value="">-- Select Program --</option>
                        </select>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Third Choice Program</label>
                        <select name="third_program_choice" class="select select-bordered w-full bg-white" required>
                            <option value="">-- Select Program --</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-3">
                    <h4 class="text-gray-800 font-semibold">Personal Information</h4>
                </div>
                <div class="p-6 grid grid-cols-12 gap-4">
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Last Name</label>
                        <input type="text" name="last_name" class="input input-bordered w-full bg-white" placeholder="Enter last name" required>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">First Name</label>
                        <input type="text" name="first_name" class="input input-bordered w-full bg-white" placeholder="Enter first name" required>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Middle Name</label>
                        <input type="text" name="middle_name" class="input input-bordered w-full bg-white" placeholder="Enter middle name" required>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Sex</label>
                        <select name="sex" class="select select-bordered w-full bg-white" required>
                            <option value="">-- Select Sex --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Citizenship</label>
                        <input type="text" name="citizenship" class="input input-bordered w-full bg-white" placeholder="Enter citizenship" required>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Religion</label>
                        <input type="text" name="religion" class="input input-bordered w-full bg-white" placeholder="Enter religion" required>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Birthdate</label>
                        <input type="date" name="birthdate" class="input input-bordered w-full bg-white" required>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Birth Place</label>
                        <input type="text" name="birth_place" class="input input-bordered w-full bg-white" placeholder="Enter birth place" required>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Civil Status</label>
                        <select name="civil_status" class="select select-bordered w-full bg-white" required>
                            <option value="">-- Select Status --</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="widowed/widower">Widowed/Widower</option>
                        </select>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Zip Code</label>
                        <input type="text" name="zip_code" class="input input-bordered w-full bg-white" placeholder="Enter zip code" required>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Present Address</label>
                        <input type="text" name="present_address" class="input input-bordered w-full bg-white" placeholder="Enter present address" required>
                    </div>
                    <div class="form-control col-span-4">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Permanent Address</label>
                        <input type="text" name="permanent_address" class="input input-bordered w-full bg-white" placeholder="Enter permanent address" required>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Telephone Number</label>
                        <input type="text" name="telephone_number" class="input input-bordered w-full bg-white" placeholder="Enter telephone number" required>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Mobile Number</label>
                        <input type="text" name="mobile_number" class="input input-bordered w-full bg-white" placeholder="Enter mobile number" required>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Email Address</label>
                        <input type="email" name="email" class="input input-bordered w-full bg-white" placeholder="Enter email address" required>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label"><span class="label-text text-gray-700 font-medium">Re-enter Email</label>
                        <input type="email" name="email_confirmation" class="input input-bordered w-full bg-white" placeholder="Confirm email address" required>
                    </div>
                </div>
            </div>

            <!-- Parent/Guardian Information Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-3">
                    <h4 class="text-gray-800 font-semibold">Parent/Guardian Information</h4>
                </div>
                <div class="p-6">
                    <!-- Header Row -->
                    <div class="grid grid-cols-12 gap-4 mb-3 pb-2 border-b border-gray-100">
                        <div class="col-span-1"><span class="text-gray-700 font-medium text-sm">Role</span></div>
                        <div class="col-span-4"><span class="text-gray-700 font-medium text-sm">Full Name</div>
                        <div class="col-span-3"><span class="text-gray-700 font-medium text-sm">Occupation</div>
                        <div class="col-span-2"><span class="text-gray-700 font-medium text-sm">Contact Number</div>
                        <div class="col-span-2"><span class="text-gray-700 font-medium text-sm">Monthly Income</div>
                    </div>
                    <!-- Mother Row -->
                    <div class="grid grid-cols-12 gap-4 mb-3 items-center">
                        <div class="col-span-1"><span class="text-gray-600 text-sm font-medium">Mother</span></div>
                        <div class="col-span-4"><input type="text" name="mother_name" class="input input-bordered w-full bg-white input-sm" placeholder="Mother's full name" required></div>
                        <div class="col-span-3"><input type="text" name="mother_occupation" class="input input-bordered w-full bg-white input-sm" placeholder="Occupation" required></div>
                        <div class="col-span-2"><input type="text" name="mother_contact_number" class="input input-bordered w-full bg-white input-sm" placeholder="Contact no." required></div>
                        <div class="col-span-2"><input type="number" name="mother_monthly_income" class="input input-bordered w-full bg-white input-sm" placeholder="₱ Income" required></div>
                    </div>
                    <!-- Father Row -->
                    <div class="grid grid-cols-12 gap-4 mb-3 items-center">
                        <div class="col-span-1"><span class="text-gray-600 text-sm font-medium">Father</span></div>
                        <div class="col-span-4"><input type="text" name="father_name" class="input input-bordered w-full bg-white input-sm" placeholder="Father's full name" required></div>
                        <div class="col-span-3"><input type="text" name="father_occupation" class="input input-bordered w-full bg-white input-sm" placeholder="Occupation" required></div>
                        <div class="col-span-2"><input type="text" name="father_contact_number" class="input input-bordered w-full bg-white input-sm" placeholder="Contact no." required></div>
                        <div class="col-span-2"><input type="number" name="father_monthly_income" class="input input-bordered w-full bg-white input-sm" placeholder="₱ Income" required></div>
                    </div>
                    <!-- Guardian Row -->
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-1"><span class="text-gray-600 text-sm font-medium">Guardian</span></div>
                        <div class="col-span-4"><input type="text" name="guardian_name" class="input input-bordered w-full bg-white input-sm" placeholder="Guardian's full name" required></div>
                        <div class="col-span-3"><input type="text" name="guardian_occupation" class="input input-bordered w-full bg-white input-sm" placeholder="Occupation" required></div>
                        <div class="col-span-2"><input type="text" name="guardian_contact_number" class="input input-bordered w-full bg-white input-sm" placeholder="Contact no." required></div>
                        <div class="col-span-2"><input type="number" name="guardian_monthly_income" class="input input-bordered w-full bg-white input-sm" placeholder="₱ Income" required></div>
                    </div>
                </div>
            </div>

            <!-- Educational Background Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-3">
                    <h4 class="text-gray-800 font-semibold">Educational Background</h4>
                </div>
                <div class="p-6">
                    <!-- Header Row -->
                    <div class="grid grid-cols-12 gap-4 mb-3 pb-2 border-b border-gray-100">
                        <div class="col-span-2"><span class="text-gray-700 font-medium text-sm">Level</span></div>
                        <div class="col-span-4"><span class="text-gray-700 font-medium text-sm">Previous School</div>
                        <div class="col-span-4"><span class="text-gray-700 font-medium text-sm">Address</div>
                        <div class="col-span-2"><span class="text-gray-700 font-medium text-sm">Inclusive Years</div>
                    </div>
                    <!-- Elementary Row -->
                    <div class="grid grid-cols-12 gap-4 mb-3 items-center">
                        <div class="col-span-2"><span class="text-gray-600 text-sm font-medium">Elementary</span></div>
                        <div class="col-span-4"><input type="text" name="elementary_school_name" class="input input-bordered w-full bg-white input-sm" placeholder="School name" required></div>
                        <div class="col-span-4"><input type="text" name="elementary_school_address" class="input input-bordered w-full bg-white input-sm" placeholder="School address" required></div>
                        <div class="col-span-2"><input type="text" name="elementary_inclusive_years" class="input input-bordered w-full bg-white input-sm" placeholder="e.g. 2015-2021" required></div>
                    </div>
                    <!-- Junior High School Row -->
                    <div class="grid grid-cols-12 gap-4 mb-3 items-center">
                        <div class="col-span-2"><span class="text-gray-600 text-sm font-medium">Junior High</span></div>
                        <div class="col-span-4"><input type="text" name="junior_school_name" class="input input-bordered w-full bg-white input-sm" placeholder="School name" required></div>
                        <div class="col-span-4"><input type="text" name="junior_school_address" class="input input-bordered w-full bg-white input-sm" placeholder="School address" required></div>
                        <div class="col-span-2"><input type="text" name="junior_inclusive_years" class="input input-bordered w-full bg-white input-sm" placeholder="e.g. 2021-2025" required></div>
                    </div>
                    <!-- Senior High School Row -->
                    <div class="grid grid-cols-12 gap-4 mb-3 items-center">
                        <div class="col-span-2"><span class="text-gray-600 text-sm font-medium">Senior High</span></div>
                        <div class="col-span-4"><input type="text" name="senior_school_name" class="input input-bordered w-full bg-white input-sm" placeholder="School name" required></div>
                        <div class="col-span-4"><input type="text" name="senior_school_address" class="input input-bordered w-full bg-white input-sm" placeholder="School address" required></div>
                        <div class="col-span-2"><input type="text" name="senior_inclusive_years" class="input input-bordered w-full bg-white input-sm" placeholder="e.g. 2025-2027" required></div>
                    </div>
                    <!-- College Row -->
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-2"><span class="text-gray-600 text-sm font-medium">College</span></div>
                        <div class="col-span-4"><input type="text" name="college_school_name" class="input input-bordered w-full bg-white input-sm" placeholder="School name" required></div>
                        <div class="col-span-4"><input type="text" name="college_school_address" class="input input-bordered w-full bg-white input-sm" placeholder="School address" required></div>
                        <div class="col-span-2"><input type="text" name="college_inclusive_years" class="input input-bordered w-full bg-white input-sm" placeholder="e.g. 2027-2031" required></div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="reset" class="btn btn-ghost border border-gray-300">Reset Form</button>
                <button type="submit" class="btn btn-primary">Submit Application</button>
            </div>
        </form>
    </div>
</x-layout>