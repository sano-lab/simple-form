-- ユーザテーブル --
CREATE TABLE accounts(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(256) NOT NULL,
    email VARCHAR(256) NOT NULL,
    message VARCHAR(256) NOT NULL
);


-- 性別テーブル --
/*
 * ISO 5218
 * 0 (不明)
 * 1 (男性)
 * 2 (女性)
 * 9 (適用不能)
 */
CREATE TABLE sexes(
    id VARCHAR(1) PRIMARY KEY DEFAULT '0' NOT NULL,
    name VARCHAR(256) NOT NULL
);
INSERT INTO sexes VALUES('0', '回答しない');
INSERT INTO sexes VALUES('1', '男性');
INSERT INTO sexes VALUES('2', '女性');
INSERT INTO sexes VALUES('9', 'その他');