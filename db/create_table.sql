/**
 * Database: penguin_poll_app
 */

use penguin_poll_app; 

-- 
-- Table structure for table `comments`
--

create table `comments` (
  `id` int(10) unsigned auto_increment primary key comment 'commentID',
  `topic_id` int(10) not null comment 'topicID',
  `agree` int(1) not null comment 'agree: 1 disagree: 0 neither: 2',
  `body` varchar(100) default null comment 'comment field',
  `user_id` varchar(10) not null comment 'User ID who created the comment',
  `del_flg` int(1) not null default '0'
    comment 'delete flag ( delete: 1 valid: 0)',
  `updated_by` varchar(20) not null default 'penguin_poll_app'
    comment 'Final updater',
  `updated_at` timestamp not null default current_timestamp on update
    current_timestamp comment 'Final update date'
);

--
-- Table structure for table `topics`
--

create table `topics` (
  `id` int(10) unsigned auto_increment primary key comment 'topicID',
  `title` varchar(30) not null comment 'title of topic',
  `published` int(1) not null comment 'open state(1: public、0: private)',
  `views` int(10) not null default '0' comment 'number of PV',
  `likes` int(10) not null default '0' comment 'number of agree',
  `dislikes` int(10) not null default '0' comment 'number of disagree',
  `neither` int(10) not null default '0' comment 'number of neither',
  `user_id` varchar(10) not null comment 'User ID who created the topic',
  `del_flg` int(1) not null default '0'
    comment 'delete flag ( delete: 1 valid: 0)',
  `updated_by` varchar(20) not null default 'penguin_poll_app'
    comment 'Final updater',
  `updated_at` timestamp not null default current_timestamp on update
    current_timestamp comment 'Final update date'
);

--
-- Table structure for table `users`
--

create table `users` (
  `id` varchar(10) primary key comment 'userID',
  `pwd` varchar(60) not null comment 'password',
  `nickname` varchar(10) not null comment 'Nickname to display on screen',
  `del_flg` int(1) not null default '0'
    comment 'delete flag ( delete: 1 valid: 0)',
  `updated_by` varchar(20) not null default 'penguin_poll_app'
    comment 'Final updater',
  `updated_at` timestamp not null default current_timestamp on update
    current_timestamp comment 'Final update date'
);
