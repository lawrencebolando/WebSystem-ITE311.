# Quick Fix: Create Announcements Table

## The Problem
Error: `Table 'lms_bolando.announcements' doesn't exist`

## The Solution (2 minutes)

### Step 1: Open phpMyAdmin
1. Go to: http://localhost/phpmyadmin
2. Click on database: **`lms_bolando`** (left sidebar)

### Step 2: Run SQL
1. Click the **"SQL"** tab at the top
2. **Copy this entire SQL** and paste it:

```sql
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

3. Click **"Go"** button
4. You should see: ✅ "Table announcements created successfully"

### Step 3: Verify
1. In the left sidebar, you should now see **`announcements`** table
2. Refresh your browser page
3. The error should be gone! ✅

## That's it! The error is fixed.

---

## Bonus: Create All Missing Tables at Once

If you want to create ALL missing tables (announcements, notifications, materials) at once:

1. Open phpMyAdmin
2. Select database: `lms_bolando`
3. Click "SQL" tab
4. Open the file `CREATE_ALL_TABLES.sql` from your project folder
5. Copy ALL the SQL from that file
6. Paste and click "Go"

This will create:
- ✅ `announcements` table
- ✅ `notifications` table  
- ✅ `materials` table

