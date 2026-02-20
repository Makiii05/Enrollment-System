- [x] create the following tables:

## assessment_history

- id
- academic_term_id
- date_printed
- timestamp()

## assessment_history_enlistment

- assessment_history_id (FK)
- code
- description
- units

## assessment_history_fee

- assessment_history_id (FK)
- type
- description
- amount

## assessment_history_student

- assessment_history_id (FK)
- student_number
- name
- year_level
- program
- departemnt

- [x] note on the tables. the value here are not FK, except those indicated

- [x] todo:
- When the print assessment butto is clicked, the assessment history is created. the date printed will be recorded. all the enlist subject also recorded, and the fee and student info.
- on Student Assessment Page, right section, under schedule and summary fee. A table called "Printing of assessment history". column: date, term, action. where action are delete and print. the data here is all the record of the student, regardless of academic term
