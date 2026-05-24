# WEBniOWEN — Task Manager (PHP MVC Final Project)

Task Manager MVP on a custom PHP MVC framework.

**GitHub:** https://github.com/kea330/WEBniOWEN

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
   - `http://localhost/owenweb/public/`
   - or `http://localhost/WEBniOWEN/public/` (depends where your project folder is inside `htdocs`)
3. Do **not** open only `http://localhost/` unless that folder contains this project.

If you still see Apache's "resource not found" message, your URL is pointing at the wrong folder — use the `/public/` path above.

The SQLite database file is created automatically at `storage/database.sqlite` on first run.

## Project structure

```
owenweb/
├── app/           # Application (MVP)
│   ├── Controllers/
│   ├── Models/
│   ├── Repositories/
│   ├── Validation/
│   └── Views/
├── core/          # Framework
├── config/
├── public/        # Document root
├── storage/       # SQLite + logs
└── vendor/
```

## Routes

| Method | URI | Action |
|--------|-----|--------|
| GET | `/` | Home page |
| GET | `/tasks` | List all tasks |
| GET | `/tasks/create` | Create form |
| POST | `/tasks` | Store new task |
| GET | `/tasks/{id}` | Show one task |
| GET | `/tasks/{id}/edit` | Edit form |
| POST | `/tasks/{id}/update` | Update task |
| POST | `/tasks/{id}/delete` | Delete task |

## Design decisions

- **SQLite by default** — easier to demo without MySQL setup; MySQL driver is still included for OCP/LSP.
- **Simple PHP views** — no Twig/Blade; views are plain PHP files rendered by `Core\View\Engine`.
- **Basic DI container** — uses reflection for constructor injection; bindings map interfaces to concrete classes.
- **ORM (Active Record)** — `core/Database/ORM/Model.php` maps models to tables; see `App\Models\Task` and `App\Models\Project`.

## ORM usage

```php
use App\Models\Task;
use App\Models\Project;

// Read
$tasks = Task::all();
$task = Task::find(1);
$projects = Project::all();

// Create
Task::create(['title' => 'New Task', 'project_id' => 1]);
Project::create(['name' => 'My Project']);

// Update
$task = Task::find(1);
$task->title = 'Updated title';
$task->save();

// Delete
$task->delete();
```

Controllers use repository interfaces; the repository calls the ORM so SQL stays out of controllers.
- **Separate Router and Dispatcher** — keeps routing logic separate from controller invocation (SRP).

## MVP description

A minimal task manager where you can create, read, update, and delete tasks organized by projects. Forms validate task titles and project names (required, min length). Invalid input shows error messages on the form.

## Author

Final project — Advanced Web Development (2025–2026)
