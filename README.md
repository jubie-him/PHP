# PHP Backend

This repository contains the PHP portion of a Python/PHP job matching application for job seekers and recruiters. It handles user authentication, job postings, messaging, and communicates with Python-based AI services.

## Getting Started

Install dependencies with [Composer](https://getcomposer.org/):

```bash
composer install
```

Run the database migration to create the SQLite database:

```bash
php scripts/migrate.php
```

Run the development server:

```bash
php -S localhost:8000 -t public
```

### API Endpoints

- `POST /register` – create a new user (`name`, `email`, `role`)
- `POST /jobs` – create a job posting (`title`, `description`, `requiredSkills`)
- `GET /jobs` – list jobs
- `POST /apply` – apply to a job (`user_id`, `job_id`)
- `GET /applications` – list applications
- `POST /documents` – upload a CV/resume (`file`, `user_id`)
- `GET /documents?user_id={id}` – list uploaded documents
- `POST /messages` – send a message (`sender_id`, `receiver_id`, `content`)
- `GET /messages?user_id={id}` – list messages for a user

Visit `http://localhost:8000` in your browser to use the web interface. The forms on this page
interact with the API endpoints described above.

### Frontend

A simple HTML frontend lives in `public/index.html` with accompanying CSS and JavaScript
in `public/assets/`. It provides forms for registration, job management, applications and
messaging. The design uses a dark theme with bright accents for a modern look.
