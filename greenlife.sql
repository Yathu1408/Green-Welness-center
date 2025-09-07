-- Create Database
CREATE DATABASE IF NOT EXISTS greenlife;
USE greenlife;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    legalid VARCHAR(20)NOT NULL UNIQUE,
    phone VARCHAR(20),
    email VARCHAR(100) ,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bookings Table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    therapist_id INT NOT NULL,
    service VARCHAR(100) NOT NULL,
    booking_date DATE NOT NULL,
    booking_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (therapist_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,        -- always the customer
    receiver_id INT NOT NULL,      -- admin or therapist
    service VARCHAR(100),          -- optional, filled if related to service
    subject VARCHAR(255),
    message TEXT NOT NULL,
    type ENUM('support','service') NOT NULL, -- customer support OR service-related
    status ENUM('pending','replied') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE therapist_services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    therapist_id INT NOT NULL,
    service_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (therapist_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    program_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE program_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    program_id INT NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE user_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    therapist_id INT NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (therapist_id) REFERENCES customers(id) ON DELETE CASCADE
);


-- Insert Admin user
INSERT INTO customers (name, legalid, email, password, role) 
VALUES ('Admin User', 'ADMIN001', 'admin@example.com', 'admin123', 'admin');

-- Insert Therapist user
INSERT INTO customers (name, legalid, email, password, role) 
VALUES ('Dr. Smith', 'THERA001', 'therapist@example.com', '12345', 'therapist');

-- Insert a Customer
INSERT INTO customers (name, legalid, phone, email, password, role) 
VALUES ('John Doe', '981070747V', '0750353808', 'john@example.com', 'cust123', 'customer');

-- Insert a Booking for the therapist
INSERT INTO bookings (customer_id, therapist_id, service, booking_date, booking_time) 
VALUES (3, 2, 'Massage', '2025-09-07', '10:00:00');

-- Insert a Message from customer to therapist
INSERT INTO messages (sender_id, receiver_id, message, type, status, created_at) 
VALUES (3, 2, 'Hi, I have a question about my session.', 'service', 'pending', NOW());

