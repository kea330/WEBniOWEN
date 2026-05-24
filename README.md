# PHP MVC Framework — Final Examination Project

Custom MVC framework built in PHP 8.3+ with a simple **blog posts** MVP on top.

## Requirements met

- PHP 8.3+ (enums, `match`, readonly properties, constructor promotion)
- MVC + front controller (`public/index.php`)
- PSR-4 autoloading: `Core\` → `core/`, `App\` → `app/`
- SOLID principles (see `SOLID-JUSTIFICATION.md`)
- CRUD MVP with validation and SQLite database

## Setup

1. Install PHP 8.3 or higher.
2. Install Composer dependencies:

```bash
composer install
```

3. Start the built-in server from the project root:

```bash
php -S localhost:8000 -t public
```

4. Open http://localhost:8000 in your browser.

### XAMPP (Apache)

1. Make sure **mod_rewrite** is enabled in `httpd.conf`.
2. Open the app through the **public** folder, for example:
   - `http://localhost/web/WEB/public/`
   - or `http://localhost/WEB/public/` (depends where your project folder is inside `htdocs`)
3. Do **not** open only `http://localhost/` unless that folder contains this project.

If you still see Apache's "resource not found" message, your URL is pointing at the wrong folder — use the `/public/` path above.

The SQLite database file is created automatically at `storage/database.sqlite` on first run.

### Using MySQL (optional)

1. Create a database named `mvc_blog`.
2. In `config/database.php`, set `'driver' => 'mysql'`.
3. In `core/Application.php`, change the container binding to `MySQLPostRepository::class`.

## Project structure

```
WEB/
├── app/           # Application (MVP)
├── core/          # Framework
├── config/
├── public/        # Document root
├── routes/
├── storage/       # SQLite + logs
└── vendor/
```

## Routes

| Method | URI | Action |
|--------|-----|--------|
| GET | `/` | Home page |
| GET | `/posts` | List all posts |
| GET | `/posts/create` | Create form |
| POST | `/posts` | Store new post |
| GET | `/posts/{id}` | Show one post |
| GET | `/posts/{id}/edit` | Edit form |
| POST | `/posts/{id}/update` | Update post |
| POST | `/posts/{id}/delete` | Delete post |

## Design decisions

- **SQLite by default** — easier to demo without MySQL setup; MySQL driver is still included for OCP/LSP.
- **Simple PHP views** — no Twig/Blade; views are plain PHP files rendered by `Core\View\Engine`.
- **Basic DI container** — uses reflection for constructor injection; bindings map interfaces to concrete classes.
- **ORM (Active Record)** — `core/Database/ORM/Model.php` maps models to tables; see `App\Models\Post`.

## ORM usage

```php
use App\Models\Post;

// Read
$posts = Post::all();
$post = Post::find(1);

// Create
Post::create(['title' => 'Hello', 'body' => 'My first post']);

// Update
$post = Post::find(1);
$post->title = 'Updated title';
$post->save();

// Delete
$post->delete();
```

Controllers use `PostRepositoryInterface`; the repository calls the ORM so SQL stays out of controllers.
- **Separate Router and Dispatcher** — keeps routing logic separate from controller invocation (SRP).

## MVP description

A minimal blog where you can create, read, update, and delete posts. Forms validate title and body (required, min length). Invalid input shows error messages on the form.

## Author

Final project — Advanced Web Development (2025–2026)
