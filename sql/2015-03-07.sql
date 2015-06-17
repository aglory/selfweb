
alter table tbApplyInfo
drop column classid,
drop column name,
drop column tel,
add column schoolname varchar(100) not null default '' comment '报名学校',
add column classname varchar(100) not null default '' comment '报名班级',
add column studentname varchar(20) not null default '' comment '学生姓名',
add column contacttel varchar(20) not null default '' comment '联系电话',
add column status int not null default 0 comment '状态(1:正常,2:删除,4:标记)',
add column datecreate timestamp not null default 0 comment '建立时间',
add column datemodify timestamp not null default 0 comment '修改时间';