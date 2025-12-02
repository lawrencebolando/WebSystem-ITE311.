<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');

// Authentication Routes
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Auth::dashboard');

// Role-specific dashboards
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('teacher/dashboard', 'Teacher::dashboard');
$routes->get('student/dashboard', 'Student::dashboard');
$routes->post('student/enroll', 'Student::enroll');

// Admin Course Management Routes
$routes->get('admin/courses', 'Admin::courses');
$routes->get('admin/courses/create', 'Admin::createCourse');
$routes->post('admin/courses/store', 'Admin::storeCourse');
$routes->get('admin/courses/edit/(:num)', 'Admin::editCourse/$1');
$routes->post('admin/courses/update/(:num)', 'Admin::updateCourse/$1');
$routes->get('admin/courses/delete/(:num)', 'Admin::deleteCourse/$1');

// Course Routes
$routes->get('courses', 'Course::index');
$routes->get('courses/(:num)', 'Course::view/$1');
$routes->post('course/enroll', 'Course::enroll');
$routes->post('course/unenroll', 'Course::unenroll');
$routes->get('courses/my-enrollments', 'Course::myEnrollments');

// Announcement Routes
$routes->get('announcements', 'Announcement::index');
$routes->get('add-announcement', 'Announcement::add');
$routes->post('add-announcement', 'Announcement::add');
$routes->get('edit-announcement/(:num)', 'Announcement::edit/$1');
$routes->post('edit-announcement/(:num)', 'Announcement::edit/$1');
$routes->get('delete-announcement/(:num)', 'Announcement::delete/$1');
