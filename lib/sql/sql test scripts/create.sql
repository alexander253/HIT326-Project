#create customer
INSERT INTO `customer` (`email`, `fname`, `lname`, `title`, `address`, `city`, `state`, `country`, `postcode`, `phone`, `hashed_password`, `salt`) VALUES ('example@hotmail.com', 'Test', 'Example', 'Mr', '123 Fake Street', 'Darwin', 'NT', 'Australia', '0812', '04123456', '1234', '1234');

#create product
INSERT INTO `product` (`productno`, `description`, `price`, `category`, `colour`, `size`) VALUES ('66', 'Test Art', '5', 'rare', 'black', 'large');

#purchase and purchaseitems can only be created from the website 