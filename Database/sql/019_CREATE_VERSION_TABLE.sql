/* Holds our versions */
CREATE TABLE IF NOT EXISTS Versions (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    version_date VARCHAR(16) NOT NULL,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
/*