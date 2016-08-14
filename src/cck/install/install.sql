--
-- JBZoo CCK
--
-- This file is part of the JBZoo CCK package.
-- For the full copyright and license information, please view the LICENSE
-- file that was distributed with this source code.
--
-- @package   CCK
-- @license   Proprietary http://jbzoo.com/license
-- @copyright Copyright (C) JBZoo.com,  All rights reserved.
-- @link      http://jbzoo.com
--

-- Prepare ---------------------------------------------------------------------

SET NAMES utf8;

-- Items -----------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `#__jbzoo_items` (
    `id`           INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(255)     NOT NULL,
    `alias`        VARCHAR(255)     NOT NULL,
    `type`         VARCHAR(100)     NOT NULL,
    `status`       TINYINT(3)       NOT NULL DEFAULT '0',
    `created_by`   INT(11)          NOT NULL,
    `created`      DATETIME         NOT NULL,
    `modified`     DATETIME         NOT NULL,
    `publish_up`   DATETIME         NOT NULL,
    `publish_down` DATETIME         NOT NULL,
    `elements`     LONGTEXT         NOT NULL,
    `params`       LONGTEXT         NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `ALIAS_INDEX` (`alias`),
    INDEX `STATUS_INDEX` (status),
    INDEX `CREATED_BY_INDEX` (`created_by`),
    INDEX `NAME_INDEX` (`name`),
    INDEX `TYPE_INDEX` (`type`),
    INDEX `CREATED_INDEX` (`created`),
    INDEX `MODIFIED_INDEX` (`modified`),
    INDEX `PUBLISH_STATUS_INDEX` (status, `publish_up`, `publish_down`),
    INDEX `PUBLISH_INDEX` (`publish_up`, `publish_down`)
)
    COLLATE = 'utf8_general_ci'
    ENGINE = InnoDB;

-- Modules ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `#__jbzoo_modules` (
    `id`     INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`  VARCHAR(255)     NOT NULL,
    `params` LONGTEXT         NOT NULL,
    PRIMARY KEY (`id`)
)
    COLLATE = 'utf8_general_ci'
    ENGINE = InnoDB;

-- Configurations --------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `#__jbzoo_config` (
    `option`   VARCHAR(250)        NOT NULL DEFAULT '',
    `value`    LONGTEXT            NOT NULL,
    `autoload` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    UNIQUE INDEX `OPTION_NAME` (`option`),
    INDEX `AUTOLOAD` (`autoload`)
)
    COLLATE = 'utf8_general_ci'
    ENGINE = InnoDB;
