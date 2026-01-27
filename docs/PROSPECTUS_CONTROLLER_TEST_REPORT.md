# ProspectusController Test Report

**Project:** Enrollment System  
**Module:** ProspectusController  
**Date:** January 26, 2026  
**Tester:** Automated Test Suite

---

## 📋 Unit Test Cases (5 Test Cases)

### UT-001: Search Request Validation Requires Department and Academic Year

| Column                  | Details                                                                           |
| ----------------------- | --------------------------------------------------------------------------------- |
| **Test ID**             | UT-001                                                                            |
| **Test Case Name**      | `test_search_request_validation_requires_department_and_academic_year`            |
| **Description**         | Verifies that search validation requires both department and academic_year fields |
| **Input/Preconditions** | Empty Request object with no parameters                                           |
| **Expected Result**     | `ValidationException` thrown                                                      |
| **Actual Result**       | `ValidationException` thrown                                                      |
| **Status**              | ✅ PASS                                                                           |

### UT-002: Prospectus Request Validation Requires All Fields

| Column                  | Details                                                                                                          |
| ----------------------- | ---------------------------------------------------------------------------------------------------------------- |
| **Test ID**             | UT-002                                                                                                           |
| **Test Case Name**      | `test_prospectus_request_validation_requires_all_fields`                                                         |
| **Description**         | Tests that prospectus creation requires all mandatory fields (curriculum, academic_term, level, subject, status) |
| **Input/Preconditions** | Request with empty required fields                                                                               |
| **Expected Result**     | `ValidationException` thrown                                                                                     |
| **Actual Result**       | `ValidationException` thrown                                                                                     |
| **Status**              | ✅ PASS                                                                                                          |

### UT-003: Prospectus Model Has Correct Relationships

| Column                  | Details                                                                                              |
| ----------------------- | ---------------------------------------------------------------------------------------------------- |
| **Test ID**             | UT-003                                                                                               |
| **Test Case Name**      | `test_prospectus_model_has_correct_relationships`                                                    |
| **Description**         | Validates all Eloquent relationships (curriculum, academicTerm, level, subject) are properly defined |
| **Input/Preconditions** | Prospectus with all foreign keys set                                                                 |
| **Expected Result**     | All relationship methods return correct model instances                                              |
| **Actual Result**       | All relationships return expected instances                                                          |
| **Status**              | ✅ PASS                                                                                              |

### UT-004: Prospectus Model Has Correct Fillable Attributes

| Column                  | Details                                                                                |
| ----------------------- | -------------------------------------------------------------------------------------- |
| **Test ID**             | UT-004                                                                                 |
| **Test Case Name**      | `test_prospectus_model_has_correct_fillable_attributes`                                |
| **Description**         | Ensures the Prospectus model's `$fillable` array contains all required fields          |
| **Input/Preconditions** | Fresh Prospectus model instance                                                        |
| **Expected Result**     | Fillable array contains: curriculum_id, subject_id, academic_term_id, level_id, status |
| **Actual Result**       | All expected fields present in fillable array                                          |
| **Status**              | ✅ PASS                                                                                |

### UT-005: Status Validation Only Accepts Active or Inactive

| Column                  | Details                                                   |
| ----------------------- | --------------------------------------------------------- |
| **Test ID**             | UT-005                                                    |
| **Test Case Name**      | `test_status_validation_only_accepts_active_or_inactive`  |
| **Description**         | Tests that status field validation rejects invalid values |
| **Input/Preconditions** | Request with `status = 'invalid_status'`                  |
| **Expected Result**     | `ValidationException` thrown                              |
| **Actual Result**       | `ValidationException` thrown                              |
| **Status**              | ✅ PASS                                                   |

---

## 📋 Integration/System Test Cases (5 Test Cases)

### IT-001: Create Prospectus Successfully Creates Record with Relationships

| Column                  | Details                                                                         |
| ----------------------- | ------------------------------------------------------------------------------- |
| **Test ID**             | IT-001                                                                          |
| **Test Case Name**      | `test_create_prospectus_successfully_creates_record_with_relationships`         |
| **Description**         | Full end-to-end test of prospectus creation via HTTP POST                       |
| **Input/Preconditions** | Authenticated user, valid curriculum/term/level/subject IDs                     |
| **Expected Result**     | HTTP 200, JSON with success=true, database record created, relationships loaded |
| **Actual Result**       | HTTP 200 returned, record persisted with relationships                          |
| **Status**              | ✅ PASS                                                                         |

### IT-002: Update and Delete Prospectus Lifecycle

