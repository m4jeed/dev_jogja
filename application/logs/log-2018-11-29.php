<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-11-29 09:42:25 --> Query error: Unknown column 'gerai_voucher_users.is_active' in 'where clause' - Invalid query: SELECT count(*) as jumlah
			FROM gerai_voucher_code
			INNER JOIN gerai_group_users
			ON gerai_voucher_code.ids=gerai_group_users.ids
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_group_users.ids
			AND gerai_voucher_users.is_active='1' 
			AND (fullname LIKE '%%'
			OR email LIKE '%%')
ERROR - 2018-11-29 09:42:46 --> Query error: Column 'is_active' in where clause is ambiguous - Invalid query: SELECT count(*) as jumlah
			FROM gerai_voucher_code
			INNER JOIN gerai_group_users
			ON gerai_voucher_code.ids=gerai_group_users.ids
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_group_users.ids
			AND is_active='1' 
			AND (fullname LIKE '%%'
			OR email LIKE '%%')
ERROR - 2018-11-29 09:43:48 --> Query error: Unknown column 'gerai_voucher_users.ids' in 'where clause' - Invalid query: SELECT count(*) as jumlah
			FROM gerai_voucher_code
			INNER JOIN gerai_group_users
			ON gerai_voucher_code.ids=gerai_group_users.ids
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_voucher_users.ids
			AND is_active='1' 
			AND (fullname LIKE '%%'
			OR email LIKE '%%')
ERROR - 2018-11-29 09:44:04 --> Query error: Unknown column 'gerai_voucher_users.ids' in 'where clause' - Invalid query: SELECT count(*) as jumlah
			FROM gerai_voucher_code
			INNER JOIN gerai_group_users
			ON gerai_voucher_code.ids=gerai_group_users.ids
			INNER JOIN ma_users
			ON gerai_voucher_users.user_id=ma_users.user_id
			WHERE gerai_voucher_users.ids
			AND gerai_voucher_users.is_active='1'
			AND (fullname LIKE '%%'
			OR email LIKE '%%')
ERROR - 2018-11-29 09:46:43 --> Query error: Unknown column 'gerai_voucher_users.ids' in 'where clause' - Invalid query: SELECT count(*) as jml 
	 	FROM gerai_voucher_code
		INNER JOIN gerai_group_users
		ON gerai_voucher_code.ids=gerai_group_users.ids
		INNER JOIN ma_users
		ON gerai_voucher_users.user_id=ma_users.user_id
		WHERE gerai_voucher_users.ids
		AND gerai_voucher_users.is_active='1'
	 	AND(voucher_code LIKE '%%' 
	 	OR voucher_desc LIKE '%%'
	 	OR voucher_value LIKE '%%'
	 	OR product LIKE '%%'
	 	OR start_date LIKE '%%'
	 	OR end_date LIKE '%%'
	 	OR filename LIKE '%%'
	 	)
ERROR - 2018-11-29 09:47:46 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'gerai_voucher_users.voucher_id,
		gerai_voucher_users.user_id,
		ma_users.full' at line 2 - Invalid query: SELECT count(*) as jml 
	 	gerai_voucher_users.voucher_id,
		gerai_voucher_users.user_id,
		ma_users.fullname
	 	FROM gerai_voucher_code
		INNER JOIN gerai_group_users
		ON gerai_voucher_code.ids=gerai_group_users.ids
		INNER JOIN ma_users
		ON gerai_voucher_users.user_id=ma_users.user_id
		WHERE gerai_voucher_users.ids
		AND gerai_voucher_users.is_active='1'
	 	AND(voucher_code LIKE '%%' 
	 	OR voucher_desc LIKE '%%'
	 	OR voucher_value LIKE '%%'
	 	OR product LIKE '%%'
	 	OR start_date LIKE '%%'
	 	OR end_date LIKE '%%'
	 	OR filename LIKE '%%'
	 	)
