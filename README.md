ver 0.21
feature1

Требования к структуре каталога.
Каталог состоит из дерева категорий (максимальная вложенность – 3) и товаров, которые принадлежат к одной из категорий второго/третьего уровня. Товары должны иметь следующие поля:
•	Название
•	Описание
•	Автогенерируемый slug
•	Категория второго/третьего уровня
•	Цена
•	Несколько дополнительных характеристики (например длина, ширина, вес).

Требования к корзине и заказам.
Взаимодействовать с корзиной и оформлять заказы могут как авторизованные, так и неавторизованные пользователи. Заказы должны содержать контактную информацию покупателя (например email и телефон), а также список купленных товаров. Для авторизированных пользователей контактная информация должна подтягиваться из профиля автоматически.

Требования к API.
API должно поддерживать авторизацию (рекомендуется использовать пакет Sanctum).

Рекомендуемый состав методов API.
•	Методы для регистрации/авторизации пользователей.
•	Метод для получения дерева категорий.
•	Метод для получения товаров. Должен поддерживать фильтрацию по категории/категориям любого уровня,
а также по цене и дополнительным характеристикам. Значения фильтров должны валидироваться.
•	Метод для получения товара по slug.
•	Методы для работы с корзиной (добавление товара, редактирование количества товара/товаров, удаление товара).
•	Метод для оформления заказа.
•	Метод для получения списка заказов авторизированного пользователя.

Запуск 
composer install
composer dump-autoload --no-scripts --optimize

создать папки storage/framework:
    sessions
    views
    cache

php artisan key:generate
php artisan migrate
php artisan db:seed

Редактировать файлы .env и src/.env
