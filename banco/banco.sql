-- Trabalho M3 - Banco de Dados
-- Executar no MySQL: mysql -u root -p < banco.sql

DROP DATABASE IF EXISTS condominio;
CREATE DATABASE condominio;
USE condominio;

-- RN02
CREATE TABLE pagador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    documento VARCHAR(30) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);

-- RN03
CREATE TABLE unidade (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(20) NOT NULL,
    localizacao VARCHAR(150) NOT NULL
);

-- RN01
CREATE TABLE pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pagador INT NOT NULL,
    data_pagamento DATE NOT NULL,
    comprovante MEDIUMBLOB NOT NULL,
    ano_referencia INT NOT NULL,
    mes_referencia INT NOT NULL,
    id_unidade INT NOT NULL,
    data_registro DATETIME,
    FOREIGN KEY (id_pagador) REFERENCES pagador(id),
    FOREIGN KEY (id_unidade) REFERENCES unidade(id)
);

-- RNF06: data de registro atribuida por trigger
DELIMITER $$
CREATE TRIGGER tg_pagamento_data_registro
BEFORE INSERT ON pagamento
FOR EACH ROW
BEGIN
    SET NEW.data_registro = NOW();
END$$

-- RNF05: insercao e delecao por stored procedures

CREATE PROCEDURE sp_inserir_pagador(IN p_nome VARCHAR(150), IN p_email VARCHAR(150),
                                    IN p_documento VARCHAR(30), IN p_telefone VARCHAR(20))
BEGIN
    INSERT INTO pagador (nome, email, documento, telefone)
    VALUES (p_nome, p_email, p_documento, p_telefone);
END$$

CREATE PROCEDURE sp_excluir_pagador(IN p_id INT)
BEGIN
    DELETE FROM pagador WHERE id = p_id;
END$$

CREATE PROCEDURE sp_inserir_unidade(IN p_numero VARCHAR(20), IN p_localizacao VARCHAR(150))
BEGIN
    INSERT INTO unidade (numero, localizacao) VALUES (p_numero, p_localizacao);
END$$

CREATE PROCEDURE sp_excluir_unidade(IN p_id INT)
BEGIN
    DELETE FROM unidade WHERE id = p_id;
END$$

CREATE PROCEDURE sp_inserir_pagamento(IN p_id_pagador INT, IN p_data_pagamento DATE,
                                      IN p_comprovante MEDIUMBLOB, IN p_ano INT,
                                      IN p_mes INT, IN p_id_unidade INT)
BEGIN
    INSERT INTO pagamento (id_pagador, data_pagamento, comprovante,
                           ano_referencia, mes_referencia, id_unidade)
    VALUES (p_id_pagador, p_data_pagamento, p_comprovante, p_ano, p_mes, p_id_unidade);
END$$

CREATE PROCEDURE sp_excluir_pagamento(IN p_id INT)
BEGIN
    DELETE FROM pagamento WHERE id = p_id;
END$$

DELIMITER ;
