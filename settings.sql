-- phpMyAdmin SQL Dump
-- version 4.3.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 21, 2015 at 02:16 PM
-- Server version: 5.6.23
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inventorytrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `key`   VARCHAR(128) NOT NULL,
  `value` VARCHAR(128) NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`key`, `value`) VALUES
  ('CAPTCHA_HEIGHT', '100'),
  ('CAPTCHA_WIDTH', '359'),
  ('CASTLE_ENABLED', 'false'),
  ('CASTLE_ID', 'XXXXXXXXXXXX'),
  ('CASTLE_SECRET', 'XXXXXXXXXXXXXXXXXXX'),
  ('COOKIE_PATH', '/'),
  ('COOKIE_RUNTIME', '1209600'),
  ('EMAIL_PASSWORD_RESET_CONTENT', 'Please click on this link to reset your password: '),
  ('EMAIL_PASSWORD_RESET_FROM_EMAIL', 'no-reply@example.com'),
  ('EMAIL_PASSWORD_RESET_FROM_NAME', 'Issue-Track'),
  ('EMAIL_PASSWORD_RESET_SUBJECT', 'Password Reset'),
  ('EMAIL_PASSWORD_RESET_URL', 'login/verifypasswordreset'),
  ('EMAIL_SMTP_AUTH', 'true'),
  ('EMAIL_SMTP_ENCRYPTION', 'ssl'),
  ('EMAIL_SMTP_HOST', 'yourhost.com'),
  ('EMAIL_SMTP_PASSWORD', 'password'),
  ('EMAIL_SMTP_PORT', '465'),
  ('EMAIL_SMTP_USERNAME', 'username'),
  ('EMAIL_USED_MAILER', 'phpmailer'),
  ('EMAIL_USE_SMTP', 'false'),
  ('EMAIL_VERIFICATION_CONTENT', 'Please click on this link to activate your account: '),
  ('EMAIL_VERIFICATION_FROM_EMAIL', 'no-reply@example.com'),
  ('EMAIL_VERIFICATION_FROM_NAME', 'Issue-Track'),
  ('EMAIL_VERIFICATION_SUBJECT', 'Email Verification'),
  ('EMAIL_VERIFICATION_URL', 'login/verify'),
  ('FACEBOOK_LOGIN', 'false'),
  ('GRAVATAR_DEFAULT_IMAGESET', 'mm'),
  ('GRAVATAR_RATING', 'pg'),
  ('SITE_DESCRIPTION', 'Issue Tracker'),
  ('SITE_NAME', 'Issue-Track'),
  ('USE_GRAVATAR', 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
ADD PRIMARY KEY (`key`), ADD UNIQUE KEY `key` (`key`);

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
