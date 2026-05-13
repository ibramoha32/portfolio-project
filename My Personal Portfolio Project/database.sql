-- Portfolio Database Schema
-- This file creates the database structure for the portfolio project

-- Create database
CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;

-- Users table for admin authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Projects table for dynamic project display
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    tags VARCHAR(255),
    link VARCHAR(255),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Contacts table for contact form submissions
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE
);

-- Insert default admin user (password: admin123 - hashed with bcrypt)
-- In production, generate a secure hash using password_hash()
INSERT INTO users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@portfolio.com');

-- Insert sample projects
INSERT INTO projects (title, description, tags, link) VALUES 
('E-Commerce Platform', 'A full-stack e-commerce solution with product management, cart functionality, and payment integration.', 'PHP,MySQL,JavaScript', '#'),
('AI Chat Application', 'An intelligent chatbot application using natural language processing and machine learning algorithms.', 'Python, TensorFlow, Flask', '#'),
('Portfolio Website', 'A responsive personal portfolio website showcasing projects and skills with modern design.', 'HTML,CSS,JavaScript', '#'),
('Task Management System', 'A collaborative task management tool with real-time updates and team features.', 'PHP,AJAX,MySQL', '#'),
('Data Visualization Dashboard', 'Interactive dashboard for visualizing complex datasets with charts and graphs.', 'JavaScript,D3.js,PHP', '#');

-- Create indexes for better performance
CREATE INDEX idx_contacts_email ON contacts(email);
CREATE INDEX idx_contacts_created_at ON contacts(created_at);
CREATE INDEX idx_projects_created_at ON projects(created_at);
