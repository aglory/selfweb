create table tbMessagesInfo(
	id int auto_increment primary key,
	tel varchar(32) not null comment '联系方式',
	msg text comment '留言',
	datecreate timestamp not null default 0 comment '留言时间',
	datemodify timestamp not null default 0 comment '修改时间',
	status int not null default 0 comment '状态(1:正常,2:标记)'
)engine='MyISAM' comment '留言信息表';