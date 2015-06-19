create table tbUserInfo(
	id int auto_increment primary key,
    `name` varchar(50) not null comment '名称',
	`password` varchar(50) not null comment '密码',
    privilege int not null default 0 comment '权限',
	datecreate timestamp not null default 0 comment '建立时间',
	datemodify timestamp not null default 0 comment '修改时间',
	status int not null default 0 comment '状态(1:正常,2:停用)'
)engine='MyISAM'  comment '用户';

insert into tbUserInfo(`name`,`password`,datecreate,datemodify,status)values('admin',md5('123456'),now(),now(),1);

create table tbSessionIfo(
	userid int not null primary key comment '用户编号',
	clientid varchar(36) not null unique comment '客户端唯一编号',
	ip varchar(20) not null unique comment '使用ip地址',
	datecreate timestamp not null default 0 comment '建立时间',
	datemodify timestamp not null default 0 comment '修改时间'
)engine='Memory' comment '会话';

create table tbLoginHistoryInfo(
	id int auto_increment primary key,
    `name` varchar(50) not null comment '用户名称',
	`password` varchar(50) not null comment '用户密码',
	ip varchar(20) not null comment '使用ip地址',
	issuccess int not  null default 0 comment '登录结果0失败，1成功',
	datecreate timestamp not null default 0 comment '建立时间'
)engine Archive comment '登录记录';