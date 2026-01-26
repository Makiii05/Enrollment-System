# ProspectusController Test Report

**Project:** Enrollment System  
**Module:** ProspectusController  
**Date:** January 26, 2026  
**Tester:** Automated Test Suite  

---

## 📋 Test Case Table

### Unit Tests (5 Test Cases)

| Test ID | Test Case Name | Description | Input/Preconditions | Expected Result | Actual Result | Status |
|---------|---------------|-------------|---------------------|-----------------|---------------|--------|
| UT-001 | `test_search_request_validation_requires_department_and_academic_year` | Verifies that search validation requires both department and academic_year fields | Empty Request object with no parameters | `ValidationException` thrown | `ValidationException` thrown | ✅ PASS |
| UT-002 | `test_prospectus_request_validation_requires_all_fields` | Tests that prospectus creation requires all mandatory fields (curriculum, academic_term, level, subject, status) | Request with empty required fields | `ValidationException` thrown | `ValidationException` thrown | ✅ PASS |
| UT-003 | `test_prospectus_model_has_correct_relationships` | Validates all Eloquent relationships (curriculum, academicTerm, level, subject) are properly defined | Prospectus with all foreign keys set | All relationship methods return correct model instances | All relationships return expected instances | ✅ PASS |
| UT-004 | `test_prospectus_model_has_correct_fillable_attributes` | Ensures the Prospectus model's `$fillable` array contains all required fields | Fresh Prospectus model instance | Fillable array contains: curriculum_id, subject_id, academic_term_id, level_id, status | All expected fields present in fillable array | ✅ PASS |
| UT-005 | `test_status_validation_only_accepts_active_or_inactive` | Tests that status field validation rejects invalid values | Request with `status = 'invalid_status'` | `ValidationException` thrown | `ValidationException` thrown | ✅ PASS |

### Integration/System Tests (5 Test Cases)

| Test ID | Test Case Name | Description | Input/Preconditions | Expected Result | Actual Result | Status |
|---------|---------------|-------------|---------------------|-----------------|---------------|--------|
| IT-001 | `test_create_prospectus_successfully_creates_record_with_relationships` | Full end-to-end test of prospectus creation via HTTP POST | Authenticated user, valid curriculum/term/level/subject IDs | HTTP 200, JSON with success=true, database record created, relationships loaded | HTTP 200 returned, record persisted with relationships | ✅ PASS |
| IT-002 | `test_update_and_delete_prospectus_lifecycle` | Tests complete CRUD lifecycle: create → update → delete | Existing prospectus record, authenticated user | Update: HTTP 200, record modified; Delete: HTTP 200, record removed from DB | Both operations successful, database state verified | ✅ PASS |
| IT-003 | `test_search_prospectus_filters_by_department_and_academic_year` | Tests filtering prospectuses by department and academic year | Two departments with separate prospectuses | Only prospectuses matching filter criteria returned | Correct filtering applied, returns 1 matching record | ✅ PASS |
| IT-004 | `test_get_levels_by_department_returns_correct_levels` | Tests the API endpoint for dynamic level loading | Two departments with different programs/levels | Only levels belonging to requested department's programs returned | Returns only department-specific levels | ✅ PASS |
| IT-005 | `test_unauthenticated_users_cannot_access_prospectus_routes` | Verifies authentication middleware protection | Unauthenticated request to protected route | HTTP 302 (redirect) or 401/403 (forbidden) | HTTP 302 redirect to login | ✅ PASS |

---

## 🐛 Bug Report

### Bug #1: Validation Type Mismatch for Department Field

