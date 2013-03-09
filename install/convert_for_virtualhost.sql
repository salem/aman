-- Run the following queries to make the sample data 
-- work in virtual host environment

UPDATE ad_banner
SET image_url = REPLACE(image_url, 'http://localhost/amancms/', '/');

UPDATE menu_item
SET
link = REPLACE(link, '/amancms/index.php/', '/');

UPDATE multimedia_file 
SET
image_square = REPLACE(image_square, 'http://localhost/amancms/', '/'), 
image_small = REPLACE(image_small, 'http://localhost/amancms/', '/'), 
image_thumbnail = REPLACE(image_thumbnail, 'http://localhost/amancms/', '/'), 
image_crop = REPLACE(image_crop, 'http://localhost/amancms/', '/'), 
image_medium = REPLACE(image_medium, 'http://localhost/amancms/', '/'), 
image_large = REPLACE(image_large, 'http://localhost/amancms/', '/');

UPDATE multimedia_set
SET
image_square = REPLACE(image_square, 'http://localhost/amancms/', '/'), 
image_small = REPLACE(image_small, 'http://localhost/amancms/', '/'), 
image_thumbnail = REPLACE(image_thumbnail, 'http://localhost/amancms/', '/'), 
image_crop = REPLACE(image_crop, 'http://localhost/amancms/', '/'), 
image_medium = REPLACE(image_medium, 'http://localhost/amancms/', '/'), 
image_large = REPLACE(image_large, 'http://localhost/amancms/', '/');

UPDATE news_article 
SET
image_square = REPLACE(image_square, 'http://localhost/amancms/', '/'), 
image_thumbnail = REPLACE(image_thumbnail, 'http://localhost/amancms/', '/'), 
image_small = REPLACE(image_small, 'http://localhost/amancms/', '/'), 
image_crop = REPLACE(image_crop, 'http://localhost/amancms/', '/'), 
image_medium = REPLACE(image_medium, 'http://localhost/amancms/', '/'), 
image_large = REPLACE(image_large, 'http://localhost/amancms/', '/'),
content = REPLACE(content, 'http://localhost/amancms/', '/');