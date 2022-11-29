alter table oc_order
add order_sale int default 0;

alter table oc_order
add sale_price int;

INSERT INTO oc_order_modify (order_modify_id, name, color, icon)
values (5, "Установлен размер скидки", "success", "fa fa-info-circle");

INSERT INTO oc_order_modify (order_modify_id, name, color, icon)
values (6, "Скидка была удалена", "danger", "fa fa-trash-o");