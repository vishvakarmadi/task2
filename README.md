# Inventory Management System (Task 2)

## Student: Aditya Vishvakarma
## Submission Date: 25/02/2026

---

## About

An Inventory Management System built with **Laravel 11** featuring:
- Product management with opening inventory tracking
- Sales with discount, VAT (5%), and due amount calculations
- Purchase recording with automatic stock updates
- Double-entry accounting journal entries
- Date-wise financial reports with profit/loss analysis
- Bootstrap 5 responsive UI with sidebar navigation

## Business Scenario

| Item | Value |
|------|-------|
| Purchase Price | 100 TK |
| Sell Price | 200 TK |
| Opening Stock | 50 units |
| Opening Inventory Value | 5,000 TK |

### Sale Calculation Example
- Sale: 10 units × 200 = 2,000 TK
- Discount: 50 TK → After Discount: 1,950 TK
- VAT (5%): 97.50 TK → Total Invoice: 2,047.50 TK
- Customer Paid: 1,000 TK → Due: 1,047.50 TK
- COGS: 10 × 100 = 1,000 TK

## Database Structure

- **products**: id, name, purchase_price, sell_price, stock
- **sales**: id, product_id, quantity, discount, vat, total, paid, due, date
- **purchases**: id, product_id, quantity, total, date
- **journal_entries**: id, account, debit, credit, date, description

## Setup Instructions

```bash
# 1. Clone project
git clone <repository-url>
cd task2

# 2. Install dependencies
composer install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Set database in .env
DB_DATABASE=task2
DB_USERNAME=root
DB_PASSWORD=

# 5. Create database & run migrations
php artisan migrate

# 6. Seed demo user
php artisan db:seed

# 7. Start server
php artisan serve
```

## Demo Credentials
- **Email:** test@example.com
- **Password:** 12345678

## Tech Stack
- Laravel 11 (PHP 8.2+)
- MySQL
- Bootstrap 5
- Font Awesome 6
