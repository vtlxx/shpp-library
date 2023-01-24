CREATE TABLE books_authors (book_id INT, author_id INT,
                            FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE,
                            FOREIGN KEY (book_id) REFERENCES books (id) ON DELETE CASCADE);
