<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-01-25 07:55:45 --> Query error: Unknown column 'ma_vacc.my_referal_code' in 'field list' - Invalid query: SELECT ma_users.*,
		    ma_vacc.my_referal_code,
		    ma_vacc.referal_code,
			ma_vacc.vacc_number,
			ma_vacc.balance,
			ma_vacc.poin 
			FROM ma_users
			INNER JOIN ma_vacc
			ON ma_users.user_id=ma_vacc.user_id
			WHERE is_active='1'
			AND is_verified='1'
			AND (fullname LIKE '%%'
			OR email LIKE '%%') ORDER BY created_on DESC  LIMIT 10 OFFSET 0
