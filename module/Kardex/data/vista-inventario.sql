SELECT
  `disponibilidad_x_almacen`.`id`,
  `disponibilidad_x_almacen`.`almacen` AS `idalmacen`,
  `almacen`.`nombre`,
  `almacen`.`idtipoalmacen`,
  `tipo_almacen`.`nombre` AS `tipoalmacen`,
  `marca`.`nombre` AS `marca`,
  `categorias`.`nombre` AS `categoria`,
  `disponibilidad_x_almacen`.`producto` AS `idproducto`,
  `productos`.`nombre` AS `nombproducto`,
  `disponibilidad_x_almacen`.`cantidad`,
  COALESCE(`view_reservado`.`reservado`,0) AS `reservado`,
  (COALESCE(`disponibilidad_x_almacen`.`cantidad`,0) - COALESCE(`view_reservado`.`reservado`,0)) AS `disponible`,
  `productos`.`unidadmedidaalmacen` AS `idunidmedalmacen`,
  `unidmedalmacen`.`simbolo` AS `unidmed`,
  `productos`.`unidadmedidaventas` AS `idunidmedventas`,
  `unidmeddetal`.`simbolo` AS `unidmeddetal`

FROM
  `disponibilidad_x_almacen`
  LEFT JOIN `almacen` ON `disponibilidad_x_almacen`.`almacen` = `almacen`.`id`
  LEFT JOIN `tipo_almacen` ON `almacen`.`idtipoalmacen` = `tipo_almacen`.`id`
  LEFT JOIN `productos` ON `disponibilidad_x_almacen`.`producto` = `productos`.`id`
  LEFT JOIN `marca` ON `productos`.`idmarca` = `marca`.`id`
  LEFT JOIN `categorias` ON `productos`.`idcategoria` = `categorias`.`id`
  LEFT JOIN `unidad_medida` AS `unidmedalmacen` ON `productos`.`unidadmedidaalmacen` = `unidmedalmacen`.`id`
  LEFT JOIN `unidad_medida` AS `unidmeddetal` ON `productos`.`unidadmedidaventas` = `unidmeddetal`.`id`
  LEFT JOIN `view_reservado` ON `disponibilidad_x_almacen`.`producto` = `view_reservado`.`producto` AND `disponibilidad_x_almacen`.`almacen` = `view_reservado`.`idalmacen`

