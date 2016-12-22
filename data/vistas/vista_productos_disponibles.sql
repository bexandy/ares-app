CREATE VIEW `vista_productos_disponibles` AS
SELECT
  `disponiblidad_productos`.`disponible`,
  `productos`.`id`,
  `productos`.`nombre`,
  TRUNCATE(IF(`disponibilidad_x_almacen`.`cantidad`<> 0,`disponibilidad_x_almacen`.`cantidad`,0),3) AS `cantidad`,
  `categorias`.`id` AS `idcategoria`,
  `categorias`.`nombre` AS `nombcategoria`,
  `productos`.`unidadmedidaventas`,
  `ventas`.`abreviatura` AS `nombunidmedventas` ,
  `productos`.`preciocosto`,
  `productos`.`ganancia`,
  TRUNCATE(IF(`productos`.`ganancia` > 0, (`productos`.`ganancia` * `productos`.`preciocosto`)/100, 0),2) AS `montoganancia`,
  `productos`.`tieneimpuesto`,
  `productos`.`impuesto`,
  TRUNCATE(IF(`productos`.`tieneimpuesto` = 1, (`productos`.`impuesto`* (`productos`.`preciocosto`*(1+(`productos`.`ganancia`/100))))/100 ,0),2) AS `montoimpuesto`,
  TRUNCATE(IF(`productos`.`tieneimpuesto` = 1, (`productos`.`preciocosto`*(1+(`productos`.`ganancia`/100)))*(1+(`productos`.`impuesto`/100)),(`productos`.`preciocosto`*(1+(`productos`.`ganancia`/100)))),2) AS `preciounidad`,
  `productos`.`unidadmedidaalmacen`,
  `almacen`.`abreviatura` AS `nombunidmedalmacen`,
  `productos`.`relacionunidad`,
  `productos`.`imagen` AS `imagen`,
  `productos`.`idmarca`,
  `marca`.`nombre` AS `nombmarca`,
  `productos`.`codpremium`,
  `productos`.`modificado`,
  `productos`.`vencimiento`
FROM `productos`
 LEFT JOIN `categorias` ON `productos`.`idcategoria` = `categorias`.`id`
 LEFT JOIN `unidad_medida` AS `ventas` ON `productos`.`unidadmedidaventas` = `ventas`.`id`
 LEFT JOIN `unidad_medida` AS `almacen` ON `productos`.`unidadmedidaalmacen` = `almacen`.`id`
 LEFT JOIN `marca` ON `productos`.`idmarca` = `marca`.`id`
 LEFT JOIN `disponibilidad_x_almacen` ON `productos`.`id` = `disponibilidad_x_almacen`.`producto` AND `disponibilidad_x_almacen`.`almacen` = 2
 INNER JOIN `disponiblidad_productos` ON `productos`.`id` = `disponiblidad_productos`.`idproducto` AND `disponiblidad_productos`.`disponible` = 1