ERROR - 2018-11-29 09:48:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'gerai_voucher_users.voucher_id,
		gerai_voucher_users.user_id,
		ma_users.full' at line 2 - Invalid query: SELECT count(*) as jml 
	 	gerai_voucher_users.voucher_id,
		gerai_voucher_users.user_id,
		ma_users.fullname
	 	FROM gerai_voucher_code
		INNER JOIN gerai_group_users
		ON gerai_voucher_code.ids=gerai_group_users.ids
		INNER JOIN ma_users
		ON gerai_voucher_users.user_id=ma_users.user_id
		WHERE gerai_voucher_users.ids
		AND is_active='1'
	 	AND(voucher_code LIKE '%%' 
	 	OR voucher_desc LIKE '%%'
	 	OR voucher_value LIKE '%%'
	 	OR product LIKE '%%'
	 	OR start_date LIKE '%%'
	 	OR end_date LIKE '%%'
	 	OR filename LIKE '%%'
	 	)
ERROR - 2018-11-29 09:48:28 --> Query error: Unknown column 'gerai_voucher_users.ids' in 'where clause' - Invalid query: SELECT count(*) as jml 
	 	
	 	FROM gerai_voucher_code
		INNER JOIN gerai_group_users
		ON gerai_voucher_code.ids=gerai_group_users.ids
		INNER JOIN ma_users
		ON gerai_voucher_users.user_id=ma_users.user_id
		WHERE gerai_voucher_users.ids
		AND is_active='1'
	 	AND(voucher_code LIKE '%%' 
	 	OR voucher_desc LIKE '%%'
	 	OR voucher_value LIKE '%%'
	 	OR product LIKE '%%'
	 	OR start_date LIKE '%%'
	 	OR end_date LIKE '%%'
	 	OR filename LIKE '%%'
	 	)
ERROR - 2018-11-29 09:48:55 --> Query error: Unknown column 'gerai_voucher_users.ids' in 'where clause' - Invalid query: SELECT count(*) as jml 
	 	
	 	FROM gerai_voucher_code
		INNER JOIN gerai_group_users
		ON gerai_voucher_code.ids=gerai_group_users.ids
		WHERE gerai_voucher_users.ids
		AND is_active='1'
	 	AND(voucher_code LIKE '%%' 
	 	OR voucher_desc LIKE '%%'
	 	OR voucher_value LIKE '%%'
	 	OR product LIKE '%%'
	 	OR start_date LIKE '%%'
	 	OR end_date LIKE '%%'
	 	OR filename LIKE '%%'
	 	)
ERROR - 2018-11-29 09:49:12 --> Query error: Unknown column 'gerai_voucher_users.ids' in 'where clause' - Invalid query: SELECT count(*) as jml 
	 	
	 	FROM gerai_voucher_code
		INNER JOIN gerai_group_users
		ON gerai_voucher_code.ids=gerai_group_users.ids
		WHERE gerai_voucher_users.ids
		AND gerai_voucher_users.is_active='1'
	 	AND (voucher_code LIKE '%%' 
	 	OR voucher_desc LIKE '%%'
	 	OR voucher_value LIKE '%%'
	 	OR product LIKE '%%'
	 	OR start_date LIKE '%%'
	 	OR end_date LIKE '%%'
	 	OR filename LIKE '%%'
	 	)
ERROR - 2018-11-29 10:10:42 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 113
ERROR - 2018-11-29 10:10:42 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 113
ERROR - 2018-11-29 10:33:47 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:33:47 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:34:41 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:34:41 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:37:31 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:37:31 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:37:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM ma_users
			INNER JOIN gerai_group_users
			ON ma_users.user_id=gerai_gro' at line 21 - Invalid query: SELECT ma_users.*,
		    gerai_group_users.user_id,
			gerai_group_users.group_id,
			oi_member.no_anggota,
			oi_member.bpk_oi,
			oi_member.bpw_oi,
			oi_member.kelurahan,
			oi_member.status_nikah,
			oi_member.gol_darah,
			oi_member.pendidikan,
			oi_member.gelar_sarjana,
			oi_member.th_masuk_anggota,
			oi_member.keahlian_profesional1,
			oi_member.keahlian_profesional2,
			base_postalcode.village,
			base_postalcode.districts,
			base_postalcode.city,
			base_postalcode.province,
			base_postalcode.postalcode,
			oi_group.group_name,
			FROM ma_users
			INNER JOIN gerai_group_users
			ON ma_users.user_id=gerai_group_users.user_id
			INNER JOIN oi_member
			ON ma_users.user_id=oi_member.user_id
			INNER JOIN base_postalcode
			ON ma_users.user_id=base_postalcode.ids
			INNER JOIN oi_group
			ON ma_users.user_id=oi_group.ids
			WHERE ma_users.user_id='337' 
