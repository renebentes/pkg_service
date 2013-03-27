ALTER TABLE `#__service` 
	ADD COLUMN `params` text NOT NULL AFTER `access`,
	ADD COLUMN `metakey` text NOT NULL,
	ADD COLUMN `metadesc` text NOT NULL,
  	ADD COLUMN `metadata` text NOT NULL