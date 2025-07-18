# Database Seeder Commands

This file contains the commands to seed the database with default data.

## Run All Seeders
```bash
php spark db:seed DatabaseSeeder
```

## Run Specific Seeders
```bash
# User seeder only
php spark db:seed UserSeeder
```

## Default User Credentials

After running the seeder, you can login with these default accounts:

### Admin Account
- **Email:** admin@perfectsmile.com
- **Username:** admin
- **Password:** admin123
- **Role:** Admin (Full access to all features)

### Doctor Account
- **Email:** doctor@perfectsmile.com
- **Username:** doctor
- **Password:** doctor123
- **Role:** Doctor (Patient management, appointments, procedures)

### Staff Account
- **Email:** staff@perfectsmile.com
- **Username:** staff
- **Password:** staff123
- **Role:** Staff (Patient check-in, appointments, invoices)

## Notes
- All passwords are hashed using PHP's `password_hash()` function
- Users are created with `active` status
- The seeder checks for existing users to prevent duplicates
- You can login using either email or username
