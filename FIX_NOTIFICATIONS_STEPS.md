# 🔔 Fix Notifications - Step by Step Guide

## Step 1: Create the Notifications Table

**Option A: Use the Controller (Easiest)**
1. Go to: http://localhost/ITE311-BOLANDO/create-tables
2. This will create all missing tables including `notifications`
3. You should see: ✅ Notifications table created successfully!

**Option B: Manual SQL (If Option A doesn't work)**
1. Open: http://localhost/phpmyadmin
2. Click on: `lms_bolando` database (left sidebar)
3. Click: "SQL" tab
4. Copy and paste this SQL:
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
5. Click: "Go"
6. You should see: "Table notifications created successfully"

## Step 2: Test Notifications

1. **Login as a student** (email: `student@gmail.com`, password: `student123`)

2. **Create a test notification:**
   - Go to: http://localhost/ITE311-BOLANDO/test-notification/create
   - You should see a success message

3. **Check the notification badge:**
   - Look at the top navigation bar
   - You should see a red badge with "1" next to "Notifications"
   - Click on "Notifications" to see the dropdown

4. **Test enrollment notification:**
   - Go to Student Dashboard
   - Enroll in a course
   - A notification should automatically appear: "You have been enrolled in [Course Name]"

## Step 3: Verify Everything Works

✅ **Checklist:**
- [ ] Notifications table exists in database
- [ ] Notification badge appears in navigation (when logged in)
- [ ] Test notification can be created
- [ ] Notifications appear in dropdown
- [ ] "Mark as Read" button works
- [ ] Badge count updates when marking as read
- [ ] Enrollment creates notification automatically

## Troubleshooting

### Problem: "Table doesn't exist" error
**Solution:** Run Step 1 above to create the table

### Problem: No notifications showing
**Solution:** 
1. Check browser console (F12) for errors
2. Make sure you're logged in
3. Create a test notification: http://localhost/ITE311-BOLANDO/test-notification/create
4. Refresh the page

### Problem: Badge not showing
**Solution:**
1. Open browser console (F12)
2. Check for JavaScript errors
3. Verify jQuery is loaded
4. Check if AJAX request to `/notifications` is successful

### Problem: "Mark as Read" not working
**Solution:**
1. Check browser console for CSRF errors
2. Make sure you're logged in
3. Refresh the page to get a new CSRF token

## Need More Help?

- Check the browser console (F12) for detailed error messages
- Check CodeIgniter logs: `writable/logs/`
- Verify database connection in `.env` file

