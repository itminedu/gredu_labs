ALTER TABLE `univ`
ADD COLUMN `ereunitiko` varchar(191),
ADD COLUMN `institute` varchar(191),
ADD COLUMN `other` varchar(191);

ALTER TABLE univ MODIFY COLUMN idrima VARCHAR(191);