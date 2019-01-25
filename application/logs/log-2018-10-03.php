<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-10-03 07:14:06 --> Severity: Notice --> Undefined variable: Editberita D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 07:14:06 --> Severity: Notice --> Trying to get property 'news_content' of non-object D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 09:25:10 --> Severity: Notice --> Undefined variable: Editberita D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 09:25:10 --> Severity: Notice --> Trying to get property 'news_content' of non-object D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 09:46:53 --> Severity: Notice --> Undefined variable: Editberita D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 09:46:53 --> Severity: Notice --> Trying to get property 'news_content' of non-object D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 09:47:46 --> Severity: Notice --> Undefined variable: Editberita D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 09:47:46 --> Severity: Notice --> Trying to get property 'news_content' of non-object D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 09:51:03 --> Severity: Notice --> Undefined variable: Editberita D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 09:51:03 --> Severity: Notice --> Trying to get property 'news_content' of non-object D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 09:51:12 --> Severity: Notice --> Undefined variable: Editberita D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 09:51:12 --> Severity: Notice --> Trying to get property 'news_content' of non-object D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 10:19:28 --> Severity: Notice --> Undefined variable: Editberita D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 10:19:28 --> Severity: Notice --> Trying to get property 'news_content' of non-object D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 63
ERROR - 2018-10-03 10:58:57 --> Query error: Column 'is_active' in where clause is ambiguous - Invalid query: SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_voucher_users.user_id
			FROM gerai_voucher_code
			INNER JOIN gerai_voucher_users
			ON gerai_voucher_code.ids=gerai_voucher_users.ids
			WHERE gerai_voucher_users.voucher_id
			AND is_active='1'
ERROR - 2018-10-03 13:44:38 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_vouch' at line 2 - Invalid query: SELECT count(*) as jml FROM gerai_voucher_code WHERE is_active='1' 
		AND(voucher_code LIKE '%%'SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_voucher_users.user_id,
			ma_users.fullname
			FROM gerai_voucher_code
			INNER JOIN gerai_voucher_users
			ON gerai_voucher_code.ids=gerai_voucher_users.voucher_id
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_voucher_users.ids
			AND gerai_voucher_users.is_active='1'
		OR voucher_desc LIKE '%%'
		OR voucher_value LIKE '%%'
		OR product LIKE '%%'
		OR start_date LIKE '%%'
		OR end_date LIKE '%%'
		OR filename LIKE '%%'
		)
ERROR - 2018-10-03 13:45:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_vouch' at line 2 - Invalid query: SELECT count(*) as jml FROM gerai_voucher_code WHERE is_active='1' 
		AND(voucher_code LIKE '%%'SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_voucher_users.user_id,
			ma_users.fullname
			FROM gerai_voucher_code
			INNER JOIN gerai_voucher_users
			ON gerai_voucher_code.ids=gerai_voucher_users.voucher_id
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_voucher_users.ids
			AND gerai_voucher_users.is_active='1'
		OR voucher_desc LIKE '%%'
		OR voucher_value LIKE '%%'
		OR product LIKE '%%'
		OR start_date LIKE '%%'
		OR end_date LIKE '%%'
		OR filename LIKE '%%'
		)
ERROR - 2018-10-03 13:56:15 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_vouch' at line 2 - Invalid query: SELECT count(*) as jml FROM gerai_voucher_code WHERE is_active='1' 
		AND(voucher_code LIKE '%%'SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_voucher_users.user_id,
			ma_users.fullname
			FROM gerai_voucher_code
			INNER JOIN gerai_voucher_users
			ON gerai_voucher_code.ids=gerai_voucher_users.voucher_id
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_voucher_users.ids
			AND gerai_voucher_users.is_active='1'
		OR voucher_desc LIKE '%%'
		OR voucher_value LIKE '%%'
		OR product LIKE '%%'
		OR start_date LIKE '%%'
		OR end_date LIKE '%%'
		OR filename LIKE '%%'
		)
ERROR - 2018-10-03 13:57:40 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_vouch' at line 2 - Invalid query: SELECT count(*) as jml FROM gerai_voucher_code WHERE is_active='1' 
		AND(voucher_code LIKE '%%'SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_voucher_users.user_id,
			ma_users.fullname
			FROM gerai_voucher_code
			INNER JOIN gerai_voucher_users
			ON gerai_voucher_code.ids=gerai_voucher_users.voucher_id
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_voucher_users.ids
			AND gerai_voucher_users.is_active='1'
		OR voucher_desc LIKE '%%'
		OR voucher_value LIKE '%%'
		OR product LIKE '%%'
		OR start_date LIKE '%%'
		OR end_date LIKE '%%'
		OR filename LIKE '%%'
		)
ERROR - 2018-10-03 14:01:26 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_vouch' at line 2 - Invalid query: SELECT count(*) as jml FROM gerai_voucher_code WHERE is_active='1' 
		AND(voucher_code LIKE '%%'SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id,
			gerai_voucher_users.user_id,
			ma_users.fullname
			FROM gerai_voucher_code
			INNER JOIN gerai_voucher_users
			ON gerai_voucher_code.ids=gerai_voucher_users.voucher_id
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_voucher_users.ids
			AND gerai_voucher_users.is_active='1'
		OR voucher_desc LIKE '%%'
		OR voucher_value LIKE '%%'
		OR product LIKE '%%'
		OR start_date LIKE '%%'
		OR end_date LIKE '%%'
		OR filename LIKE '%%'
		)
ERROR - 2018-10-03 14:03:08 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.user_id
			ma_users.fullname
			FROM gerai_voucher_code
			INNER JOIN gerai_' at line 3 - Invalid query: SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id
			gerai_voucher_users.user_id
			ma_users.fullname
			FROM gerai_voucher_code
			INNER JOIN gerai_voucher_users
			ON gerai_voucher_code.ids=gerai_voucher_users.voucher_id
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_voucher_users.ids
			AND gerai_voucher_users.is_active='1'
			AND (voucher_code LIKE '%%'
		    OR voucher_desc LIKE '%%') ORDER BY voucher_code DESC  LIMIT 10 OFFSET 0
ERROR - 2018-10-03 14:03:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.user_id
			ma_users.fullname
			FROM gerai_voucher_code
			INNER JOIN gerai_' at line 3 - Invalid query: SELECT gerai_voucher_code.*,
			gerai_voucher_users.voucher_id
			gerai_voucher_users.user_id
			ma_users.fullname
			FROM gerai_voucher_code
			INNER JOIN gerai_voucher_users
			ON gerai_voucher_code.ids=gerai_voucher_users.voucher_id
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_voucher_users.ids
			AND gerai_voucher_users.is_active='1'
			AND (voucher_code LIKE '%%'
		    OR voucher_desc LIKE '%%') ORDER BY voucher_code DESC  LIMIT 10 OFFSET 0
