CREATE TABLE IF NOT EXISTS niveis (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        nivel VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS desenvolvedores (
                                 id INT AUTO_INCREMENT PRIMARY KEY,
                                 nivel_id INT NOT NULL,
                                 nome VARCHAR(100) NOT NULL,
                                 sexo char(1) NOT NULL,
                                 data_nascimento VARCHAR(100) NOT NULL,
                                 hobby VARCHAR(255),
                                 FOREIGN KEY (nivel_id) REFERENCES niveis(id)
);