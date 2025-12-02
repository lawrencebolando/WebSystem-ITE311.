# ✅ Complete Notification Test Guide

## Prerequisites Checklist

Before testing, make sure:

- [ ] **Notifications table exists**
  - Go to: http://localhost/ITE311-BOLANDO/create-tables
  - Should show: ✅ Notifications table created successfully! (or "already exists")

- [ ] **You are logged in as a student**
  - Email: `student@gmail.com`
  - Password: `student123`
  - Go to: http://localhost/ITE311-BOLANDO/login

- [ ] **Browser console is open** (Press F12)
  - This helps you see what's happening

---

## Step-by-Step Test

### Step 1: Verify Table Exists

1. Go to: **http://localhost/ITE311-BOLANDO/quick-test**
2. Check if it says: **"Table Exists: YES"** ✅
3. If it says "NO", click "Create Table" button

---

### Step 2: Create a Test Notification (Manual)

1. Go to: **http://localhost/ITE311-BOLANDO/notification-debug**
2. Click the button: **"Create Test Notification"**
3. You should see: "Test notification created successfully!"
4. Refresh the page
5. You should see the notification in the list

---

### Step 3: Check Notification Badge

1. Go to: **http://localhost/ITE311-BOLANDO/student/dashboard**
2. Look at the top navigation bar
3. Find "Notifications" with a bell icon 🔔
4. **You should see a red badge with a number** (e.g., "1") next to it
5. If you don't see the badge:
   - Open browser console (F12)
   - Look for errors
   - Check if you see: "🔔 Notifications script loaded"

---

### Step 4: Click Notification Dropdown

1. Click on **"Notifications"** in the navigation bar
2. A dropdown menu should open
3. **You should see your notification(s) listed**
4. Each notification should show:
   - The message (e.g., "Test notification created at...")
   - Time ago (e.g., "Just now")
   - A "Mark as Read" button (if unread)

---

### Step 5: Test Enrollment Notification

1. Go to: **http://localhost/ITE311-BOLANDO/student/dashboard**
2. Scroll down to "Available Courses"
3. Find a course you haven't enrolled in
4. Click the **"Enroll"** button
5. Wait for success message
6. **A new notification should appear:**
   - "You have been enrolled in [Course Name]"
7. The notification badge count should increase

---

### Step 6: Mark Notification as Read

1. Click on **"Notifications"** dropdown
2. Find an unread notification (has a "Mark as Read" button)
3. Click the **"Mark as Read"** button (checkmark icon ✓)
4. The notification should:
   - Disappear from the unread list (or show as read)
   - The badge count should decrease
5. Refresh the page
6. The notification should still be there but marked as read (no button)

---

## Troubleshooting

### Problem: No badge showing

**Check:**
1. Open browser console (F12)
2. Look for: "🔔 Notifications script loaded"
3. Look for: "📡 Fetching notifications"
4. Look for: "✅ Notifications response received"

**If you see errors:**
- "Table doesn't exist" → Create the table
- "404 Not Found" → Check routes
- "500 Server Error" → Check database connection

---

### Problem: Badge shows but dropdown is empty

**Check:**
1. Browser console for: "📋 Notifications: []"
2. Go to: http://localhost/ITE311-BOLANDO/quick-test
3. See if notifications exist in database
4. Check if your user_id matches the notifications

---

### Problem: Enrollment doesn't create notification

**Check:**
1. Go to: http://localhost/ITE311-BOLANDO/quick-test
2. Enroll in a course
3. Refresh quick-test page
4. See if notification appears in database

**If not:**
- Check CodeIgniter logs: `writable/logs/`
- Look for "Notification created" or "Failed to create notification"

---

### Problem: Mark as Read doesn't work

**Check:**
1. Browser console for errors
2. Check if CSRF token is valid (refresh page)
3. Check if notification belongs to your user_id

---

## Quick Verification URLs

- **Create Table:** http://localhost/ITE311-BOLANDO/create-tables
- **Debug Page:** http://localhost/ITE311-BOLANDO/notification-debug
- **Quick Test:** http://localhost/ITE311-BOLANDO/quick-test
- **Student Dashboard:** http://localhost/ITE311-BOLANDO/student/dashboard
- **API Endpoint:** http://localhost/ITE311-BOLANDO/notifications

---

## Expected Behavior

✅ **When you have notifications:**
- Red badge appears with count
- Dropdown shows notifications
- "Mark as Read" button works
- Badge count decreases when marked as read

✅ **When you enroll:**
- Notification is created automatically
- Badge count increases
- Notification appears in dropdown

✅ **When page loads:**
- Notifications are fetched automatically
- Badge is updated
- Dropdown is populated

---

## Still Not Working?

1. **Check browser console** (F12) - Share any errors you see
2. **Check quick-test page** - Share what it shows
3. **Check if table exists** - Go to create-tables page
4. **Check if logged in** - Make sure you're logged in as student
5. **Check user_id** - Make sure notifications have your user_id

**Share with me:**
- What you see on quick-test page
- Any errors in browser console
- What happens when you click "Notifications"

