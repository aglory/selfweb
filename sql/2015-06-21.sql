
create table tbClassPropertyKeyInfo(
	id int auto_increment primary key,
    classid int not null default 0 comment '所属班级',
	`name` varchar(100) not null comment '属性名',
    targetlevel int not null default 0 comment '指定信息重要程度',
    displaytype int not null default 0 comment '展示方式 1：默认，2：无序，3有序',
	`order` int not null default 0 comment '顺序',
	datecreate timestamp not null default 0 comment '建立时间',
	datemodify timestamp not null default 0 comment '修改时间',
	status int not null default 0 comment '状态(1:正常,2:停用)'
) engine='MyISAM'  comment '班级附加信息名称';


create table tbClassPropertyValueInfo(
	id int auto_increment primary key,
    classid int not null default 0 comment '所属班级',
    keyid int not null default 0 comment '所属附加 班级信息名称',
	`value` varchar(400) not null comment '属性名',
    targetlevel int not null default 0 comment '指定信息重要程度',
	`order` int not null default 0 comment '顺序',
	datecreate timestamp not null default 0 comment '建立时间',
	datemodify timestamp not null default 0 comment '修改时间',
	status int not null default 0 comment '状态(1:正常,2:停用)'
) engine='MyISAM'  comment '班级附加信息值';