| Field | Details |
|-------|---------|
| **Bug ID** | BUG-PROS-001 |
| **Severity** | Low |
| **Priority** | Medium |
| **Status** | Open (Documented) |
| **Component** | `ProspectusController::validateSearchRequest()` |
| **Found In** | [ProspectusController.php](app/Http/Controllers/ProspectusController.php#L15-L20) |

**Description:**  
The `validateSearchRequest()` method validates the `department` field as `'required|string|max:255'`, but the actual form submission sends the department ID as an integer. This causes a type mismatch that requires explicit string casting on the client side.

**Steps to Reproduce:**
1. Send POST request to `/registrar/prospectuses/search`
2. Include `department` field as integer (e.g., `1`)
3. Observe validation error: "The department field must be a string."

**Expected Behavior:**  
The validation should accept both integer IDs and string representations of IDs, as the value represents a foreign key.

**Actual Behavior:**  
Validation fails with "The department field must be a string" when integer is passed.

**Recommended Fix:**
```php
// Change from:
'department' => 'required|string|max:255',

// Change to:
'department' => 'required|exists:departments,id',
```

**Workaround:**  
Cast department ID to string before sending request: `(string) $departmentId`

---

## 📊 Test Summary Report

### Execution Summary

| Metric | Value |
|--------|-------|
| **Total Test Cases** | 10 |
| **Passed** | 10 |
| **Failed** | 0 |
| **Skipped** | 0 |
| **Pass Rate** | 100% |
| **Total Assertions** | 38 |
| **Execution Time** | ~7.73 seconds |

### Test Coverage by Category

| Category | Test Count | Pass | Fail | Coverage |
|----------|------------|------|------|----------|
| Unit Tests | 5 | 5 | 0 | 100% |
| Integration Tests | 5 | 5 | 0 | 100% |

### Functionality Coverage

| Controller Method | Unit Test | Integration Test | Status |
|-------------------|-----------|------------------|--------|
| `validateSearchRequest()` | UT-001 | IT-003 | ✅ Covered |
| `validateProspectusRequest()` | UT-002, UT-005 | IT-001 | ✅ Covered |
| `showProspectus()` | - | - | ⚠️ Not Directly Tested |
| `searchProspectus()` | UT-001 | IT-003 | ✅ Covered |
| `createProspectus()` | UT-002 | IT-001 | ✅ Covered |
| `updateProspectus()` | - | IT-002 | ✅ Covered |
| `deleteProspectus()` | - | IT-002 | ✅ Covered |
| `getLevelsByDepartment()` | - | IT-004 | ✅ Covered |
| `getProspectusesApi()` | - | - | ⚠️ Not Directly Tested |

### Key Findings

1. **All critical CRUD operations are functioning correctly** - Create, Read (search), Update, and Delete operations work as expected with proper database persistence.

2. **Relationship loading works correctly** - The controller properly loads and returns related data (curriculum, academicTerm, level, subject) with responses.

3. **Authentication middleware is properly enforced** - Unauthenticated users are correctly redirected, protecting sensitive data operations.

4. **Minor validation inconsistency identified** - The `department` field validation expects a string but typically receives an integer ID (see Bug Report BUG-PROS-001).

5. **Model relationships are properly defined** - All foreign key relationships on the Prospectus model function correctly.

### Recommendations

1. **Fix the department validation rule** (BUG-PROS-001) to use `exists:departments,id` instead of `string|max:255` for better type safety and referential integrity.

2. **Add tests for `showProspectus()`** and `getProspectusesApi()` methods to achieve complete test coverage.

3. **Consider adding edge case tests** for:
   - Attempting to delete a non-existent prospectus
   - Creating duplicate prospectus entries
   - Testing with inactive related records

---

### Test Files Location

- **Unit Tests:** `tests/Unit/ProspectusControllerTest.php`
- **Integration Tests:** `tests/Feature/ProspectusControllerIntegrationTest.php`

### How to Run Tests

```bash
# Run all ProspectusController tests
php artisan test --filter=ProspectusController

# Run only unit tests
php artisan test --filter=ProspectusControllerTest

# Run only integration tests
php artisan test --filter=ProspectusControllerIntegrationTest
```
