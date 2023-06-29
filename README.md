# LARAVEL-ELK-8
By this you can make your elk stack in one command
docker-compose up -d --build

# NGINX
localhost:8080

# ELK
localhot:7601

# LARAVEL
composer require elasticsearch/elasticsearch
composer require ruflin/Elastica
composer require laravel/scout

docker-compose run --rm composer require nyholm/psr7
docker-compose run --rm composer require symfony/psr-http-message-bridge 
