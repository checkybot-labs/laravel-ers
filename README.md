# 🚨 Laravel ERS

[![Latest Version on Packagist](https://img.shields.io/packagist/v/checkybot-labs/laravel-ers.svg?style=flat-square)](https://packagist.org/packages/checkybot-labs/laravel-ers)
[![Total Downloads](https://img.shields.io/packagist/dt/checkybot-labs/laravel-ers.svg?style=flat-square)](https://packagist.org/packages/checkybot-labs/laravel-ers)
![Tests](https://github.com/checkybot-labs/laravel-ers/workflows/Run%20tests/badge.svg)

A Laravel integration for sending application errors to [Checkybot](https://checkybot.com) or any compatible error reporting service.

This package is a fork of [spatie/laravel-flare](https://github.com/spatie/laravel-flare), with added support for sending errors to a **custom error reporting endpoint**.

---

## 🔧 What's New

Compared to the original `spatie/laravel-flare` package, this version adds:

- 🌐 Support for a **custom error reporting URL**
- ⏱ Configurable **request timeout**
- 🔒 Option to **disable SSL verification**

These are useful for integrating with self-hosted or third-party systems like [Checkybot](https://checkybot.com).  
Configuration is handled via environment variables or a published config file.

Internally, this package uses [`checkybot-labs/laravel-ers-client`](https://github.com/checkybot-labs/laravel-ers-client) to send the actual payload.

For full documentation of the original implementation, visit:  
👉 [https://github.com/spatie/laravel-flare](https://github.com/spatie/laravel-flare)

---

## 📦 Installation

Install via Composer:

```bash
composer require checkybot-labs/laravel-ers
```

Publish the config file (optional):

```bash
php artisan vendor:publish --tag="flare-config"
```

---

## ⚙️ Configuration

Add the following variables to your `.env` file:

```env
CHECKYBOT_BASE_URL=https://checkybot.test/api/v1
CHECKYBOT_KEY=slwYvL36HdRI8dzz8qTJwrWRswWjJSLUS0POb2bH
CHECKYBOT_CURL_TIMEOUT=60
CHECKYBOT_CURL_SSL_VERIFY_PEER=false
```

Or, modify the `config/checkybot.php` file after publishing.

| Variable                         | Description                                                    |
|----------------------------------|----------------------------------------------------------------|
| `CHECKYBOT_BASE_URL`             | The endpoint where error payloads are sent                     |
| `CHECKYBOT_KEY`                  | API token from your Checkybot dashboard                        |
| `CHECKYBOT_CURL_TIMEOUT`         | Timeout in seconds for the HTTP request                        |
| `CHECKYBOT_CURL_SSL_VERIFY_PEER` | Whether to verify SSL certificates (set to `false` to disable) |

---

## 📄 License

This package is open-sourced software licensed under the [MIT license](LICENSE).  
Originally developed by [Spatie](https://github.com/spatie) and extended by [Checkybot Labs](https://github.com/checkybot-labs).
