-- База данных фотостудии «Кадр»
CREATE DATABASE IF NOT EXISTS photostudio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE photostudio;

DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS users;

-- Пользователи сайта
CREATE TABLE users (
    id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name          VARCHAR(100) NOT NULL,
    email         VARCHAR(120) NOT NULL,
    phone         VARCHAR(20)  NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB;

-- Услуги фотостудии
CREATE TABLE services (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    hall        VARCHAR(50)  NOT NULL,
    duration    SMALLINT UNSIGNED NOT NULL COMMENT 'минуты',
    price       INT UNSIGNED NOT NULL COMMENT 'рубли',
    description VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

-- Заявки на съёмку: каждая связана с пользователем и услугой
CREATE TABLE bookings (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id    INT UNSIGNED NOT NULL,
    service_id INT UNSIGNED NOT NULL,
    shoot_date DATE NOT NULL,
    shoot_time TIME NOT NULL,
    comment    VARCHAR(255) NULL,
    status     VARCHAR(20) NOT NULL DEFAULT 'new',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_bookings_slot (shoot_date, shoot_time),
    CONSTRAINT fk_bookings_user    FOREIGN KEY (user_id)    REFERENCES users (id)    ON DELETE CASCADE,
    CONSTRAINT fk_bookings_service FOREIGN KEY (service_id) REFERENCES services (id)
) ENGINE=InnoDB;

INSERT INTO services (id, name, hall, duration, price, description) VALUES
(1, 'Портретная съёмка',   'Зал «Свет»', 60,  3500, 'Классический и студийный портрет, работа со светом и позированием.'),
(2, 'Семейная фотосессия', 'Зал «Уют»',  90,  5500, 'Съёмка для всей семьи в интерьере с живым светом.'),
(3, 'Love Story',          'Зал «Уют»',  90,  5000, 'Парная съёмка для влюблённых, подготовка образов и идей.'),
(4, 'Предметная съёмка',   'Зал «Лайт»', 120, 4500, 'Каталожные и имиджевые снимки товаров на светлом или цветном фоне.'),
(5, 'Фото на документы',   'Зал «Свет»', 20,  600,  'Быстрая съёмка по требованиям паспорта, визы и пропуска.');
