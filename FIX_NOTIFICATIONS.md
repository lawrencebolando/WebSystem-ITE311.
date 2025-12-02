# Fix Notifications - Step by Step

## Problem: Notifications not showing

The most common reason is that the **notifications table doesn't exist** in your database.

## Solution 1: Create the Table (EASIEST)

### Option A: Using phpMyAdmin (Recommended)

1. **Open phpMyAdmin**: http://localhost/phpmyadmin
2. **Select database**: Click on `lms_bolando` in the left sidebar
3. **Click "SQL" tab** at the top
4. **Copy and paste this SQL**:

```sql
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `message` VARCHAR(255) NOT NULL,
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `is_read` (`is_read`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

5. **Click "Go"** button
6. **You should see**: "Table notifications created successfully"
7. **Refresh your page** and check notifications

### Option B: Using Command Line

1. Open Command Prompt or PowerShell
2. Navigate to your project:
   ```
   cd C:\xampp\htdocs\ITE311-BOLANDO
   ```
3. Run:
   ```
   php spark migrate
   ```

## Solution 2: Test the System

After creating the table, test it:

1. **Go to**: http://localhost/ITE311-BOLANDO/notification-debug
2. **This will show you**:
   - If the table exists
   - Your user ID
   - How many notifications you have
   - Any errors

3. **Create a test notification**: 
   - Go to: http://localhost/ITE311-BOLANDO/notification-debug/create-test
   - This will create a test notification
   - Refresh your page and check the bell icon

## Solution 3: Create Notification Manually

If you want to test immediately:

1. **Open phpMyAdmin**: http://localhost/phpmyadmin
2. **Select database**: `lms_bolando`
3. **Click on `notifications` table**
4. **Click "Insert" tab**
5. **Fill in**:
   - `user_id`: **3** (or check your users table for student ID)
   - `message`: **"You have been enrolled in Test Course"**
   - `is_read`: **0**
   - `created_at`: Leave empty (will auto-fill)
6. **Click "Go"**
7. **Refresh your page** - you should see the notification!

## Solution 4: Check Browser Console

1. **Press F12** in your browser
2. **Click "Console" tab**
3. **Look for errors** (red text)
4. **Common errors**:
   - "Table doesn't exist" → Create the table (Solution 1)
   - "404 Not Found" → Check routes
   - "500 Internal Server Error" → Check server logs

## Quick Checklist

- [ ] Table `notifications` exists in database? (Check phpMyAdmin)
- [ ] You're logged in as student? (Check top right)
- [ ] Bell icon visible in navigation? (Should be between Dashboard and Logout)
- [ ] No JavaScript errors? (Press F12, check Console)
- [ ] `/notifications` endpoint works? (Check Network tab in F12)

## Still Not Working?

1. **Check the debug page**: http://localhost/ITE311-BOLANDO/notification-debug
2. **Share the output** - it will tell us exactly what's wrong
3. **Check browser console** (F12) for errors
4. **Check if jQuery is loading** - look for errors about `$` or `jQuery`

