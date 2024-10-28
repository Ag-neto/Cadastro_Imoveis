CREATE DATABASE  IF NOT EXISTS `controledepropriedade` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `controledepropriedade`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: controledepropriedade
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
  `endereco` varchar(45) DEFAULT NULL,
  `id_localizacao` int DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `profissao` varchar(45) DEFAULT NULL,
  `nacionalidade` varchar(45) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (3,'MICAEL LUCAS DIAS TAVARES','12.345.678-9','123.456.789-09','RUA NOVA, MATA REDONDA',1,'2005-01-20','(83) 98179-7415','DESENVOLVEDOR DE SOFTWARE','BRASILEIRO','58320-000'),(5,'CLIENTE DE TESTE','33.333.333-3','333.333.3333-3','RUA TESTE, TESTE, TESTE',2,'1990-12-01','(33) 33333-3333','PROFISSÃO DE TESTE','BRASILEIRO','58320-000');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conta_corrente_propriedade`
--

LOCK TABLES `conta_corrente_propriedade` WRITE;
/*!40000 ALTER TABLE `conta_corrente_propriedade` DISABLE KEYS */;
INSERT INTO `conta_corrente_propriedade` VALUES (9,8,'LIMPESA',500.00,'2024-10-21','despesa',-500.00),(10,8,'LIMPESA 2',500.00,'2024-10-21','despesa',-1000.00),(12,8,'LIMPESA 3',500.00,'2024-10-21','despesa',-1500.00),(13,8,'ALUGUEL PAGO',2000.00,'2024-10-21','receita',500.00),(14,11,'TESTE',100.00,'2024-10-22','despesa',-100100.00),(15,11,'TESTE',100.00,'2024-10-22','receita',-100000.00),(16,11,'ALUGUEL PAGO',5000.00,'2024-10-23','receita',-95000.00);
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
  `valor_aluguel` float DEFAULT NULL,
  `vencimento` int DEFAULT NULL,
  `data_inicio_residencia` date DEFAULT NULL,
  `data_final_residencia` date DEFAULT NULL,
  `periodo_residencia` int DEFAULT NULL,
  `tipo_contrato` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_contratos`),
  KEY `id_propriedade_idx` (`id_propriedade`),
  KEY `id_cliente_idx` (`id_cliente`),
  CONSTRAINT `fk_cliente_contrato` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`idcliente`),
  CONSTRAINT `fk_propriedade_contrato` FOREIGN KEY (`id_propriedade`) REFERENCES `propriedade` (`idpropriedade`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contratos`
--

LOCK TABLES `contratos` WRITE;
/*!40000 ALTER TABLE `contratos` DISABLE KEYS */;
INSERT INTO `contratos` VALUES (1,11,3,1000,20241101,'2024-10-24','2025-10-24',365,'ALUGUEL');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentacao_cliente`
--

LOCK TABLES `documentacao_cliente` WRITE;
/*!40000 ALTER TABLE `documentacao_cliente` DISABLE KEYS */;
INSERT INTO `documentacao_cliente` VALUES (3,'Contrato 01-24.pdf','arquivos/670feefe73505.pdf','2024-10-16',3),(4,'Currículo.pdf','arquivos/670feefe74ffc.pdf','2024-10-16',3),(7,'Contrato de Locação de Imóvel.pdf','arquivos/671aa5738d717.pdf','2024-10-24',5);
/*!40000 ALTER TABLE `documentacao_cliente` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentacao_propriedade`
--

LOCK TABLES `documentacao_propriedade` WRITE;
/*!40000 ALTER TABLE `documentacao_propriedade` DISABLE KEYS */;
INSERT INTO `documentacao_propriedade` VALUES (102,'Contrato 01-24.pdf','arquivos/670da98bb7e61.pdf','2024-10-14',11),(103,'Currículo.pdf','arquivos/670da98bb96b1.pdf','2024-10-14',11),(104,'Contrato 01-24.pdf','arquivos/670daa20d87cd.pdf','2024-10-14',12),(105,'Currículo.pdf','arquivos/670daa20da2ba.pdf','2024-10-14',12),(108,'teste.pdf','arquivos/670e56e193a92.pdf','2024-10-15',8),(109,'teste.pdf','arquivos/670e570444a63.pdf','2024-10-15',12),(114,'teste.pdf','arquivos/670e887da1dcd.pdf','2024-10-15',15),(115,'235_pt_manual_1705497285.pdf','arquivos/670e887da3da7.pdf','2024-10-15',15),(118,'teste.pdf','arquivos/671695fa4acf7.pdf','2024-10-21',18),(119,'Contrato 01-24.pdf','arquivos/6716da7893776.pdf','2024-10-21',20);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `localizacao`
--

LOCK TABLES `localizacao` WRITE;
/*!40000 ALTER TABLE `localizacao` DISABLE KEYS */;
INSERT INTO `localizacao` VALUES (1,'ALHANDRA',15),(2,'JOÃO PESSOA',15),(3,'RECIFE',17);
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
-- Table structure for table `pagamento_aluguel`
--

DROP TABLE IF EXISTS `pagamento_aluguel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagamento_aluguel` (
  `idpagamento_aluguel` int NOT NULL AUTO_INCREMENT,
  `id_contrato_aluguel` int DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idpagamento_aluguel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagamento_aluguel`
--

LOCK TABLES `pagamento_aluguel` WRITE;
/*!40000 ALTER TABLE `pagamento_aluguel` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagamento_aluguel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propriedade`
--

DROP TABLE IF EXISTS `propriedade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `propriedade` (
  `idpropriedade` int NOT NULL AUTO_INCREMENT,
  `nome_propriedade` varchar(45) NOT NULL,
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
  PRIMARY KEY (`idpropriedade`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propriedade`
--

LOCK TABLES `propriedade` WRITE;
/*!40000 ALTER TABLE `propriedade` DISABLE KEYS */;
INSERT INTO `propriedade` VALUES (8,'MINHA LOJA',2,7,100,123456,'FAZENDA DA BOA ESPERANÇA ',1,'2024-10-14 00:00:00','IPTU',150,'Mensal'),(11,'PROPRIEDADE COMPLETA',2,2,500,100000,'FAZENDA DA BOA ESPERANÇA',1,'2024-10-14 00:00:00',NULL,NULL,NULL),(12,'LOJA ALI DA ESQUINA',3,2,123,123123,'FAZENDA DA BOA ESPERANÇA ',2,'2024-10-14 00:00:00',NULL,NULL,NULL),(15,'POLIMASSA ARGAMASSA LTDA',1,2,2000,10000000,'BR 101 - KM 106',8,'2024-10-15 00:00:00',NULL,NULL,NULL),(18,'PROPRIEDADE COM IMPOSTO',2,1,22,100000,'CENTRO',8,'2024-10-21 00:00:00','IPTU',1000,'Anual'),(19,'TESTE2',1,1,123,12312,'FAZENDA DA BOA ESPERANÇA ',1,'2024-10-21 00:00:00','ITR',122,'Mensal'),(20,'TEST3',3,1,123,122,'CENTRO, S/N',1,'2024-10-21 00:00:00','IPTU',123,'Nenhum');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'micael','$2y$10$/Tg2pox.43DYGEgVmUBARuAlMsTX3hyU2AjrBBa4GloZKKfhAQ0OS',1,'micaellucasdias@gmail.com',3);
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

-- Dump completed on 2024-10-28  0:11:42
