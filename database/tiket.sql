-- Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel events
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) NOT NULL UNIQUE,
    event_images VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    kota VARCHAR(255) NOT NULL,
    description LONGTEXT NOT NULL,
    terms LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Tabel event_tickets
CREATE TABLE event_tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    ticket_name VARCHAR(100) NOT NULL,
    price VARCHAR(255) NOT NULL,
    qty INT NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
);


-- Tabel orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(255) NOT NULL,
    user_id INT,
    event_ticket_id INT,
    status ENUM('pending','used') NOT NULL DEFAULT 'pending',
    snaptoken VARCHAR(255) NOT NULL,
    barcode VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_ticket_id) REFERENCES event_tickets(id),
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Tabel Payments
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    transaction_status ENUM('pending', 'success', 'cancel') NOT NULL DEFAULT 'pending',
    transaction_time TIMESTAMP,
    transaction_id VARCHAR(255),
    transaction_status_code VARCHAR(255),
    transaction_status_message VARCHAR(255),
    transaction_gross_amount VARCHAR(255),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Logs
CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    activity LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



