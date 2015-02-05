

alter table tbClassInfo 
add column diplomabefore int not null default 0 comment '入学条件(1:小学，2：初中，4：高中，8：中专，16：大专，32：本科)',
add column diplomaafter int not null default 0 comment '毕业文凭(1:小学，2：初中，4：高中，8：中专，16：大专，32：本科)';

update tbClassInfo set diplomabefore = case when requiredlevel = 1 then 1 when requiredlevel = 2 then 2 when requiredlevel = 3 then 4 else 0 end; -- 更新以前老数据

alter table tbClassInfo
drop column requiredlevel;



