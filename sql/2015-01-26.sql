create table tbApplyInfo(
id int primary key auto_increment,
classid int not null default 0 comment '报名的班级', 
name varchar(200) not null comment '姓名',
tel varchar(30) not null comment '联系方式',
remark text comment '备注'

) engine='MyISAM' charset='utf8' comment '报名信息表';