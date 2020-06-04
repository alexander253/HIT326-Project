use art_db;

#Customer
INSERT INTO `customer` (`email`, `fname`, `lname`, `title`, `address`, `city`, `state`, `country`, `postcode`, `phone`, `hashed_password`, `salt`) VALUES ('bob@hotmail.com', 'Bob', 'Marley', 'MR', 'Somewhere in land far away', 'Darwin', 'NT', 'Australia', '0899', '04204401', '1234', '1234');


#Product

INSERT INTO `product` (`productno`, `description`, `price`, `category`, `colour`, `size`) 
VALUES 
('1', 'Mona Lisa', '100', 'rare', 'black', 'large'), 
('2', 'Starry Night', '200', 'common', 'blue', 'large'), 
('3', 'The Scream', '300', 'rare', 'black', 'small'), 
('4', 'The Last Supper', '500', 'rare', 'brown', 'medium');