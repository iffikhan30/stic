## Laravel

Laravel support ticket system, the form insert the relevant database by customer select type. I am using webpack package.

### Installation

- Composer Install
- npm update

### Database Connection

- Update env file
- Default database name `sticket`
- Run migration command [npm run migrate]
- Remainnig database connection add on env file and database.php inside the config folder.
- php artisan migrate --database=tech_mysql --path=database/migrations/2025_11_29_080310_create_tickets_table.php
- php artisan migrate --database=bill_mysql --path=database/migrations/2025_11_29_080310_create_tickets_table.php
- php artisan migrate --database=product_mysql --path=database/migrations/2025_11_29_080310_create_tickets_table.php
- php artisan migrate --database=general_mysql --path=database/migrations/2025_11_29_080310_create_tickets_table.php
- php artisan migrate --database=feedback_mysql --path=database/migrations/2025_11_29_080310_create_tickets_table.php

### Seed

- Run [php artisan db:seed]

### How To run.

- php artisan serve.
- npm run watch.
- In case your port is busy change the command
- php artisan serve --port 8002
- update webpacke.mix.js.

### Dashboard

- [local]/admin/login
- -u : jack@admin.com
- -p : baabooEuro

### Ticket Panel

- Tickets submitted show on list.
- I add option to add Ticket support
- I add option in listing view ticket
- Delete Option also there

### Frontend page

- The form showing to submiting the form and select type to send the ticket.
