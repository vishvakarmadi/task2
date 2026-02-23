# Inventory Management System

A simple inventory system with accounting journal entries and financial reports.

## What It Does

- Add products with purchase price, sell price, and opening stock
- Record sales with discount, 5% VAT, and partial payment tracking
- Record purchases to restock inventory
- Auto-generate journal entries for every transaction
- Date-wise financial report (total sales, expenses, profit/loss)

## Business Scenario (from assignment)

A product is entered:
- Purchase Price: 100 TK, Sell Price: 200 TK, Opening Stock: 50 units

Then a sale happens:
- Sold: 10 units, Discount: 50 TK, VAT: 5%
- Customer pays: 1000 TK, rest is due

### Calculation
```
Sale Amount:     10 x 200     = 2,000.00 TK
Discount:                     -    50.00 TK
After Discount:               = 1,950.00 TK
VAT (5%):        1950 x 0.05  =    97.50 TK
Total Invoice:                = 2,047.50 TK
Customer Paid:                = 1,000.00 TK
Due:                          = 1,047.50 TK
```

### Journal Entries Created
| Account | Debit | Credit |
|---------|-------|--------|
| Cash A/C | 1,000.00 | |
| Accounts Receivable A/C | 1,047.50 | |
| Sales A/C | | 1,950.00 |
| VAT Payable A/C | | 97.50 |
| COGS A/C | 1,000.00 | |
| Inventory A/C | | 1,000.00 |

## Tech Stack

- Laravel 11
- Bootstrap 5
- MySQL

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Update `.env`:
```
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass
```

Run:
```bash
php artisan migrate
php artisan db:seed
php artisan serve
```

Login: `test@example.com` / `12345678`

## Pages

- **Dashboard** - summary cards (products, stock, sales, purchases, due, profit)
- **Products** - CRUD with opening stock journal entries
- **Sales** - create sale with live invoice calculator, auto journal entries
- **Purchases** - add stock with journal entries
- **Journal** - view all accounting entries
- **Reports** - date-wise filter for sales, expenses, profit

## Live Demo

- URL: https://task2.kisusoft.com
- Credentials: test@example.com / 12345678
