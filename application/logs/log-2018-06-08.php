<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-06-08 11:13:17 --> Query error: Table 'gerai_dev.base_voucher_code' doesn't exist - Invalid query: select poin_reward_claim.*,
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
