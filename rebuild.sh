docker stop avidbrain
docker ps -q -a | xargs docker rm
docker build -t megamind/avidbrain ~/Public/avidbrain.dev.old
docker run --name avidbraindb -e MYSQL_ROOT_PASSWORD=avidbrain2017 -v /Users/briancullinan/Public/avidbrain.dev.old/resources/data:/var/lib/mysql -d mysql:latest --sql_mode=""
docker run --name avidbrain --link avidbraindb:avidbraindb -p 8085:80 -d megamind/avidbrain
