CREATE
 ALGORITHM = UNDEFINED
 VIEW `vista_solicitud_producto`
 AS SELECT
`solicitud_producto`.`id`,
`solicitud_producto`.`idproducto`,
`productos`.`nombre`,
`solicitud_producto`.`estatus`,
`solicitud_producto`.`fecha`
FROM `solicitud_producto`
LEFT JOIN `productos` ON `solicitud_producto`.`idproducto`=`productos`.`id`