-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Янв 05 2026 г., 10:20
-- Версия сервера: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `asctc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_menus`
--

CREATE TABLE `admin_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_menus`
--

INSERT INTO `admin_menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'top', '2025-11-19 09:26:15', '2025-11-19 09:26:15'),
(3, 'bottom-right', '2025-11-19 09:32:40', '2025-11-19 09:32:40'),
(4, 'bottom-left', '2025-11-19 09:35:14', '2025-11-19 09:35:14');

-- --------------------------------------------------------

--
-- Структура таблицы `admin_menu_items`
--

CREATE TABLE `admin_menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `class` varchar(255) DEFAULT NULL,
  `menu` bigint(20) UNSIGNED NOT NULL,
  `depth` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_menu_items`
--

INSERT INTO `admin_menu_items` (`id`, `label`, `link`, `parent`, `sort`, `class`, `menu`, `depth`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Как сделать заказ', '/page/kak-sdelat-zakaz-v-ast-komponents', 0, 0, NULL, 1, 0, '2025-11-19 09:27:31', '2025-11-25 14:00:51', 0),
(2, 'Доставка и оплата', '/conditions', 0, 1, NULL, 1, 0, '2025-11-19 09:28:21', '2025-12-27 21:01:29', 0),
(3, 'Производители', '/manufacturers', 0, 2, NULL, 1, 0, '2025-11-19 09:28:55', '2025-11-25 13:58:57', 0),
(4, 'О компании', 'tyu', 0, 3, NULL, 1, 0, '2025-11-19 09:29:42', '2025-11-19 09:29:42', 0),
(5, 'Новости', '/news', 0, 9, NULL, 1, 0, '2025-11-19 09:30:02', '2025-11-25 13:56:58', 0),
(6, 'Контакты', '/contacts', 0, 10, NULL, 1, 0, '2025-11-19 09:30:21', '2025-11-25 13:57:41', 0),
(7, 'Конвертеры', '/converters', 0, 11, NULL, 1, 0, '2025-11-19 09:30:40', '2025-11-25 13:58:23', 0),
(8, 'Производители', '/manufacturers', 0, 0, NULL, 3, 0, '2025-11-19 09:33:09', '2025-11-25 15:03:18', 0),
(9, 'Как сделать заказ', '/conditions', 0, 1, NULL, 3, 0, '2025-11-19 09:33:30', '2025-12-27 21:02:12', 0),
(10, 'Доставка и оплата', '/page/dostavka-i-oplata', 9, 2, NULL, 3, 1, '2025-11-19 09:34:04', '2025-12-27 21:02:22', 0),
(11, 'Новости', '/news', 0, 3, NULL, 3, 0, '2025-11-19 09:34:32', '2025-11-25 15:06:57', 0),
(12, 'Контакты', '/contacts', 0, 4, NULL, 3, 0, '2025-11-19 09:34:57', '2025-11-25 15:07:17', 0),
(13, 'О нас', '/', 0, 0, NULL, 4, 0, '2025-11-19 09:35:53', '2025-11-19 09:36:14', 0),
(14, 'Реквизиты', '/page/rekvizityi-kompanii', 0, 1, NULL, 4, 0, '2025-11-19 09:36:14', '2025-12-17 09:17:30', 0),
(15, 'Пригласить на тендер', '/invite', 0, 2, NULL, 4, 0, '2025-11-19 09:36:42', '2025-11-25 15:08:42', 0),
(16, 'Запрос номенклатуры', '/nomenclature-request', 0, 3, NULL, 4, 0, '2025-11-19 09:36:48', '2025-11-25 15:09:02', 0),
(17, 'Карьера', '/page/careers', 0, 4, NULL, 4, 0, '2025-11-19 09:37:05', '2025-12-17 09:59:56', 0),
(18, 'О нас', '/', 4, 4, NULL, 1, 1, '2025-11-25 13:49:08', '2025-11-25 14:01:34', 0),
(19, 'Реквизиты', '/details', 4, 5, NULL, 1, 1, '2025-11-25 13:50:27', '2025-11-25 13:51:54', 0),
(20, 'Пригласить на тендер', '/invite', 4, 6, NULL, 1, 1, '2025-11-25 13:51:54', '2025-11-25 13:53:03', 0),
(21, 'Запрос номенклатуры', '/nomenclature-request', 4, 7, NULL, 1, 1, '2025-11-25 13:53:03', '2025-11-25 14:23:58', 0),
(22, 'Карьера', '/page/career', 4, 8, NULL, 1, 1, '2025-11-25 13:56:31', '2025-11-25 13:56:38', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `catalogs`
--

CREATE TABLE `catalogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `seo_h1` varchar(255) DEFAULT NULL,
  `seo_url_canonical` varchar(255) DEFAULT NULL,
  `seo_sitemap` tinyint(1) NOT NULL DEFAULT 1,
  `slug` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `catalogs`
--

