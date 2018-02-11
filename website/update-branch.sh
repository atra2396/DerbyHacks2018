scp -r ec2-user@18.219.164.44:/var/www/html/* .

git add .

git commit -a -m "$1"

git push
