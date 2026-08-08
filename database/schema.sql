-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Settings Table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL UNIQUE,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert Default Settings
INSERT INTO settings (setting_key, setting_value) VALUES 
('site_name', 'بصيرة'),
('site_description', 'منصة إسلامية متكاملة تضم القرآن الكريم، الأحاديث، السيرة النبوية، الأذكار، الأدعية، ومحتوى إسلاميًا موثوقًا.'),
('seerah_playlist_id', 'PL_Q-A-rD82_A8Y00z9r-N33O1k2mN0b63'), -- Default: Sheikh Othman Al-Kamees Seerah or similar
('contact_email', 'info@basseera.com'),
('facebook_url', '#'),
('twitter_url', '#'),
('instagram_url', '#'),
('youtube_url', '#')
ON DUPLICATE KEY UPDATE setting_value=setting_value;

-- Categories Table (For Hadith, Duaa, Azkar, Articles)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    type ENUM('hadith', 'duaa', 'azkar', 'article') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Default Categories
INSERT INTO categories (name, slug, type) VALUES
('أذكار الصباح', 'morning', 'azkar'),
('أذكار المساء', 'evening', 'azkar'),
('أذكار النوم', 'sleep', 'azkar'),
('أذكار الصلاة', 'prayer', 'azkar'),
('أذكار السفر', 'travel', 'azkar'),
('أذكار المطر', 'rain', 'azkar'),
('أذكار المسجد', 'mosque', 'azkar'),
('أذكار الطعام', 'food', 'azkar'),
('أحاديث نبوية', 'prophet-hadith', 'hadith'),
('أحاديث قدسية', 'qudsi', 'hadith'),
('أدعية قرآنية', 'quranic-duaa', 'duaa'),
('أدعية مأثورة', 'prophet-duaa', 'duaa')
ON DUPLICATE KEY UPDATE name=name;

-- Hadith Table
CREATE TABLE IF NOT EXISTS hadiths (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    text_arabic TEXT NOT NULL,
    narrator VARCHAR(100),
    reference VARCHAR(150),
    grade VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Duaa Table
CREATE TABLE IF NOT EXISTS duas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    text_arabic TEXT NOT NULL,
    reference VARCHAR(150),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Azkar Table
CREATE TABLE IF NOT EXISTS azkar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    text_arabic TEXT NOT NULL,
    reference VARCHAR(150),
    count INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Articles Table (For Sahaba, Prophets, General Articles)
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    type ENUM('sahaba', 'prophet', 'general') DEFAULT 'general',
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a default admin
INSERT INTO users (name, email, password) VALUES 
('Admin', 'admin@basseera.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi') -- password is 'password'
ON DUPLICATE KEY UPDATE name=name;
