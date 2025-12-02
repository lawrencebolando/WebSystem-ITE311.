# How to Test the Notifications System

## Step 1: Make sure the database table exists

**Option A: Run Migration (Recommended)**
1. Open Command Prompt or PowerShell
2. Navigate to your project:
   ```
   cd C:\xampp\htdocs\ITE311-BOLANDO
   ```
3. Run:
   ```
   php spark migrate
   ```

**Option B: Run SQL directly**
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Select database: `lms_bolando`
3. Click "SQL" tab
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
5. Click "Go"

## Step 2: Log in as Student

1. Go to: http://localhost/ITE311-BOLANDO/login
2. Email: `student@gmail.com`
3. Password: `student123`
4. Click "Login"

## Step 3: Check the Navigation Bar

After logging in, look at the top navigation bar. You should see:
- Home | About | Contact | Dashboard | **🔔 Notifications** | Logout

The "Notifications" link should have a **bell icon** (🔔).

## Step 4: Enroll in a Course

1. On the Student Dashboard, find the "Available Courses" section
2. Find a course you haven't enrolled in yet
3. Click the **"+ Enroll"** button on that course
4. Wait for the success message

## Step 5: Check for Notification Badge

1. **Refresh the page** (Press F5 or click refresh)
2. Look at the **Notifications** link in the navigation bar
3. You should see a **red badge** with the number "1" next to the bell icon
   - It looks like: 🔔 **1** (red circle with number)

## Step 6: Open the Notification Dropdown

1. Click on the **"Notifications"** link in the navigation bar
2. A dropdown menu should open
3. You should see:
   - Header: "Notifications"
   - A line (divider)
   - Your notification: "You have been enrolled in [Course Name]"
   - A small blue dot (●) indicating it's unread
   - A **"✓" button** (Mark as Read button)
   - Time: "Just now" or "X minutes ago"

## Step 7: Mark Notification as Read

1. Click the **"✓" button** (checkmark button) next to the notification
2. The notification should:
   - Disappear from the list (or show without the blue dot)
   - The red badge should disappear or show "0"

## Step 8: Verify Badge Updated

1. Look at the Notifications link again
2. The red badge should be **gone** (or show "0")
3. This means the notification was marked as read successfully!

---

## Troubleshooting

### Problem: No notification badge appears

**Check:**
1. Did you run the migration? (Step 1)
2. Did you actually enroll in a course? (Step 4)
3. Open browser console (F12) and check for errors
4. Check if the `notifications` table exists in phpMyAdmin

### Problem: Badge shows but dropdown is empty

**Check:**
1. Open browser console (F12)
2. Go to "Network" tab
3. Refresh the page
4. Look for a request to `/notifications`
5. Click on it and check the response
6. If you see an error, check the browser console for details

### Problem: "Mark as Read" button doesn't work

**Check:**
1. Open browser console (F12)
2. Click the "Mark as Read" button
3. Check for any error messages in the console
4. Check the Network tab for the POST request to `/notifications/mark_read/[id]`

### Problem: Can't see the Notifications link

**Check:**
1. Make sure you're logged in
2. The Notifications link only appears when you're logged in
3. Try logging out and logging back in

### Manual Test: Create Notification in Database

If enrollment doesn't create a notification, you can create one manually:

1. Open phpMyAdmin
2. Select database: `lms_bolando`
3. Click on `notifications` table
4. Click "Insert" tab
5. Fill in:
   - `user_id`: 3 (or your student user ID - check `users` table)
   - `message`: "You have been enrolled in Test Course"
   - `is_read`: 0
   - `created_at`: (current date/time)
6. Click "Go"
7. Refresh your page and check the notification badge

---

## What You Should See

### Before Enrolling:
- Notifications link: 🔔 (no badge)

### After Enrolling:
- Notifications link: 🔔 **1** (red badge with "1")

### After Clicking Notifications:
- Dropdown shows:
  ```
  Notifications
  ──────────────
  ● You have been enrolled in [Course Name]
     Just now                    [✓]
  ```

### After Marking as Read:
- Notifications link: 🔔 (badge gone)
- Dropdown shows: "No notifications" or empty

---

## Still Having Issues?

1. Check browser console (F12) for JavaScript errors
2. Check Network tab for failed AJAX requests
3. Verify the `notifications` table exists and has data
4. Make sure jQuery is loading (check console for jQuery errors)
5. Verify you're logged in as a student (not admin or teacher)

