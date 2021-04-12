ALTER TABLE `sms_student_list` CHANGE `session` `year` YEAR NOT NULL DEFAULT (YEAR(CURDATE()))
ALTER TABLE `sms_employee` CHANGE `designation` `designation_id` INT NOT NULL;