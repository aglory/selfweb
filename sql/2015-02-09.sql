

alter table tbClassInfo
add column `guid` varchar(36);

update tbClassInfo set `guid` = md5(rand());

alter table tbClassInfo
add unique index `unique_guid`(`guid` asc);



alter table tbSchoolInfo
add column `guid` varchar(36);

update tbSchoolInfo set `guid` = md5(rand());

alter table tbSchoolInfo
add unique index `unique_guid`(`guid` asc)