INSERT INTO `catalogs` (`id`, `name`, `meta_title`, `meta_description`, `meta_keywords`, `seo_h1`, `seo_url_canonical`, `seo_sitemap`, `slug`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Микроконтроллеры', 'Микроконтроллеры', NULL, NULL, 'Микроконтроллеры', NULL, 1, 'mikrokontrolleryi', 0, '2025-11-20 14:16:49', '2025-11-20 14:16:49'),
(2, 'Аналоговые компоненты', 'Аналоговые компоненты', NULL, NULL, 'Аналоговые компоненты', NULL, 1, 'analogovyie-komponentyi', 0, '2025-11-20 14:17:08', '2025-11-20 14:17:08'),
(3, 'Схемы памяти (EEPROM, FLASH, SRAM)', 'Схемы памяти (EEPROM, FLASH, SRAM)', NULL, NULL, 'Схемы памяти (EEPROM, FLASH, SRAM)', NULL, 1, 'shemyi-pamyati-eeprom-flash-sram', 0, '2025-11-20 14:20:58', '2025-11-20 14:20:58'),
(5, 'Схемы программируемой логики (CPLD)', 'Схемы программируемой логики (CPLD)', NULL, NULL, 'Схемы программируемой логики (CPLD)', NULL, 1, 'shemyi-programmiruemoy-logiki-cpld', 0, '2025-11-20 14:33:34', '2025-11-20 14:33:34'),
(6, 'Приемо-передатчики проводных линий (трансиверы RS485, CAN, UART)', 'Приемо-передатчики проводных линий (трансиверы RS485, CAN, UART)', NULL, NULL, 'Приемо-передатчики проводных линий (трансиверы RS485, CAN, UART)', NULL, 1, 'priemo-peredatchiki-provodnyih-liniy-transiveryi', 0, '2025-11-20 14:34:04', '2025-11-20 14:34:04'),
(7, 'Дискретные компоненты', 'Дискретные компоненты', NULL, NULL, 'Дискретные компоненты', NULL, 1, 'diskretnyie-komponentyi', 0, '2025-11-20 14:34:25', '2025-11-20 14:34:25'),
(8, 'Оптоэлектронные компоненты', 'Оптоэлектронные компоненты', NULL, NULL, 'Оптоэлектронные компоненты', NULL, 1, 'optoelektronnyie-komponentyi', 0, '2025-11-20 14:35:01', '2025-11-20 14:35:01');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `attach` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `company`, `email`, `phone`, `message`, `attach`, `ip`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Alex A', NULL, 'janickiy@mail.ru', '+79104696327', 'Номер извещения о закупочной процедуре: 34534563<br>Сообщение: ertyry ertyretr wet', NULL, '192.168.65.1', 1, '2025-12-19 12:25:12', '2025-12-19 12:25:12'),
(2, 'Alex A', NULL, 'janickiy@mail.ru', '+79104696327', 'Номер извещения о закупочной процедуре: 34534563<br>Сообщение: ertyry ertyretr wet', NULL, '192.168.65.1', 1, '2025-12-19 12:25:13', '2025-12-19 12:25:13');

-- --------------------------------------------------------

--
-- Структура таблицы `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `country` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `seo_h1` varchar(255) DEFAULT NULL,
  `seo_url_canonical` varchar(255) DEFAULT NULL,
  `seo_sitemap` tinyint(1) NOT NULL DEFAULT 1,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `title`, `description`, `country`, `image`, `slug`, `meta_title`, `meta_description`, `meta_keywords`, `seo_h1`, `seo_url_canonical`, `seo_sitemap`, `published`, `created_at`, `updated_at`) VALUES
(1, 'Atmel', '<div class=\"manufacturer-hero__description\">\r\n                                <p>Atmel Выпускает несколько семейств микроконтроллеров. Наиболее популярны&nbsp;8-и&nbsp;разрядные&nbsp;MCS-51, AVR и&nbsp;32-х&nbsp;разрядные ARM, AVR32. </p>\r\n                                <p>Функциональность и&nbsp;надежность, \r\nмножество различных периферийных устройств, удобные средства разработки \r\n(JTAG ICE, STK500) и&nbsp;отладки прикладных программ (AVR Studio) определяют\r\n широкое применение микроконтроллеров Atmel. </p>\r\n                                <p>Большинство позиций AVR доступны \r\nсо&nbsp;склада в&nbsp;Москве или с&nbsp;небольшим сроком поставки. Для новых проектов \r\nможно заказать образцы и&nbsp;отладочные комплекты.&nbsp;</p>\r\n                                <p>Atmel Corporation выпускает широкий \r\nспектр устройств энергонезависимой памяти, отличающихся назначением, \r\nинтерфейсом, организацией и архитектурой. В её ассортименте имеется \r\nнесколько линеек микросхем с постраничным и с побайтным доступом. </p>\r\n                                <p>Микросхемы последовательной памяти \r\nAtmel обеспечивают высокую скорость для этого типа памяти — они работают\r\n на частоте до 70 МГц. </p>\r\n                                <p>Микросхемы последовательной \r\nFlash-памяти часто используются как память программ в устройствах, \r\nподдерживающих механизм сохранения данных во внешнюю память. </p>\r\n                                <p>Микросхемы последовательной \r\nFlash-памяти серии AT45 DataFlash производятся по технологии \r\nэлементарной ячейки NOR Flash, обеспечивающей 100%-ную программируемость\r\n каждого бита массива памяти. </p>\r\n                                <p>Широкий выбор устройств \r\nэнергонезависимой памяти Atmel с различным напряжением питания, в \r\nразличных типах корпусов позволяет использовать наиболее удобный вариант\r\n в конечном приложении.</p></div>', 'США', '1766407209.png', 'atmel', 'Atmel', NULL, NULL, NULL, NULL, 1, 1, '2025-12-22 12:40:09', '2025-12-22 12:40:09');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2025_10_21_151025_create_news_table', 1),
(7, '2025_10_21_151254_create_feedback_table', 1),
(8, '2025_11_04_225756_create_settings_table', 2),
(11, '2017_08_11_073824_create_menus_wp_table', 5),
(12, '2017_08_11_074006_create_menu_items_wp_table', 5),
(13, '2025_11_18_142913_create_pages_table', 6),
(14, '2019_01_05_293551_add-role-id-to-menu-items-table', 7),
(15, '2025_11_19_094159_create_manufacturers_table', 8),
(16, '2025_11_19_123845_create_seo_table', 9),
(20, '2025_11_17_115401_create_catalogs_table', 10),
(21, '2025_11_18_075731_create_products_table', 11),
(22, '2025_11_19_145717_create_product_parameters_table', 11),
(23, '2025_11_19_145729_create_product_documents_table', 11),
(24, '2025_12_26_141806_create_redirect_table', 12),
(25, '2026_01_04_150258_add_email_to_users_table', 13);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `preview` text NOT NULL,
  `text` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `promotion` tinyint(1) NOT NULL DEFAULT 0,
  `seo_h1` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `seo_url_canonical` varchar(255) DEFAULT NULL,
  `image_title` varchar(100) DEFAULT NULL,
  `image_alt` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `preview`, `text`, `image`, `slug`, `published`, `promotion`, `seo_h1`, `meta_title`, `meta_description`, `meta_keywords`, `seo_url_canonical`, `image_title`, `image_alt`, `created_at`, `updated_at`) VALUES
(2, 'JW-05-4CH инфракрасный датчик бытового метана от Cubic', 'Инфракрасный датчик JW-05-4CH контролирует утечку в реальном времени, отличается точностью и долговременной стабильностью. Температурный диапазон – 20 + 60С. Срок службы более 10 лет.', '<p>Инфракрасный датчик <a href=\"https://gassensor.ru/catalog/metan/jw-05\">JW-05-4CH</a>\r\n контролирует утечку в реальном времени, отличается точностью и \r\nдолговременной стабильностью. Температурный диапазон – 20 + 60С. Срок \r\nслужбы более 10 лет.</p>', '1766478426.jpg', 'jw-05-4ch-infrakrasnyiy-datchik-byitovogo-metana-ot-cubic', 1, 1, 'JW-05-4CH инфракрасный датчик бытового метана от Cubic', 'JW-05-4CH инфракрасный датчик бытового метана от Cubic', NULL, NULL, NULL, 'JW-05-4CH инфракрасный датчик бытового метана от Cubic', 'JW-05-4CH инфракрасный датчик бытового метана от Cubic', '2025-12-23 08:27:06', '2025-12-23 08:27:06');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `main` tinyint(1) NOT NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `parent_id` int(11) DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `seo_h1` varchar(255) DEFAULT NULL,
  `seo_url_canonical` varchar(255) DEFAULT NULL,
  `seo_sitemap` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `title`, `text`, `slug`, `main`, `published`, `parent_id`, `meta_title`, `meta_description`, `meta_keywords`, `seo_h1`, `seo_url_canonical`, `seo_sitemap`, `created_at`, `updated_at`) VALUES
(1, 'Как сделать заказ в АСТ Компонентс', '<p class=\"how-order__description\">Мы работаем с юридическими лицами и индивидуальными предпринимателями — начать сотрудничество просто</p>\r\n            <ul class=\"how-order__list\">\r\n                <li class=\"how-order-item\">\r\n                    <article class=\"how-order-item__wrap\">\r\n                        <div class=\"how-order-item__top\">\r\n                            <span class=\"how-order-item__numb\"><span>1</span></span>\r\n                        </div>\r\n                        <div class=\"how-order-item__bottom\">\r\n                            <div class=\"how-order-item__title\">\r\n                                <h2>Отправьте реквизиты компании</h2>\r\n                            </div>\r\n                            <p class=\"how-order-item__description\">на почту <a href=\"mailto:sales@astc.ru\">sales@astc.ru</a> или укажите в <a href=\".#\">личном кабинете</a> после регистрации</p>\r\n                        </div>\r\n                        <div class=\"how-order-item__lines\"></div>\r\n                    </article>\r\n                </li>\r\n                <li class=\"how-order-item\">\r\n                    <article class=\"how-order-item__wrap\">\r\n                        <div class=\"how-order-item__top\">\r\n                            <span class=\"how-order-item__numb\"><span>2.1</span></span>\r\n                        </div>\r\n                        <div class=\"how-order-item__bottom\">\r\n                            <div class=\"how-order-item__title\">\r\n                                <h2>Оформите заказ</h2>\r\n                            </div>\r\n                            <p class=\"how-order-item__description\">Если вы зарегистрировались и указали реквизиты в <a href=\".#\">личном кабинете</a>, то можете оформить заказ, собрав в корзину нужные товары</p>\r\n                        </div>\r\n                        <div class=\"how-order-item__lines\"></div>\r\n                    </article>\r\n                </li>\r\n                <li class=\"how-order-item\">\r\n                    <article class=\"how-order-item__wrap\">\r\n                        <div class=\"how-order-item__top\">\r\n                            <span class=\"how-order-item__numb\"><span>2.2</span></span>\r\n                        </div>\r\n                        <div class=\"how-order-item__bottom\">\r\n                            <div class=\"how-order-item__title\">\r\n                                <h2>Дождитесь звонка менеджера</h2>\r\n                            </div>\r\n                            <p class=\"how-order-item__description\">После оформления заказа на сайте или получения реквизитов по электронной почте мы свяжемся с вами. Наш специалист уточнит детали: позиции, способ доставки, стоимость и условия оплаты.</p>\r\n                        </div>\r\n                        <div class=\"how-order-item__lines\"></div>\r\n                    </article>\r\n                </li>\r\n                <li class=\"how-order-item\">\r\n                    <article class=\"how-order-item__wrap\">\r\n                        <div class=\"how-order-item__top\">\r\n                            <span class=\"how-order-item__numb\"><span>3</span></span>\r\n                        </div>\r\n                        <div class=\"how-order-item__bottom\">\r\n                            <div class=\"how-order-item__title\">\r\n                                <h2>Получите и оплатите счет</h2>\r\n                            </div>\r\n                            <p class=\"how-order-item__description\">Оплатите счет. Он придет на почту, если заказ оформлен через менеджера, или в личный кабинет, если заказ оформлен через сайт</p>\r\n                        </div>\r\n                        <div class=\"how-order-item__lines\"></div>\r\n                    </article>\r\n                </li>\r\n                <li class=\"how-order-item\">\r\n                    <article class=\"how-order-item__wrap\">\r\n                        <div class=\"how-order-item__top\">\r\n                            <span class=\"how-order-item__numb\"><span>4</span></span>\r\n                        </div>\r\n                        <div class=\"how-order-item__bottom\">\r\n                            <div class=\"how-order-item__title\">\r\n                                <h2>Получите поставку</h2>\r\n                            </div>\r\n                            <p class=\"how-order-item__description\">Доставим продукцию на ваш склад</p>\r\n                        </div>\r\n                        <div class=\"how-order-item__lines\"></div>\r\n                    </article>\r\n                </li>\r\n                <li class=\"how-order-item is-link\">\r\n                    <a href=\"./contacts.html\" class=\"how-order-item__wrap\">\r\n                        <div class=\"how-order-item__top\">\r\n                            <div class=\"how-order-item__icon\">\r\n                                <img src=\"./images/advantages/chat-help.svg\" alt=\"\" aria-hidden=\"true\">\r\n                            </div>\r\n                            <span class=\"how-order-item__link btn btn--icon btn--tertiary\">\r\n                                <span class=\"sr-only\">Перейти на страницу \"Контакты\"</span>\r\n                                <svg aria-hidden=\"true\" class=\"white\">\r\n                                    <use xlink:href=\"images/sprite.svg#arrow-right\"></use>\r\n                                </svg>\r\n                            </span>\r\n                        </div>\r\n                        <div class=\"how-order-item__bottom\">\r\n                            <div class=\"how-order-item__title\">\r\n                                <h2>Остались вопросы?<br>Свяжитесь с нами любым удобным способом</h2>\r\n                            </div>\r\n                        </div>\r\n                    </a>\r\n                </li>\r\n            </ul>', 'kak-sdelat-zakaz-v-ast-komponents', 0, 1, 0, 'Как сделать заказ в АСТ Компонентс', NULL, NULL, 'Как сделать заказ в АСТ Компонентс', NULL, 1, '2025-11-20 14:59:23', '2025-11-20 14:59:23'),
(2, 'Политика конфиденциальности', '<div class=\"text-page container-sm\">\r\n            <h2>1. Общие положения</h2>\r\n            <p>Настоящая политика обработки персональных данных составлена в соответствии с требованиями Федерального закона от 27.07.2006. № 152-ФЗ «О персональных данных» (далее — Закон о персональных данных) и определяет порядок обработки персональных данных и меры по обеспечению безопасности персональных данных, предпринимаемые Михайловым Иваном Сергеевичем (далее — Оператор).</p>\r\n            <ol>\r\n                <li>\r\n                    <span class=\"text-page__numb\">1.1</span>\r\n                    <p>Оператор ставит своей важнейшей целью и условием осуществления своей деятельности соблюдение прав и свобод человека и гражданина при обработке его персональных данных, в том числе защиты прав на неприкосновенность частной жизни, личную и семейную тайну.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">1.2</span>\r\n                    <p>Настоящая политика Оператора в отношении обработки персональных данных (далее — Политика) применяется ко всей информации, которую Оператор может получить о посетителях веб-сайта httpsː//thismywebsite·com.</p>\r\n                </li>\r\n            </ol>\r\n            <h2>2. Основные понятия, используемые в Политике</h2>\r\n            <ol>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.1</span>\r\n                    <p>Автоматизированная обработка персональных данных — обработка персональных данных с помощью средств вычислительной техники.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.2</span>\r\n                    <p>Блокирование персональных данных — временное прекращение обработки персональных данных (за исключением случаев, если обработка необходима для уточнения персональных данных).</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.3</span>\r\n                    <p>Веб-сайт — совокупность графических и информационных материалов, а также программ для ЭВМ и баз данных, обеспечивающих их доступность в сети интернет по сетевому адресу httpsː//thismywebsite·com.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.4</span>\r\n                    <p>Информационная система персональных данных — совокупность содержащихся в базах данных персональных данных и обеспечивающих их обработку информационных технологий и технических средств.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.5</span>\r\n                    <p>Обезличивание персональных данных — действия, в результате которых невозможно определить без использования дополнительной информации принадлежность персональных данных конкретному Пользователю или иному субъекту персональных данных.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.6</span>\r\n                    <p>Обработка персональных данных — любое действие (операция) или совокупность действий (операций), совершаемых с использованием средств автоматизации или без использования таких средств с персональными данными, включая сбор, запись, систематизацию, накопление, хранение, уточнение (обновление, изменение), извлечение, использование, передачу (распространение, предоставление, доступ), обезличивание, блокирование, удаление, уничтожение персональных данных.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.7</span>\r\n                    <p>Оператор — государственный орган, муниципальный орган, юридическое или физическое лицо, самостоятельно или совместно с другими лицами организующие и/или осуществляющие обработку персональных данных, а также определяющие цели обработки персональных данных, состав персональных данных, подлежащих обработке, действия (операции), совершаемые с персональными данными.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.8</span>\r\n                    <p>Персональные данные — любая информация, относящаяся прямо или косвенно к определенному или определяемому Пользователю веб-сайта httpsː//thismywebsite·com.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.9</span>\r\n                    <p>Персональные данные, разрешенные субъектом персональных данных для распространения, — персональные данные, доступ неограниченного круга лиц к которым предоставлен субъектом персональных данных путем дачи согласия на обработку персональных данных, разрешенных субъектом персональных данных для распространения в порядке, предусмотренном Законом о персональных данных (далее — персональные данные, разрешенные для распространения).</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.10</span>\r\n                    <p>Пользователь — любой посетитель веб-сайта httpsː//thismywebsite·com.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.11</span>\r\n                    <p>Предоставление персональных данных — действия, направленные на раскрытие персональных данных определенному лицу или определенному кругу лиц.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.12</span>\r\n                    <p>Распространение персональных данных — любые действия, направленные на раскрытие персональных данных неопределенному кругу лиц (передача персональных данных) или на ознакомление с персональными данными неограниченного круга лиц, в том числе обнародование персональных данных в средствах массовой информации, размещение в информационно-телекоммуникационных сетях или предоставление доступа к персональным данным каким-либо иным способом.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.13</span>\r\n                    <p>Трансграничная передача персональных данных — передача персональных данных на территорию иностранного государства органу власти иностранного государства, иностранному физическому или иностранному юридическому лицу.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">2.14</span>\r\n                    <p>Уничтожение персональных данных — любые действия, в результате которых персональные данные уничтожаются безвозвратно с невозможностью дальнейшего восстановления содержания персональных данных в информационной системе персональных данных и/или уничтожаются материальные носители персональных данных.</p>\r\n                </li>\r\n            </ol>\r\n            <h2>3. Основные права и обязанности Оператора</h2>\r\n            <ol>\r\n                <li>\r\n                    <span class=\"text-page__numb\">3.1</span>\r\n                    <div>\r\n                        <p>Оператор имеет право:</p>\r\n                        <ul>\r\n                            <li>Получать от субъекта персональных данных достоверные информацию и/или документы, содержащие персональные данные;</li>\r\n                            <li>В случае отзыва субъектом персональных данных согласия на обработку персональных данных, а также, направления обращения с требованием о прекращении обработки персональных данных, Оператор вправе продолжить обработку персональных данных без согласия субъекта персональных данных при наличии оснований, указанных в Законе о персональных данных;</li>\r\n                            <li>Самостоятельно определять состав и перечень мер, необходимых и достаточных для обеспечения выполнения обязанностей, предусмотренных Законом о персональных данных и принятыми в соответствии с ним нормативными правовыми актами, если иное не предусмотрено Законом о персональных данных или другими федеральными законами.</li>\r\n                        </ul>\r\n                    </div>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">3.2</span>\r\n                    <div>\r\n                        <p>Оператор обязан:</p>\r\n                        <ul>\r\n                            <li>Предоставлять субъекту персональных данных по его просьбе информацию, касающуюся обработки его персональных данных;</li>\r\n                            <li>Организовывать обработку персональных данных в порядке, установленном действующим законодательством РФ;</li>\r\n                            <li>Отвечать на обращения и запросы субъектов персональных данных и их законных представителей в соответствии с требованиями Закона о персональных данных;</li>\r\n                            <li>Сообщать в уполномоченный орган по защите прав субъектов персональных данных по запросу этого органа необходимую информацию в течение 10 дней с даты получения такого запроса;</li>\r\n                            <li>Публиковать или иным образом обеспечивать неограниченный доступ к настоящей Политике в отношении обработки персональных данных;</li>\r\n                            <li>Принимать правовые, организационные и технические меры для защиты персональных данных от неправомерного или случайного доступа к ним, уничтожения, изменения, блокирования, копирования, предоставления, распространения персональных данных, а также от иных неправомерных действий в отношении персональных данных;</li>\r\n                            <li>Прекратить передачу (распространение, предоставление, доступ) персональных данных, прекратить обработку и уничтожить персональные данные в порядке и случаях, предусмотренных Законом о персональных данных;</li>\r\n                            <li>Исполнять иные обязанности, предусмотренные Законом о персональных данных.</li>\r\n                        </ul>\r\n                    </div>\r\n                </li>\r\n            </ol>\r\n            <h2>4. Основные права и обязанности субъектов персональных данных</h2>\r\n            <ol>\r\n                <li>\r\n                    <span class=\"text-page__numb\">4.1</span>\r\n                    <div>\r\n                        <p>Субъекты персональных данных имеют право:</p>\r\n                        <ul>\r\n                            <li>Получать информацию, касающуюся обработки его персональных данных, за исключением случаев, предусмотренных федеральными законами. Сведения предоставляются субъекту персональных данных Оператором в доступной форме, и в них не должны содержаться персональные данные, относящиеся к другим субъектам персональных данных, за исключением случаев, когда имеются законные основания для раскрытия таких персональных данных. Перечень информации и порядок ее получения установлен Законом о персональных данных;</li>\r\n                            <li>Требовать от оператора уточнения его персональных данных, их блокирования или уничтожения в случае, если персональные данные являются неполными, устаревшими, неточными, незаконно полученными или не являются необходимыми для заявленной цели обработки, а также принимать предусмотренные законом меры по защите своих прав;</li>\r\n                            <li>Выдвигать условие предварительного согласия при обработке персональных данных в целях продвижения на рынке товаров, работ и услуг;</li>\r\n                            <li>На отзыв согласия на обработку персональных данных, а также, на направление требования о прекращении обработки персональных данных;</li>\r\n                            <li>Обжаловать в уполномоченный орган по защите прав субъектов персональных данных или в судебном порядке неправомерные действия или бездействие Оператора при обработке его персональных данных;</li>\r\n                            <li>На осуществление иных прав, предусмотренных законодательством РФ.</li>\r\n                        </ul>\r\n                    </div>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">4.2</span>\r\n                    <div>\r\n                        <p>Субъекты персональных данных обязаны:</p>\r\n                        <ul>\r\n                            <li>Предоставлять Оператору достоверные данные о себе;</li>\r\n                            <li>Сообщать Оператору об уточнении (обновлении, изменении) своих персональных данных.</li>\r\n                        </ul>\r\n                    </div>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">4.3</span>\r\n                    <p>Лица, передавшие Оператору недостоверные сведения о себе, либо сведения о другом субъекте персональных данных без согласия последнего, несут ответственность в соответствии с законодательством РФ.</p>\r\n                </li>\r\n            </ol>\r\n            <h2>5. Принципы обработки персональных данных</h2>\r\n            <ol>\r\n                <li>\r\n                    <span class=\"text-page__numb\">5.1</span>\r\n                    <p>Обработка персональных данных осуществляется на законной и справедливой основе.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">5.2</span>\r\n                    <p>Обработка персональных данных ограничивается достижением конкретных, заранее определенных и законных целей. Не допускается обработка персональных данных, несовместимая с целями сбора персональных данных.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">5.3</span>\r\n                    <p>Не допускается объединение баз данных, содержащих персональные данные, обработка которых осуществляется в целях, несовместимых между собой.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">5.4</span>\r\n                    <p>Обработке подлежат только персональные данные, которые отвечают целям их обработки.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">5.5</span>\r\n                    <p>Содержание и объем обрабатываемых персональных данных соответствуют заявленным целям обработки. Не допускается избыточность обрабатываемых персональных данных по отношению к заявленным целям их обработки.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">5.6</span>\r\n                    <p>При обработке персональных данных обеспечивается точность персональных данных, их достаточность, а в необходимых случаях и актуальность по отношению к целям обработки персональных данных. Оператор принимает необходимые меры и/или обеспечивает их принятие по удалению или уточнению неполных или неточных данных.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">5.7</span>\r\n                    <p>Хранение персональных данных осуществляется в форме, позволяющей определить субъекта персональных данных, не дольше, чем этого требуют цели обработки персональных данных, если срок хранения персональных данных не установлен федеральным законом, договором, стороной которого, выгодоприобретателем или поручителем по которому является субъект персональных данных. Обрабатываемые персональные данные уничтожаются либо обезличиваются по достижении целей обработки или в случае утраты необходимости в достижении этих целей, если иное не предусмотрено федеральным законом.</p>\r\n                </li>\r\n            </ol>\r\n            <h2>6. Цели обработки персональных данных</h2>\r\n            <table>\r\n                <tbody>\r\n                    <tr>\r\n                        <th>Цель обработки</th>\r\n                        <td>Персональные данные</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>Персональные данные</th>\r\n                        <td>\r\n                            <ul>\r\n                                <li>Фамилия, имя, отчество</li>\r\n                                <li>Электронный адрес</li>\r\n                                <li>Номера телефонов</li>\r\n                            </ul>\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>Правовые основания</th>\r\n                        <td>Федеральный закон «Об информации, информационных технологиях и о защите информации» от 27.07.2006 N 149-ФЗ</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <th>Виды обработки персональных данных</th>\r\n                        <td>Передача персональных данных</td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            <h2>7. Условия обработки персональных данных</h2>\r\n            <ol>\r\n                <li>\r\n                    <span class=\"text-page__numb\">7.1</span>\r\n                    <p>Обработка персональных данных осуществляется с согласия субъекта персональных данных на обработку его персональных данных.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">7.2</span>\r\n                    <p>Обработка персональных данных необходима для достижения целей, предусмотренных международным договором Российской Федерации или законом, для осуществления возложенных законодательством Российской Федерации на оператора функций, полномочий и обязанностей.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">7.3</span>\r\n                    <p>Обработка персональных данных необходима для осуществления правосудия, исполнения судебного акта, акта другого органа или должностного лица, подлежащих исполнению в соответствии с законодательством Российской Федерации об исполнительном производстве.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">7.4</span>\r\n                    <p>Обработка персональных данных необходима для исполнения договора, стороной которого либо выгодоприобретателем или поручителем по которому является субъект персональных данных, а также для заключения договора по инициативе субъекта персональных данных или договора, по которому субъект персональных данных будет являться выгодоприобретателем или поручителем.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">7.5</span>\r\n                    <p>Обработка персональных данных необходима для осуществления прав и законных интересов оператора или третьих лиц либо для достижения общественно значимых целей при условии, что при этом не нарушаются права и свободы субъекта персональных данных.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">7.6</span>\r\n                    <p>Осуществляется обработка персональных данных, доступ неограниченного круга лиц к которым предоставлен субъектом персональных данных либо по его просьбе (далее — общедоступные персональные данные).</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">7.7</span>\r\n                    <p>Осуществляется обработка персональных данных, подлежащих опубликованию или обязательному раскрытию в соответствии с федеральным законом.</p>\r\n                </li>\r\n            </ol>\r\n            <h2>8. Порядок сбора, хранения, передачи и других видов обработки персональных данных</h2>\r\n            <p>Безопасность персональных данных, которые обрабатываются Оператором, обеспечивается путем реализации правовых, организационных и технических мер, необходимых для выполнения в полном объеме требований действующего законодательства в области защиты персональных данных.</p>\r\n            <ol>\r\n                <li>\r\n                    <span class=\"text-page__numb\">8.1</span>\r\n                    <p>Оператор обеспечивает сохранность персональных данных и принимает все возможные меры, исключающие доступ к персональным данным неуполномоченных лиц.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">8.2</span>\r\n                    <p>Персональные данные Пользователя никогда, ни при каких условиях не будут переданы третьим лицам, за исключением случаев, связанных с исполнением действующего законодательства либо в случае, если субъектом персональных данных дано согласие Оператору на передачу данных третьему лицу для исполнения обязательств по гражданско-правовому договору.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">8.3</span>\r\n                    <p>В случае выявления неточностей в персональных данных, Пользователь может актуализировать их самостоятельно, путем направления Оператору уведомление на адрес электронной почты Оператора privacy@thismywebsite·com с пометкой «Актуализация персональных данных».</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">8.4</span>\r\n                    <p>Срок обработки персональных данных определяется достижением целей, для которых были собраны персональные данные, если иной срок не предусмотрен договором или действующим законодательством.<br>Пользователь может в любой момент отозвать свое согласие на обработку персональных данных, направив Оператору уведомление посредством электронной почты на электронный адрес Оператора privacy@thismywebsite·com с пометкой «Отзыв согласия на обработку персональных данных».</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">8.5</span>\r\n                    <p>Вся информация, которая собирается сторонними сервисами, в том числе платежными системами, средствами связи и другими поставщиками услуг, хранится и обрабатывается указанными лицами (Операторами) в соответствии с их Пользовательским соглашением и Политикой конфиденциальности. Субъект персональных данных и/или с указанными документами. Оператор не несет ответственность за действия третьих лиц, в том числе указанных в настоящем пункте поставщиков услуг.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">8.6</span>\r\n                    <p>Установленные субъектом персональных данных запреты на передачу (кроме предоставления доступа), а также на обработку или условия обработки (кроме получения доступа) персональных данных, разрешенных для распространения, не действуют в случаях обработки персональных данных в государственных, общественных и иных публичных интересах, определенных законодательством РФ.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">8.7</span>\r\n                    <p>Оператор при обработке персональных данных обеспечивает конфиденциальность персональных данных.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">8.8</span>\r\n                    <p>Оператор осуществляет хранение персональных данных в форме, позволяющей определить субъекта персональных данных, не дольше, чем этого требуют цели обработки персональных данных, если срок хранения персональных данных не установлен федеральным законом, договором, стороной которого, выгодоприобретателем или поручителем по которому является субъект персональных данных.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">8.9</span>\r\n                    <p>Условием прекращения обработки персональных данных может являться достижение целей обработки персональных данных, истечение срока действия согласия субъекта персональных данных, отзыв согласия субъектом персональных данных или требование о прекращении обработки персональных данных, а также выявление неправомерной обработки персональных данных.</p>\r\n                </li>\r\n            </ol>\r\n            <h2>9. Перечень действий, производимых Оператором с полученными персональными данными</h2>\r\n            <ol>\r\n                <li>\r\n                    <span class=\"text-page__numb\">9.1</span>\r\n                    <p>Оператор осуществляет сбор, запись, систематизацию, накопление, хранение, уточнение (обновление, изменение), извлечение, использование, передачу (распространение, предоставление, доступ), обезличивание, блокирование, удаление и уничтожение персональных данных.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">9.2</span>\r\n                    <p>Оператор осуществляет автоматизированную обработку персональных данных с получением и/или передачей полученной информации по информационно-телекоммуникационным сетям или без таковой.</p>\r\n                </li>\r\n            </ol>\r\n            <h2>10. Трансграничная передача персональных данных</h2>\r\n            <ol>\r\n                <li>\r\n                    <span class=\"text-page__numb\">10.1</span>\r\n                    <p>Оператор до начала осуществления деятельности по трансграничной передаче персональных данных обязан уведомить уполномоченный орган по защите прав субъектов персональных данных о своем намерении осуществлять трансграничную передачу персональных данных (такое уведомление направляется отдельно от уведомления о намерении осуществлять обработку персональных данных).</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">10.2</span>\r\n                    <p>Оператор до подачи вышеуказанного уведомления, обязан получить от органов власти иностранного государства, иностранных физических лиц, иностранных юридических лиц, которым планируется трансграничная передача персональных данных, соответствующие сведения.</p>\r\n                </li>\r\n            </ol>\r\n            <h2>11. Конфиденциальность персональных данных</h2>\r\n            <p>Оператор и иные лица, получившие доступ к персональным данным, обязаны не раскрывать третьим лицам и не распространять персональные данные без согласия субъекта персональных данных, если иное не предусмотрено федеральным законом.</p>\r\n            <h2>12. Заключительные положения</h2>\r\n            <ol>\r\n                <li>\r\n                    <span class=\"text-page__numb\">12.1</span>\r\n                    <p>Пользователь может получить любые разъяснения по интересующим вопросам, касающимся обработки его персональных данных, обратившись к Оператору с помощью электронной почты privacy@thismywebsite·com.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">12.2</span>\r\n                    <p>В данном документе будут отражены любые изменения политики обработки персональных данных Оператором. Политика действует бессрочно до замены ее новой версией.</p>\r\n                </li>\r\n                <li>\r\n                    <span class=\"text-page__numb\">12.3</span>\r\n                    <p>Актуальная версия Политики в свободном доступе расположена в сети Интернет по адресу httpsː//thismywebsite·com/privacy-policy/.</p>\r\n                </li>\r\n            </ol>\r\n        </div>', 'privacy-policy', 0, 1, 0, 'Политика конфиденциальности', NULL, NULL, 'Политика конфиденциальности', NULL, 1, '2025-11-20 15:17:56', '2025-11-25 15:13:27'),
(3, 'О компании АСТ Компонентс', '<div class=\"about container-md\">\r\n            <div class=\"about__logo\">\r\n                <img src=\"/images/logo.svg\" alt=\"\" aria-hidden=\"true\">\r\n            </div>\r\n            <div class=\"about__info\">\r\n                <p class=\"about__text\">АСТ Компонентс начала работать в то время, когда купить микросхему на Митинском рынке было проще, чем у официальных поставщиков. С первых дней для нас было важно одно — чтобы клиент всегда получал нужные и надёжные электронные компоненты.</p>\r\n                <span class=\"about__title\">Поэтому мы:</span>\r\n                <ul class=\"about__list\">\r\n                    <li>Думаем в первую очередь о задачах заказчика</li>\r\n                    <li>Используем опыт и связи как на российских, так и на зарубежных рынках</li>\r\n                    <li>Выбираем только <a href=\"/manufacturers\">проверенных партнёров</a></li>\r\n                </ul>\r\n                <div class=\"about__title\">\r\n                    <h2>На чём держится наша работа</h2>\r\n                </div>\r\n                <ul class=\"about__principle-list\">\r\n                    <li>\r\n                        <article class=\"principle\">\r\n                            <div class=\"principle__indicators\">\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                            </div>\r\n                            <div>\r\n                                <div class=\"principle__title\">\r\n                                    <h3>Надежность</h3>\r\n                                </div>\r\n                                <p class=\"principle__description\">Фиксированные договорные условия, соблюдение обязательств, прозрачные цены</p>\r\n                            </div>\r\n                        </article>\r\n                    </li>\r\n                    <li>\r\n                        <article class=\"principle\">\r\n                            <div class=\"principle__indicators\">\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                            </div>\r\n                            <div>\r\n                                <div class=\"principle__title\">\r\n                                    <h3>Профессионализм</h3>\r\n                                </div>\r\n                                <p class=\"principle__description\">Квалифицированная команда, широкая сеть поставщиков, техподдержка</p>\r\n                            </div>\r\n                        </article>\r\n                    </li>\r\n                    <li>\r\n                        <article class=\"principle\">\r\n                            <div class=\"principle__indicators\">\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                            </div>\r\n                            <div>\r\n                                <div class=\"principle__title\">\r\n                                    <h3>Взаимоуважение</h3>\r\n                                </div>\r\n                                <p class=\"principle__description\">Долгосрочные партнёрства и честные условия</p>\r\n                            </div>\r\n                        </article>\r\n                    </li>\r\n                    <li>\r\n                        <article class=\"principle\">\r\n                            <div class=\"principle__indicators\">\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                                <svg aria-hidden=\"true\">\r\n                                    <use xlink:href=\"/images/sprite.svg#breadcrumb-separator\"></use>\r\n                                </svg>\r\n                            </div>\r\n                            <div>\r\n                                <div class=\"principle__title\">\r\n                                    <h3>Скорость и результат</h3>\r\n                                </div>\r\n                                <p class=\"principle__description\">Быстрая реакция на запросы и комплексная комплектация </p>\r\n                            </div>\r\n                        </article>\r\n                    </li>\r\n                </ul>\r\n                <p class=\"about__text\">Мы уверены, что наша деятельность способствует развитию технологий, укреплению позиций клиентов на рынке и построению долгосрочных партнёрских отношений.</p>\r\n                <div class=\"about__btn-wrap\">\r\n                    <a href=\"/images/logo.svg\" download=\"logo.svg\" class=\"btn btn--tertiary\">\r\n                        <svg aria-hidden=\"true\">\r\n                            <use xlink:href=\"/images/sprite.svg#download\"></use>\r\n                        </svg>\r\n                        <span>Договор поставки</span>\r\n                    </a>\r\n                    <span class=\"about__discuss\">Хотите обсудить сотрудничество?<br><a href=\"/contacts\">Свяжитесь с нами</a> любым удобным способом</span>\r\n                </div>\r\n            </div>\r\n        </div>', 'o-kompanii-ast-komponents', 1, 1, 0, 'О компании АСТ Компонентс', NULL, NULL, 'О компании АСТ Компонентс', NULL, 1, '2025-11-20 15:28:38', '2025-12-20 04:42:33'),
(6, 'Реквизиты компании', '<div class=\"details container-sm\">\r\n            <div class=\"details__row\">\r\n                <div class=\"details__general\">\r\n                    <section class=\"details__block\">\r\n                        <h2>Общая информация</h2>\r\n                        <dl class=\"details__table\">\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Полное наименование компании</dt>\r\n                                <dd class=\"details__row-text\">Общество с Ограниченной Ответственностью «АСТ&nbsp;Компонентс»</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Сокращенное наименование компании</dt>\r\n                                <dd class=\"details__row-text\">ООО «АСТ&nbsp;Компонентс»</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">ИНН</dt>\r\n                                <dd class=\"details__row-text\">7728275701</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">КПП</dt>\r\n                                <dd class=\"details__row-text\">772001001</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">ОГРН</dt>\r\n                                <dd class=\"details__row-text\">1037728000243</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">ОКПО</dt>\r\n                                <dd class=\"details__row-text\">59811030</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Юридический адрес</dt>\r\n                                <dd class=\"details__row-text\">111123, г. Москва, шоссе Энтузиастов, дом 56, стр. 32, этаж 2, помещения 219, 221</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Фактический адрес</dt>\r\n                                <dd class=\"details__row-text\">115088, г. Москва, проезд Южнопортовый 2-й, д.20А</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Почтовый адрес</dt>\r\n                                <dd class=\"details__row-text\">115088, г. Москва, а/я&nbsp;45</dd>\r\n                            </div>\r\n                        </dl>\r\n                    </section>\r\n                    <a href=\"DETAIL_DOWNLOAD_TAG\" class=\"details__btn btn btn--primary btn--lg\">\r\n                        <svg aria-hidden=\"true\" class=\"white\">\r\n                            <use xlink:href=\"images/sprite.svg#download\"></use>\r\n                        </svg>\r\n                        <span>Скачать реквизиты</span>\r\n                    </a>\r\n                </div>\r\n                <div class=\"details__other\">\r\n                    <section class=\"details__block\">\r\n                        <h2>Банковские реквизиты</h2>\r\n                        <dl class=\"details__table\">\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Банк</dt>\r\n                                <dd class=\"details__row-text\">ПАО СБЕРБАНК</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">БИК</dt>\r\n                                <dd class=\"details__row-text\">044525225</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">ИНН банка</dt>\r\n                                <dd class=\"details__row-text\">7707083893</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Расчетный счет</dt>\r\n                                <dd class=\"details__row-text\">40702810638000061502</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Корреспондентский счет</dt>\r\n                                <dd class=\"details__row-text\">30101810400000000225</dd>\r\n                            </div>\r\n                        </dl>\r\n                    </section>\r\n                    <section class=\"details__block\">\r\n                        <h2>Контакты</h2>\r\n                        <dl class=\"details__table\">\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Генеральный директор</dt>\r\n                                <dd class=\"details__row-text\">Бичев Вадим Георгиевич</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Главный бухгалтер</dt>\r\n                                <dd class=\"details__row-text\">Бичев Вадим Георгиевич</dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Телефон</dt>\r\n                                <dd class=\"details__row-text\">\r\n                                    <a href=\"tel:+74959814114\">8(495) 981-41-14</a>\r\n                                </dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Факс</dt>\r\n                                <dd class=\"details__row-text\">\r\n                                    <a href=\"tel:+74959212441\">8(495) 921-24-41</a>\r\n                                </dd>\r\n                            </div>\r\n                            <div class=\"details__table-row\">\r\n                                <dt class=\"details__row-title\">Электронная почта</dt>\r\n                                <dd class=\"details__row-text\">\r\n                                    <a href=\"mailto:info@astc.ru\">info@astc.ru</a>\r\n                                </dd>\r\n                            </div>\r\n                        </dl>\r\n                    </section>\r\n                </div>\r\n            </div>\r\n        </div>', 'rekvizityi-kompanii', 0, 1, 0, 'Реквизиты компании', NULL, NULL, 'Реквизиты компании', NULL, 1, '2025-12-16 14:12:47', '2025-12-17 09:44:10');
INSERT INTO `pages` (`id`, `title`, `text`, `slug`, `main`, `published`, `parent_id`, `meta_title`, `meta_description`, `meta_keywords`, `seo_h1`, `seo_url_canonical`, `seo_sitemap`, `created_at`, `updated_at`) VALUES
(7, 'Присоединяйся к команде АСТ Компонентс!', '<div class=\"career\">\r\n            <div class=\"container-sm\">\r\n                <div class=\"career__description\">\r\n                    <div class=\"career__img-part\">\r\n                        <p class=\"career__text\">Мы — динамично развивающаяся московская компания с более чем 25-летним опытом в сфере поставок импортных электронных компонентов. От образцов до крупных партий, от редких микросхем до пассивных элементов — наши решения гибко адаптированы под нужды клиентов и оптимизированы для рынка.</p>\r\n                        <picture class=\"career__img\">\r\n                            <source srcset=\"/images/career-img.webp, /images/career-img@2x.webp 2x\" type=\"image/webp\">\r\n                            <img src=\"/images/career-img.jpg\" srcset=\"/images/career-img@2x.jpg 2x\" alt=\"Работа в АСТ Компонентс\">\r\n                        </picture>\r\n                    </div>\r\n                    <div>\r\n                        <p class=\"career__text\">В АСТ Компонентс мы ценим:</p>\r\n                        <ul class=\"career__worth-list\">\r\n                            <li class=\"career__worth\">\r\n                                <span class=\"career__worth-title\">Профессиональное развитие</span>\r\n                                <p class=\"career__worth-text\">Мы всегда открыты к новым знаниям — как инженерным, так и коммерческим</p>\r\n                            </li>\r\n                            <li class=\"career__worth\">\r\n                                <span class=\"career__worth-title\">Командный дух и надёжность</span>\r\n                                <p class=\"career__worth-text\">Со сменой технологий растёт и наша команда — вместе формируем культуру взаимной поддержки</p>\r\n                            </li>\r\n                            <li class=\"career__worth\">\r\n                                <span class=\"career__worth-title\">Гибкость и ответственность</span>\r\n                                <p class=\"career__worth-text\">Поддержка инициативных сотрудников и самостоятельность в принятии решений — часть нашей повседневной работы</p>\r\n                            </li>\r\n                            <li class=\"career__worth\">\r\n                                <span class=\"career__worth-title\">Инновации в действии</span>\r\n                                <p class=\"career__worth-text\">Мы постоянно расширяем ассортимент, находим аналоги, предлагаем образцы и техдокументацию — и всё это в короткие сроки</p>\r\n                            </li>\r\n                        </ul>\r\n                        <p class=\"career__text\">Если вы энергичны, увлечены электроникой, цените качество и хотите расти вместе с компанией, вы попали по адресу. Ниже — актуальные вакансии, открытые возможности и требования. Присоединяйтесь к нам!</p>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div class=\"container-md\">\r\n                <div class=\"career__vacancies-list\">\r\n                    <article class=\"vacancy\">\r\n                        <div class=\"vacancy__title\">\r\n                            <h2>Менеджер по развитию бизнеса</h2>\r\n                        </div>\r\n                        <div class=\"vacancy__subtitle\">\r\n                            <h3>Требования:</h3>\r\n                        </div>\r\n                        <ul class=\"vacancy__list\">\r\n                            <li>Высшее образование(желательно техническое)</li>\r\n                            <li>Английский на базовом уровне</li>\r\n                            <li>Опыт активных продаж от 1 года</li>\r\n                            <li>Стремление к развитию и картерному росту</li>\r\n                            <li>Наличие своей клиентской базы приветствуется</li>\r\n                        </ul>\r\n                        <div class=\"vacancy__subtitle\">\r\n                            <h3>Задачи:</h3>\r\n                        </div>\r\n                        <ul class=\"vacancy__list\">\r\n                            <li>Поддержка региональных заказчиков</li>\r\n                            <li>Представление интересов компании в вашем регионе</li>\r\n                        </ul>\r\n                    </article>\r\n                    <article class=\"career__card-email\">\r\n                        <div class=\"career__card-title\">\r\n                            <h2>Хотите работать в&nbsp;АСТ&nbsp;Компонентс? Отправьте резюме на&nbsp;электронную почту с&nbsp;пометкой “Резюме”</h2>\r\n                        </div>\r\n                        <div class=\"career__card-link\">\r\n                            <svg aria-hidden=\"true\">\r\n                                <use xlink:href=\"images/sprite.svg#mail\"></use>\r\n                            </svg>\r\n                            <a href=\"mailto:en@astc.ru\">en@astc.ru</a>\r\n                        </div>\r\n                    </article>\r\n                </div>\r\n            </div>\r\n        </div>', 'careers', 0, 1, 0, 'Присоединяйся к команде АСТ Компонентс!', NULL, NULL, 'Присоединяйся к команде АСТ Компонентс!', NULL, 1, '2025-12-17 09:49:31', '2025-12-17 10:00:54');

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `article` varchar(50) NOT NULL,
  `n_number` int(11) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `catalog_id` bigint(20) UNSIGNED NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `seo_url_canonical` varchar(255) DEFAULT NULL,
  `seo_h1` varchar(255) DEFAULT NULL,
  `seo_sitemap` tinyint(1) NOT NULL DEFAULT 1,
  `image_title` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `article`, `n_number`, `thumbnail`, `origin`, `catalog_id`, `price`, `meta_title`, `meta_description`, `meta_keywords`, `slug`, `seo_url_canonical`, `seo_h1`, `seo_sitemap`, `image_title`, `image_alt`, `published`, `created_at`, `updated_at`) VALUES
(1, 'ADUC812BSZ, Микроконвертер, 12-Bit ADC, 8-bit ADuC8xx 8052 CISC 8KB Flash 3.3V/5V [MQFP-52]', '<p>MSC-51 8K-Flash/256-RAM/640-EEPROM 8 x 12-бит АЦП + 2 x 12-бит ЦАП</p>', '324523', 34534, NULL, NULL, 1, 0, 'ADUC812BSZ, Микроконвертер, 12-Bit ADC, 8-bit ADuC8xx 8052 CISC 8KB Flash 3.3V/5V [MQFP-52]', NULL, NULL, 'aduc812bsz-mikrokonverter-12-bit-adc-8-bit-aduc8xx-8052-cisc-8kb-flash-33v', NULL, 'ADUC812BSZ, Микроконвертер, 12-Bit ADC, 8-bit ADuC8xx 8052 CISC 8KB Flash 3.3V/5V [MQFP-52]', 1, NULL, NULL, 1, '2025-11-20 16:18:07', '2025-11-22 13:18:51');

-- --------------------------------------------------------

--
-- Структура таблицы `product_documents`
--

CREATE TABLE `product_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `product_parameters`
--

CREATE TABLE `product_parameters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_parameters`
--

INSERT INTO `product_parameters` (`id`, `name`, `value`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 'Бренд', 'Analog Devices', 1, '2025-11-22 13:53:31', '2025-11-22 13:53:31'),
(2, 'Ядро', '8052', 1, '2025-11-22 13:54:46', '2025-11-22 13:54:46'),
(3, 'Тактовая частота, МГц', '16', 1, '2025-11-22 13:55:46', '2025-11-22 13:55:46'),
(4, 'Объем памяти программ', '8 кбайт(8k x 8)', 1, '2025-11-22 13:56:15', '2025-11-22 13:56:15'),
(5, 'Объем EEPROM', '640x8', 1, '2025-11-22 13:56:47', '2025-11-22 13:56:47'),
(6, 'Наличие АЦП/ЦАП', 'ацп 8x12b/цап 2x12b', 1, '2025-11-22 13:57:09', '2025-11-22 13:57:09'),
(7, 'Встроенная периферия', 'psm, temp sensor, wdt', 1, '2025-11-22 13:57:42', '2025-11-22 13:57:42'),
(8, 'Рабочая температура', '-40…+85c', 1, '2025-11-22 13:58:03', '2025-11-22 13:58:03'),
(9, 'Серия', 'microconverter aduc8xx', 1, '2025-11-22 13:58:56', '2025-11-22 13:58:56'),
(10, 'Ширина шины данных', '8-бит', 1, '2025-11-22 13:59:18', '2025-11-22 13:59:18'),
(11, 'Количество входов/выходов', '34', 1, '2025-11-22 13:59:37', '2025-11-22 13:59:37'),
(12, 'Тип памяти программ', 'flash', 1, '2025-11-22 14:00:00', '2025-11-22 14:00:00'),
(13, 'Объем RAM', '256x8', 1, '2025-11-22 14:00:21', '2025-11-22 14:00:21'),
(14, 'Встроенные интерфейсы', 'i2c, spi, uart', 1, '2025-11-22 14:00:43', '2025-11-22 14:00:43'),
(15, 'Напряжение питания', '2.7…5.5 в', 1, '2025-11-22 14:01:05', '2025-11-22 14:01:05'),
(16, 'Корпус', 'mqfp-52(10x10)', 1, '2025-11-22 14:01:25', '2025-11-22 14:01:25');

-- --------------------------------------------------------

--
-- Структура таблицы `redirect`
--

CREATE TABLE `redirect` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `status` enum('301','302') NOT NULL DEFAULT '301',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `seo`
--

CREATE TABLE `seo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `h1` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `seo_sitemap` tinyint(1) NOT NULL DEFAULT 1,
  `keyword` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `url_canonical` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2vd4mrD7za6deng5T8nw4f3T60C7624NFJXIWQU8', NULL, '44.247.216.141', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G965U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.111 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYmdSTW0xNWRwbXN2ckxrYUpGeUh2WnBaRGdmRkhjSE5hZWhldmh6bSI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly90ZXN0MS5hc3RjLm9yZy5ydSI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767607934),
('3Xfjn7VNGQyIyWo2GT0NjePLsAoMDHpsFpy8L16y', NULL, '34.122.147.229', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSVhOUkRpdEtndGFPWG1EM2tCUTZjVkYxTXJ3Wml5NHFRcHI3ajN0VyI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly80NS4xNDAuMTY3LjE4MCI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767606107),
('66P8YdWCa0rfUIiLMA6LjiW4vESCQ8JZEESMNgca', NULL, '147.185.132.35', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSXVQR2kwR1RTcE5BdE1SM2V4RlRVazhmMVJQQkdWZTR3R3o0ODJ0ViI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vNDUuMTQwLjE2Ny4xODAiO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767602973),
('8WXQDnrWk8WDLEErqL31OprPq7Ko9SYsNktpPDQn', NULL, '52.2.72.219', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRDJnV3JQQ0RFWHBZWGtUN0k3eHlocndVZ3Ntc3hFUDQwcnZScEJTRyI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly80NS4xNDAuMTY3LjE4MCI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767602167),
('Bsyukz52i0GlfAd62kMvFLcNkZHHxrO1g3NhG6DK', NULL, '44.247.216.141', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR1M4ajFlZWcxcWpKRWk3bUFVd3JxcTBOR1djclg1b0h2azRIdWJlTCI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly90ZXN0MS5hc3RjLm9yZy5ydSI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767607934),
('cNOZCjjsCI3sseM4uTouJ1MswcywiEfKMarDiRMh', NULL, '149.50.103.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSkJjbG94YXFhM1pzVVdlMFJCMU5lalJvSE5HQ3lmWlJEY3JiNjRTdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767600692),
('cQFdvuHXsHkuIcRudgqkecSC4C3ZAHo8CjU7Kziu', NULL, '34.123.170.104', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQng0NldobzRyS0pLN3hXV0ZPSG9UdVpvMmRmeGxSVU16RkIyWncwYiI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly80NS4xNDAuMTY3LjE4MCI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767606155),
('DuO1jqqs8DlgEKbSvR6WDewPuJxr8WiYKAR5YDS1', NULL, '43.153.101.233', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQmtvZTAwQ2k5dmpzYkdsZ2hHRW9kVTc1ZEJWQ2lRVEpMR0h2MU1UciI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly80NS4xNDAuMTY3LjE4MCI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767600285),
('ElE8otllWmmv6gGU3we3mmqHseLi8ofktiYnSsSB', NULL, '34.223.242.184', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.4 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidldzc3hFNzFyNDhEanBnUHc0NlVhelF5bDNXNmdlcWJ4WndKUWZFcyI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly93d3cudGVzdDEuYXN0Yy5vcmcucnUiO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767608100),
('EX4zz15H0msUemakM4WGFfiMjFFw12K28sxYi6vN', NULL, '34.223.242.184', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSTRzQWdJUVBwZW9SV2hlcWw2UXdpOTJ3eG95cjI5VGVieVFDWGhkayI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly93d3cudGVzdDEuYXN0Yy5vcmcucnUiO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767608098),
('GjkWggP6Lwo5b3YQcSAbFTN82o02nDvvtWCKYEeh', NULL, '167.86.107.35', 'Mozilla/5.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMTk5V3d6OU90Wm5kTWM3NGlOUUN4R3pOWkFSZE1XM0hBT2tacktUViI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly80NS4xNDAuMTY3LjE4MCI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767605741),
('Gwr6PF1L7CRCDrqEHh3OYXauTGMcWIfyvQXzDdh8', NULL, '206.191.154.44', 'Mozilla/5.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicDk0SFZqU0hLVHUxcGFLV0ZsQnpUY2hrd0JoRE56OGZLY1NkVmFhVSI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vNDUuMTQwLjE2Ny4xODAiO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767602442),
('JlQdLoCmyi0T5Jx00H4O8UG64XDU1kVze51jst0V', NULL, '128.192.12.105', 'Mozilla/5.0 (compatible; UGAResearchAgent/1.0; Please visit: NISLabUGA.github.io)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNWZ5WjVzWmtWQlZ0UnRGd3VNT01DRWQ4ZVM2NHJRcWRPbDRrSGFNcyI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vd3d3LnRlc3QxLmFzdGMub3JnLnJ1IjtzOjU6InJvdXRlIjtzOjE0OiJmcm9udGVuZC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1767608169),
('mnALNyuvkA9qbyXxzHB3X8lCOkudjbdqUk0aBlFR', NULL, '147.185.132.6', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU0hQY0JwQjBUUHpDcGtHRWVIS202RVl4WWw2SlV4VDRVMVc0WURESiI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly80NS4xNDAuMTY3LjE4MCI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767608184),
('MRNbGLNnCBAU8XEiVUcxWObBECLMFgE3ImSSJWMn', NULL, '167.94.138.181', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiamZtN3g3QTdITnduSVdOM3hNZUsxUzNqUWdscHRXVGFFSE4wcnZYWCI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly80NS4xNDAuMTY3LjE4MCI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767607197),
('pEl8iVvn5BObIqEMaFzkhsCsb8TU2zqL5pCWCMLQ', 1, '185.77.207.83', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidm9WUWgwSFZieUVsS0JEVm9rVEJLVkVXSFdXN1pHTjgzU0ZOSkZrNiI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vYXN0Yy5qYW5pY2tpeS5jb20iO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767604846),
('PLNANFiClZfOsRXY4TFz6z9iMI8WP3cBvy02PIE2', NULL, '188.18.72.58', 'Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHZETVU0VVFpc3RqRWZ5OFVzc09GalpoaEJVZU1zTzNNcEFwRHIxRyI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vYXN0Yy5qYW5pY2tpeS5jb20vY2F0YWxvZyI7czo1OiJyb3V0ZSI7czoxNjoiZnJvbnRlbmQuY2F0YWxvZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1767605679),
('sMzuDzCVBeVuo40YIF7l9LL1VkZPlN73r4rI8XCZ', NULL, '185.100.87.136', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:104.71.6212.24) Gecko/25.2.4212.671 Firefox/2.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUVV0QVZkbzZsakdPclVPREtPbmM1TDJ3WHRzSmdqQXdNVENWTGJaMSI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vNDUuMTQwLjE2Ny4xODAiO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767607659),
('tEC02ZaSNFxYiCgan0phwQDUrtlZWJJHS6DCuPJg', NULL, '185.77.207.83', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRTlicHpuRmVtakllUkI0MW1Ka2dUUHhtVkJpYmlaZndLSTZ4bUkxZyI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9hc3RjLmphbmlja2l5LmNvbSI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767604846),
('Tn45NyJOavVMwQw9vrh24wOj8WOjOUoBR3M3uBfE', NULL, '185.77.207.83', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiamdwS21mZVkyeURncEdtUVkzcnBuSHZYSDhGMVNJeUxqUngyTXVZMyI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly90ZXN0My5hc3RjLm9yZy5ydSI7czo1OiJyb3V0ZSI7czoxNDoiZnJvbnRlbmQuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767607978),
('UUMyVKrGoIfjKeXnBWaS8fpImcQtDkFHJp6SeG04', NULL, '79.173.88.161', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoienhLWFoxTVZOUUt6QTJQYzBPcXdpZnE4M1FmTU9Hd2xVQWRSNTdRdiI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vYXN0Yy5qYW5pY2tpeS5jb20iO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767604684),
('v4wden6mTey01yGSAsMZRGMyHjqKydOTqW9zPTeJ', NULL, '52.2.72.219', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS09XU0xadmZYYWtSUEMwSXVTRklqcm9QUWs3cFR0UXF5Y1dRa0NsQSI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vNDUuMTQwLjE2Ny4xODAiO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767602172),
('vYTghzJvrgyj7OimG4DONCgxBqvnYnHrXboRloJ1', NULL, '89.107.138.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiakRiYzY5QkZnanZvcWV4dDRRNDlSSG5UUXYwWkZZUHZlQ0g4bmRwNCI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vYXN0Yy5qYW5pY2tpeS5jb20iO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767601718),
('WC1laF5D8gaAs5cC7ioVIzs8Y0uK58RQbbcjXnJN', NULL, '167.86.107.35', 'Mozilla/5.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib2p2bGtQaVBDRklZekwzWWhpdmJHNTM2MHRkRTJJQUp2OFdVbHloZiI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vNDUuMTQwLjE2Ny4xODAiO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767601643),
('X1YIJbYTkNYIO40ywDiPiKLxJRJAdmaBWk08uPCZ', NULL, '167.94.138.174', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWU5a3dXcnBaV3JwODljNDM2TlZWUzJwQTd5eUozbE1zZHpPYktpNiI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vNDUuMTQwLjE2Ny4xODAiO3M6NToicm91dGUiO3M6MTQ6ImZyb250ZW5kLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767603514),
('xhBe6w3j2j2EgjEKRujyt3FuYZQMTR23KtmMH9bs', NULL, '149.50.103.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSURkY200Q0ROZ2hZdWZ5RFk2ZEhUQndndHJsZjdPOW5naDNlNzZKaCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767605616),
('ZsrjBQ1QbBJwmnhfvpax3VmI2kiZ7TS0fAFVmYjo', NULL, '13.49.243.115', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36 Assetnote/1.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiam9qV0hzOXdERGhKY1FNV3BUZERBeWFLZzZmRlcxcklZdEIxbGhDYSI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vYXN0YzIuamFuaWNraXkuY29tIjtzOjU6InJvdXRlIjtzOjE0OiJmcm9udGVuZC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1767607174);

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key_cd` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `display_value` varchar(255) DEFAULT NULL,
  `value` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `key_cd`, `name`, `type`, `display_value`, `value`, `published`, `created_at`, `updated_at`) VALUES