ERROR - 2018-11-29 10:39:30 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:39:30 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:40:06 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:40:06 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:41:26 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:41:26 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:44:06 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:44:06 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:44:49 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:44:49 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:57:53 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 10:57:53 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:17:31 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:17:31 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:17:34 --> Query error: Unknown column 'oi_group.ids' in 'field list' - Invalid query: SELECT ma_users.*,
		    gerai_group_users.user_id,
			gerai_group_users.group_id,
			oi_member.no_anggota,
			oi_member.bpk_oi,
			oi_member.bpw_oi,
			oi_member.kelurahan,
			oi_member.status_nikah,
			oi_member.gol_darah,
			oi_member.pendidikan,
			oi_member.gelar_sarjana,
			oi_member.th_masuk_anggota,
			oi_member.keahlian_profesional1,
			oi_member.keahlian_profesional2,
			base_postalcode.village,
			base_postalcode.districts,
			base_postalcode.city,
			base_postalcode.province,
			base_postalcode.postalcode,
			oi_group.ids,
			oi_group.group_name
			FROM ma_users
			INNER JOIN gerai_group_users
			ON ma_users.user_id=gerai_group_users.user_id
			INNER JOIN oi_member
			ON ma_users.user_id=oi_member.user_id
			INNER JOIN base_postalcode
			ON ma_users.user_id=base_postalcode.ids
			
			
			WHERE ma_users.user_id='337' 
ERROR - 2018-11-29 11:18:04 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:18:04 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:18:07 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:18:07 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:18:31 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:18:31 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:18:34 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:18:34 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:19:31 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:19:31 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:19:33 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:19:33 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:20:12 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:20:12 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:20:15 --> Query error: Unknown column 'oi_group.ids' in 'field list' - Invalid query: SELECT ma_users.*,
		    gerai_group_users.user_id,
			gerai_group_users.group_id,
			oi_member.no_anggota,
			oi_member.bpk_oi,
			oi_member.bpw_oi,
			oi_member.kelurahan,
			oi_member.status_nikah,
			oi_member.gol_darah,
			oi_member.pendidikan,
			oi_member.gelar_sarjana,
			oi_member.th_masuk_anggota,
			oi_member.keahlian_profesional1,
			oi_member.keahlian_profesional2,
			base_postalcode.village,
			base_postalcode.districts,
			base_postalcode.city,
			base_postalcode.province,
			base_postalcode.postalcode,
			oi_group.ids,
			oi_group.group_name
			FROM ma_users
			INNER JOIN gerai_group_users
			ON ma_users.user_id=gerai_group_users.user_id
			INNER JOIN oi_member
			ON ma_users.user_id=oi_member.user_id
			INNER JOIN base_postalcode
			ON ma_users.user_id=base_postalcode.ids
			WHERE ma_users.user_id='337' 
ERROR - 2018-11-29 11:20:30 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:20:30 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:20:47 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:20:47 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:20:49 --> Query error: Unknown column 'oi_group.ids' in 'field list' - Invalid query: SELECT ma_users.*,
		    gerai_group_users.user_id,
			gerai_group_users.group_id,
			oi_member.no_anggota,
			oi_member.bpk_oi,
			oi_member.bpw_oi,
			oi_member.kelurahan,
			oi_member.status_nikah,
			oi_member.gol_darah,
			oi_member.pendidikan,
			oi_member.gelar_sarjana,
			oi_member.th_masuk_anggota,
			oi_member.keahlian_profesional1,
			oi_member.keahlian_profesional2,
			base_postalcode.village,
			base_postalcode.districts,
			base_postalcode.city,
			base_postalcode.province,
			base_postalcode.postalcode,
			oi_group.ids,
			oi_group.group_name
			FROM ma_users
			INNER JOIN gerai_group_users
			ON ma_users.user_id=gerai_group_users.user_id
			INNER JOIN oi_member
			ON ma_users.user_id=oi_member.user_id
			INNER JOIN base_postalcode
			ON ma_users.user_id=base_postalcode.ids

			WHERE ma_users.user_id='338' 
