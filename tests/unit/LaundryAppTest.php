<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class LaundryAppTest extends CIUnitTestCase
{
  use FeatureTestTrait;
  use DatabaseTestTrait;

  // Mengembalikan kontrol migrasi dan seeder otomatis ke framework
  protected $migrate = true;
  protected $seed = \App\Database\Seeds\DatabaseSeeder::class;

  // Memaksa sistem mencari file migrasi ke folder utama aplikasi (app/Database)
  protected $namespace = 'App';

  public function testHalamanUtamaDapatDiakses()
  {
    $result = $this->call('get', '/');
    $this->assertTrue($result->isOK());
  }

  public function testDashboardMemproteksiTamuGunaRedirectKeLogin()
  {
    $result = $this->call('get', 'dashboard');
    $this->assertTrue($result->isRedirect());
    $result->assertRedirectTo(base_url('login'));
  }

  public function testValidasiStrukturDataLayananDiDatabase()
  {
    $serviceModel = new \App\Models\ServiceModel();
    $layanan = $serviceModel->findAll();

    $this->assertIsArray($layanan);
    if (count($layanan) > 0) {
      $this->assertArrayHasKey('name', $layanan[0]);
      $this->assertArrayHasKey('price', $layanan[0]);
    }
  }
}