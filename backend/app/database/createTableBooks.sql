CREATE TABLE books (id INT AUTO_INCREMENT KEY, title VARCHAR(100), description VARCHAR(400),
                    pages INT, year INT, views INT DEFAULT 0, clicks INT DEFAULT 0);