<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-10-17 09:44:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '-1 OFFSET 0' at line 12 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND gerai_medsos_posts.is_active='1'
			AND (post LIKE '%%') ORDER BY created_on DESC  LIMIT -1 OFFSET 0
ERROR - 2018-10-17 10:19:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND gerai_medsos_posts.is_active='1'
			AND gerai_medsos_posts.post_id
			AND ' at line 11 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			--AND gerai_medsos_posts.is_active='1'
			AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') ORDER BY abuse_desc DESC  LIMIT 10 OFFSET 0
ERROR - 2018-10-17 10:19:15 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND gerai_medsos_posts.is_active='1'
			--AND gerai_medsos_posts.post_id
			AN' at line 11 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			--AND gerai_medsos_posts.is_active='1'
			--AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') ORDER BY abuse_desc DESC  LIMIT 10 OFFSET 0
ERROR - 2018-10-17 10:21:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') LIMIT 10 OFFSET 0' at line 12 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND gerai_medsos_posts.is_active='1'
			--AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') LIMIT 10 OFFSET 0
ERROR - 2018-10-17 10:22:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') ORDER BY abuse_desc asc ' at line 12 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND gerai_medsos_posts.is_active='1'
			--AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') ORDER BY abuse_desc asc  LIMIT 10 OFFSET 0
ERROR - 2018-10-17 10:23:26 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') ORDER BY post DESC  LIMI' at line 12 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND gerai_medsos_posts.is_active='1'
			--AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') ORDER BY post DESC  LIMIT 10 OFFSET 0
ERROR - 2018-10-17 10:25:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') ORDER BY post asc  LIMIT' at line 12 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND gerai_medsos_posts.is_active='1'
			--AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') ORDER BY post asc  LIMIT 10 OFFSET 0
ERROR - 2018-10-17 10:26:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') ORDER BY abuse_desc DESC' at line 12 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND gerai_medsos_posts.is_active='1'
			--AND gerai_medsos_posts.post_id
			AND (post LIKE '%%') ORDER BY abuse_desc DESC  LIMIT 10 OFFSET 0
ERROR - 2018-10-17 10:26:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND gerai_medsos_posts.post_id
			AND (abuse_desc LIKE '%%') ORDER BY abuse_des' at line 12 - Invalid query: SELECT gerai_medsos_posts.*,
			gerai_medsos_abuse_post.abuse_desc,
			gerai_medsos_abuse_post.abuse_from_user_id,
			ma_users.fullname
			FROM gerai_medsos_posts
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.ids
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND gerai_medsos_posts.is_active='1'
			--AND gerai_medsos_posts.post_id
			AND (abuse_desc LIKE '%%') ORDER BY abuse_desc DESC  LIMIT 10 OFFSET 0
ERROR - 2018-10-17 10:39:40 --> Query error: Unknown column 'abuse_desc' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_medsos_posts 
			WHERE is_active='1'
			AND (post LIKE '%%' 
			OR abuse_desc LIKE '%%'
			)