(1, 'COMPANY_NAME', 'Сокращенное наименование компании', 'TEXT', NULL, 'ООО «АСТ Компонентс»', 1, '2025-11-17 12:09:20', '2025-11-17 13:25:05'),
(3, 'COMPANY_FULL_NAME', 'Полное наименование компании', 'TEXT', NULL, 'Общество с Ограниченной Ответственностью «АСТ Компонентс»', 1, '2025-11-17 13:26:49', '2025-11-17 13:26:49'),
(4, 'INN', 'ИНН', 'TEXT', NULL, '7728275701', 1, '2025-11-17 13:27:29', '2025-11-17 13:27:29'),
(5, 'KPP', 'КПП', 'TEXT', NULL, '772001001', 1, '2025-11-17 13:28:06', '2025-11-17 13:28:06'),
(6, 'OGRN', 'ОГРН', 'TEXT', NULL, '1037728000243', 1, '2025-11-17 13:29:26', '2025-11-17 13:29:26'),
(7, 'OKPO', 'ОКПО', 'TEXT', NULL, '59811030', 1, '2025-11-17 13:30:32', '2025-11-17 13:30:32'),
(8, 'LEGAL_ADDRESS', 'Юридический адрес', 'TEXT', NULL, '111123, г. Москва, шоссе Энтузиастов, дом 56, стр. 32, этаж 2, помещения 219, 221', 1, '2025-11-17 13:31:55', '2025-11-17 13:31:55'),
(9, 'REAL_ADDRESS', 'Фактический адрес', 'TEXT', NULL, '115088, г. Москва, проезд Южнопортовый 2-й, д.20А', 1, '2025-11-17 13:33:35', '2025-11-17 13:33:35'),
(10, 'POSTAL_ADDRESS', 'Почтовый адрес', 'TEXT', NULL, '115088, г. Москва, а/я 45', 1, '2025-11-17 13:35:07', '2025-11-17 13:35:07'),
(11, 'BANK', 'Банк', 'TEXT', 'Банковские реквизиты', 'ПАО СБЕРБАНК', 1, '2025-11-17 13:36:15', '2025-11-17 13:36:15'),
(12, 'BIK', 'БИК', 'TEXT', NULL, '044525225', 1, '2025-11-17 13:36:47', '2025-11-17 13:36:47'),
(13, 'INN_BANK', 'ИНН банка', 'TEXT', 'Банковские реквизиты', '7707083893', 1, '2025-11-17 13:37:56', '2025-11-17 13:37:56'),
(14, 'CURRENT_ACCOUNT', 'Расчетный счет', 'TEXT', 'Банковские реквизиты', '40702810638000061502', 1, '2025-11-17 13:39:06', '2025-11-17 13:39:06'),
(15, 'CORRESPONDENT_ACCOUNT', 'Корреспондентский счет', 'TEXT', 'Банковские реквизиты', '30101810400000000225', 1, '2025-11-17 13:40:03', '2025-11-17 13:40:03'),
(16, 'GENERAL_MANAGER', 'Генеральный директор', 'TEXT', 'Контакты', 'Бичев Вадим Георгиевич', 1, '2025-11-17 13:41:13', '2025-11-17 13:41:13'),
(17, 'CHIEF_ACCOUNTANT', 'Главный бухгалтер', 'TEXT', 'Контакты', 'Бичев Вадим Георгиевич', 1, '2025-11-17 13:42:27', '2025-11-17 13:42:27'),
(18, 'PHONE', 'Телефон', 'TEXT', 'Контакты', '8(495) 981-41-14', 1, '2025-11-17 13:44:19', '2025-11-17 13:44:19'),
(19, 'FAX', 'Факс', 'TEXT', 'Контакты', '8(495) 921-24-41', 1, '2025-11-17 13:45:08', '2025-11-17 13:45:08'),
(20, 'EMAIL', 'Электронная почта', 'TEXT', 'Контакты', 'info@astc.ru', 1, '2025-11-17 13:45:41', '2025-11-17 13:45:41'),
(21, 'MAP_ADRESS_LINK', 'Ссылка на яндекс карту', 'TEXT', NULL, 'https://yandex.ru/maps/-/CLqsZYNp', 1, '2025-11-25 13:07:56', '2025-11-25 13:07:56'),
(22, 'SALE_EMAIL', 'sale email', 'TEXT', NULL, 'sales@astc.ru', 1, '2025-11-25 14:51:22', '2025-11-25 14:51:22'),
(23, 'PHONE2', 'Телефон 2', 'TEXT', 'Контакты', '8 (495) 123-45-14', 1, '2025-12-16 15:01:21', '2025-12-16 15:01:55'),
(24, 'YANDEX_MAP', 'Яндекс карта', 'HTML', NULL, '<a href=\"https://yandex.ru/maps/-/CLqsZYNp\" target=\"_blank\" rel=\"noopener noreferrer\">Москва, проезд Южнопортовый 2-й, д.20А</a>', 1, '2025-12-16 15:05:41', '2025-12-16 15:05:41'),
(25, 'DETAILS', 'Скачать реквизиты', 'FILE', NULL, '1765963319.png', 1, '2025-12-17 09:21:59', '2025-12-17 09:21:59'),
(26, 'EMAIL_NOTIFY', 'janickiy@mail.ru,yanack@yandex.ru', 'TEXT', 'Email куда приходят уведомления (перечислить через запятую)', 'Email куда приходят уведомления (перечислить через запятую)', 1, '2025-12-19 10:06:28', '2025-12-19 10:06:28');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `login` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `login`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin', NULL, NULL, '$2y$12$VqRRMivy.KQ9TjOWbJP0MOGE3oTQVBoVAqZv0sKmPhMpOB8zdnT22', 'hfdZTl3wlEmv9Gzaba1PMx0Jjot8KArQxmxfKuLojdlM0wTfLz8Eij8bSzAB', '2025-10-21 20:49:35', '2025-10-21 20:49:35');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin_menus`
--
ALTER TABLE `admin_menus`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `admin_menu_items`
--
ALTER TABLE `admin_menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_menu_items_menu_foreign` (`menu`);

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `catalogs`
--
ALTER TABLE `catalogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `catalogs_slug_unique` (`slug`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `manufacturers_slug_unique` (`slug`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_catalog_id_foreign` (`catalog_id`),
  ADD KEY `n_number` (`n_number`);

--
-- Индексы таблицы `product_documents`
--
ALTER TABLE `product_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_documents_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `product_parameters`
--
ALTER TABLE `product_parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_parameters_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `redirect`
--
ALTER TABLE `redirect`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_cd_unique` (`key_cd`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_unique` (`login`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin_menus`
--
ALTER TABLE `admin_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `admin_menu_items`
--
ALTER TABLE `admin_menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `catalogs`
--
ALTER TABLE `catalogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `product_documents`
--
ALTER TABLE `product_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `product_parameters`
--
ALTER TABLE `product_parameters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `redirect`
--
ALTER TABLE `redirect`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `seo`
--
ALTER TABLE `seo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `admin_menu_items`
--
ALTER TABLE `admin_menu_items`
  ADD CONSTRAINT `admin_menu_items_menu_foreign` FOREIGN KEY (`menu`) REFERENCES `admin_menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_catalog_id_foreign` FOREIGN KEY (`catalog_id`) REFERENCES `catalogs` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_documents`
--
ALTER TABLE `product_documents`
  ADD CONSTRAINT `product_documents_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_parameters`
--
ALTER TABLE `product_parameters`
  ADD CONSTRAINT `product_parameters_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
