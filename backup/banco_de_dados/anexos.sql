CREATE TABLE anexos (
  ID INT PRIMARY KEY,
  NomeArquivo VARCHAR(255),
  TipoArquivo VARCHAR(50),
  CaminhoArquivo VARCHAR(255)
);

INSERT INTO anexos (NomeArquivo, TipoArquivo, CaminhoArquivo)
VALUES ('search-ms:displayname=Resultados%20da%20Pesquisa%20em%20aleatoriedade&crumb=Qualquertexto%3Ateste&crumb=location:C%3A%5Caleatoriedade');