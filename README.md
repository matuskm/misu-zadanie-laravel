 
## MI:SU Design - zadanie eshop

**Vytvor si `.env` s `.env.example`**

### Spustenie dockera

Pri prvom spustení je potrebné spustiť build
```
docker-compose up -d --build
```
Pri ďalších spusteniach stačí
```
docker-compose up -d
```

### Zastavenie dockera
```
docker-compose down
```

### Potrebné príkazy pri prvom štarte aplikácie
```
docker exec misuzadanie_app composer install
docker exec misuzadanie_app php artisan key:generate
docker exec misuzadanie_app php artisan migrate:fresh
docker run --rm -w /home/node/app -v $PWD:/home/node/app node:16 npm install
docker run --rm -w /home/node/app -v $PWD:/home/node/app node:16 npm run watch // or "dev" or "prod"
```

### Pridanie nového e-shop feed
1. Vytvor v `App/Handlers/Eshop` súbor napr. `Eshop5Handler.php`
2. Skopíruj ukážkový kód z priečinka `docs/EshopExampleHandler.php`. V priečinku `docs` nájdeš aj zoznam e-shopov - `eshop_list.txt`
3. Uprav údaje o eshope v `__construct`
4. V metóde `parsheDataFromFeed()` uprav feed z eshopu tak aby vrátil pole produktov:
    ```
       'name'  => 'xyz',
       'price' => 999,
       'ean'   => 123465798
    ```
6. Spusť príkaz:
    ```
    docker exec misuzadanie_app php artisan eshop-action:update
    ```
7. Hotovo. V logu sú zapísané eshopy ktoré boli aktualizované. Log nájdeš v: `storage/logs/laravel.log`

### Nastavenia v `.env`
1. Notifikačný e-mail - `NOTIFICATION_EMAIL`
2. Minimálna zmena ceny v percentách pre notifikácie - `PRICE_CHANGE_PERCENTAGE`


### Pre nastavenie CRON JOBS
1. Podľa docs [Laravel](https://laravel.com/docs/10.x/scheduling)
2. V `App/Console/Kernel.php` je ukážkovo nastavené spúštanie v `schedule()`
    ```
    eshop-action:update
    email:send-notification
    ```

