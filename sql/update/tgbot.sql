ALTER TABLE `config`
	ADD COLUMN `is_tg_bot` TEXT NULL COMMENT 'Enable TGBot' AFTER `alipay_currency`;
	ADD COLUMN `tgbot_token` TEXT NULL COMMENT 'Enable TGBot' AFTER `is_tg_bot`;
	ADD COLUMN `tgbot_channelid` TEXT NULL COMMENT 'Enable TGBot' AFTER `tgbot_token`;

	
