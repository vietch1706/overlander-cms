echo "Enter cmd"
read cmd
if [ $cmd == "clear" ];
then
	php artisan view:clear
	php artisan cache:clear
	php artisan route:clear
	echo "Clear all"
elif [ $cmd == "docker" ];
then
	echo "Go to docker bash"
	docker exec -it php-blog bash
elif [ $cmd == "linux" ];
then
sudo chown -R $USER:www-data plugins
chmod -R 775 plugins
sudo chown -R $USER:www-data storage
chmod -R 775 storage
echo "Permisstion OK!!"
elif [ $cmd == "v1" ];
then
	php artisan swagger:generate openapi/v1.yml
	echo "Generate file v1"
elif [ $cmd == "install" ];
then
	composer i
	cp .env.example .env
	php artisan key:generate
	mysql -u root -padmin
	echo "Install"
else
	echo "Sorry, try for the next time"
fi
