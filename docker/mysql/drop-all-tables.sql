SET FOREIGN_KEY_CHECKS = 0;

SET @tables = NULL;
SELECT GROUP_CONCAT('`', table_schema, '`.`', table_name, '`') INTO @tables
FROM information_schema.tables
WHERE table_schema = 'yii2db';

-- Проверяем, что @tables не NULL (есть таблицы для удаления)
SELECT IF(@tables IS NOT NULL, 
    CONCAT('DROP TABLE IF EXISTS ', @tables), 
    'SELECT 1'
) INTO @tables;

PREPARE stmt FROM @tables;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET FOREIGN_KEY_CHECKS = 1;