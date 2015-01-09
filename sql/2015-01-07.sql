
create table tbSchoolInfo(
	id int auto_increment primary key,
	`name` varchar(100) not null comment '校名',
	url varchar(255) not null default '网址',
	latitude decimal(9,6) not null default 0 comment '纬度',
	longitude decimal(9,6) not null default 0 comment '经度',
	description text comment '简介',
	`order` int not null default 0 comment '顺序',
	status int not null default 0 comment '状态(1:正常,2:删除)'
)engine='MyISAM' comment '学校基本信息表';

create table tbClassInfo(
	id int auto_increment primary key,
	schoolid varchar(100) not null default 0 comment '所属院校',
	`name` varchar(100) not null comment '课名',
	price decimal(12,2) not null default 0 comment '价格,小于0表示没有',
	description text comment '简介',
	`order` int not null default 0 comment '顺序',
	status int not null default 0 comment '状态(1:正常,2:删除)'
)engine='MyISAM' comment '班级基本信息表';
