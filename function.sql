 DELIMITER $$
CREATE PROCEDURE indexx (IN datte date, IN orderr varchar(500), IN clann_id int)


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
  INSERT into Players_t select * FROM Players where id=idd and timemark<=datte and clan_id=clann_id order by timemark DESC LIMIT 1;


  IF v_finished = 1 THEN
  LEAVE get_email;
  END IF;

  -- build email list

  END LOOP get_email;

  CLOSE ids_cursor;
  -- select orderr;
  -- select * from Players_t order by nick;
  select * from Players_t order by nick;

  DROP TEMPORARY TABLE Players_t;

 END$$

 DELIMITER ;








 DELIMITER $$
 CREATE PROCEDURE indexx_all (IN datte date, IN orderr varchar(500))


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
  INSERT into Players_t select * FROM Players where id=idd and timemark<=datte order by timemark DESC LIMIT 1;


  IF v_finished = 1 THEN
  LEAVE get_email;
  END IF;

  -- build email list

  END LOOP get_email;

  CLOSE ids_cursor;
  -- select orderr;
  -- select * from Players_t order by nick;
  select * from Players_t order by nick;

  DROP TEMPORARY TABLE Players_t;

 END$$

 DELIMITER ;









 DELIMITER $$
CREATE PROCEDURE clans_list (IN datte date)


 BEGIN

  DECLARE v_finished INTEGER DEFAULT 0;
         DECLARE idd integer;
  -- declare cursor for employee email
  DEClARE ids_cursor CURSOR FOR
  SELECT DISTINCT id FROM Clans;

  -- declare NOT FOUND handler
  DECLARE CONTINUE HANDLER
         FOR NOT FOUND SET v_finished = 1;

  CREATE TEMPORARY TABLE Clans_t LIKE Clans;

  OPEN ids_cursor;

  get_email: LOOP

  FETCH ids_cursor INTO idd;
  INSERT into Clans_t select * FROM Clans where id=idd and timemark<=datte order by timemark DESC LIMIT 1;


  IF v_finished = 1 THEN
  LEAVE get_email;
  END IF;

  -- build email list

  END LOOP get_email;

  CLOSE ids_cursor;
  -- select orderr;
  -- select * from Players_t order by nick;
  select DISTINCT id,title from Clans_t;

  DROP TEMPORARY TABLE Clans_t;

 END$$

 DELIMITER ;





 DELIMITER $$
 CREATE PROCEDURE era_data (IN idd integer)


 BEGIN
select * from eras where id=idd;

 END$$

 DELIMITER ;









 DELIMITER $$
CREATE PROCEDURE in_era_data (IN era_id integer, IN datte date, IN orderr varchar(500), IN clann_id int)


 BEGIN

  DECLARE v_finished INTEGER DEFAULT 0;
         DECLARE idd integer;
         declare startedd date;
         declare endedd date;
  -- declare cursor for employee email
  DEClARE ids_cursor CURSOR FOR
  SELECT DISTINCT id FROM Players;

  -- declare NOT FOUND handler
  DECLARE CONTINUE HANDLER
         FOR NOT FOUND SET v_finished = 1;

  CREATE TEMPORARY TABLE Players_t LIKE Players;

  select started, ended into startedd, endedd from eras where id=era_id;


  OPEN ids_cursor;

  get_email: LOOP

  FETCH ids_cursor INTO idd;
  INSERT into Players_t select * FROM Players where id=idd and timemark<=datte and timemark>=startedd and timemark<=endedd + INTERVAL 1 DAY and clan_id=clann_id order by timemark ASC;


  IF v_finished = 1 THEN
  LEAVE get_email;
  END IF;

  -- build email list

  END LOOP get_email;

  CLOSE ids_cursor;
  -- select orderr;
  -- select * from Players_t order by nick;
  select * from Players_t order by nick;

  DROP TEMPORARY TABLE Players_t;

 END$$

 DELIMITER ;




  DELIMITER $$
 CREATE PROCEDURE in_era_data_all (IN era_id integer, IN datte date, IN orderr varchar(500))


  BEGIN

   DECLARE v_finished INTEGER DEFAULT 0;
          DECLARE idd integer;
          declare startedd date;
          declare endedd date;
   -- declare cursor for employee email
   DEClARE ids_cursor CURSOR FOR
   SELECT DISTINCT id FROM Players;

   -- declare NOT FOUND handler
   DECLARE CONTINUE HANDLER
          FOR NOT FOUND SET v_finished = 1;

   CREATE TEMPORARY TABLE Players_t LIKE Players;

   select started, ended into startedd, endedd from eras where id=era_id;


   OPEN ids_cursor;

   get_email: LOOP

   FETCH ids_cursor INTO idd;
   INSERT into Players_t select * FROM Players where id=idd and timemark<=datte and timemark>=startedd and timemark<=endedd + INTERVAL 1 DAY order by timemark ASC;


   IF v_finished = 1 THEN
   LEAVE get_email;
   END IF;

   -- build email list

   END LOOP get_email;

   CLOSE ids_cursor;
   -- select orderr;
   -- select * from Players_t order by nick;
   select * from Players_t order by nick;

   DROP TEMPORARY TABLE Players_t;

  END$$

  DELIMITER ;
