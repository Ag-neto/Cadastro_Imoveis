CREATE TABLE Propriedades (
  PropriedadeID INT AUTO_INCREMENT PRIMARY KEY,
  TipoPropriedade VARCHAR(50),  // apartamento, casa, fazenda, etc.
  InformaçãoPropriedade TEXT,  // informações gerais
  DataRegistro DATE,  // data que o inquilo chegou
  Tamanho DECIMAL(10, 2),  // tamanho da propriedade
  Localização VARCHAR(100),  // localização
  IPTU DECIMAL(10, 2)  // valor do IPTU para zona urbana
  ITR DECIMAL(10,2) // valor do ITR para zona rural
);