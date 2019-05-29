CREATE TABLE `Players` (
  `timemark` datetime DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `nick` varchar(100) DEFAULT NULL,
  `frags` int(11) DEFAULT NULL,
  `deaths` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `clan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Players`
  ADD KEY `timemark` (`timemark`),
  ADD KEY `id` (`id`);

DELIMITER $$
  CREATE PROCEDURE indexx (IN datte date, IN orderr text(500), IN clann_id int)
  BEGIN
    DECLARE v_finished INTEGER DEFAULT 0;
    DECLARE idd integer;
    -- declare cursor for employee email
    DEClARE ids_cursor CURSOR FOR
    SELECT DISTINCT id FROM Players;
    -- declare NOT FOUND handler
    DECLARE CONTINUE HANDLER
    FOR NOT FOUND SET v_finished = 1;
    CREATE TEMPORARY TABLE Players_t LIKE Players;
    OPEN ids_cursor;
      get_email: LOOP
      FETCH ids_cursor INTO idd;
      IF v_finished = 1 THEN
        LEAVE get_email;
      END IF;
      -- build email list
      INSERT into Players_t select * FROM Players where id=idd and timemark<=datte and clan_id=clann_id order by timemark DESC LIMIT 1;
    END LOOP get_email;
    CLOSE ids_cursor;
    -- select orderr;
    -- select * from Players_t order by nick;
    select * from Players_t order by nick;
    DROP TEMPORARY TABLE Players_t;
  END$$
DELIMITER ;

DELIMITER $$
  CREATE PROCEDURE indexx_all (IN datte date, IN orderr text(500))
  BEGIN
    DECLARE v_finished INTEGER DEFAULT 0;
    DECLARE idd integer;
    -- declare cursor for employee email
    DEClARE ids_cursor CURSOR FOR
    SELECT DISTINCT id FROM Players;
    -- declare NOT FOUND handler
    DECLARE CONTINUE HANDLER
    FOR NOT FOUND SET v_finished = 1;
    CREATE TEMPORARY TABLE Players_t LIKE Players;
    OPEN ids_cursor;
      get_email: LOOP
      FETCH ids_cursor INTO idd;
      IF v_finished = 1 THEN
        LEAVE get_email;
      END IF;
      -- build email list
      INSERT into Players_t select * FROM Players where id=idd and timemark<=datte order by timemark DESC LIMIT 1;
    END LOOP get_email;
    CLOSE ids_cursor;
    -- select orderr;
    -- select * from Players_t order by nick;
    select * from Players_t order by nick;
    DROP TEMPORARY TABLE Players_t;
  END$$
DELIMITER ;

-- --------------------------------------------------------

CREATE TABLE `Admins` (
  `id` int
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Admins`
  ADD UNIQUE KEY `id` (`id`);

DELIMITER $$
  CREATE PROCEDURE AddAdmin(in idd int)
  BEGIN
    insert into Admins (id) values (idd);
  END$$
DELIMITER ;

DELIMITER $$
  CREATE PROCEDURE DeleteAdmin(in idd int)
  BEGIN
    delete from Admins where id=idd;
  END$$
DELIMITER ;

-- --------------------------------------------------------

CREATE TABLE `Matches` (
  `forum` int(11) NOT NULL,
  `game` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Matches`
  ADD PRIMARY KEY (`forum`);
