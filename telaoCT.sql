CREATE TABLE `conteudo` (
  `id` int NOT NULL,
  `idTela` int DEFAULT NULL,
  `tipo` int NOT NULL,
  `posicao` int NOT NULL DEFAULT '1',
  `dados` varchar(500) NOT NULL,
  `duracaoVideo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `telas` (
  `id` int NOT NULL,
  `tipo` int NOT NULL DEFAULT '1',
  `descricao` varchar(200) NOT NULL,
  `duracao` int NOT NULL DEFAULT '20',
  `dataLimite` date NOT NULL DEFAULT '2030-01-01',
  `ordem` int NOT NULL DEFAULT '1000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

ALTER TABLE `conteudo` ADD PRIMARY KEY (`id`), ADD KEY `idTela` (`idTela`);

ALTER TABLE `conteudo` MODIFY `id` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `telas`  MODIFY `id` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `telas` ADD PRIMARY KEY (`id`);

ALTER TABLE `conteudo`  ADD CONSTRAINT `conteudo_ibfk_1` FOREIGN KEY (`idTela`) REFERENCES `telas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;