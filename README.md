
## Commands to run
    * php artisan migrate
    * php artisan db:seed --class=WebsiteSeeder
    
## Routes
    * POST /api/posts/create            with parameters (website_id, title, description)
    * POST /api/websites/subscribe      with parameters (website_id)


## Postman Collection
    * for postman collection to work, you need to change env variable {{url}} to your own url