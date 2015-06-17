

alter table tbMessagesInfo
rename to tbMessageInfo ;


alter table tbClassInfo
add column preferential text comment '优惠';


create table tbCategoryInfo(
	id int auto_increment primary key,
    guid varchar(36) not null unique,
    `name` varchar(100) not null comment '分类名称',
    type int not null default 0 comment '分类所属',
	`order` int not null default 0 comment '顺序',
	datecreate timestamp not null default 0 comment '建立时间',
	datemodify timestamp not null default 0 comment '修改时间',
	status int not null default 0 comment '状态(1:正常,2:停用)'
)engine='MyISAM'  comment '分类';

create table tbJobInfo(
	id int auto_increment primary key,
    guid varchar(36) not null unique,
    `name` varchar(100) not null comment '项目名称',
    categoryid int not null default 0 comment '所属分类',
    method int not null default 0 comment '劳务方式(0:未知，1：直签，2：派遣,4:先派遣后直签)',
	serviceprice decimal(18,2) not null default 0 comment '服务费',
	`order` int not null default 0 comment '顺序',
	datecreate timestamp not null default 0 comment '建立时间',
	datemodify timestamp not null default 0 comment '修改时间',
	status int not null default 0 comment '状态(1:正常,2:停用)'
	
)engine = 'MyISAM' comment '安置就业';
