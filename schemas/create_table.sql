CREATE TABLE IF NOT EXISTS `bbsdb04`.`images` (
    `id` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `registered_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '登録日時',
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    `file_name` varchar(45) NOT NULL COMMENT 'ファイル名のSHA1ハッシュ',
    `mime_type` varchar(20) DEFAULT NULL COMMENT 'MIME タイプ',
    `raw_data` mediumblob NOT NULL COMMENT 'オリジナル画像データ',
    `raw_size` int(11) NOT NULL COMMENT 'オリジナル画像のファイルサイズ',
    `raw_width` int(11) NOT NULL COMMENT 'オリジナル画像の幅',
    `raw_height` int(11) NOT NULL COMMENT 'オリジナル画像の高さ',
    `thumb_data` blob NOT NULL COMMENT 'サムネイル画像データ',
    `thumb_size` int(11) NOT NULL COMMENT 'サムネイル画像のファイルサイズ',
    `thumb_width` smallint(6) NOT NULL COMMENT 'サムネイル画像の幅',
    `thumb_height` smallint(6) NOT NULL COMMENT 'サムネイル画像の高さ',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bbsdb04`.`posts` (
    `id` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `registered_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '投稿日時',
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    `title` varchar(30) NOT NULL COMMENT 'タイトル',
    `name` varchar(20) NOT NULL COMMENT '名前',
    `email` varchar(250) COMMENT 'メールアドレス',
    `comment` varchar(250) NOT NULL COMMENT '本文',
    `is_deleted` tinyint NOT NULL DEFAULT 0 COMMENT '削除フラグ',
    `image_id` int NULL COMMENT 'imagetbl の ID',
    FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bbsdb04`.`users` (
    `id` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `registered_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '登録日時',
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    `name` varchar(20) NOT NULL COMMENT 'ユーザー名',
    `password` varchar(20) NOT NULL COMMENT 'パスワード',
    `is_active` tinyint NOT NULL DEFAULT 0 COMMENT 'アクティブフラグ',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
