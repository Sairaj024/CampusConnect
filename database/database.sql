CREATE TABLE students(
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    department VARCHAR(100),
    year VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE companies(
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,
    package VARCHAR(50),
    location VARCHAR(100),
    eligibility VARCHAR(100),
    last_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE applications(
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    company_id INT,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE announcements(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);