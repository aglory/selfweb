

alter table tbClassInfo 
add column levecount int not null default 0 comment '剩余名额',
add column requiredlevel int not null default 0 comment '入学条件(1:小学，2：初中，3：高中)',
add column teachdate int not null default 0 comment '学制',
add column teachunit int not null default 0 comment '时间单位（1：年，2：月，3：天，4：小时）',
add column datecreate timestamp not null default 0 comment '建立时间',
add column datemodify timestamp not null default 0 comment '修改时间';


alter table tbSchoolInfo 
add column datecreate timestamp not null default 0 comment '建立时间',
add column datemodify timestamp not null default 0 comment '修改时间';
