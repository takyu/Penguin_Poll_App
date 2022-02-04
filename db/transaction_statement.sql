/**
 * Database: penguin_poll_app
 */

use penguin_poll_app;
start transaction;

-- 
-- Set the time zone to Asia/Tokyo
-- 

set time_zone = "+09:00";

--
-- Dumping data for table `comments`
--

insert into `comments`
  (`id`, `topic_id`, `agree`, `body`, `user_id`, `del_flg`)
  values
    (1, 1, 1, 'めっちゃかわいいです。', 'pensan', 0),
    (2, 1, 1, 'どの生物よりもかわいい。', 'pensan', 0),
    (3, 1, 0, 'んー、猫の方が好きかなぁ。', 'pensan', 0),
    (4, 1, 1, '大賛成です。', 'pensan', 0),
    (5, 2, 0, '鳥類のイメージかも？', 'pensan', 0),
    (6, 2, 1, 'でも飛べなくて泳ぐから魚類かなー？', 'pensan', 0),
    (7, 2, 0, '脊椎動物の定義上、鳥類になりますよ。', 'pensan', 0),
    (8, 3, 0, '海泳ぐイメージしか逆にないかなー。', 'pensan', 0),
    (9, 3, 0, '羽無いからね。', 'pensan', 0),
    (10, 3, 1, '手を羽と見立てると飛べそう？', 'pensan', 0),
    (11, 4, 1, 'めっちゃ飼いたいです。', 'pensan', 0),
    (12, 4, 0, 'でも飼育大変そう。。', 'pensan', 0);

--
-- Dumping data for table `topics`
--

insert into `topics`
  (`id`, `title`, `published`, `views`, `likes`, `dislikes`,
    `user_id`, `del_flg`)
  values
  (1, 'ペンギンはかわいいですよね？', 1, 100, 20, 3, 'pensan', 0),
  (2, 'ペンギンのイメージって魚類ですよね？', 1, 80, 3, 30, 'pensan', 0),
  (3, 'ペンギンって飛べそうなイメージですよね？', 1, 70, 5, 20, 'pensan', 0),
  (4, 'ペンギンを家で飼いたいですよね？', 1, 60, 18, 2, 'pensan', 0);

--
-- Dumping data for table `users`
--

insert into `users` (`id`, `pwd`, `nickname`, `del_flg`) values
('pensan', '$2y$10$9UI490kzeoalaJ/KKWNTwuoFffw/BbrxsJIRiTeh2BOKzdUAjsgnC',
  'ペンさん', 0);

commit;