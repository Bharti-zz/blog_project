## TASK 4: Implement Security (Prevent SQL Injection)

### Objective
Improve the security of the blog project by preventing SQL Injection attacks using Prepared Statements in PHP.

### Technologies Used
- PHP
- MySQL
- Bootstrap
- XAMPP

### Features Implemented
- Secure Search Functionality
- SQL Injection Protection using Prepared Statements
- Pagination for posts
- Bootstrap UI for better design
- XSS Protection using `htmlspecialchars()`

### How It Works
1. User enters a search keyword.
2. PHP uses **Prepared Statements** instead of direct SQL queries.
3. The query safely fetches matching posts from the database.
4. Pagination limits the number of posts displayed per page.

### Example Query

```php
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt,"ssii",$search_param,$search_param,$start,$limit);
mysqli_stmt_execute($stmt);
