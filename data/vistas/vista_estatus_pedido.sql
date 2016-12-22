SELECT
SUM(IF(`pedidos`.`estatus` = 1,1,0)) AS `editando`,
SUM(IF(`pedidos`.`estatus` = 2,1,0)) AS `enviados`,
SUM(IF(`pedidos`.`estatus` = 3,1,0)) AS `atendiendo`,
SUM(IF(`pedidos`.`estatus` = 4,1,0)) AS `finalizados`,
SUM(IF(`pedidos`.`estatus` = 5,1,0)) AS `cancelados`
FROM
`pedidos`
