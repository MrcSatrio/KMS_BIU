<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->get('id_role')) {
            return redirect()->to(base_url('/'));
        } else {
            $role = $session->get('id_role');
            if ($role == 1 && strpos($request->uri->getPath(), 'admin') === false) {
                return redirect()->to(base_url('admin/dashboard'));
            } elseif ($role == 2 && strpos($request->uri->getPath(), 'uploader') === false) {
                return redirect()->to(base_url('uploader/dashboard'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
