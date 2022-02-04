/**
 * Execute the following sql statement with root user
 */
 
--
-- Database: penguin_poll_app
-- 

drop database penguin_poll_app;
create database if not exists penguin_poll_app
  default character set utf8mb4 collate utf8mb4_general_ci;
use penguin_poll_app;

-- 
-- Grant permissions to the user 'ppa_user'
-- 

create user if not exists 'ppa_user'@'localhost' identified by 'User@123';
grant all on penguin_poll_app.* to 'ppa_user'@'localhost';