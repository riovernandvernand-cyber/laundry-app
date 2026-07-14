<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class ApiAuthFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    $apiKey = $request->getHeaderLine('X-API-KEY');
    $secretToken = 'laundry_secret_2026';

    if (empty($apiKey) || $apiKey !== $secretToken) {
      $response = Services::response();

      $response->setStatusCode(401);
      $response->setJSON([
        'status' => 401,
        'error' => 'Unauthorized',
        'message' => 'Akses ditolak. X-API-KEY tidak valid atau tidak disertakan pada Header request.'
      ]);

      return $response;
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
  }
}