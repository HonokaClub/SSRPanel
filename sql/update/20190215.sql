-- 邮件投递记录增加最后更新字段
ALTER TABLE `email_log`
	ADD COLUMN `updated_at` DATETIME NULL DEFAULT NULL COMMENT '最后更新时间' AFTER `created_at`;

INSERT INTO `config` values ('90', 'is_f2fpay', 0);
INSERT INTO `config` VALUES ('91', 'f2fpay_app_id', '');
INSERT INTO `config` VALUES ('92', 'f2fpay_private_key', '');
INSERT INTO `config` VALUES ('93', 'f2fpay_public_key', '');
