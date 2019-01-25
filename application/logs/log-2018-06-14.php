<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-06-14 01:35:54 --> Query error: Table 'gerai_dev.base_voucher_code' doesn't exist - Invalid query: select poin_reward_claim.*,
			poin_reward.poin_reward_desc,
			poin_reward.poin_reward_value,
			poin_reward.poin_reward_image,
			base_voucher_code.voucher_code,
			base_voucher_code.start_date,
			base_voucher_code.end_date
			from poin_reward_claim 
			INNER JOIN poin_reward
			ON poin_reward.ids=poin_reward_claim.reward_poin_id
			INNER JOIN base_voucher_code
			ON poin_reward_claim.id_voucher=base_voucher_code.ids
			WHERE poin_reward_claim.user_id='295' and base_voucher_code.is_active='1'
			ORDER BY ids DESC
ERROR - 2018-06-14 01:36:13 --> Query error: Table 'gerai_dev.base_voucher_code' doesn't exist - Invalid query: select poin_reward_claim.*,
			poin_reward.poin_reward_desc,
			poin_reward.poin_reward_value,
			poin_reward.poin_reward_image,
			base_voucher_code.voucher_code,
			base_voucher_code.start_date,
			base_voucher_code.end_date
			from poin_reward_claim 
			INNER JOIN poin_reward
			ON poin_reward.ids=poin_reward_claim.reward_poin_id
			INNER JOIN base_voucher_code
			ON poin_reward_claim.id_voucher=base_voucher_code.ids
			WHERE poin_reward_claim.user_id='295' and base_voucher_code.is_active='1'
			ORDER BY ids DESC
ERROR - 2018-06-14 01:56:24 --> Query error: Table 'gerai_dev.base_voucher_code' doesn't exist - Invalid query: select poin_reward_claim.*,
			poin_reward.poin_reward_desc,
			poin_reward.poin_reward_value,
			poin_reward.poin_reward_image,
			base_voucher_code.voucher_code,
			base_voucher_code.start_date,
			base_voucher_code.end_date
			from poin_reward_claim 
			INNER JOIN poin_reward
			ON poin_reward.ids=poin_reward_claim.reward_poin_id
			INNER JOIN base_voucher_code
			ON poin_reward_claim.id_voucher=base_voucher_code.ids
			WHERE poin_reward_claim.user_id='295' and base_voucher_code.is_active='1'
			ORDER BY ids DESC
ERROR - 2018-06-14 05:11:58 --> Severity: Notice --> Undefined index: is_error /var/www/html/dev_gerai/application/controllers/api/v1/Poin.php 34
ERROR - 2018-06-14 05:11:59 --> Severity: Notice --> Undefined index: response_msg /var/www/html/dev_gerai/application/controllers/api/v1/Poin.php 38
ERROR - 2018-06-14 05:12:15 --> Severity: Notice --> Undefined index: is_error /var/www/html/dev_gerai/application/controllers/api/v1/Poin.php 34
ERROR - 2018-06-14 05:12:15 --> Severity: Notice --> Undefined index: response_msg /var/www/html/dev_gerai/application/controllers/api/v1/Poin.php 38
ERROR - 2018-06-14 05:12:41 --> Severity: Notice --> Undefined index: is_error /var/www/html/dev_gerai/application/controllers/api/v1/Poin.php 34
ERROR - 2018-06-14 05:12:41 --> Severity: Notice --> Undefined index: response_msg /var/www/html/dev_gerai/application/controllers/api/v1/Poin.php 38
ERROR - 2018-06-14 06:43:59 --> Query error: Table 'gerai_dev.base_voucher_code' doesn't exist - Invalid query: select poin_reward_claim.*,
			poin_reward.poin_reward_desc,
			poin_reward.poin_reward_value,
			poin_reward.poin_reward_image,
			base_voucher_code.voucher_code,
			base_voucher_code.start_date,
			base_voucher_code.end_date
			from poin_reward_claim 
			INNER JOIN poin_reward
			ON poin_reward.ids=poin_reward_claim.reward_poin_id
			INNER JOIN base_voucher_code
			ON poin_reward_claim.id_voucher=base_voucher_code.ids
			WHERE poin_reward_claim.user_id='295' and base_voucher_code.is_active='1'
			ORDER BY ids DESC
