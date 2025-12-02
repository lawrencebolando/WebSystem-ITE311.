# 🚨 QUICK FIX: Notifications Not Showing

## Step 1: Check if Table Exists

Go to: **http://localhost/ITE311-BOLANDO/notification-debug**

This page will show you:
- ✅ If the notifications table exists
- ✅ If you're logged in
- ✅ Your user ID
- ✅ All your notifications
- ✅ Debug information

---

## Step 2: Create the Table (If Missing)

If the table doesn't exist, go to:
**http://localhost/ITE311-BOLANDO/create-tables**

This will create the `notifications` table automatically.

---

## Step 3: Create a Test Notification

After the table exists, click the button on the debug page:
**"Create Test Notification"**

Or go directly to:
**http://localhost/ITE311-BOLANDO/notification-debug/create-test**

---

## Step 4: Check Browser Console

1. Open your browser (Chrome/Firefox)
2. Press **F12** to open Developer Tools
3. Click the **Console** tab
4. Refresh the page
5. Look for any errors in red

Common errors:
- `404 Not Found` → Route not configured
- `500 Internal Server Error` → Table doesn't exist or database error
- `CSRF token mismatch` → Refresh the page

---

## Step 5: Test the API Directly

Open this URL in your browser:
**http://localhost/ITE311-BOLANDO/notifications**

You should see JSON like:
```json
{
  "success": true,
  "unread_count": 1,
  "notifications": [
    {
      "id": 1,
      "message": "Test notification...",
      "is_read": false,
      "time_ago": "Just now"
    }
  ]
}
```

If you see an error, that's the problem!

---

## Common Issues & Solutions

### Issue 1: "Table doesn't exist"
**Solution:** Run `create-tables` first

### Issue 2: "No notifications" but table exists
**Solution:** 
1. Create a test notification via debug page
2. Check if your user_id matches the notifications in database

### Issue 3: Badge not showing
**Solution:**
1. Check browser console for JavaScript errors
2. Make sure jQuery is loaded
3. Verify AJAX call is successful

### Issue 4: Notifications created but not showing
**Solution:**
1. Check browser console
2. Verify the AJAX endpoint returns data
3. Check if notifications belong to your user_id

---

## Manual Database Check

If nothing works, check the database directly:

1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Select database: `lms_bolando`
3. Click on table: `notifications`
4. Check if:
   - Table exists
   - Has rows
   - `user_id` matches your logged-in user ID
   - `is_read` is 0 for unread notifications

---

## Still Not Working?

1. **Check CodeIgniter logs:**
   - File: `writable/logs/log-YYYY-MM-DD.log`
   - Look for errors related to notifications

2. **Verify routes:**
   - Make sure `/notifications` route exists in `app/Config/Routes.php`

3. **Check session:**
   - Make sure you're logged in
   - Verify `user_id` is set in session

4. **Test with a fresh browser:**
   - Clear browser cache
   - Try incognito/private mode

---

## Quick Test Checklist

- [ ] Table exists? → Check debug page
- [ ] Logged in? → Check debug page  
- [ ] User ID set? → Check debug page
- [ ] Test notification created? → Use debug page button
- [ ] API returns data? → Visit `/notifications` directly
- [ ] JavaScript working? → Check browser console
- [ ] Badge appears? → Check navigation bar

**Start with the debug page: http://localhost/ITE311-BOLANDO/notification-debug**

