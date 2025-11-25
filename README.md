
# ⚠️ Disclaimer

> **This software is an open-source project developed for the community and is not affiliated with any organization or institution.**  
> It is shared purely for **educational purposes**, software development testing, and to contribute to the growth of the open-source community.

---

### ⚖️ Legal Responsibility
By using this software, you agree that:
- **All responsibility lies with you, the user.**
- The platform and its contributors provide this software **"as is"**, without any warranty of any kind, express or implied.  
  This includes, but is not limited to, the warranties of **merchantability**, **fitness for a particular purpose**, or **non-infringement**.  

> ⚠️ **Use it at your own risk.**

---

### 🎯 Intended Use
The primary purpose of this project is to:
- Educate the community by sharing open-source code.
- Facilitate learning and encourage innovation through open collaboration.

❌ **This software is not intended for production use.**  
We strongly recommend purchasing and using professionally licensed software for your needs.

---

### 🙌 Support the Community
If you would like to support the community and this project, consider making a donation:  
[![Donate](https://img.shields.io/badge/Donate-Click%20Here-orange?style=for-the-badge&logo=paypal)](https://ubd.one/donate)

---

### 🚨 Report Abuse
If you encounter any abuse or misuse of this software, please report it to:  
📧 **[abuse@ubden.com](mailto:abuse@ubden.com)**

---

> Thank you for being a part of the open-source community! 🌟

# Coff PHP Framework (v2.0)

Coff PHP Framework is a modern, lightweight, and **AI-friendly** PHP framework designed for speed, efficiency, and predictability. 

With version 2.0, the framework has been re-architected to support **microservices**, strict typing, and modern dependency injection patterns while maintaining its simplicity.

## 🚀 Features

- **AI-Friendly Architecture**: Strict typing, predictable interfaces, and PSR standards make it easy for AI assistants to understand and generate code.
- **Modern Core**: A completely refactored kernel (`src/Core`) with a powerful **Dependency Injection Container**.
- **Microservice Ready**: Built-in support for JSON APIs, Stateless Authentication (JWT-ready), and standardized API Responses.
- **Dual Routing System**: Supports both modern Route definitions (`routes/web.php`, `routes/api.php`) and legacy folder-based routing (`?path=Handler`).
- **Robust Logging**: Integrated **Monolog** support for professional-grade logging.
- **Lightweight**: Minimal overhead compared to Laravel or Symfony.

## 📂 Project Structure

The framework follows a clean separation of concerns:

```
coff-framework/
├── app/                # Application Logic (Your Code)
│   ├── Controllers/    # Web Controllers
│   ├── Models/         # Database Models
│   └── Services/       # Business Logic
├── config/             # Configuration Files
├── public/             # Web Entry Point (index.php)
├── routes/             # Route Definitions
│   ├── api.php         # API Routes (Microservices)
│   └── web.php         # Web Routes
├── src/                # Framework Core (Do Not Edit)
│   ├── Auth/           # Authentication Guards
│   ├── Core/           # Container, Application, Logger
│   └── Http/           # Kernel, Router, Request, Response
└── vendor/             # Composer Dependencies
```

## 🛠️ Getting Started

### Prerequisites
- PHP 7.4 or higher
- Composer

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/ubden/coff-framework.git
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Set up your environment:
   Copy `.env.example` to `.env` (if available) and configure your database.

## 📖 Usage

### Routing
Define your routes in `routes/web.php` or `routes/api.php`.

```php
// routes/api.php
$router->get('/users', 'App\Controllers\UserController@index');

// routes/web.php
$router->get('/', function() {
    echo "Welcome to Coff Framework!";
});
```

### Dependency Injection
The new Container supports auto-wiring. You can type-hint dependencies in your controller constructors.

```php
use Coff\Framework\Core\Logger;

class UserController {
    protected $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    public function index() {
        $this->logger->info('User list accessed');
        // ...
    }
}
```

### API Responses
Use the `ApiResponse` helper for consistent JSON output.

```php
use Coff\Framework\Http\ApiResponse;

public function index() {
    return ApiResponse::success(['id' => 1, 'name' => 'John Doe']);
}
```

### Legacy Support
The framework maintains backward compatibility with the old `?path=Page` routing style, ensuring your existing modules continue to work while you migrate to the new structure.

## 🤝 Comparison

### Coff vs Laravel
- **Performance:** Coff is significantly lighter and faster for small-to-medium projects and microservices.
- **Simplicity:** No complex facades or magic methods; just pure, understandable PHP.

### Coff vs Symfony
- **Flexibility:** Coff provides a minimal structure, giving you total freedom over your architecture.
- **Learning Curve:** You can understand the entire core code in an afternoon.

## 📞 Contact Us

Have questions or need support? Feel free to reach out!

- **Name:** Ubden Developer Community (coff.dev)
- **Email:** info@coff.dev

For more details, visit our [website](https://coff.dev) or open an issue on our GitHub page.