ERROR - 2018-11-29 11:21:04 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:21:04 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:23:47 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 11:23:47 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 12:12:07 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 12:12:07 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 12:16:40 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 12:16:40 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 12:16:42 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM ma_users
			INNER JOIN gerai_group_users
			ON ma_users.user_id=gerai_gro' at line 21 - Invalid query: SELECT ma_users.*,
		    gerai_group_users.user_id,
			gerai_group_users.group_id,
			oi_member.no_anggota,
			oi_member.bpk_oi,
			oi_member.bpw_oi,
			oi_member.kelurahan,
			oi_member.status_nikah,
			oi_member.gol_darah,
			oi_member.pendidikan,
			oi_member.gelar_sarjana,
			oi_member.th_masuk_anggota,
			oi_member.keahlian_profesional1,
			oi_member.keahlian_profesional2,
			base_postalcode.village,
			base_postalcode.districts,
			base_postalcode.city,
			base_postalcode.province,
			base_postalcode.postalcode,
			
			FROM ma_users
			INNER JOIN gerai_group_users
			ON ma_users.user_id=gerai_group_users.user_id
			INNER JOIN oi_member
			ON ma_users.user_id=oi_member.user_id
			INNER JOIN base_postalcode
			ON ma_users.postalcode_id=base_postalcode.ids
			
			WHERE ma_users.user_id='338' 
ERROR - 2018-11-29 12:16:45 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM ma_users
			INNER JOIN gerai_group_users
			ON ma_users.user_id=gerai_gro' at line 21 - Invalid query: SELECT ma_users.*,
		    gerai_group_users.user_id,
			gerai_group_users.group_id,
			oi_member.no_anggota,
			oi_member.bpk_oi,
			oi_member.bpw_oi,
			oi_member.kelurahan,
			oi_member.status_nikah,
			oi_member.gol_darah,
			oi_member.pendidikan,
			oi_member.gelar_sarjana,
			oi_member.th_masuk_anggota,
			oi_member.keahlian_profesional1,
			oi_member.keahlian_profesional2,
			base_postalcode.village,
			base_postalcode.districts,
			base_postalcode.city,
			base_postalcode.province,
			base_postalcode.postalcode,
			
			FROM ma_users
			INNER JOIN gerai_group_users
			ON ma_users.user_id=gerai_group_users.user_id
			INNER JOIN oi_member
			ON ma_users.user_id=oi_member.user_id
			INNER JOIN base_postalcode
			ON ma_users.postalcode_id=base_postalcode.ids
			
			WHERE ma_users.user_id='337' 
ERROR - 2018-11-29 12:16:59 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 12:16:59 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 12:20:10 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 12:20:10 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:46:34 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:46:34 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:47:09 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:47:09 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:54:13 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:54:13 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:57:33 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:57:33 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:58:39 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:58:39 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:59:28 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:59:28 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:59:51 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 13:59:51 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:02:29 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:02:29 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:22:36 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:22:36 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:23:27 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:23:27 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:23:53 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:23:53 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:24:19 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:24:19 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:26:10 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:26:10 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:26:24 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:26:24 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:27:03 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:27:03 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:27:16 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:27:16 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:27:18 --> Query error: Unknown column 'ma_users.group_id' in 'on clause' - Invalid query: SELECT ma_users.*,
		    gerai_group_users.user_id,
			gerai_group_users.group_id,
			oi_member.no_anggota,
			oi_member.bpk_oi,
			oi_member.bpw_oi,
			oi_member.kelurahan,
			oi_member.status_nikah,
			oi_member.gol_darah,
			oi_member.pendidikan,
			oi_member.gelar_sarjana,
			oi_member.th_masuk_anggota,
			oi_member.keahlian_profesional1,
			oi_member.keahlian_profesional2,
			base_postalcode.village,
			base_postalcode.districts,
			base_postalcode.city,
			base_postalcode.province,
			base_postalcode.postalcode,
			oi_group.group_name
			FROM ma_users
			INNER JOIN gerai_group_users
			ON ma_users.user_id=gerai_group_users.user_id
			INNER JOIN oi_member
			ON ma_users.user_id=oi_member.user_id
			INNER JOIN base_postalcode
			ON ma_users.postalcode_id=base_postalcode.ids
			INNER JOIN oi_group
			ON oi_group.ids=ma_users.group_id
			WHERE ma_users.user_id='337' 
