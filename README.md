# Back-End-Assessment

A Laravel API application for managing users, wallets, and transactions.

## Setup

1. Install dependencies:
```bash
composer install
npm install
```

2. Copy environment file:
```bash
cp .env.example .env
```

3. Generate application key:
```bash
php artisan key:generate
```

4. Configure your database in `.env` file

## Database Setup

1. Run migrations:
```bash
php artisan migrate
```

2. Seed the database:
```bash
php artisan db:seed
```

## Running the Application

Start the Laravel development server:
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## API Endpoints

### Health Check
```bash
GET /api/health
```

### Users
- Create user:
```bash
POST /api/users
Content-Type: application/json
{
  "name": "John Doe",
  "email": "john@mail.com"
}
```

- Get user profile:
```bash
GET /api/user/profile
```

### Wallets
- Create wallet:
```bash
POST /api/wallets
Content-Type: application/json
{
  "user_id": 1,
  "name": "Main Wallet"
}
```

- Get wallet with transactions:
```bash
GET /api/wallets/{id}
```

### Transactions
- Create transaction:
```bash
POST /api/transactions
Content-Type: application/json
{
  "wallet_id": 1,
  "type": "income|expense",
  "amount": 100,
  "description": "Salary payment"
}
```

## Testing the API

### Quick Test Commands

1. Check health:
```bash
curl http://localhost:8000/api/health
```

2. Get user profile (includes wallets):
```bash
curl http://localhost:8000/api/user/profile
```

3. Get specific wallet with transactions:
```bash
curl http://localhost:8000/api/wallets/1
```

4. Create a new user:
```bash
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","email":"test@example.com"}'
```

5. Create a transaction:
```bash
curl -X POST http://localhost:8000/api/transactions \
  -H "Content-Type: application/json" \
  -d '{"wallet_id":1,"type":"income","amount":100,"description":"Test income"}'
```

## Notes

- Authentication is currently skipped for testing purposes
- The API uses the first user in the database for operations that require a user context
- Minimum transaction amount is 1.00
- Wallet names must be unique