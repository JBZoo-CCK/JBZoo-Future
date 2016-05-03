SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `t_jbzoo_config`;
CREATE TABLE `t_jbzoo_config` (
  `option` varchar(250) NOT NULL DEFAULT '',
  `value` longtext NOT NULL,
  `autoload` tinyint(3) unsigned NOT NULL DEFAULT '1',
  UNIQUE KEY `option_name` (`option`),
  KEY `autoload` (`autoload`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `t_jbzoo_config` (`option`, `value`, `autoload`) VALUES
('atom.core',	'{\n    \"debug\": {\n            \"dumper\": \"symfony\",\n            \"ip\": \"127.0.0.1\\r\\n192.168.0.1\\r\\n8.8.8.8\",\n            \"log\": 1,\n            \"dump\": true,\n            \"sql\": true,\n            \"profiler\": true,\n            \"trace\": false\n    }\n}',	1),
('atom.test',	'{\n    \"checkbox\": 1,\n    \"text\": \"Some text\",\n    \"group\": {\n        \"toggle\": false,\n        \"text1\": \"\"\n    },\n    \"textarea\": \"\",\n    \"toggle\": true,\n    \"date\": \"2016-04-22\",\n    \"time\": \"00:42\",\n    \"select\": null,\n    \"radio\": 2\n}',	1);