| Column                  | Details                                                                     |
| ----------------------- | --------------------------------------------------------------------------- |
| **Test ID**             | IT-002                                                                      |
| **Test Case Name**      | `test_update_and_delete_prospectus_lifecycle`                               |
| **Description**         | Tests complete CRUD lifecycle: create → update → delete                     |
| **Input/Preconditions** | Existing prospectus record, authenticated user                              |
| **Expected Result**     | Update: HTTP 200, record modified; Delete: HTTP 200, record removed from DB |
| **Actual Result**       | Both operations successful, database state verified                         |
| **Status**              | ✅ PASS                                                                     |

### IT-003: Search Prospectus Filters by Department and Academic Year

| Column                  | Details                                                          |
| ----------------------- | ---------------------------------------------------------------- |
| **Test ID**             | IT-003                                                           |
| **Test Case Name**      | `test_search_prospectus_filters_by_department_and_academic_year` |
| **Description**         | Tests filtering prospectuses by department and academic year     |
| **Input/Preconditions** | Two departments with separate prospectuses                       |
| **Expected Result**     | Only prospectuses matching filter criteria returned              |
| **Actual Result**       | Correct filtering applied, returns 1 matching record             |
| **Status**              | ✅ PASS                                                          |

### IT-004: Get Levels by Department Returns Correct Levels

| Column                  | Details                                                           |
| ----------------------- | ----------------------------------------------------------------- |
| **Test ID**             | IT-004                                                            |
| **Test Case Name**      | `test_get_levels_by_department_returns_correct_levels`            |
| **Description**         | Tests the API endpoint for dynamic level loading                  |
| **Input/Preconditions** | Two departments with different programs/levels                    |
| **Expected Result**     | Only levels belonging to requested department's programs returned |
| **Actual Result**       | Returns only department-specific levels                           |
| **Status**              | ✅ PASS                                                           |

### IT-005: Unauthenticated Users Cannot Access Prospectus Routes

| Column                  | Details                                                      |
| ----------------------- | ------------------------------------------------------------ |
| **Test ID**             | IT-005                                                       |
| **Test Case Name**      | `test_unauthenticated_users_cannot_access_prospectus_routes` |
| **Description**         | Verifies authentication middleware protection                |
| **Input/Preconditions** | Unauthenticated request to protected route                   |
| **Expected Result**     | HTTP 302 (redirect) or 401/403 (forbidden)                   |
| **Actual Result**       | HTTP 302 redirect to login                                   |
| **Status**              | ✅ PASS                                                      |

---

## 🐛 Bug Report

### Bug #1: Validation Type Mismatch for Department Field

| Field         | Details                                                                           |
| ------------- | --------------------------------------------------------------------------------- |
| **Bug ID**    | BUG-PROS-001                                                                      |
| **Severity**  | Low                                                                               |
| **Priority**  | Medium                                                                            |
| **Status**    | Open (Documented)                                                                 |
| **Component** | `ProspectusController::validateSearchRequest()`                                   |
| **Found In**  | [ProspectusController.php](app/Http/Controllers/ProspectusController.php#L15-L20) |

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

| Metric               | Value         |
| -------------------- | ------------- |
| **Total Test Cases** | 10            |
| **Passed**           | 10            |
| **Failed**           | 0             |
| **Skipped**          | 0             |
| **Pass Rate**        | 100%          |
| **Total Assertions** | 38            |
| **Execution Time**   | ~7.73 seconds |

### Test Coverage by Category

| Category          | Test Count | Pass | Fail | Coverage |
| ----------------- | ---------- | ---- | ---- | -------- |
| Unit Tests        | 5          | 5    | 0    | 100%     |
| Integration Tests | 5          | 5    | 0    | 100%     |

### Functionality Coverage

| Controller Method             | Unit Test      | Integration Test | Status                 |
| ----------------------------- | -------------- | ---------------- | ---------------------- |
| `validateSearchRequest()`     | UT-001         | IT-003           | ✅ Covered             |
| `validateProspectusRequest()` | UT-002, UT-005 | IT-001           | ✅ Covered             |
| `showProspectus()`            | -              | -                | ⚠️ Not Directly Tested |
| `searchProspectus()`          | UT-001         | IT-003           | ✅ Covered             |
| `createProspectus()`          | UT-002         | IT-001           | ✅ Covered             |
| `updateProspectus()`          | -              | IT-002           | ✅ Covered             |
| `deleteProspectus()`          | -              | IT-002           | ✅ Covered             |
| `getLevelsByDepartment()`     | -              | IT-004           | ✅ Covered             |
| `getProspectusesApi()`        | -              | -                | ⚠️ Not Directly Tested |

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