ERROR - 2018-11-29 14:27:35 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:27:35 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:28:38 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 14:28:38 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 16:08:41 --> Query error: Unknown column 'abuse_desc' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_medsos_posts 
			WHERE is_active='1'
			AND (post LIKE '%%' 
			OR abuse_desc LIKE '%%'
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			OR removed_on LIKE '%%'
			OR removed_by LIKE '%%'
			)
ERROR - 2018-11-29 17:05:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '// OR abuse_desc LIKE '%%'
			// OR fullname LIKE '%%'
			OR created_on LIKE '' at line 5 - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_medsos_posts 
			WHERE is_active='1'
			AND (post LIKE '%%' 
			// OR abuse_desc LIKE '%%'
			// OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			OR removed_on LIKE '%%'
			OR removed_by LIKE '%%'
			)
ERROR - 2018-11-29 17:10:41 --> Query error: Column 'created_on' in where clause is ambiguous - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_medsos_posts 
			INNER JOIN gerai_medsos_abuse_post 
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.abuse_from_post_id
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND gerai_medsos_posts.is_active='1'
			
			AND (post LIKE '%%' 
			OR abuse_desc LIKE '%%'
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			OR removed_on LIKE '%%'
			OR removed_by LIKE '%%'
			)
ERROR - 2018-11-29 17:12:03 --> Query error: Column 'is_active' in where clause is ambiguous - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_medsos_posts 
			INNER JOIN gerai_medsos_abuse_post 
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.abuse_from_post_id
			INNER JOIN ma_users
			ON gerai_medsos_abuse_post.abuse_from_user_id=ma_users.user_id
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND gerai_medsos_posts.group_id='2'
			AND is_active='1'
			AND (post LIKE '%%' 
		    OR abuse_desc LIKE '%%'
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			OR removed_on LIKE '%%'
			OR removed_by LIKE '%%'
			)
ERROR - 2018-11-29 17:13:33 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 17:13:33 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 17:15:19 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 17:15:19 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 17:15:22 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_medsos_posts 
			INNER JOIN gerai_medsos_abuse_post 
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.abuse_from_post_id
			
			WHERE gerai_medsos_abuse_post.abuse_from_post_id
			AND gerai_medsos_posts.group_id='2'
			AND is_active='1'
			AND (post LIKE '%%' 
		    OR abuse_desc LIKE '%%'
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			OR removed_on LIKE '%%'
			OR removed_by LIKE '%%'
			)
ERROR - 2018-11-29 17:18:20 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 17:18:20 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 17:18:56 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:18:56 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:18:56 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:18:56 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:18:56 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:18:56 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:18:56 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:18:56 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:18:56 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:18:56 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:26:11 --> Query error: Column 'created_on' in where clause is ambiguous - Invalid query: 
			SELECT gerai_notifikasi.*,
			ma_users.user_id 
			FROM gerai_notifikasi 
			INNER JOIN ma_users
			ON ma_users.user_id=gerai_notifikasi.ids
			WHERE notifikasi LIKE '%%' 
			OR userid LIKE '%%'
			OR created_on LIKE '%%'
			ORDER BY notifikasi asc
			LIMIT 10 OFFSET 0
ERROR - 2018-11-29 17:26:43 --> Query error: Column 'created_on' in where clause is ambiguous - Invalid query: 
			SELECT gerai_notifikasi.*,
			ma_users.user_id 
			FROM gerai_notifikasi 
			INNER JOIN ma_users
			ON ma_users.user_id=gerai_notifikasi.ids
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			ORDER BY notifikasi asc
			LIMIT 10 OFFSET 0
