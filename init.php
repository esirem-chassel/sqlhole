<?php
echo 'Loggin to DB...'.PHP_EOL;
require_once 'db.php';

$queries = [];

$queries[] = <<<'EOT'
create table `users` (`id` int not null primary key auto_increment,
`email` varchar(200) not null unique,
`pwd` varchar(200) not null,
`birthdate` varchar(200) default null
);
EOT;

$queries[] = <<<'EOT'
create table `addresses` (`id` int not null primary key auto_increment,
`user` int not null,
`content` text not null,
constraint `fk_addresses_user`
foreign key (`user`)
references `users`(`id`)
);
EOT;

$queries[] = <<<'EOT'
INSERT INTO users (email, pwd, birthdate) VALUES
('alice@example.com', '$2y$10$1vY1dQasd1KxZqEr1234567890example', '1990-03-15'),
('bob@example.com', '$2y$10$aKfTxN1kD0Yp2Ajl234567890example', '1985-07-30'),
('carol@example.com', '$2y$10$RfY98DwqLkTeMwFj345678901example', '1992-12-01'),
('dave@example.com', '$2y$10$MnC7WxqZB2EAmnL456789012example', '1988-01-10'),
('eve@example.com', '$2y$10$ZxCfQp4BvUeE5Sd567890123example', '1995-05-25'),
('frank@example.com', '$2y$10$KjU9oPqx9CrWyBl678901234example', '1991-09-09'),
('grace@example.com', '$2y$10$DnM8JqSaVcUtZkL789012345example', '1983-04-18'),
('heidi@example.com', '$2y$10$YlPoLqMdN5Ko8Zn890123456example', '1997-11-21'),
('ivan@example.com', '$2y$10$XnQaTkVbLuOwXm901234567example', '1993-06-14'),
('judy@example.com', '$2y$10$GoApLsWx9ErBoPn012345678example', '1986-08-05');
EOT;

$queries[] = <<<'EOT'
INSERT INTO addresses (user, content) VALUES
(1, '42 Rue des Lilas, Paris'),
(2, '8 Boulevard Haussmann, Paris'),
(3, '17 Avenue de la République, Lyon'),
(4, '5 Place Bellecour, Lyon'),
(5, '33 Rue Nationale, Lille'),
(6, '12 Rue des Fleurs, Nantes'),
(1, '10 Rue Victor Hugo, Marseille'),
(8, '19 Boulevard Voltaire, Toulouse'),
(9, '24 Rue de la Liberté, Strasbourg'),
(10, '3 Rue Carnot, Bordeaux');
EOT;

foreach($queries as $q) {
    echo 'Running '.$q.' ...';
    $sql->query($q);
    echo ' done.'.PHP_EOL;
}

echo 'All done.'.PHP_EOL;
