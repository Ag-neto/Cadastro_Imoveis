CREATE DATABASE  IF NOT EXISTS `controledepropriedade2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `controledepropriedade2`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: controledepropriedade2
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `idcliente` int NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(45) DEFAULT NULL,
  `rg_numero` varchar(45) DEFAULT NULL,
  `cpf_numero` varchar(45) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `id_localizacao` int DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `profissao` varchar(45) DEFAULT NULL,
  `nacionalidade` varchar(45) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (3,'MICAEL LUCAS DIAS TAVARES','12.345.678-9','123.456.789-09','RUA NOVA, MATA REDONDA',1,'2005-01-20','(83) 98179-7415','DESENVOLVEDOR DE SOFTWARE','BRASILEIRO','58320-000'),(5,'CLIENTE DE TESTE','33.333.333-3','333.333.333-32','RUA TESTE, TESTE, TESTE',2,'1990-12-01','(33) 33333-3333','PROFISSÃO DE TESTE','BRASILEIRO','58320-000'),(6,'MARÍLIA ARAÚJO REUL','31.720.96','090.109.574-54','RUA BACHAREL JOSÉ DE OLIVEIRA CURCHATUZ, 320, JARDIM OCEANIA',2,'1989-05-28','(83) 99610-3230','PSICÓLOGA','BRASILEIRA','58037-432');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conta_corrente_propriedade`
--