ERROR - 2018-11-29 17:32:16 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:33:05 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:34:08 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			
			
ERROR - 2018-11-29 17:34:37 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:35:30 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:37:11 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:39:24 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:41:30 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:48:59 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:52:27 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:52:39 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:53:10 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 17:53:41 --> Query error: Unknown column 'gerai_notifikasi.user_id' in 'on clause' - Invalid query: 
			SELECT gerai_notifikasi.*,
			ma_users.user_id 
			FROM gerai_notifikasi 
			INNER JOIN ma_users
			ON gerai_notifikasi.user_id=ma_users.user_id
			WHERE ma_users.is_active='1'
			AND (notifikasi LIKE '%%' 
			OR userid LIKE '%%') ORDER BY notifikasi DESC  LIMIT 10 OFFSET 0
ERROR - 2018-11-29 17:56:24 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:56:24 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:56:24 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:56:24 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:56:24 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:56:24 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:56:24 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:56:24 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:56:24 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 17:56:24 --> Severity: Notice --> Undefined index: fullname D:\xampp\htdocs\develop_gerai\application\controllers\oi\Notifikasi.php 48
ERROR - 2018-11-29 18:26:41 --> Severity: Notice --> Undefined variable: oiGroup D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 18:26:41 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\develop_gerai\application\views\oi\v_masteruser.php 118
ERROR - 2018-11-29 18:34:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '* 
			  ma_users.fullname
			  FROM gerai_notifikasi 
			INNER JOIN ma_users' at line 1 - Invalid query: SELECT gerai_notifikasi,* 
			  ma_users.fullname
			  FROM gerai_notifikasi 
			INNER JOIN ma_users
			ON gerai_notifikasi.userid=ma_users.user_id
			WHERE (notifikasi LIKE '%%' 
			OR userid LIKE '%%'
			OR created_on LIKE '%%') ORDER BY notifikasi LIMIT 10 OFFSET 0
ERROR - 2018-11-29 18:39:42 --> Query error: Column 'created_on' in where clause is ambiguous - Invalid query: SELECT gerai_notifikasi.*, 
			  ma_users.fullname
			FROM gerai_notifikasi 
			INNER JOIN ma_users
			ON gerai_notifikasi.userid=ma_users.user_id
			WHERE (notifikasi LIKE '%%' 
			OR userid LIKE '%%'
			OR created_on LIKE '%%') ORDER BY notifikasi LIMIT 10 OFFSET 0
ERROR - 2018-11-29 18:41:14 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 18:43:42 --> Query error: Unknown column 'fullname' in 'where clause' - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_notifikasi 
			WHERE notifikasi LIKE '%%' 
			OR fullname LIKE '%%'
			OR created_on LIKE '%%'
			
ERROR - 2018-11-29 18:58:23 --> Query error: Column 'created_on' in where clause is ambiguous - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_medsos_posts 
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.abuse_from_post_id
			WHERE is_active='1'
			AND (post LIKE '%%' 
			OR created_on LIKE '%%'
			OR removed_on LIKE '%%'
			OR removed_by LIKE '%%'
			)
ERROR - 2018-11-29 19:00:24 --> Query error: Column 'created_on' in where clause is ambiguous - Invalid query: 
			SELECT count(*) as jumlah 
			FROM gerai_medsos_posts 
			INNER JOIN gerai_medsos_abuse_post
			ON gerai_medsos_posts.post_id=gerai_medsos_abuse_post.abuse_from_post_id
			WHERE gerai_medsos_abuse_post.ids
			AND is_active='1'
			AND (post LIKE '%%' 
			OR created_on LIKE '%%'
			OR removed_on LIKE '%%'
			OR removed_by LIKE '%%'
			)
ERROR - 2018-11-29 19:01:10 --> Severity: Compile Error --> Cannot redeclare M_coment::count_all() D:\xampp\htdocs\develop_gerai\application\models\oi\M_coment.php 61
