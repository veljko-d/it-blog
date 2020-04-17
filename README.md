# it-blog
A simple plain PHP blog, built with my "m-frame" micro framework.

#### Requirements
- PHP v.7.4+
- MySQL v.5.7

#### Installation

Clone the project:

```bash
git clone https://github.com/veljko-d/it-blog.git
```

Install composer dependencies:

```bash
composer update
```

There is no database migrations implemented.

Dump database file `it-blog.sql` is provided inside the `db/dump` folder with required tables and data.
Create `it-blog` schema and import the sql file.

Or you can do it your own way...

Add `it-blog.test` domain inside your hosts file.
