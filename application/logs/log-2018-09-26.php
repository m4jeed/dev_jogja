<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-09-26 10:08:56 --> Query error: Unknown column 'ma_users.fulname' in 'field list' - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fulname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 10:10:20 --> Query error: Unknown column 'ma_users.fulname' in 'field list' - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fulname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.ids=ma_users.user_id
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 10:11:18 --> Query error: Unknown column 'ma_users.fulname' in 'field list' - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fulname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_post_id=ma_users.user_id
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 10:12:12 --> Query error: Unknown column 'ma_users.fulname' in 'field list' - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fulname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_posts.from_user_id=ma_users.user_id
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 10:12:43 --> Query error: Unknown column 'ma_users.fulname' in 'field list' - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fulname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_posts.from_user_id=ma_users.user_id
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 10:13:20 --> Query error: Column 'is_active' in where clause is ambiguous - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_posts.from_user_id=ma_users.user_id
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 10:13:58 --> Query error: Column 'is_active' in where clause is ambiguous - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_posts.from_user_id=ma_users.user_id
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (created_on LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 11:15:18 --> Query error: Column 'is_active' in where clause is ambiguous - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 11:16:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0' at line 12 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1';
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 11:18:42 --> Query error: Column 'is_active' in where clause is ambiguous - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_user_id=gerai_medsos_posts.from_user_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 11:19:51 --> Query error: Column 'created_on' in where clause is ambiguous - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_user_id
			-- AND is_active='1'
			AND (created_on LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 11:20:35 --> Query error: Column 'created_on' in where clause is ambiguous - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_user_id
			-- AND is_active='1'
			AND (created_on LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 13:50:11 --> Severity: Notice --> Undefined variable: post_id D:\xampp\htdocs\dev_gerai\application\models\oi\M_coment.php 35
ERROR - 2018-09-26 13:50:12 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0' at line 12 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id='';
			-- AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 13:53:25 --> Query error: Column 'is_active' in where clause is ambiguous - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.from_user_id=gerai_medsos_abuse_post.abuse_from_user_id
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 13:57:29 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_meds' at line 5 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			-- ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			-- INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 13:58:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_meds' at line 5 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			-- ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			-- INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 13:58:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_meds' at line 5 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			-- ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			-- INNER JOIN ma_users
			--ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 14:00:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_meds' at line 5 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			-- ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_abuse_post.ids
			-- INNER JOIN ma_users
			--ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
ERROR - 2018-09-26 14:21:54 --> Severity: Notice --> Undefined variable: Editberita D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 60
ERROR - 2018-09-26 14:21:54 --> Severity: Notice --> Trying to get property 'news_content' of non-object D:\xampp\htdocs\dev_gerai\application\views\oi\vBerita.php 60