DROP TABLE IF EXISTS `conta_corrente_propriedade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conta_corrente_propriedade` (
  `id_movimento` int NOT NULL AUTO_INCREMENT,
  `id_propriedade` int DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_movimento` date DEFAULT NULL,
  `tipo_movimento` enum('receita','despesa') DEFAULT NULL,
  `saldo_acumulado` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_movimento`),
  KEY `id_propriedade` (`id_propriedade`),
  CONSTRAINT `conta_corrente_propriedade_ibfk_1` FOREIGN KEY (`id_propriedade`) REFERENCES `propriedade` (`idpropriedade`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conta_corrente_propriedade`
--

LOCK TABLES `conta_corrente_propriedade` WRITE;
/*!40000 ALTER TABLE `conta_corrente_propriedade` DISABLE KEYS */;
/*!40000 ALTER TABLE `conta_corrente_propriedade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contratos`
--

DROP TABLE IF EXISTS `contratos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contratos` (
  `id_contratos` int NOT NULL AUTO_INCREMENT,
  `id_propriedade` int DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  `data_compra` date DEFAULT NULL,
  `data_inicio_residencia` date DEFAULT NULL,
  `data_final_residencia` date DEFAULT NULL,
  `periodo_residencia` int DEFAULT NULL,
  `tipo_contrato` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_contratos`),
  KEY `id_propriedade_idx` (`id_propriedade`),
  KEY `id_cliente_idx` (`id_cliente`),
  CONSTRAINT `fk_cliente_contrato` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`idcliente`),
  CONSTRAINT `fk_propriedade_contrato` FOREIGN KEY (`id_propriedade`) REFERENCES `propriedade` (`idpropriedade`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contratos`
--

LOCK TABLES `contratos` WRITE;
/*!40000 ALTER TABLE `contratos` DISABLE KEYS */;
INSERT INTO `contratos` VALUES (32,28,6,1500,'2024-01-15',NULL,'2024-01-01','2025-01-01',366,'ALUGUEL');
/*!40000 ALTER TABLE `contratos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentacao_cliente`
--

DROP TABLE IF EXISTS `documentacao_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentacao_cliente` (
  `iddocumentacao_cliente` int NOT NULL AUTO_INCREMENT,
  `nome_doc` varchar(45) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `data_upload` date DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  PRIMARY KEY (`iddocumentacao_cliente`),
  KEY `id_cliente_idx` (`id_cliente`),
  CONSTRAINT `id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentacao_cliente`
--

LOCK TABLES `documentacao_cliente` WRITE;
/*!40000 ALTER TABLE `documentacao_cliente` DISABLE KEYS */;
INSERT INTO `documentacao_cliente` VALUES (3,'Contrato 01-24.pdf','arquivos/670feefe73505.pdf','2024-10-16',3),(4,'Currículo.pdf','arquivos/670feefe74ffc.pdf','2024-10-16',3),(7,'Contrato de Locação de Imóvel.pdf','arquivos/671aa5738d717.pdf','2024-10-24',5),(8,'RG_MARILIA_ARAUJO_REUL.pdf','arquivos/6734ba6807d83.pdf','2024-11-13',6);
/*!40000 ALTER TABLE `documentacao_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentacao_contrato`
--

DROP TABLE IF EXISTS `documentacao_contrato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentacao_contrato` (
  `iddocumentacao_contrato` int NOT NULL AUTO_INCREMENT,
  `nome_doc` varchar(250) NOT NULL,
  `path` varchar(250) NOT NULL,
  `data_upload` date NOT NULL,
  `id_contrato` int DEFAULT NULL,
  PRIMARY KEY (`iddocumentacao_contrato`),
  KEY `id_contrato_idx` (`id_contrato`),
  CONSTRAINT `id_contrato` FOREIGN KEY (`id_contrato`) REFERENCES `contratos` (`id_contratos`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentacao_contrato`
--

LOCK TABLES `documentacao_contrato` WRITE;
/*!40000 ALTER TABLE `documentacao_contrato` DISABLE KEYS */;
INSERT INTO `documentacao_contrato` VALUES (8,'Contrato Sala 712.pdf','arquivos/6734bc80087c5.pdf','2024-11-13',32);
/*!40000 ALTER TABLE `documentacao_contrato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentacao_propriedade`
--

DROP TABLE IF EXISTS `documentacao_propriedade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentacao_propriedade` (
  `iddocumentacao_propriedade` int NOT NULL AUTO_INCREMENT,
  `nome_doc` varchar(250) NOT NULL,
  `path` varchar(250) NOT NULL,
  `data_upload` date NOT NULL,
  `id_propriedade` int DEFAULT NULL,
  PRIMARY KEY (`iddocumentacao_propriedade`),
  KEY `fk_propriedade` (`id_propriedade`),
  CONSTRAINT `fk_propriedade` FOREIGN KEY (`id_propriedade`) REFERENCES `propriedade` (`idpropriedade`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentacao_propriedade`
--

LOCK TABLES `documentacao_propriedade` WRITE;
/*!40000 ALTER TABLE `documentacao_propriedade` DISABLE KEYS */;
INSERT INTO `documentacao_propriedade` VALUES (125,'TOSCANO DE BRITO.pdf','arquivos/6734aaefb9b2c.pdf','2024-11-13',23),(126,'terrenoOI20_compressed.pdf','arquivos/6734b01c32d3e.pdf','2024-11-13',24),(127,'terrenoOi19_compressed.pdf','arquivos/6734b1a876459.pdf','2024-11-13',25),(128,'terrenoAltiplano22.pdf','arquivos/6734b4fea4230.pdf','2024-11-13',26),(129,'terrenoOrquideas64.pdf','arquivos/6734b66170007.pdf','2024-11-13',27),(130,'sala712.pdf','arquivos/6734b7a898b4d.pdf','2024-11-13',28),(131,'salaParthenon7_compressed.pdf','arquivos/6734bf1a69acb.pdf','2024-11-13',29),(132,'salaParthenon8.pdf','arquivos/6734c183c9a8d.pdf','2024-11-13',30),(133,'salaTrade2.pdf','arquivos/6734c27a96938.pdf','2024-11-13',31),(134,'gameleiras130.pdf','arquivos/6734c3611b854.pdf','2024-11-13',32);
/*!40000 ALTER TABLE `documentacao_propriedade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados` (
  `id_estado` int NOT NULL AUTO_INCREMENT,
  `nome_estado` varchar(45) DEFAULT NULL,
  `sigla` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados`
--

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` VALUES (1,'Acre','AC'),(2,'Alagoas','AL'),(3,'Amapá','AP'),(4,'Amazonas','AM'),(5,'Bahia','BA'),(6,'Ceará','CE'),(7,'Distrito Federal','DF'),(8,'Espírito Santo','ES'),(9,'Goiás','GO'),(10,'Maranhão','MA'),(11,'Mato Grosso','MT'),(12,'Mato Grosso do Sul','MS'),(13,'Minas Gerais','MG'),(14,'Pará','PA'),(15,'Paraíba','PB'),(16,'Paraná','PR'),(17,'Pernambuco','PE'),(18,'Piauí','PI'),(19,'Rio de Janeiro','RJ'),(20,'Rio Grande do Norte','RN'),(21,'Rio Grande do Sul','RS'),(22,'Rondônia','RO'),(23,'Roraima','RR'),(24,'Santa Catarina','SC'),(25,'São Paulo','SP'),(26,'Sergipe','SE'),(27,'Tocantins','TO');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localizacao`
--

DROP TABLE IF EXISTS `localizacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `localizacao` (
  `idlocalizacao` int NOT NULL AUTO_INCREMENT,
  `nome_cidade` varchar(20) DEFAULT NULL,
  `id_estado` int DEFAULT NULL,
  PRIMARY KEY (`idlocalizacao`),
  KEY `id_estado_idx` (`id_estado`),
  CONSTRAINT `id_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `localizacao`
--

LOCK TABLES `localizacao` WRITE;
/*!40000 ALTER TABLE `localizacao` DISABLE KEYS */;
INSERT INTO `localizacao` VALUES (1,'ALHANDRA',15),(2,'JOÃO PESSOA',15),(3,'RECIFE',17),(4,'RIO DE JANEIRO',19);
/*!40000 ALTER TABLE `localizacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_atividades`
--

DROP TABLE IF EXISTS `log_atividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_atividades` (
  `idlog_atividades` int NOT NULL,
  `atividade` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idlog_atividades`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_atividades`
--

LOCK TABLES `log_atividades` WRITE;
/*!40000 ALTER TABLE `log_atividades` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_atividades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `acao` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` int NOT NULL,
  `nivel_acesso` int NOT NULL,
  `url_destino` varchar(45) DEFAULT NULL,
  `lida` tinyint(1) DEFAULT '0',
  `id_pagamento` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `nivel_acesso` (`nivel_acesso`),
  KEY `logs_ibfk_3_idx` (`id_pagamento`),
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idusuario`),
  CONSTRAINT `logs_ibfk_2` FOREIGN KEY (`nivel_acesso`) REFERENCES `nivel_de_acesso` (`id_nivel`),
  CONSTRAINT `logs_ibfk_3` FOREIGN KEY (`id_pagamento`) REFERENCES `pagamentos` (`id_pagamento`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (28,'Notificação de Vencimento','Propriedade: SALA 712 - Pagamento vencido para confirmação','2024-11-29 14:11:58',1,1,'controle_financas.php',0,34148);
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivel_de_acesso`
--

DROP TABLE IF EXISTS `nivel_de_acesso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nivel_de_acesso` (
  `id_nivel` int NOT NULL AUTO_INCREMENT,
  `nome_nivel` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_nivel`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel_de_acesso`
--

LOCK TABLES `nivel_de_acesso` WRITE;
/*!40000 ALTER TABLE `nivel_de_acesso` DISABLE KEYS */;
INSERT INTO `nivel_de_acesso` VALUES (1,'administrador'),(2,'usuario');
/*!40000 ALTER TABLE `nivel_de_acesso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagamentos`
--

DROP TABLE IF EXISTS `pagamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagamentos` (
  `id_pagamento` int NOT NULL AUTO_INCREMENT,
  `id_contrato` int DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `status` enum('pendente','pago','confirmando','vencido','pago_vencido') DEFAULT 'pendente',
  `comprovante` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pagamento`),
  KEY `id_contrato` (`id_contrato`),
  CONSTRAINT `pagamentos_ibfk_1` FOREIGN KEY (`id_contrato`) REFERENCES `contratos` (`id_contratos`)
) ENGINE=InnoDB AUTO_INCREMENT=34150 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagamentos`
--

LOCK TABLES `pagamentos` WRITE;
/*!40000 ALTER TABLE `pagamentos` DISABLE KEYS */;
INSERT INTO `pagamentos` VALUES (34138,32,1500.00,'2024-01-15','pendente',''),(34139,32,1500.00,'2024-02-15','pendente',''),(34140,32,1500.00,'2024-03-15','pendente',''),(34141,32,1500.00,'2024-04-15','pendente',''),(34142,32,1500.00,'2024-05-15','pendente',''),(34143,32,1500.00,'2024-06-15','pendente',''),(34144,32,1500.00,'2024-07-15','pendente',''),(34145,32,1500.00,'2024-08-15','pendente',''),(34146,32,1500.00,'2024-09-15','pendente',''),(34147,32,1500.00,'2024-10-15','pendente',''),(34148,32,1500.00,'2024-11-15','vencido',''),(34149,32,1500.00,'2024-12-15','pendente','');
/*!40000 ALTER TABLE `pagamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propriedade`
--

DROP TABLE IF EXISTS `propriedade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `propriedade` (
  `idpropriedade` int NOT NULL AUTO_INCREMENT,
  `nome_propriedade` varchar(255) NOT NULL,
  `id_localizacao` int DEFAULT NULL,
  `id_tipo_prop` int DEFAULT NULL,
  `tamanho` float DEFAULT NULL,
  `valor_adquirido` float DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `id_situacao` int DEFAULT NULL,
  `data_registro` datetime DEFAULT NULL,
  `tipo_imposto` varchar(45) DEFAULT NULL,
  `valor_imposto` float DEFAULT NULL,
  `periodo_imposto` varchar(45) DEFAULT NULL,
  `incra` varchar(255) DEFAULT NULL,
  `nome_fantasia` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idpropriedade`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propriedade`
--

LOCK TABLES `propriedade` WRITE;
/*!40000 ALTER TABLE `propriedade` DISABLE KEYS */;
INSERT INTO `propriedade` VALUES (23,'TERRENO TORRE',2,4,270,400,'RUA CARNEIRO DA CUNHA, 134, TORRE',2,'2015-10-08 00:00:00','IPTU',245,'Anual','322.222.222.222-22','CASA DO SEU JOÃO'),(24,'TERRENO OI 20',2,4,600,390,'RUA ANTÔNIO FRANCISCANO DO AMARAL, LOTEAMENTO JARDIM BELA VISTA, 20, ALTIPLANO',2,'2022-09-01 00:00:00','IPTU',200,'Anual',NULL,NULL),(25,'TERRENO OI 19',2,4,600,390,'RUA ANTÔNIO FRANCISCANO DO AMARAL, LOTEAMENTO JARDIM BELA VISTA, 19, ALTIPLANO',2,'2022-09-10 00:00:00','IPTU',200,'Anual',NULL,NULL),(26,'TERRENO ALTIPLANO 22',2,4,480,450,'RUA ANTÔNIO FRANCISCANO DO AMARAL, LOTEAMENTO JARDIM BELA VISTA, 22, ALTIPLANO',2,'2018-11-26 00:00:00','IPTU',200,'Anual',NULL,NULL),(27,'TERRENO ORQUÍDEAS 64',2,4,450,400,'AVENIDA GOVERNADOR ANTONIO DA SILVA MARIZ, 600, LOTE 64',8,'2016-01-04 00:00:00','IPTU',300,'Anual',NULL,NULL),(28,'SALA 712',2,7,26,60,'AVENIDA RUI CARNEIRO, 300, MIRAMAR',7,'2015-06-02 00:00:00','IPTU',100,'Anual',NULL,NULL),(29,'SALA PARTHENON 07',2,7,54,194,'RUA JOSITA ALMEIDA, 240, ALTIPLANO',2,'2017-12-20 00:00:00','IPTU',200,'Anual',NULL,NULL),(30,'SALA PARTHENON 08',2,7,54,140,'RUA JOSITA ALMEIDA, 240, ALTIPLANO',2,'2018-10-04 00:00:00','IPTU',100,'Anual',NULL,NULL),(31,'SALA 02 TRADE CENTER',2,7,43,100,'AVENIDA RUI CARNEIRO, 300, MIRAMAR',2,'2017-08-14 00:00:00','IPTU',100,'Anual',NULL,NULL),(32,'GAMELEIRAS 130',2,4,450,405,'AVENIDA GOVERNADOR ANTONIO DA SILVA MARIZ, 601, PORTAL DO SOL',2,'2016-05-16 00:00:00','IPTU',100,'Anual',NULL,NULL);
/*!40000 ALTER TABLE `propriedade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `situacao`
--

DROP TABLE IF EXISTS `situacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `situacao` (
  `id_situacao` int NOT NULL AUTO_INCREMENT,
  `nome_situacao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_situacao`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `situacao`
--

LOCK TABLES `situacao` WRITE;
/*!40000 ALTER TABLE `situacao` DISABLE KEYS */;
INSERT INTO `situacao` VALUES (1,'À Venda'),(2,'Para Alugar'),(3,'Arrendamento'),(4,'Permuta'),(5,'Em Construção'),(6,'Vendido'),(7,'Alugado'),(8,'Disponivel');
/*!40000 ALTER TABLE `situacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_prop`
--

DROP TABLE IF EXISTS `tipo_prop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_prop` (
  `id_tipo_prop` int NOT NULL AUTO_INCREMENT,
  `nome_tipo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_prop`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_prop`
--

LOCK TABLES `tipo_prop` WRITE;
/*!40000 ALTER TABLE `tipo_prop` DISABLE KEYS */;
INSERT INTO `tipo_prop` VALUES (1,'Residencial'),(2,'Industrial'),(3,'Rural'),(4,'Terreno'),(7,'Comercial');
/*!40000 ALTER TABLE `tipo_prop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(45) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `idnivel_acesso` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_cliente` int DEFAULT NULL,
  PRIMARY KEY (`idusuario`),
  KEY `id_cliente_idx` (`id_cliente`),
  CONSTRAINT `fk_cliente_usuario` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'micael','$2y$10$/Tg2pox.43DYGEgVmUBARuAlMsTX3hyU2AjrBBa4GloZKKfhAQ0OS',1,'micaellucasdias@gmail.com',3),(2,'Usuario Teste','$2y$10$uTNdUhkrAm4hJbq0We8CQepGFDFMc5Z0KmKH2J7VtnkHrNvqqomc6',2,'teste@gmail.com',5),(3,'agnaldo','$2y$10$QLiTj2DqtNxbUoJ7zHo1SebfTW75.UBizClvQSwQ6sbQD0G.tayFe',1,'guineto2002@hotmail.com',NULL),(4,'melina','$2y$10$HAAWd8toK3W1Ml9ecAVymOkI2uVbF9tMiOUAEM/rjF4ihRl4xmzJy',1,'melinazevedo@hotmail.com',6);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-08 15:51:03
