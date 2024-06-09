Buatlah database

# User

Buatlah model user beserta migration dan seeder

`php artisan make:model User --migration --seed`

Setup migration untuk mendefinisikan column table di database.
Setup Model untuk memiliki table user.

`php artisan migrate`

# Contact

Buatlah model Contact beserta migration dan seeder

` php artisan make:model Contact --migration --seed`

Setup migration untuk mendefinisikan column table di database. Contact adalah milik User, jadi buatkanlah FK.

`php artisan migrate`

Setup Model untuk memiliki table Contact.

Buatlah relasi antara user dan contact.
Pada User buat function `hasmany`
Pada Contact buat function `BelongsTo`

# Address

Buatlah model Address beserta migration dan seeder

`php artisan make:model Address --migration --seed `

Setup migration untuk mendefinisikan column table di database.
Address adalah milik Contact, jadi buatkanlah FK.

`php artisan migrate`

Setup Model untuk memiliki table Address.
Buatlah relasi antara Contact dan Address.
Pada Contact buat function `hasmany`
Pada Address buat function `BelongsTo`

# Membuat register

membuat Request

`php artisan make:request UserRegisterRequest`

membuat response

Atur Authorize menjadi false yang berarti siapapun boleh masuk
Atur Rules untuk validation

`php artisan make:resource UserResource`

pada toArray(), masukkan response object atau body yang diharapnkan

Membuat User controller

`php artisan make:controller UserController`

Atur Register dan throw httpexception

daftarkan ke RouteServiceProvider lalu pergi ke routes api

Lalukan test
