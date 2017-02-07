
LOCK TABLES `itemcategory` WRITE;
/*!40000 ALTER TABLE `itemcategory` DISABLE KEYS */;
INSERT INTO `itemcategory` (`id`,`name`,`groupflag`,`sort`) VALUES 
(124,'ΜΟΝΑΔΑ ΑΔΙΑΛΕΙΠΤΗΣ ΠΑΡΟΧΗΣ ΡΕΥΜΑΤΟΣ (UPS)', 1, 24);
/*!40000 ALTER TABLE `itemcategory` ENABLE KEYS */;
UNLOCK TABLES;

ALTER TABLE `itemcategory` AUTO_INCREMENT = 200;

alter table `applicationform` modify `received_by` varchar(255);

lock tables `tpesurvey` write;
alter table `tpesurvey` modify `teacher_id` int(11) unsigned null;
alter table `tpesurvey` drop foreign key `c_fk_tpesurvey_teacher_id`;
alter table `tpesurvey` add constraint `c_fk_tpesurvey_teacher_id` 
foreign key (`teacher_id`) 
references `teacher` (`id`) on update cascade on delete set null;
unlock tables;
