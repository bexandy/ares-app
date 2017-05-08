CREATE
 ALGORITHM = UNDEFINED
 VIEW `vista_detalles_lote`
 AS SELECT
detalles_lote.id,
detalles_lote.lote,
lotes.num_lote AS numlote,
detalles_lote.producto,
productos.nombre AS `nombproducto`,
detalles_lote.costo,
detalles_lote.vencimiento
FROM `detalles_lote`
JOIN productos ON detalles_lote.producto = productos.id
JOIN lotes ON detalles_lote.lote = lotes.id