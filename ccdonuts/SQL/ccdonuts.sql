-- データベースの作成
drop database if exists ``;
CREATE DATABASE IF NOT EXISTS `` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
drop user if exists ''@'';
create user ''@'' identified by '';
grant all on .* to ''@'';
USE ``;


-- テーブル `customers`
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `nameKana` varchar(100) NOT NULL,
  `postalCode1` int(3) NOT NULL,
  `postalCode2` int(4) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=6;

INSERT INTO `customers` (`id`, `name`, `nameKana`, `postalCode1`, `postalCode2`, `address`, `email`, `password`) VALUES
(2, 'ドーナツ太郎', 'ドーナツタロウ', 111, 1111, '千葉県', '123@gmail.com', '123456789'),
(4, 'ドーナツ花子', 'ドーナツハナコ', 987, 6543, '東京都', '000@gmail.com', '0000000000'),
(5, 'ドーナツ二郎', 'ドーナツジロウ', 222, 3333, '大阪府', '111@gmail.com', '789456123');


-- テーブル `products`
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `pieces` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `category` varchar(50) NOT NULL,
  `is_new` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=13;

INSERT INTO `products` (`id`, `name`, `pieces`, `price`, `description`, `category`, `is_new`) VALUES
(1, 'CCドーナツ 当店オリジナル', 5, 1500, '当店のオリジナル商品...', 'main', 0),
(2, 'チョコレートデライト', 5, 1600, 'チョコレートデライトは...', 'main', 0),
(3, 'キャラメルクリーム', 5, 1600, 'キャラメルクリームは...', 'main', 0),
(4, 'プレーンクラシック', 5, 1500, 'プレーンクラシックは...', 'main', 0),
(5, 'サマーシトラス', 5, 1600, 'サマーシトラスは...', 'main', 1),
(6, 'ストロベリークラッシュ', 5, 1800, 'ストロベリークラッシュは...', 'main', 0),
(7, 'フルーツドーナツセット', 12, 3500, '新鮮で豊かなフルーツを...', 'variety', 0),
(8, 'フルーツドーナツセット', 14, 4000, 'フルーツドーナツセット（14個入り）は...', 'variety', 0),
(9, 'ベストセレクションボックス', 4, 1200, '当店おすすめの人気フレーバー...', 'variety', 0),
(10, 'チョコクラッシュボックス', 7, 2400, '濃厚なチョコレートの風味を...', 'variety', 0),
(11, 'クリームボックス', 4, 1400, 'なめらかなクリームの甘さが楽しめる...', 'variety', 0),
(12, 'クリームボックス', 9, 2800, 'クリームボックス（9個入り）は...', 'variety', 0);

