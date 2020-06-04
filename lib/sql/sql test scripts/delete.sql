#delete example@hotmail.com data from database
DELETE FROM `customer` WHERE `customer`.`email` = 'example@hotmail.com';

#delete Test Art from database
DELETE FROM `product` WHERE `product`.`productno` = 66;