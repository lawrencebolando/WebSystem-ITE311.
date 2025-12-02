<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleAuth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not change the request or response.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $uri = $request->getUri()->getPath();

        // Check if user is logged in
        if (!$session->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login to access this page.');
            return redirect()->to(base_url('login'));
        }

        $userRole = $session->get('role');

        // Admin routes: Only admins can access /admin/*
        if (strpos($uri, '/admin') === 0 || strpos($uri, 'admin') === 0) {
            if ($userRole !== 'admin') {
                session()->setFlashdata('error', 'Access Denied: Insufficient Permissions');
                return redirect()->to(base_url('announcements'));
            }
        }

        // Teacher routes: Only teachers can access /teacher/*
        if (strpos($uri, '/teacher') === 0 || strpos($uri, 'teacher') === 0) {
            if ($userRole !== 'teacher') {
                session()->setFlashdata('error', 'Access Denied: Insufficient Permissions');
                return redirect()->to(base_url('announcements'));
            }
        }

        // Student routes: Only students can access /student/*
        if (strpos($uri, '/student') === 0 || strpos($uri, 'student') === 0) {
            if ($userRole !== 'student') {
                session()->setFlashdata('error', 'Access Denied: Insufficient Permissions');
                return redirect()->to(base_url('announcements'));
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not need to return anything.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
