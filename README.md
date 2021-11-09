# 👑 Arthur's Family Tree

Make sure that you have **PHP 8.0** installed in your machine when running this application.

```bash
git clone git@github.com:plmrlnsnts/arthur-family-tree.git
cd arthur-family-tree && cp .env.example .env
composer install && php artisan key:generate
```

You can trigger the script by running `php artisan meet-the-family`. The list of instructions can be found in the `meet-the-family` file inside the project's root directory.

```bash
php artisan meet-the-family

CHILD_ADDED
Dominique Minerva
Victoire Dominique Louis
PERSON_NOT_FOUND
PERSON_NOT_FOUND
CHILD_ADDITION_FAILED
NONE
Darcy Alice
```

You may run the automated tests by running `php artisan test`. You can check the unit test files inside the `tests/Unit` directory.
