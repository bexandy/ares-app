-- MySQL dump 10.13  Distrib 5.7.15, for Linux (i686)
--
-- Host: localhost    Database: app_ares
-- ------------------------------------------------------
-- Server version	5.7.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `almacen`
--

DROP TABLE IF EXISTS `almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `almacen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idtipoalmacen` int(11) NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `almacen`
--

LOCK TABLES `almacen` WRITE;
/*!40000 ALTER TABLE `almacen` DISABLE KEYS */;
INSERT INTO `almacen` VALUES (1,1,'Depósito'),(2,2,'Tienda');
/*!40000 ALTER TABLE `almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disponibilidad_x_almacen`
--

DROP TABLE IF EXISTS `disponibilidad_x_almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disponibilidad_x_almacen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto` int(11) NOT NULL,
  `almacen` int(11) NOT NULL,
  `cantidad` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disponibilidad_x_almacen`
--

LOCK TABLES `disponibilidad_x_almacen` WRITE;
/*!40000 ALTER TABLE `disponibilidad_x_almacen` DISABLE KEYS */;
/*!40000 ALTER TABLE `disponibilidad_x_almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disponiblidad_productos`
--

DROP TABLE IF EXISTS `disponiblidad_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disponiblidad_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idproducto` int(11) NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disponiblidad_productos`
--

LOCK TABLES `disponiblidad_productos` WRITE;
/*!40000 ALTER TABLE `disponiblidad_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `disponiblidad_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estatus_pedido`
--

DROP TABLE IF EXISTS `estatus_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estatus_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `msgclientes` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `msgventas` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `msgdespacho` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatus_pedido`
--

LOCK TABLES `estatus_pedido` WRITE;
/*!40000 ALTER TABLE `estatus_pedido` DISABLE KEYS */;
INSERT INTO `estatus_pedido` VALUES (1,'ventas','Tomando el Pedido','Tomando el Pedido','Realizando Pedido'),(2,'enviado','En Cola','Enviado','Pendiente'),(3,'despacho','Atendiendo','En Despacho','Atendiendo'),(4,'finalizado','Entregado','Finalizado','Entregado'),(5,'cancelado','Cancelado','Cancelado','Cancelado');
/*!40000 ALTER TABLE `estatus_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico_precios`
--

DROP TABLE IF EXISTS `historico_precios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historico_precios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `idproducto` int(11) NOT NULL,
  `preciocosto` float NOT NULL,
  `ganancia` float NOT NULL,
  `impuesto` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_precios`
--

LOCK TABLES `historico_precios` WRITE;
/*!40000 ALTER TABLE `historico_precios` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico_precios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingreso_almacen`
--

DROP TABLE IF EXISTS `ingreso_almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingreso_almacen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idproducto` int(11) NOT NULL,
  `idalmacen` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingreso_almacen`
--

LOCK TABLES `ingreso_almacen` WRITE;
/*!40000 ALTER TABLE `ingreso_almacen` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingreso_almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marca`
--

DROP TABLE IF EXISTS `marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `imagen` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merma_x_almacen`
--

DROP TABLE IF EXISTS `merma_x_almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merma_x_almacen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idalmacen` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merma_x_almacen`
--

LOCK TABLES `merma_x_almacen` WRITE;
/*!40000 ALTER TABLE `merma_x_almacen` DISABLE KEYS */;
/*!40000 ALTER TABLE `merma_x_almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimiento_almacen`
--

DROP TABLE IF EXISTS `movimiento_almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movimiento_almacen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idalmacenmayor` int(11) NOT NULL,
  `idalmacendetal` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `fecha` date NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento_almacen`
--

LOCK TABLES `movimiento_almacen` WRITE;
/*!40000 ALTER TABLE `movimiento_almacen` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimiento_almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `preciototal` int(11) NOT NULL,
  `cliente` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `estatus` int(11) NOT NULL,
  `despachador` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `idalmacen` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(11) NOT NULL DEFAULT '17',
  `idmarca` int(11) DEFAULT '7',
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unidadmedidaventas` int(11) NOT NULL DEFAULT '3',
  `preciocosto` int(11) NOT NULL,
  `ganancia` int(11) NOT NULL,
  `tieneimpuesto` tinyint(1) NOT NULL,
  `impuesto` int(11) NOT NULL,
  `unidadmedidaalmacen` int(11) NOT NULL DEFAULT '2',
  `relacionunidad` float NOT NULL DEFAULT '1',
  `imagen` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '/img/productos/default.png',
  `codpremium` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modificado` date DEFAULT NULL,
  `vencimiento` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idcategoria` (`idcategoria`),
  KEY `unidadmedidaventas` (`unidadmedidaventas`),
  KEY `unidadmedidaalmacen` (`unidadmedidaalmacen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_x_pedido`
--

DROP TABLE IF EXISTS `productos_x_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_x_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido` int(11) NOT NULL,
  `producto` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `preciocosto` float NOT NULL,
  `ganancia` float NOT NULL,
  `impuesto` float NOT NULL,
  `subtotal` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_x_pedido`
--

LOCK TABLES `productos_x_pedido` WRITE;
/*!40000 ALTER TABLE `productos_x_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos_x_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_almacen`
--

DROP TABLE IF EXISTS `tipo_almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_almacen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_almacen`
--

LOCK TABLES `tipo_almacen` WRITE;
/*!40000 ALTER TABLE `tipo_almacen` DISABLE KEYS */;
INSERT INTO `tipo_almacen` VALUES (1,'Mayor'),(2,'Detal');
/*!40000 ALTER TABLE `tipo_almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidad_medida`
--

DROP TABLE IF EXISTS `unidad_medida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidad_medida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `abreviatura` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `simbolo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidad_medida`
--

LOCK TABLES `unidad_medida` WRITE;
/*!40000 ALTER TABLE `unidad_medida` DISABLE KEYS */;
/*!40000 ALTER TABLE `unidad_medida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin@tucorreo.com','Administrador','$2y$14$Mt8/ZbyMTqpobNQJ5/fBMuLjN2sezYyg0fbvl8A5Z1TcetWWcQLMy',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleId` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roleId` (`roleId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'autenticado',1,NULL),(2,'vendedor',0,'autenticado'),(3,'despachador',0,'autenticado'),(4,'administrador',0,'autenticado'),(5,'cliente',0,'autenticado');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_linker`
--

DROP TABLE IF EXISTS `user_role_linker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role_linker` (
  `user_id` int(10) NOT NULL,
  `role_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_role_linker_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`roleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_linker`
--

LOCK TABLES `user_role_linker` WRITE;
/*!40000 ALTER TABLE `user_role_linker` DISABLE KEYS */;
INSERT INTO `user_role_linker` VALUES (1,'administrador');
/*!40000 ALTER TABLE `user_role_linker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_reservado`
--

DROP TABLE IF EXISTS `view_reservado`;
/*!50001 DROP VIEW IF EXISTS `view_reservado`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_reservado` AS SELECT 
 1 AS `producto`,
 1 AS `idalmacen`,
 1 AS `reservado`,
 1 AS `estatus`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_almacen`
--

DROP TABLE IF EXISTS `vista_almacen`;
/*!50001 DROP VIEW IF EXISTS `vista_almacen`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_almacen` AS SELECT 
 1 AS `id`,
 1 AS `idtipoalmacen`,
 1 AS `nombtipoalmacen`,
 1 AS `nombre`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_disponibilidad_almacen`
--

DROP TABLE IF EXISTS `vista_disponibilidad_almacen`;
/*!50001 DROP VIEW IF EXISTS `vista_disponibilidad_almacen`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_disponibilidad_almacen` AS SELECT 
 1 AS `id`,
 1 AS `idalmacen`,
 1 AS `nombre`,
 1 AS `idtipoalmacen`,
 1 AS `tipoalmacen`,
 1 AS `idproducto`,
 1 AS `nombproducto`,
 1 AS `cantidad`,
 1 AS `reservado`,
 1 AS `disponible`,
 1 AS `idunidmedalmacen`,
 1 AS `unidmed`,
 1 AS `idunidmedventas`,
 1 AS `unidmeddetal`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_ingresos`
--

DROP TABLE IF EXISTS `vista_ingresos`;
/*!50001 DROP VIEW IF EXISTS `vista_ingresos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_ingresos` AS SELECT 
 1 AS `id`,
 1 AS `fecha`,
 1 AS `idalmacen`,
 1 AS `nombalmacen`,
 1 AS `idproducto`,
 1 AS `nombproducto`,
 1 AS `cantidad`,
 1 AS `unidmed`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_items`
--

DROP TABLE IF EXISTS `vista_items`;
/*!50001 DROP VIEW IF EXISTS `vista_items`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_items` AS SELECT 
 1 AS `pedido`,
 1 AS `producto`,
 1 AS `nombproducto`,
 1 AS `unidmedprod`,
 1 AS `cantidad`,
 1 AS `subtotal`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_movimientos`
--

DROP TABLE IF EXISTS `vista_movimientos`;
/*!50001 DROP VIEW IF EXISTS `vista_movimientos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_movimientos` AS SELECT 
 1 AS `id`,
 1 AS `idalmacenmayor`,
 1 AS `nombmayor`,
 1 AS `idalmacendetal`,
 1 AS `nombdetal`,
 1 AS `idproducto`,
 1 AS `nombproducto`,
 1 AS `cantidad`,
 1 AS `unidmed`,
 1 AS `fecha`,
 1 AS `idusuario`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_pedidos`
--

DROP TABLE IF EXISTS `vista_pedidos`;
/*!50001 DROP VIEW IF EXISTS `vista_pedidos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_pedidos` AS SELECT 
 1 AS `id`,
 1 AS `codigo`,
 1 AS `vendedor`,
 1 AS `nombvendedor`,
 1 AS `preciototal`,
 1 AS `cliente`,
 1 AS `estatus`,
 1 AS `nombestatus`,
 1 AS `msgclientes`,
 1 AS `msgventas`,
 1 AS `msgdespacho`,
 1 AS `despachador`,
 1 AS `nombdespachador`,
 1 AS `fecha`,
 1 AS `hora`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_productos`
--

DROP TABLE IF EXISTS `vista_productos`;
/*!50001 DROP VIEW IF EXISTS `vista_productos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_productos` AS SELECT 
 1 AS `id`,
 1 AS `nombre`,
 1 AS `cantidad`,
 1 AS `idcategoria`,
 1 AS `nombcategoria`,
 1 AS `unidadmedidaventas`,
 1 AS `nombunidmedventas`,
 1 AS `preciocosto`,
 1 AS `ganancia`,
 1 AS `montoganancia`,
 1 AS `tieneimpuesto`,
 1 AS `impuesto`,
 1 AS `montoimpuesto`,
 1 AS `preciounidad`,
 1 AS `unidadmedidaalmacen`,
 1 AS `nombunidmedalmacen`,
 1 AS `relacionunidad`,
 1 AS `imagen`,
 1 AS `idmarca`,
 1 AS `nombmarca`,
 1 AS `codpremium`,
 1 AS `modificado`,
 1 AS `vencimiento`,
 1 AS `disponible`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_productos_disponibles`
--

DROP TABLE IF EXISTS `vista_productos_disponibles`;
/*!50001 DROP VIEW IF EXISTS `vista_productos_disponibles`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_productos_disponibles` AS SELECT 
 1 AS `disponible`,
 1 AS `id`,
 1 AS `nombre`,
 1 AS `cantidad`,
 1 AS `idcategoria`,
 1 AS `nombcategoria`,
 1 AS `unidadmedidaventas`,
 1 AS `nombunidmedventas`,
 1 AS `preciocosto`,
 1 AS `ganancia`,
 1 AS `montoganancia`,
 1 AS `tieneimpuesto`,
 1 AS `impuesto`,
 1 AS `montoimpuesto`,
 1 AS `preciounidad`,
 1 AS `unidadmedidaalmacen`,
 1 AS `nombunidmedalmacen`,
 1 AS `relacionunidad`,
 1 AS `imagen`,
 1 AS `idmarca`,
 1 AS `nombmarca`,
 1 AS `codpremium`,
 1 AS `modificado`,
 1 AS `vencimiento`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_productos_traslado`
--

DROP TABLE IF EXISTS `vista_productos_traslado`;
/*!50001 DROP VIEW IF EXISTS `vista_productos_traslado`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_productos_traslado` AS SELECT 
 1 AS `id`,
 1 AS `idalmacen`,
 1 AS `nombre`,
 1 AS `idmarca`,
 1 AS `nombmarca`,
 1 AS `idcategoria`,
 1 AS `nombcategoria`,
 1 AS `idproducto`,
 1 AS `nombproducto`,
 1 AS `disponible`,
 1 AS `unidmed`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_reservado`
--

/*!50001 DROP VIEW IF EXISTS `view_reservado`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_reservado` AS select `productos_x_pedido`.`producto` AS `producto`,`pedidos`.`idalmacen` AS `idalmacen`,sum(`productos_x_pedido`.`cantidad`) AS `reservado`,`pedidos`.`estatus` AS `estatus` from (`productos_x_pedido` left join `pedidos` on((`productos_x_pedido`.`pedido` = `pedidos`.`id`))) where (`pedidos`.`estatus` = 2) group by `productos_x_pedido`.`producto`,`pedidos`.`estatus`,`pedidos`.`idalmacen` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_almacen`
--

/*!50001 DROP VIEW IF EXISTS `vista_almacen`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_almacen` AS select `almacen`.`id` AS `id`,`almacen`.`idtipoalmacen` AS `idtipoalmacen`,`tipo_almacen`.`nombre` AS `nombtipoalmacen`,`almacen`.`nombre` AS `nombre` from (`almacen` left join `tipo_almacen` on((`almacen`.`idtipoalmacen` = `tipo_almacen`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_disponibilidad_almacen`
--

/*!50001 DROP VIEW IF EXISTS `vista_disponibilidad_almacen`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_disponibilidad_almacen` AS select `disponibilidad_x_almacen`.`id` AS `id`,`disponibilidad_x_almacen`.`almacen` AS `idalmacen`,`almacen`.`nombre` AS `nombre`,`almacen`.`idtipoalmacen` AS `idtipoalmacen`,`tipo_almacen`.`nombre` AS `tipoalmacen`,`disponibilidad_x_almacen`.`producto` AS `idproducto`,`productos`.`nombre` AS `nombproducto`,`disponibilidad_x_almacen`.`cantidad` AS `cantidad`,coalesce(`view_reservado`.`reservado`,0) AS `reservado`,(coalesce(`disponibilidad_x_almacen`.`cantidad`,0) - coalesce(`view_reservado`.`reservado`,0)) AS `disponible`,`productos`.`unidadmedidaalmacen` AS `idunidmedalmacen`,`unidmedalmacen`.`simbolo` AS `unidmed`,`productos`.`unidadmedidaventas` AS `idunidmedventas`,`unidmeddetal`.`simbolo` AS `unidmeddetal` from ((((((`disponibilidad_x_almacen` left join `almacen` on((`disponibilidad_x_almacen`.`almacen` = `almacen`.`id`))) left join `tipo_almacen` on((`almacen`.`idtipoalmacen` = `tipo_almacen`.`id`))) left join `productos` on((`disponibilidad_x_almacen`.`producto` = `productos`.`id`))) left join `unidad_medida` `unidmedalmacen` on((`productos`.`unidadmedidaalmacen` = `unidmedalmacen`.`id`))) left join `unidad_medida` `unidmeddetal` on((`productos`.`unidadmedidaventas` = `unidmeddetal`.`id`))) left join `view_reservado` on(((`disponibilidad_x_almacen`.`producto` = `view_reservado`.`producto`) and (`disponibilidad_x_almacen`.`almacen` = `view_reservado`.`idalmacen`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_ingresos`
--

/*!50001 DROP VIEW IF EXISTS `vista_ingresos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_ingresos` AS select `ingreso_almacen`.`id` AS `id`,`ingreso_almacen`.`fecha` AS `fecha`,`ingreso_almacen`.`idalmacen` AS `idalmacen`,`almacen`.`nombre` AS `nombalmacen`,`ingreso_almacen`.`idproducto` AS `idproducto`,`productos`.`nombre` AS `nombproducto`,`ingreso_almacen`.`cantidad` AS `cantidad`,`unidad_medida`.`simbolo` AS `unidmed` from (((`ingreso_almacen` left join `almacen` on((`ingreso_almacen`.`idalmacen` = `almacen`.`id`))) left join `productos` on((`ingreso_almacen`.`idproducto` = `productos`.`id`))) left join `unidad_medida` on((`productos`.`unidadmedidaalmacen` = `unidad_medida`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_items`
--

/*!50001 DROP VIEW IF EXISTS `vista_items`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_items` AS select `productos_x_pedido`.`pedido` AS `pedido`,`productos_x_pedido`.`producto` AS `producto`,`productos`.`nombre` AS `nombproducto`,`unidad_medida`.`simbolo` AS `unidmedprod`,`productos_x_pedido`.`cantidad` AS `cantidad`,`productos_x_pedido`.`subtotal` AS `subtotal` from ((`productos_x_pedido` left join `productos` on((`productos_x_pedido`.`producto` = `productos`.`id`))) left join `unidad_medida` on((`productos`.`unidadmedidaventas` = `unidad_medida`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_movimientos`
--

/*!50001 DROP VIEW IF EXISTS `vista_movimientos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_movimientos` AS select `movimiento_almacen`.`id` AS `id`,`movimiento_almacen`.`idalmacenmayor` AS `idalmacenmayor`,`mayor`.`nombre` AS `nombmayor`,`movimiento_almacen`.`idalmacendetal` AS `idalmacendetal`,`detal`.`nombre` AS `nombdetal`,`movimiento_almacen`.`idproducto` AS `idproducto`,`productos`.`nombre` AS `nombproducto`,`movimiento_almacen`.`cantidad` AS `cantidad`,`unidad_medida`.`simbolo` AS `unidmed`,`movimiento_almacen`.`fecha` AS `fecha`,`movimiento_almacen`.`idusuario` AS `idusuario` from ((((`movimiento_almacen` left join `almacen` `mayor` on((`movimiento_almacen`.`idalmacenmayor` = `mayor`.`id`))) left join `almacen` `detal` on((`movimiento_almacen`.`idalmacendetal` = `detal`.`id`))) left join `productos` on((`movimiento_almacen`.`idproducto` = `productos`.`id`))) left join `unidad_medida` on((`productos`.`unidadmedidaalmacen` = `unidad_medida`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_pedidos`
--

/*!50001 DROP VIEW IF EXISTS `vista_pedidos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_pedidos` AS select `pedidos`.`id` AS `id`,`pedidos`.`codigo` AS `codigo`,`pedidos`.`vendedor` AS `vendedor`,`ventas`.`display_name` AS `nombvendedor`,`pedidos`.`preciototal` AS `preciototal`,`pedidos`.`cliente` AS `cliente`,`pedidos`.`estatus` AS `estatus`,`estatus_pedido`.`nombre` AS `nombestatus`,`estatus_pedido`.`msgclientes` AS `msgclientes`,`estatus_pedido`.`msgventas` AS `msgventas`,`estatus_pedido`.`msgdespacho` AS `msgdespacho`,`pedidos`.`despachador` AS `despachador`,`despacho`.`display_name` AS `nombdespachador`,`pedidos`.`fecha` AS `fecha`,`pedidos`.`hora` AS `hora` from (((`pedidos` left join `user` `ventas` on((`pedidos`.`vendedor` = `ventas`.`user_id`))) left join `user` `despacho` on((`pedidos`.`despachador` = `despacho`.`user_id`))) left join `estatus_pedido` on((`pedidos`.`estatus` = `estatus_pedido`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_productos`
--

/*!50001 DROP VIEW IF EXISTS `vista_productos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_productos` AS select `productos`.`id` AS `id`,`productos`.`nombre` AS `nombre`,truncate(if((`disponibilidad_x_almacen`.`cantidad` <> 0),`disponibilidad_x_almacen`.`cantidad`,0),3) AS `cantidad`,`categorias`.`id` AS `idcategoria`,`categorias`.`nombre` AS `nombcategoria`,`productos`.`unidadmedidaventas` AS `unidadmedidaventas`,`ventas`.`abreviatura` AS `nombunidmedventas`,`productos`.`preciocosto` AS `preciocosto`,`productos`.`ganancia` AS `ganancia`,truncate(if((`productos`.`ganancia` > 0),((`productos`.`ganancia` * `productos`.`preciocosto`) / 100),0),2) AS `montoganancia`,`productos`.`tieneimpuesto` AS `tieneimpuesto`,`productos`.`impuesto` AS `impuesto`,truncate(if((`productos`.`tieneimpuesto` = 1),((`productos`.`impuesto` * (`productos`.`preciocosto` * (1 + (`productos`.`ganancia` / 100)))) / 100),0),2) AS `montoimpuesto`,truncate(if((`productos`.`tieneimpuesto` = 1),((`productos`.`preciocosto` * (1 + (`productos`.`ganancia` / 100))) * (1 + (`productos`.`impuesto` / 100))),(`productos`.`preciocosto` * (1 + (`productos`.`ganancia` / 100)))),2) AS `preciounidad`,`productos`.`unidadmedidaalmacen` AS `unidadmedidaalmacen`,`almacen`.`abreviatura` AS `nombunidmedalmacen`,`productos`.`relacionunidad` AS `relacionunidad`,`productos`.`imagen` AS `imagen`,`productos`.`idmarca` AS `idmarca`,`marca`.`nombre` AS `nombmarca`,`productos`.`codpremium` AS `codpremium`,`productos`.`modificado` AS `modificado`,`productos`.`vencimiento` AS `vencimiento`,`disponiblidad_productos`.`disponible` AS `disponible` from ((((((`productos` left join `categorias` on((`productos`.`idcategoria` = `categorias`.`id`))) left join `unidad_medida` `ventas` on((`productos`.`unidadmedidaventas` = `ventas`.`id`))) left join `unidad_medida` `almacen` on((`productos`.`unidadmedidaalmacen` = `almacen`.`id`))) left join `marca` on((`productos`.`idmarca` = `marca`.`id`))) left join `disponibilidad_x_almacen` on(((`productos`.`id` = `disponibilidad_x_almacen`.`producto`) and (`disponibilidad_x_almacen`.`almacen` = 2)))) left join `disponiblidad_productos` on((`productos`.`id` = `disponiblidad_productos`.`idproducto`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_productos_disponibles`
--

/*!50001 DROP VIEW IF EXISTS `vista_productos_disponibles`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_productos_disponibles` AS select `disponiblidad_productos`.`disponible` AS `disponible`,`productos`.`id` AS `id`,`productos`.`nombre` AS `nombre`,truncate(if((`disponibilidad_x_almacen`.`cantidad` <> 0),`disponibilidad_x_almacen`.`cantidad`,0),3) AS `cantidad`,`categorias`.`id` AS `idcategoria`,`categorias`.`nombre` AS `nombcategoria`,`productos`.`unidadmedidaventas` AS `unidadmedidaventas`,`ventas`.`abreviatura` AS `nombunidmedventas`,`productos`.`preciocosto` AS `preciocosto`,`productos`.`ganancia` AS `ganancia`,truncate(if((`productos`.`ganancia` > 0),((`productos`.`ganancia` * `productos`.`preciocosto`) / 100),0),2) AS `montoganancia`,`productos`.`tieneimpuesto` AS `tieneimpuesto`,`productos`.`impuesto` AS `impuesto`,truncate(if((`productos`.`tieneimpuesto` = 1),((`productos`.`impuesto` * (`productos`.`preciocosto` * (1 + (`productos`.`ganancia` / 100)))) / 100),0),2) AS `montoimpuesto`,truncate(if((`productos`.`tieneimpuesto` = 1),((`productos`.`preciocosto` * (1 + (`productos`.`ganancia` / 100))) * (1 + (`productos`.`impuesto` / 100))),(`productos`.`preciocosto` * (1 + (`productos`.`ganancia` / 100)))),2) AS `preciounidad`,`productos`.`unidadmedidaalmacen` AS `unidadmedidaalmacen`,`almacen`.`abreviatura` AS `nombunidmedalmacen`,`productos`.`relacionunidad` AS `relacionunidad`,`productos`.`imagen` AS `imagen`,`productos`.`idmarca` AS `idmarca`,`marca`.`nombre` AS `nombmarca`,`productos`.`codpremium` AS `codpremium`,`productos`.`modificado` AS `modificado`,`productos`.`vencimiento` AS `vencimiento` from ((((((`productos` left join `categorias` on((`productos`.`idcategoria` = `categorias`.`id`))) left join `unidad_medida` `ventas` on((`productos`.`unidadmedidaventas` = `ventas`.`id`))) left join `unidad_medida` `almacen` on((`productos`.`unidadmedidaalmacen` = `almacen`.`id`))) left join `marca` on((`productos`.`idmarca` = `marca`.`id`))) left join `disponibilidad_x_almacen` on(((`productos`.`id` = `disponibilidad_x_almacen`.`producto`) and (`disponibilidad_x_almacen`.`almacen` = 2)))) join `disponiblidad_productos` on(((`productos`.`id` = `disponiblidad_productos`.`idproducto`) and (`disponiblidad_productos`.`disponible` = 1)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_productos_traslado`
--

/*!50001 DROP VIEW IF EXISTS `vista_productos_traslado`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_productos_traslado` AS select `disponibilidad_x_almacen`.`id` AS `id`,`disponibilidad_x_almacen`.`almacen` AS `idalmacen`,`almacen`.`nombre` AS `nombre`,`marca`.`id` AS `idmarca`,`marca`.`nombre` AS `nombmarca`,`categorias`.`id` AS `idcategoria`,`categorias`.`nombre` AS `nombcategoria`,`disponibilidad_x_almacen`.`producto` AS `idproducto`,`productos`.`nombre` AS `nombproducto`,`disponibilidad_x_almacen`.`cantidad` AS `disponible`,`unidmedalmacen`.`simbolo` AS `unidmed` from ((((((`disponibilidad_x_almacen` left join `almacen` on((`disponibilidad_x_almacen`.`almacen` = `almacen`.`id`))) left join `tipo_almacen` on((`almacen`.`idtipoalmacen` = `tipo_almacen`.`id`))) left join `productos` on((`disponibilidad_x_almacen`.`producto` = `productos`.`id`))) left join `unidad_medida` `unidmedalmacen` on((`productos`.`unidadmedidaalmacen` = `unidmedalmacen`.`id`))) left join `marca` on((`productos`.`idmarca` = `marca`.`id`))) left join `categorias` on((`productos`.`idcategoria` = `categorias`.`id`))) where (`almacen`.`idtipoalmacen` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-27 10:19:49
